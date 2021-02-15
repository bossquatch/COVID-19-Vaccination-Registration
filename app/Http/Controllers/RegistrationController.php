<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Notifications\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Support\Facades\DB;
use App\Rules\AtLeastThirteen;
use App\Rules\DateParsable;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['verified', 'can:create_registration']);
    }

    public function submitRegistration()
    {

    	$user = Auth::user();

    	// check for existing registration. There is an issue where 0.7% of the time a user registers twice.
		if(Registration::where('user_id', $user->id)->count() != 0) {
			return redirect('/home');
		}

        $valid = request()->validate($this->validationRules());
        $valid['scheculePreference'] = (bool) request('scheculePreference');
        $is_valid_letters = false;
        $randomletter = '';

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

        if (!empty($user->phone)) {
            $phones = [[
                "contact_type_id" => 2,
                "phone_type_id" => 1,
                "value" => preg_replace('/\D/', '', $user->phone),
            ]];
        } else {
            $phones = [];
        }
        $emails = [[
            "contact_type_id" => 1,
            "value" => $user->email,
        ]];

        $registration = \App\Models\Registration::create([
            'code'=> $code,
            'user_id'=> Auth::id(),
            'race_id'=> $valid['race'],
            'gender_id'=> $valid['gender'],
            'occupation_id'=> $valid['occupation'],
//  removed and replaced by locations
//            'county_id'=> $valid['county'],

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
            //'address1'=> $valid['address1'],
            //'address2'=> $valid['address2'],
            //'city'=> $valid['city'],
            //'state'=> $valid['state'],
            //'zip'=> $valid['zip'],
            'prefer_close_location'=> $valid['scheculePreference'],
            'submitted_at'=> Carbon::now(),
        ]);

        $registration->syncAddress($valid);

        // Assign phones and emails
            // add foreach loop to create all contact types

        //Combine email and phones
        $registration->contacts()->createMany(array_merge($phones,$emails));

        $registration->conditions()->sync($conditions);

        $this->logChanges($registration, 'submitted', true);

		$registration->notify(new Register());

        Session::flash('success', "<p>Registration submission was successful.</p><p>Be sure to fill out a <a href=\"/docs/consent_moderna.pdf\" target=\"_blank\" rel=\"noopener\" download aria-download=\"true\">Moderna Consent Form</a>.</p><p>Your code is:</p><p class=\"h3 mb-6\">".$code."</p>");
        return redirect('/home');
    }

    public function edit()
    {
        if (Auth::user()->registration) {
            return view('register.edit', ['registration' => Auth::user()->registration]);
        }

        abort(404);
    }

    public function update()
    {
        if (empty(Auth::user()->registration)) {
            abort(404);
        }

        $user = Auth::user();
        $valid = request()->validate($this->validationRules(true));
        $valid['scheculePreference'] = (bool) request('scheculePreference');

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
            'birth_date' => Carbon::parse($valid['dateOfBirth']),
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

        $registration = $user->registration;

        $registration->update([
            'race_id'=> $valid['race'],
            'gender_id'=> $valid['gender'],
            'occupation_id'=> $valid['occupation'],
//            removed - this is part of the locations functionality now
//            'county_id'=> $valid['county'],

            // Obtained by user account:
            'first_name' => $valid['firstName'],
            'middle_name' => $valid['middleName'],
            'last_name' => $valid['lastName'],
            //'email' => $valid['email'],
            //'phone' => $valid['phone'],
            'birth_date' => Carbon::parse($valid['dateOfBirth']),
            'suffix_id' => ($valid['suffix'] != '0' ? $valid['suffix'] : null),

            // New Info
            //'address1'=> $valid['address1'],
            //'address2'=> $valid['address2'],
            //'city'=> $valid['city'],
            //'state'=> $valid['state'],
            //'zip'=> $valid['zip'],
            'prefer_close_location'=> $valid['scheculePreference'],
        ]);

        $registration->syncAddress($valid);

        $registration->conditions()->sync($conditions);

        // rewrite if we start allowing multiple phones and emails
        $contacts = [];
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

        Session::flash('success', "<p>Registration edit was successful.</p>");
        return redirect('/home');
    }

    public function deleteRegistration()
    {
        $cur_user = Auth::user();
        $regis = $cur_user->registration;
        if(empty($regis)) {
            abort(404);
        }

        $this->logChanges($regis, 'deleted', true, false, ['deleted_by_self'=>true]);

        $regis->delete();

//      DPC
//        prefix the email address to avoid integrity constraint violation if the email is re-used later
//        (soft) delete the user; I checked, the user model has softdeletes
        //$cur_user = User::findOrFail($regis->user_id);
        $cur_user->email = $cur_user->id . rand(10000,99999) . '-' . $cur_user->email;
        $cur_user->update();
        $cur_user->delete();

        app(\App\Http\Controllers\Auth\LoginController::class)->inlineLogout(request());

        Session::flash('success', "<p>Registration was successfully deleted.</p>");
        return redirect('/');
    }

    private function validationRules($full = false)
    {
        $valid_races = implode(",",\App\Models\Race::pluck('id')->toArray());
        $valid_genders = implode(",",\App\Models\Gender::pluck('id')->toArray());
        $valid_occupations = implode(",",\App\Models\Occupation::pluck('id')->toArray());
        $valid_counties = implode(",",\App\Models\County::pluck('id')->toArray());
        $valid_states = implode(",",\App\Models\State::pluck('id')->toArray());

        $rules = [
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
            'condition' =>'nullable'
        ];

        if ($full) {
            $valid_suffixes = '0,'.implode(",",\App\Models\Suffix::pluck('id')->toArray());

            $rules = array_merge($rules, [
                'firstName' => ['required', 'string', 'max:255'],
                'middleName' => ['nullable', 'string', 'max:30'],
                'lastName' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'regex:/^(?=.*[0-9])[- +()0-9]+$/', 'max:14'],
                'dateOfBirth' => ['required', 'date', new DateParsable, new AtLeastThirteen],
                'suffix' => ['required', 'in:'.$valid_suffixes],
            ]);
        }

        return $rules;
    }
}
