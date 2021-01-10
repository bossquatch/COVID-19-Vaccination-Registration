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
        $this->middleware(['auth', 'can:create_registration']);
    }

    public function submitRegistration()
    {
        $valid = request()->validate($this->validationRules());
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
        $agreements = array_keys($valid['agreement']);
        $user = Auth::user();

        $registration = \App\Models\Registration::create([
            'code'=> $code,
            'user_id'=> Auth::id(),
            'race_id'=> $valid['race'],
            'gender_id'=> $valid['gender'],
            
            // Obtained by user account:
            'first_name'=> $user->first_name,
            'middle_name'=> $user->middle_name,
            'last_name'=> $user->last_name,
            'email'=> $user->email,
            'phone'=> $user->phone,
            'birth_date'=> $user->birth_date,

            // New Info
            'address1'=> $valid['address1'],
            'address2'=> $valid['address2'],
            'city'=> $valid['city'],
            'state'=> $valid['state'],
            'zip'=> $valid['zip'],
            'submitted_at'=> Carbon::now(),
        ]);

        $registration->agreements()->sync($agreements);

        $this->logChanges($registration, 'submitted', true);

        Session::flash('success', "Registration submission was successful.  Your code is: ".$code);
        return redirect('/home');
    }

    private function validationRules()
    {
        $valid_races = implode(",",\App\Models\Race::pluck('id')->toArray());
        $valid_genders = implode(",",\App\Models\Gender::pluck('id')->toArray());

        $rules = [
            'race' => 'required|in:'.$valid_races,
            'gender' => 'required|in:'.$valid_genders,
            'address1' => 'required|max:60',
            'address2' => 'nullable|max:60',
            'city' => 'required|max:60',
            'state' => 'required|max:2',
            'zip' => 'required|max:11',
            'vaccineAgreement' => 'accepted',
            'reactionAgreement' =>'accepted',
            'agreement' =>'nullable'
        ];

        return $rules;
    }
}
