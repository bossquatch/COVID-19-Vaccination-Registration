<?php

/*
*       Event Scheduling Helper Class: The Post Process
*       Purpose: cleans up no shows at the end of the day as well as schedules a second event
*       Naming: The PO monitors the parolee's behavior to see whether or not they need to be sent back to prison
*/

namespace App\Helpers\Scheduling;

use App\Models\Invitation;
use App\Models\Event;
use App\Models\Registration;
use Carbon\Carbon;

class PostEvent
{
    // fulfill task
    public static function run()
    {
        // get events that need to be modified
        $events = self::toClean();

        // loop through
        foreach ($events as $event) {
            self::markNoShow($event->id);

            // get registrations that need a second appointment
            $registrations = self::regisNeedingSecondAppointment($event->id);
            $count = $registrations->count();
            
            if ($count > 0) {
                // clone the event
                $event_new = self::cloneEvent($event, 28);
                
                // invite the registrations to event
                self::reInvite($registrations, $event_new);
            }

            // close the old event
            $event->open = false;
            $event->save();
        }

        return true;
    }

    // gets processed events that need to be cleaned
    private static function toClean()
    {
        $yesterday = Carbon::yesterday();
        return Event::where([
            ['date_held', '=', $yesterday],
            ['open', '=', true],
        ])->get();
    }

    // mark the no shows
    private static function markNoShow($event_id)
    {
        $query = Invitation::whereHas('slot', function ($query) use ($event_id) {
                $query->where('event_id', '=', $event_id);
            })->where('invite_status_id', '=', 6);
            
        Registration::whereIn('id', $query->pluck('registration_id')->toArray())->update([
                'status_id' => 1
            ]);
            
        $query->update([
                'invite_status_id' => 8
            ]);
    }

    // find registrations of an event that need a second vaccine
    private static function regisNeedingSecondAppointment($event_id)
    {
        return Registration::select('id', 'status_id')
            ->withCount('vaccines as received_vaccines_count')
            ->having('received_vaccines_count', '<', 2)
            ->whereHas('invitations', function ($query) use ($event_id) {
                $query->whereHas('slot', function ($query) use ($event_id) {
                    $query->where('event_id', '=', $event_id);
                })->whereIn('invite_status_id', [7, 10]);                       // Assuming people checked in have recieved the vaccine
            })->get();
    }

    // clone an event X amount of days later
    private static function cloneEvent($event, $interval)
    {
        // create a new event with same partners and timeslots, just $interval days later
        $event_new = Event::create([
            'location_id' => $event->location_id,
            'date_held' => Carbon::parse($event->date_held)->addDays($interval),
            'title' => $event->title,
            'open' => false,
            'partner_handled' => $event->partner_handled,
        ]);

        // handle partners
        if ($event->partner_handled) {
            $partners = $event->tags()->pluck('id')->toArray();
            $event_new->tags()->sync($partners);
        }

        // handle slots
        foreach($event->slots as $slot) {
            $event_new->slots()->create([
                'starting_at' => Carbon::parse($slot->starting_at)->addDays($interval),
                'ending_at' => Carbon::parse($slot->ending_at)->addDays($interval),
                'capacity' => $slot->capacity,
            ]);
        }

        return $event_new;
    }

    // invite registrations to event
    private static function reInvite($registrations, $event)
    {
        $slots = $event->slots->all();
        $slot_num = 0;
        $regis_ids = $registrations->pluck('id');
        $regis_keys = [];
        foreach ($regis_ids as $id) {
            if (count($regis_keys) >= $slots[$slot_num]->capacity) {
                $slots[$slot_num]->invitations()->createMany($regis_keys);
                $slot_num += 1;
                $regis_keys = [];
            }

            $regis_keys[] = [
                "registration_id" => $id,
                "invite_status_id" => 1,
            ];
        }

        // assign
        Registration::whereIn('id', $regis_ids)->update(['status_id' => 2]);               // set the registrations to appointment pending
        $slots[$slot_num]->invitations()->createMany($regis_keys);                                     // create the invitations
    } 
}