<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['verified', 'can:create_registration']);
    }

    public function submitRegistration()
    {
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
        $user = Auth::user();

        if (!empty($user->phone)) {
            $phones = [[
                "contact_type_id" => 2,
                "phone_type_id" => 1,
                "value" => $user->phone,
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

        $this->logChanges($registration, 'submitted', true);

        Session::flash('success', "Registration submission was successful.  Your code is: ".$code);
        return redirect('/home');
    }

    private function validationRules()
    {
        $valid_races = implode(",",\App\Models\Race::pluck('id')->toArray());
        $valid_genders = implode(",",\App\Models\Gender::pluck('id')->toArray());
        $valid_occupations = implode(",",\App\Models\Occupation::pluck('id')->toArray());
        $valid_counties = implode(",",\App\Models\County::pluck('id')->toArray());

        $rules = [
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
