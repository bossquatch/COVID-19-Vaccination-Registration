<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SlotController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['verified']);
    }

    public function options($event_id) 
    {
        $event = \App\Models\Event::findOrFail($event_id);

        $slots = $event->slots()->select('id', 'event_id', 'capacity', 'deleted_at', 'starting_at', 'ending_at', 'reserved')
            ->withCount([
                'invitations as active_invitations_count' => function ($query) {
                    $query->whereHas('invite_status', function ($query) {
                        $query->whereNotIn('id', [4, 5]);
                    });
                },
            ])->havingRaw('`capacity` > `active_invitations_count`')->get();        // allow retroactive assigning to filled slots via reservation

        if ($slots->count() > 0) {
            return json_encode(['status' => 'success', 'html' => view('manage.partials.slotoptions', ['slots' => $slots])->render()]);
        } else {
            return json_encode(['status' => 'danger', 'message' => 'No slots available']);
        }
    }

    public function forceInvite($regis_id)
    {
        $registration = \App\Models\Registration::findOrFail($regis_id);
        $inputs = request()->all();
        
        $validator = Validator::make($inputs, $this->validationRules());

        if ($validator->fails()) {
            return json_encode(['status' => 'failed', 'message' => 'Event and slot inputs are required!', 'errors' => $validator->errors()]);
        }

        $slot = \App\Models\Slot::findOrFail($inputs['slot']);
        $event = \App\Models\Event::findOrFail($inputs['event']);
        if ($slot->event_id != $event->id) {
            return json_encode(['status' => 'failed', 'message' => 'Slot is not affiliated with selected event!']);
        }

        if (!$slot->has_stock) {
            return json_encode(['status' => 'failed', 'message' => 'Slot has no more capacity!']);
        }

        if (in_array($registration->id, $event->invitations()->pluck('registration_id')->toArray())) {
            return json_encode(['status' => 'failed', 'message' => 'Registration already affiliated with the event!']);
        }

        if (\Carbon\Carbon::parse($event->date_held)->greaterThan(\Carbon\Carbon::now())) {
            $registration->invitations()->create([
                'slot_id' => $slot->id,
                'invite_status_id' => 6
            ]);
            $registration->status_id = 3;
            $registration->save();
            $registration->notify(new Confirm());
        } else {
            $registration->invitations()->create([
                'slot_id' => $slot->id,
                'invite_status_id' => 10
            ]); 
        }

        $this->logChanges($registration, 'force invite', true, false, ['forced by' => Auth::id()]);

        return json_encode(['status' => 'success']);
    }

    private function validationRules()
    {
        return [
            'event' => 'required|integer',
            'slot' => 'required|integer',
        ];
    }
}
