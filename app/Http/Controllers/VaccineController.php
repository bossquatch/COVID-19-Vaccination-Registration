<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Rules\ElevenDigits;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

        if ($inputs['giver'] ?? null) {
            $vac = \App\Models\User::findOrFail($inputs['giver']);            
        } else {
            $vac = Auth::user();
        }

        $inputs['giverFirstName'] = $vac->first_name;
        $inputs['giverCreds'] = $vac->creds;
        $inputs['giverLastName'] = $vac->last_name;

        $vaccine = \App\Models\Vaccine::create([
            'registration_id' => $inputs['registrationId'],
            'vaccine_type_id' => $inputs['vaccineName'] ?? 1,                                               // default: Moderna
            'manufacturer_id' => $inputs['manufacturer'] ?? 1,                                              // default: Moderna
            'injection_site_id' => $inputs['injectionSite'],
            'injection_route_id' => $inputs['injectionRoute'] ?? 2,                                         // default: Intramuscular
            'eligibility_id' => $inputs['eligibility'] ?? 1,                                                // default: ?
            'date_given' => $inputs['dateGiven'] ?? Carbon::today(),                                        // default: today
            'lot_number' => $inputs['lotNumber'],
            'ndc' => $inputs['ndc'] ?? '08077727399',                                                       // default: normal NDC
            'exp_month' => $inputs['expDateMonth'] ?? Carbon::today()->addMonth()->format('m'),             // default: next month
            'exp_year' => $inputs['expDateYear'] ?? Carbon::today()->addMonth()->format('Y'),               // default: next month
            'vis_publication' => $inputs['visPubDate'] ?? '2020-12-18',
            'giver_fname' => $inputs['giverFirstName'],
            'giver_creds' => $inputs['giverCreds'],
            'giver_lname' => $inputs['giverLastName'],
            'user_id' => Auth::id(),
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
        $valid_givers = implode(",",\App\Models\User::whereHas('roles', function($query) { $query->where('name', '=', 'vac'); })->pluck('id')->toArray());

        $rules = [
            'registrationId' => ['required'],
            'dateGiven' => ['nullable', 'date'],
            'vaccineName' => ['nullable', 'in:'.$valid_types],
            'manufacturer' => ['nullable', 'in:'.$valid_manus],
            'lotNumber' => ['required', 'string', 'max:255'],
            'ndc' => ['nullable', 'string', 'max:255', new ElevenDigits],
            'expDateMonth' => ['nullable', 'integer', 'min:1', 'max:12'],
            'expDateYear' => ['nullable', 'integer', 'min:2021'],
            'visPubDate' => ['nullable', 'date'],
            'injectionSite' => ['required', 'in:'.$valid_sites],
            'injectionRoute' => ['nullable', 'in:'.$valid_routes],
            'eligibility' => ['required', 'in:'.$valid_eligs],
            'risks' => ['nullable'],
            'giver' => ['nullable', 'in:'.$valid_givers]
            //'giverCreds' => ['nullable', 'string', 'max:255'],
            //'giverLastName' => ['nullable', 'string', 'max:255'],
            //'giverFirstName' => ['nullable', 'string', 'max:255'],
        ];

        return $rules;
    }
}
