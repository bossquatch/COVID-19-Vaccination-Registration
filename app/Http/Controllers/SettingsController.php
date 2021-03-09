<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['verified', 'can:read_event']);
    }

    public function index($id)
    {
        $event = \App\Models\Event::findOrFail($id);

        return view('event.settings', [
            'event' => $event,
            'settings' => $event->settings,
        ]);
    }

    public function update($id)
    {
        $valid = request()->validate($this->validationRules());

        $event = \App\Models\Event::findOrFail($id);
        $settings = $event->settings;

        if(!$settings) {
            abort(404);
        }

        if(isset($valid['vulnerability'])) {
            $vul = explode('|', $valid['vulnerability']);
            $valid['vulnerabilityMin'] = $vul[0] ?? null;
            $valid['vulnerabilityMax'] = $vul[1] ?? null;
        }

        if (isset($valid['zips'])) {
            $valid['zips'] = preg_replace('/\s+/', '', rtrim($valid['zips'],","));
        }

        $settings->update([
            'age_min' => $valid['ageMin'] ?? null,
            'age_max' => $valid['ageMax'] ?? null,
            'vulnerability_min' => $valid['vulnerabilityMin'] ?? null,
            'vulnerability_max' => $valid['vulnerabilityMax'] ?? null,
            'zips_string' => $valid['zips'] ?? null,
            'search_address' => $valid['autocomplete'] ?? null,
            'latitude' => $valid['latitude'] ?? null,
            'longitude' => $valid['longitude'] ?? null,
            'search_radius' => $valid['radius'] ?? null,
            'polk_only' => isset($valid['polkOnly']),
        ]);

        $settings->conditions()->sync(isset($valid['condition']) ? array_keys($valid['condition']) : []);
        $settings->occupations()->sync(isset($valid['occupation']) ? array_keys($valid['occupation']) : []);

        Session::flash('success', "Event settings were updated.");
        return redirect('/events/'.$event->id);
    }

    private function validationRules()
    {
        return [
            'ageMin' => 'nullable|numeric',
            'ageMax' => 'nullable|numeric',
            'condition' => 'nullable',
            'vulnerability' => 'nullable',
            'occupation' => 'nullable',
            'zips' => 'nullable',
            'autocomplete' => 'nullable',
            'polkOnly' => 'nullable',
            'latitude' => 'required_with:longitude,autocomplete,radius|nullable|numeric',
            'longitude' => 'required_with:latitude,autocomplete,radius|nullable|numeric',
            'radius' => 'required_with:longitude,autocomplete,latitude|nullable|numeric',
        ];
    }
}
