<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
use App\Rules\AtLeastThirteen;
use App\Rules\DateParsable;
use Illuminate\Support\Facades\Validator;
use App\Mail\RegistrationComplete;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Builder;


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
        return response()->json(
            $this->searchResults(
                \App\Models\User::whereHas('roles', function (Builder $query) {
                    $query->where('name', '=', 'user');
                })->where(DB::raw('CONCAT_WS(" ",users.first_name,users.last_name)'), 'LIKE', '%'.request()->input('val').'%'), 
                request()->input('offset'),
                request()->input('sort')
            )
        );
    }

    public function searchAddr()
    {
        return response()->json(
            $this->searchResults(
                \App\Models\User::whereHas('registration', function (Builder $query) {
                    $query->whereHas('address', function (Builder $query) {
                        $query->where(DB::raw('CONCAT_WS(" ",street_number,street_name,locality,(SELECT states.abbr FROM states where states.id = addresses.state_id),postal_code)'), 'LIKE', '%'.request()->input('val').'%');
                    });
                }), 
                request()->input('offset'),
                request()->input('sort')
            )
        );
    }

    public function searchRegis()
    {
        return response()->json(
            $this->searchResults(
                \App\Models\User::whereHas('registration', function (Builder $query) {
                    $query->where('id', '=', request()->input('val'));
                }), 
                request()->input('offset'),
                request()->input('sort')
            )
        );
    }

    public function searchCode()
    {
        return response()->json(
            $this->searchResults(
                \App\Models\User::whereHas('registration', function (Builder $query) {
                    $query->where('code', 'LIKE', '%'.request()->input('val').'%');
                }),
                request()->input('offset'),
                request()->input('sort')
            )
        );
    }

    private function searchResults($query, $offset, $sort)
    {
        $limit = config('app.pagination_limit');
        $total_count = $query->count();
        $res = $query->join('registrations', 'users.id', '=', 'registrations.user_id')->orderBy('registrations.submitted_at', $sort ?? 'asc')->select('users.*')->offset($offset)->limit($limit)->get();
        $pagination = '';

        if ($total_count > 0) {
            $html = view('manage.partials.tablerow', ['results' => $res])->render();

            if ($total_count > $limit) {
                $pagination = view('manage.partials.paginationrow', ['top' => (($offset + $limit) > $total_count ? $total_count : ($offset + $limit)), 'bot' => $offset + 1, 'total' => $total_count])->render();
            }
        } else {
            $html = '<td colspan="7"><div class="alert alert-warning">No registrations were found!</div></td>';
        }

        return [
            'result' => $html,
            'offset' => $offset + $limit,
            'limit' => $limit,
            'pagination' => $pagination,
        ];
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

        if (request()->input('checkin') == 'auto') {
            if ($regis->has_appointment) {
                $inv = $regis->active_invite;
                if ($inv->invite_status_id == 6) {
                    $inv->invite_status_id = 7;
                    $inv->save();
                    Session::flash('success', "<p>Registrant was checked in.</p>");
                }
            }
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
            'suffix_id' => ($valid['suffix'] != '0' ? $valid['suffix'] : null),
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
            //'county_id'=> $valid['county'],

            // Obtained by user account:
            'first_name'=> $user->first_name,
            'middle_name'=> $user->middle_name,
            'last_name'=> $user->last_name,
            // Replaced by 'contacts' table
            //'email'=> $user->email,
            //'phone'=> $user->phone,
            'birth_date'=> $user->birth_date,
            'suffix_id' => $user->suffix_id,

            // New Info
            // 'address1'=> $valid['address1'],
            // 'address2'=> $valid['address2'],
            // 'city'=> $valid['city'],
            // 'state'=> $valid['state'],
            // 'zip'=> $valid['zip'],
            'prefer_close_location'=> $valid['scheculePreference'],
            'submitted_at'=> Carbon::now(),
        ]);

        $registration->syncAddress($valid);

        // Assign phones and emails
            // add foreach loop to create all contact types

        //Combine email and phones
        $registration->contacts()->createMany(array_merge($phones,$emails));

        $registration->conditions()->sync($conditions);

        $this->logChanges($registration, 'procured', true);

        // send email
        if (!empty($valid['email'])) {
            Mail::to($valid['email'])->send(new RegistrationComplete($registration));
        }

        if(request()->filled('comment')) {
            $comment = \App\Models\Comment::create([
                'user_id' => Auth::id(),
                'registration_id' => $registration->id,
                'text' => request()->input('comment'),
            ]);

            $this->logChanges($comment, 'created');
        }

        Session::flash('success', "<p>Registration submission was successful.</p><p>Be sure to remind the caller that they will need to fill out a Moderna consent form at their appointment.</p><p>Your code is:</p><p class=\"h3 mb-6\">".$code."</p>");
        return redirect('/manage');
    }

    public function updateRegistration($regis_id)
    {
        $registration = \App\Models\Registration::findOrFail($regis_id);

        $valid = request()->validate($this->validationRules());
        $valid['scheculePreference'] = (bool) request('scheculePreference');

        $user = $registration->user;

        if ($user->phone != preg_replace('/\D/', '', $valid['phone'])) {
            $user->update([
                'phone' => preg_replace('/\D/', '', $valid['phone']),
            ]);

            $user->forceFill([
                'sms_capable' => 0,
                'sms_verified_at' => null,
            ]);

            $this->logChanges($user, 'updated', false, true);
        }

        $user->update([
            'first_name' => $valid['firstName'],
            'middle_name' => $valid['middleName'],
            'last_name' => $valid['lastName'],
            'birth_date' => $valid['dateOfBirth'],
            'suffix_id' => ($valid['suffix'] != '0' ? $valid['suffix'] : null),
        ]);

        $this->logChanges($user, 'updated', false, true);

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
            //'county_id'=> $valid['county'],

            // Obtained by user account:
            'first_name' => $valid['firstName'],
            'middle_name' => $valid['middleName'],
            'last_name' => $valid['lastName'],
            //'email' => $valid['email'],
            //'phone' => $valid['phone'],
            'birth_date' => Carbon::parse($valid['dateOfBirth']),
            'suffix_id' => ($valid['suffix'] != '0' ? $valid['suffix'] : null),

            // New Info
            // 'address1'=> $valid['address1'],
            // 'address2'=> $valid['address2'],
            // 'city'=> $valid['city'],
            // 'state'=> $valid['state'],
            // 'zip'=> $valid['zip'],
            'prefer_close_location'=> $valid['scheculePreference'],
        ]);

        $registration->syncAddress($valid);

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

        if(request()->filled('comment')) {
            $comment = \App\Models\Comment::create([
                'user_id' => Auth::id(),
                'registration_id' => $registration->id,
                'text' => request()->input('comment'),
            ]);

            $this->logChanges($comment, 'created');
        }

        Session::flash('success', "<p>Registration edit was successful.</p><p>Be sure to remind the caller that they will need to fill out a Moderna consent form at their appointment.</p><p>Your code is:</p><p class=\"h3 mb-6\">".$registration->code."</p>");
        return redirect('/manage');
    }

    public function forceResetPassword()
    {
        $success = false;
        if(request()->input('user')) {
            $user = \App\Models\User::find(request()->input('user'));

            $success = ($user != null);
            $error_msg = '404-'.$user->id;
        } else {
            $error_msg = '400-'.Carbon::now()->isoFormat('SSSS');
        }

        if ($success) {
            $user->forceReset();
            Session::flash('success', "User account password has been reset.  They will be prompted to change their password at the next login attempt within the next hour.");
        } else {
            $validator = Validator::make([],[]);
            $validator->errors()->add('form', 'ERROR '.$error_msg.': The requested user could not have their password reset.');
            return redirect()->back()->withErrors($validator->errors());
        }
        return redirect()->back();
    }

    public function delete($regis_id)
    {
        $regis = \App\Models\Registration::findOrFail($regis_id);
        $this->logChanges($regis, 'deleted', true);
        $regis->delete();

//      DPC
//        prefix the email address to avoid integrity constraint violation if the email is re-used later
//        (soft) delete the user; I checked, the user model has softdeletes
        $cur_user = User::findOrFail($regis->user_id);
        $cur_user->email = $cur_user->id . rand(10000,99999) . '-' . $cur_user->email;
        $cur_user->update();
        $cur_user->delete();

        Session::flash('success', "<p>Registration was successfully deleted.</p>");
        return redirect('/manage');
    }

    public function complete($regis_id)
    {
        $regis = \App\Models\Registration::findOrFail($regis_id);
        $regis->update([
            'status_id' => 5,
        ]);
        $this->logChanges($regis, 'completed', true);

        Session::flash('success', "<p>Registration was marked as completed.</p>");
        return redirect('/manage');
    }

    public function userDelete($id)
    {
        $user = User::findOrFail($id);
        $user->email = $user->id . rand(10000,99999) . '-' . $user->email;
        $user->update();
        $this->logChanges($user, 'deleted', false, false, null, true);
        $user->delete();

        Session::flash('success', "<p>User was successfully deleted.</p>");
        return redirect('/manage');
    }

    private function validationRules()
    {
        $valid_races = implode(",",\App\Models\Race::pluck('id')->toArray());
        $valid_genders = implode(",",\App\Models\Gender::pluck('id')->toArray());
        $valid_occupations = implode(",",\App\Models\Occupation::pluck('id')->toArray());
        $valid_counties = implode(",",\App\Models\County::pluck('id')->toArray());
        $valid_states = implode(",",\App\Models\State::pluck('id')->toArray());
        $valid_suffixes = '0,'.implode(",",\App\Models\Suffix::pluck('id')->toArray());

        $rules = [
            'firstName' => 'required|string|max:255',
            'middleName' => 'nullable|string|max:30',
            'lastName' => 'required|string|max:255',
            'email' => 'required_without:phone|nullable|string|email:filter|max:255',
            'phone' => 'required_without:email|nullable|regex:/^(?=.*[0-9])[- +()0-9]+$/|max:14',
            'dateOfBirth' => ['required','date', new DateParsable, new AtLeastThirteen],
            'race' => 'required|in:'.$valid_races,
            'gender' => 'required|in:'.$valid_genders,
            'occupation' => 'required|in:'.$valid_occupations,
            //'address1' => 'required|max:60',
            //'address2' => 'nullable|max:60',
            //'city' => 'required|max:60',
            'autocomplete' => 'nullable',
            'street_number' => 'required|max:60',
            'street_name' => 'required|max:60',
            'line_2' => 'nullable',
            'locality' => 'required|max:60',
            'postal_code' => 'required|max:60',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'state' => 'required|in:'.$valid_states,
            //'zip' => 'required|max:11',
            'county' => 'required|in:'.$valid_counties,
            //'vaccineAgreement' => 'accepted',
            'reactionAgreement' =>'accepted',
            'availableAgreement' =>'accepted',
            //'illAgreement' =>'accepted',
            'condition' =>'nullable',
            'suffix' => ['required', 'in:'.$valid_suffixes],
        ];

        return $rules;
    }
}
