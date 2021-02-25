<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Exports\EventReport;
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
            'events' => Event::where('date_held', '>=', DB::raw('CURDATE()'))->orderBy('date_held', 'asc')->orderBy('created_at', 'asc')->paginate(config('app.pagination_limit')),
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

    public function close($id)
    {
        $event = Event::findOrFail($id);

        $event->open = false;
        $event->save();

        Session::flash('success', "Event was closed for scheduling.");
        return redirect('/events');
    }

    public function addLot($id)
    {
        $event = Event::findOrFail($id);
        $lots = [];

        if (request()->has('lots')) {
            foreach (request()->get('lots') as $lot_id) {
                // validate that the lot number is not empty
                if (trim($lot_id) != '') {
                    $lot = Lot::find($lot_id);
                    $lots[] = $lot_id;
                }
            }
            $event->lots()->sync($lots);

            return json_encode(['status' => 'success', 'html' => $event->lot_numbers]);
        } else {
            return json_encode(['status' => 'danger']);
        }
    }

    public function report($id)
    {
        $event = Event::findOrFail($id);

        return new EventReport($event->id, $event->date_held);
    }

    public function store()
    {
        $valid = request()->validate($this->validationRules());
        
        $carbon_date = \Carbon\Carbon::parse($valid['date']);
        $slot_times = [];
        $lots = explode(",",$valid['lots']);

        try {
            $slot_machine = new \App\Helpers\Events\SlotMachine($carbon_date, (float) $valid["start"], (float) $valid["end"], $valid['slotLength'], (float) $valid['slotCapacity']);
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
            'send_auto_notifs' => isset($valid['autoNotify']),
            'partner_handled' => isset($valid['partners']),
        ]);

        // don't try to do anything else to the db if this is a duplicate event
        if ($event->wasRecentlyCreated) {
            foreach ($lots as $lot_id) {
                // validate that the lot number is not empty
                if (trim($lot_id) != '') {
                    $lot = Lot::find($lot_id);
                    if ($lot) {
                        $event->lots()->attach($lot->id);
                    }
                }
            }
            
            $event->slots()->createMany($slot_times);

            if(isset($valid['partners'])) {
                $event->tags()->sync(array_keys($valid['partners']));
            }

            // SETTINGS

            if(isset($valid['vulnerability'])) {
                $vul = explode('|', $valid['vulnerability']);
                $valid['vulnerabilityMin'] = $vul[0] ?? null;
                $valid['vulnerabilityMax'] = $vul[1] ?? null;
            }

            if (isset($valid['zips'])) {
                $valid['zips'] = preg_replace('/\s+/', '', rtrim($valid['zips'],","));
            }

            $settings = $event->settings()->create([
                'age_min' => $valid['ageMin'] ?? null,
                'age_max' => $valid['ageMax'] ?? null,
                'vulnerability_min' => $valid['vulnerabilityMin'] ?? null,
                'vulnerability_max' => $valid['vulnerabilityMax'] ?? null,
                'zips_string' => $valid['zips'] ?? null,
                'search_address' => $valid['autocomplete'] ?? null,
                'latitude' => $valid['latitude'] ?? null,
                'longitude' => $valid['longitude'] ?? null,
                'search_radius' => $valid['radius'] ?? null,
            ]);

            $settings->conditions()->sync(isset($valid['condition']) ? array_keys($valid['condition']) : []);
            $settings->occupations()->sync(isset($valid['occupation']) ? array_keys($valid['occupation']) : []);
        }

        Session::flash('success', "Event was added.");
        return redirect('/events');
    }

    public function update($id)
    {
        $valid = request()->validate($this->validationRules(false));

        $carbon_date = \Carbon\Carbon::parse($valid['date']);

        $event = Event::findOrFail($id);
        $new_date = ($event->date_held != $carbon_date->format('Y-m-d'));
        $event->update([
            'location_id' => $valid['location'],
            'date_held' => $carbon_date->format('Y-m-d'),
            'title' => $valid['title'],
            'send_auto_notifs' => isset($valid['autoNotify']),
        ]);

        if ($new_date) {
            foreach ($event->slots as $slot) {
                $new_start = $carbon_date->copy();
                $new_end = $carbon_date->copy();

                $new_start->hour = \Carbon\Carbon::parse($slot->starting_at)->hour;
                $new_start->minute = \Carbon\Carbon::parse($slot->starting_at)->minute;
                $new_end->hour = \Carbon\Carbon::parse($slot->ending_at)->hour;
                $new_end->minute = \Carbon\Carbon::parse($slot->ending_at)->minute;

                $slot->update([
                    'starting_at' => $new_start,
                    'ending_at' => $new_end,
                ]);
            }
        }

        Session::flash('success', "Event was updated.");
        return redirect()->back();
    }

    public function delete($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();   // listeners will handle the slots & invitataions being removed

        Session::flash('success', 'Event was cancelled.');
        return redirect('/events');
    }

    public function pendingInvites($id)
    {
        $event = Event::findOrFail($id);
        $invitations = $event->pending_callbacks_query()->paginate(config('app.pagination_limit'));

        return view('event.invites', [
            'invites' => $invitations,
            'event' => $event,
        ]);
    }

    public function slotInvites($event_id, $slot_id)
    {
        $slot = \App\Models\Slot::findOrFail($slot_id);
        if ($slot->event_id != $event_id) { abort(404); }

        $invitations = $slot->invitations()->whereHas('invite_status', function ($query) {
                $query->whereNotIn('id', [4, 5]);
            })->paginate(config('app.pagination_limit'));

        return view('event.slotlist', [
            'invites' => $invitations,
            'slot' => $slot,
        ]);
    }

    public function slotDelete($event_id, $slot_id)
    {
        $slot = \App\Models\Slot::findOrFail($slot_id);
        if ($slot->event_id != $event_id) { abort(404); }

        $slot->delete();

        Session::flash('success', 'Slot was removed.');
        return redirect('/events/'.$event_id);
    }

    public function reserve($event_id, $slot_id) 
    {
        $slot = \App\Models\Slot::findOrFail($slot_id);
        if ($slot->event_id != $event_id) { abort(404); }
        $valid = request()->validate(['amount' => 'required|numeric|min:0|max:'.($slot->capacity - $slot->active_invitation_count)]);

        $slot->reserved = $valid['amount'];
        $slot->save();

        Session::flash('success', "Reserved seats in slot were set.");
        return redirect('/events/'.$slot->event_id);
    }

    public function newSlot($id)
    {
        $valid = request()->validate([
            'startTime' => ['required', 'date'],
            'slotLength' => ['required', Rule::in(['15 minutes', '30 minutes', '1 hour', '2 hours'])],
            'slotCapacity' => 'required|numeric|min:0',
        ]);

        $event = Event::findOrFail($id);

        $period = new \Carbon\CarbonPeriod(\Carbon\Carbon::parse($valid['startTime']), $valid['slotLength'], \Carbon\Carbon::parse($valid['startTime'])->add($valid['slotLength']));
        if ($event->intersectsSlot($period)) {
            return redirect()->back()->withErrors(['slotLength' => 'Chosen time slot length causes an overlap with existing time slots'])->withInput();
        }

        $event->slots()->create([
            'starting_at' => \Carbon\Carbon::parse($valid['startTime']),
            'ending_at' => \Carbon\Carbon::parse($valid['startTime'])->add($valid['slotLength']),
            'capacity' => $valid['slotCapacity']
        ]);

        Session::flash('success', "Time slot added.");
        return redirect()->back();
    }

    private function validationRules($full = true)
    {
        $valid_locations = implode(",",\App\Models\Location::pluck('id')->toArray());
        $valid_lots = implode(",",\App\Models\Lot::pluck('id')->toArray());

        if ($full) {
            return [
                'title' => 'required|max:255',
                'date' => ['required', 'date', new DateParsable],
                'location' => 'required|in:'.$valid_locations,
                'start' => 'required|numeric|min:0|max:23',
                'end' => 'required|numeric|min:0|max:23|gt:start',
                'slotLength' => ['required', Rule::in(\App\Helpers\Events\SlotMachine::$validIntervals)],
                'slotCapacity' => 'required|numeric|min:0',
                'lots' => 'required',
                'autoNotify' => 'nullable',
                'openAutomatically' => 'nullable',
                'partners.*' => 'nullable',
                'ageMin' => 'nullable|numeric',
                'ageMax' => 'nullable|numeric',
                'condition' => 'nullable',
                'vulnerability' => 'nullable',
                'occupation' => 'nullable',
                'zips' => 'nullable',
                'autocomplete' => 'nullable',
                'latitude' => 'required_with:longitude,autocomplete,radius|nullable|numeric',
                'longitude' => 'required_with:latitude,autocomplete,radius|nullable|numeric',
                'radius' => 'required_with:longitude,autocomplete,latitude|nullable|numeric',
            ];
        } else {
            return [
                'title' => 'required|max:255',
                'date' => ['required', 'date', new DateParsable],
                'location' => 'required|in:'.$valid_locations,
                'autoNotify' => 'nullable',
            ];
        }
    }
}
