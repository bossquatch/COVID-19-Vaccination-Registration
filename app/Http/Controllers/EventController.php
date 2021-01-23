<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Rules\DateParsable;
use App\Models\Event;
use App\Models\Lot;
use Session;

class EventController extends Controller
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

    public function index()
    {
        return view('event.index', [
            'events' => Event::where('date_held', '>=', DB::raw('CURDATE()'))->orderBy('date_held', 'asc')->paginate(config('app.pagination_limit')),
            'lots' => Lot::get()->pluck('number')->all(),
        ]);
    }

    public function history()
    {
        return view('event.history', [
            'events' => Event::where('date_held', '<', DB::raw('CURDATE()'))->orderBy('date_held', 'desc')->paginate(config('app.pagination_limit')),
        ]);
    }

    public function read($id)
    {
        $event = Event::findOrFail($id);

        return view('event.details', [
            'event' => $event,
            'lots' => Lot::get()->pluck('number')->all(),
        ]);
    }

    public function open($id)
    {
        $event = Event::findOrFail($id);

        $event->open = true;
        $event->save();

        Session::flash('success', "Event was opened for scheduling.");
        return redirect('/events');
    }

    public function addLot($id)
    {
        $event = Event::findOrFail($id);
        if (request()->has('lot')) {
            $lot = Lot::firstOrCreate([
                'number' => request()->input('lot'),
            ]);

            $event->lots()->attach($lot->id);

            return json_encode(['status' => 'success', 'html' => $event->lot_numbers]);
        } else {
            return json_encode(['status' => 'danger']);
        }
    }

    public function store()
    {
        $valid = request()->validate($this->validationRules());

        $carbon_date = \Carbon\Carbon::parse($valid['date']);
        $slot_times = [];

        try {
            $slot_machine = new \App\Helpers\Events\SlotMachine($carbon_date, (int) $valid["start"], (int) $valid["end"], $valid['slotLength'], (int) $valid['slotCapacity']);
            $slot_times = $slot_machine->run();
        } catch (\App\Helpers\Events\SlotMachineException $e) {
            $val = Validator::make([],[]);
            $val->errors()->add('slotLength', 'Slot length does not divide equally into given start and end times');
            return redirect()->back()->withErrors($val->errors())->withInput($valid);
        }

        // Make sure we don't have two identical events
        $event = Event::firstOrCreate([
            'location_id' => $valid['location'],
            'date_held' => $carbon_date->format('Y-m-d'),
            'title' => $valid['title'],
            'open' => isset($valid['openAutomatically']),
        ]);

        // don't try to do anything else to the db if this is a duplicate event
        if ($event->wasRecentlyCreated) {
            $lot = Lot::firstOrCreate([
                'number' => $valid['lot'],
            ]);

            $event->lots()->attach($lot->id);
            $event->slots()->createMany($slot_times);
        }

        Session::flash('success', "Event was added.");
        return redirect('/events');
    }

    public function delete($id)
    {
        // Will need to work out how this works and how the repurcussions will impact the system
    }

    private function validationRules()
    {
        $valid_locations = implode(",",\App\Models\Location::pluck('id')->toArray());

        return [
            'title' => 'required|max:255',
            'date' => ['required', 'date', new DateParsable],
            'location' => 'required|in:'.$valid_locations,
            'start' => 'required|numeric|min:0|max:23',
            'end' => 'required|numeric|min:0|max:23|gt:start',
            'slotLength' => ['required', Rule::in(\App\Helpers\Events\SlotMachine::$validIntervals)],
            'slotCapacity' => 'required|numeric|min:0',
            'lot' => 'required|string|max:255',
            'openAutomatically' => 'nullable',
        ];
    }
}
