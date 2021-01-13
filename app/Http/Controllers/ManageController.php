<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
use App\Rules\AtLeastThirteen;

class ManageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['verified', 'can:read_registration']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('manage.index');
    }

    public function edit($regis_id)
    {
        $registration = \App\Models\Registration::findOrFail($regis_id);

        return view('manage.edit', ['registration' => $registration]);
    }

    public function searchName()
    {
        return response()->json($this->searchResults(\App\Models\Registration::where(DB::raw('CONCAT_WS(" ",first_name,last_name)'), 'LIKE', '%'.request()->input('val').'%')->get()));
    }

    public function searchAddr()
    {
        return response()->json($this->searchResults(\App\Models\Registration::where(DB::raw('CONCAT_WS(" ",address1,address2,city,state,zip)'), 'LIKE', '%'.request()->input('val').'%')->get()));
    }

    public function searchRegis()
    {
        return response()->json($this->searchResults(\App\Models\Registration::where('id', '=', request()->input('val'))->get()));
    }

    public function searchCode()
    {
        return response()->json($this->searchResults(\App\Models\Registration::where('code', 'LIKE', '%'.request()->input('val').'%')->get()));
    }

    private function searchResults($results)
    {
        $html = '';

        foreach($results as $res) {
            $html .= '<tr><td>'.$res->first_name.' '.$res->last_name.'</td><td>'.$res->id.'</td><td>'.$res->code.'</td><td>'.Carbon::parse($res->submitted_at)->format('m-d-Y h:i:s A').'</td><td>'.$res->status->name.'</td><td><a href="/manage/edit/'.$res->id.'"><span class="fad fa-edit"></span></a></td></tr>';
        }

        if ($html == '') {
            $html = '<td colspan="5"><div class="alert alert-warning">No registrations were found!</div></td>';
        }

        return ['result' => $html];
    }

    public function qrRead()
    {
        return view('manage.qr');
    }

    public function view_registration($user_id, $app_id, $code)
    {
        $regis = \App\Models\Registration::findOrFail($app_id);

        if ($user_id != $regis->user_id || $code != $regis->code) {
            abort(404);
        }

        return view('manage.registration', ['registration' => $regis]);
    }

    public function register()
    {
        return view('manage.register');
    }

    public function submitRegistration()
    {
        $valid = request()->validate($this->validationRules());
        $valid['scheculePreference'] = (bool) request('scheculePreference');
        $is_valid_letters = false;
        $randomletter = '';

        // create user
        // check email
        $email_is_valid = false;
        $user_email = $valid['firstName'].$valid['lastName'].rand().config('app.default_no_email');

        while (!$email_is_valid) {
            if (\App\Models\User::where('email', '=', $user_email)->count() > 0) {
                $user_email = $valid['firstName'].$valid['firstName'].rand().config('app.default_no_email');
            } else {
                $email_is_valid = true;
            }
        }

        $user = \App\Models\User::create([
            'first_name' => $valid['firstName'],
            'middle_name' => $valid['middleName'],
            'last_name' => $valid['lastName'],
            'email' => $user_email,
            'phone' => preg_replace('/\D/', '', $valid['phone']),
            'birth_date' => Carbon::parse($valid['dateOfBirth']),
            'password' => \Illuminate\Support\Facades\Hash::make(config('app.default_password').rand()),
        ]);

        $this->logChanges($user, 'procured', false, true);

        $user->assignRole('user');

        // create registration
        while(!$is_valid_letters) {
            $randomletter = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);

            $invalid_letter_codes = [
                'ASS',
                'CUM',
                'FAG', 
                'GAY', 
                'GOD', 
                'JEW',
                'TIT',
                'FUK',
                'FUC',
                'VAG',
                'JIZ',
            ];

            if(!in_array($randomletter, $invalid_letter_codes)) { 
                $is_valid_letters = true;
            }
        }

        $code = $randomletter . Carbon::now()->isoFormat('SSSS');
        $conditions = [];
        if (isset($valid['condition'])) {
            $conditions = array_keys($valid['condition']);
        }
        //$user = Auth::user();

        if (!empty($user->phone)) {
            $phones = [[
                "contact_type_id" => 2,
                "phone_type_id" => 1,
                "value" => preg_replace('/\D/', '', $user->phone),
            ]];
        } else {
            $phones = [];
        }
        if (!empty($valid['email'])) {
            $emails = [[
                "contact_type_id" => 1,
                "value" => $valid['email'],
            ]];
        } else {
            $emails = [];
        }

        $registration = \App\Models\Registration::create([
            'code'=> $code,
            'user_id'=> $user->id,
            'race_id'=> $valid['race'],
            'gender_id'=> $valid['gender'],
            'occupation_id'=> $valid['occupation'],
            'county_id'=> $valid['county'],
            
            // Obtained by user account:
            'first_name'=> $user->first_name,
            'middle_name'=> $user->middle_name,
            'last_name'=> $user->last_name,
            // Replaced by 'contacts' table
            //'email'=> $user->email,
            //'phone'=> $user->phone,
            'birth_date'=> $user->birth_date,

            // New Info
            'address1'=> $valid['address1'],
            'address2'=> $valid['address2'],
            'city'=> $valid['city'],
            'state'=> $valid['state'],
            'zip'=> $valid['zip'],
            'prefer_close_location'=> $valid['scheculePreference'],
            'submitted_at'=> Carbon::now(),
        ]);

        // Assign phones and emails
            // add foreach loop to create all contact types

        //Combine email and phones
        $registration->contacts()->createMany(array_merge($phones,$emails));

        $registration->conditions()->sync($conditions);

        $this->logChanges($registration, 'procured', true);

        Session::flash('success', "Registration submission was successful.  Your code is: ".$code);
        return redirect('/manage');
    }

    public function updateRegistration($regis_id)
    {
        $registration = \App\Models\Registration::findOrFail($regis_id);

        $valid = request()->validate($this->validationRules());
        $valid['scheculePreference'] = (bool) request('scheculePreference');

        $conditions = [];
        if (isset($valid['condition'])) {
            $conditions = array_keys($valid['condition']);
        }

        if (!empty($valid['phone'])) {
            $phones = [[
                "contact_type_id" => 2,
                "phone_type_id" => 1,
                "value" => preg_replace('/\D/', '', $valid['phone']),
            ]];
        } else {
            $phones = [];
        }
        if (!empty($valid['email'])) {
            $emails = [[
                "contact_type_id" => 1,
                "value" => $valid['email'],
            ]];
        } else {
            $emails = [];
        }

        $registration->update([
            'race_id'=> $valid['race'],
            'gender_id'=> $valid['gender'],
            'occupation_id'=> $valid['occupation'],
            'county_id'=> $valid['county'],
            
            // Obtained by user account:
            'first_name' => $valid['firstName'],
            'middle_name' => $valid['middleName'],
            'last_name' => $valid['lastName'],
            //'email' => $valid['email'],
            //'phone' => $valid['phone'],
            'birth_date' => Carbon::parse($valid['dateOfBirth']),

            // New Info
            'address1'=> $valid['address1'],
            'address2'=> $valid['address2'],
            'city'=> $valid['city'],
            'state'=> $valid['state'],
            'zip'=> $valid['zip'],
            'prefer_close_location'=> $valid['scheculePreference'],
        ]);

        $registration->conditions()->sync($conditions);

        // rewrite if we start allowing multiple phones and emails
        $contacts = [];
        if (count($registration->emails()) > 0) {
            if (empty($emails)) { 
                $registration->emails()[0]->delete(); 
            } else {
                $registration->emails()[0]->update($emails[0]);
            }
        } else {
            $contacts = array_merge($contacts, $emails);
        }

        if (count($registration->phones()) > 0) {
            if (empty($phones)) { 
                $registration->phones()[0]->delete(); 
            } else {
                $registration->phones()[0]->update($phones[0]);
            }
        } else {
            $contacts = array_merge($contacts, $phones);
        }

        if (count($contacts) > 0) {
            $registration->contacts()->createMany($contacts);
        }

        $this->logChanges($registration, 'updated', true);

        Session::flash('success', "Registration edit was successful.  Your code is: ".$registration->code);
        return redirect('/manage');
    }

    private function validationRules()
    {
        $valid_races = implode(",",\App\Models\Race::pluck('id')->toArray());
        $valid_genders = implode(",",\App\Models\Gender::pluck('id')->toArray());
        $valid_occupations = implode(",",\App\Models\Occupation::pluck('id')->toArray());
        $valid_counties = implode(",",\App\Models\County::pluck('id')->toArray());

        $rules = [
            'firstName' => 'required|string|max:255',
            'middleName' => 'nullable|string|max:30',
            'lastName' => 'required|string|max:255',
            'email' => 'required_without:phone|nullable|string|email|max:255',
            'phone' => 'required_without:email|nullable|regex:/^(?=.*[0-9])[- +()0-9]+$/|max:14',
            'dateOfBirth' => ['required','date', new AtLeastThirteen],
            'race' => 'required|in:'.$valid_races,
            'gender' => 'required|in:'.$valid_genders,
            'occupation' => 'required|in:'.$valid_occupations,
            'address1' => 'required|max:60',
            'address2' => 'nullable|max:60',
            'city' => 'required|max:60',
            'state' => 'required|max:2',
            'zip' => 'required|max:11',
            'county' => 'required|in:'.$valid_counties,
            //'vaccineAgreement' => 'accepted',
            'reactionAgreement' =>'accepted',
            'availableAgreement' =>'accepted',
            //'illAgreement' =>'accepted',
            'condition' =>'nullable'
        ];

        return $rules;
    }
}
