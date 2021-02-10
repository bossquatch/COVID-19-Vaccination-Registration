<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Rules\ElevenDigits;

class VaccineController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['verified', 'can:create_vaccine']);
    }

    public function store()
    {
        // validate registration
        $inputs = request()->all();

        if (empty($inputs['registrationId'])) {
            abort(404);
        }
        $regis = \App\Models\Registration::findOrFail($inputs['registrationId']);

        $validator = Validator::make($inputs, $this->validationRules());

        if ($validator->fails()) {
            return json_encode(['status' => 'failed', 'errors' => $validator->errors()]);
        }

        $vaccine = \App\Models\Vaccine::create([
            'registration_id' => $inputs['registrationId'],
            'vaccine_type_id' => $inputs['vaccineName'],
            'manufacturer_id' => $inputs['manufacturer'],
            'injection_site_id' => $inputs['injectionSite'],
            'injection_route_id' => $inputs['injectionRoute'],
            'eligibility_id' => $inputs['eligibility'],
            'date_given' => $inputs['dateGiven'],
            'lot_number' => $inputs['lotNumber'],
            'ndc' => $inputs['ndc'],
            'exp_month' => $inputs['expDateMonth'],
            'exp_year' => $inputs['expDateYear'],
            'vis_publication' => $inputs['visPubDate'],
            'giver_fname' => $inputs['giverFirstName'],
            'giver_creds' => $inputs['giverCreds'],
            'giver_lname' => $inputs['giverLastName'],
        ]);

        if (!isset($inputs['risks'])) {
            $inputs['risks'] = [];
        }
        $vaccine->risk_factors()->sync($inputs['risks']);

        $this->checkCompleted($regis);

        return json_encode(['status' => 'success', 'html' => view('vaccine.partials.info', ['vaccine' => $vaccine])->render()]);
    }

    private function checkCompleted($registration)
    {
        if ($registration->vaccines()->count() >= 2) {
            $registration->status_id = 5;
            $registration->save();

            $this->logChanges($registration, 'completed', true);
        }
    }

    private function validationRules()
    {
        $valid_types = implode(",",\App\Models\VaccineType::pluck('id')->toArray());
        $valid_manus = implode(",",\App\Models\Manufacturer::pluck('id')->toArray());
        $valid_sites = implode(",",\App\Models\InjectionSite::pluck('id')->toArray());
        $valid_routes = implode(",",\App\Models\InjectionRoute::pluck('id')->toArray());
        $valid_eligs = implode(",",\App\Models\Eligibility::pluck('id')->toArray());

        $rules = [
            'registrationId' => ['required'],
            'dateGiven' => ['required', 'date'],
            'vaccineName' => ['required', 'in:'.$valid_types],
            'manufacturer' => ['required', 'in:'.$valid_manus],
            'lotNumber' => ['required', 'string', 'max:255'],
            'ndc' => ['required', 'string', 'max:255', new ElevenDigits],
            'expDateMonth' => ['required', 'integer', 'min:1', 'max:12'],
            'expDateYear' => ['required', 'integer', 'min:2021'],
            'visPubDate' => ['nullable', 'date'],
            'injectionSite' => ['required', 'in:'.$valid_sites],
            'injectionRoute' => ['required', 'in:'.$valid_routes],
            'eligibility' => ['required', 'in:'.$valid_eligs],
            'risks' => ['nullable'],
            'giverCreds' => ['nullable', 'string', 'max:255'],
            'giverLastName' => ['nullable', 'string', 'max:255'],
            'giverFirstName' => ['nullable', 'string', 'max:255'],
        ];

        return $rules;
    }
}
