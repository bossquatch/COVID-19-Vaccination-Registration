<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use Session;

class LocationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['verified', 'can:read_location']);
    }

    public function index()
    {
        return view('location.index', [
            'locations' => Location::orderBy('created_at', 'desc')->paginate(config('app.pagination_limit')),
        ]);
    }

    public function store()
    {
        $valid = request()->validate($this->validationRules());
        Location::create($valid);

        Session::flash('success', "Location was added.");
        return $this->index();
    }

    public function delete($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        Session::flash('success', "Location was removed.");
        return $this->index();
    }

    private function validationRules()
    {
        return [
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'city' => 'required|max:60',
            'state' => 'required|max:2',
            'zip' => 'required|max:11',
        ];
    }
}
