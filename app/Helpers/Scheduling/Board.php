<?php

/*
*       Event Scheduling Helper Class: The Board
*       Purpose: takes empty slots from upcoming events and assigns what registrations will go in on what slot.
*       Naming: The Board decides what prisoners go on parole and when
*/

namespace App\Helpers\Scheduling;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Slot;
use App\Models\Registration;
use App\Models\Address;
use App\Models\Invitation;
use Carbon\Carbon;

class Board
{
    // fulfill task
    public static function run()
    {
        // get slots
        $slots = self::stack();
        
        // for each slot:
        foreach ($slots as $slot) {
            $registrations = self::evaluate(($slot->capacity - ($slot->active_invitations_count + $slot->reserved)), Carbon::parse($slot->starting_at)->format('Y-m-d'), $slot->event_id, $slot->event->settings->queryMods())->get();
            $regis_ids = $registrations->pluck('id');
            $regis_keys = [];
            foreach ($regis_ids as $id) {
                $regis_keys[] = [
                    "registration_id" => $id,
                    "invite_status_id" => 1,
                ];
            }

            // assign
            Registration::whereIn('id', $regis_ids)->update(['status_id' => 2]);               // set the registrations to appointment pending
            $slot->invitations()->createMany($regis_keys);                                     // create the invitations
        }

        return true;
    }

    // build the slots stack
    protected static function stack()
    {
        $start_at = Carbon::now()->addHours(1);
        $date_limit = Carbon::today()->addDays(25);
        return Slot::select('id', 'event_id', 'capacity', 'reserved', 'starting_at')
            ->withCount([
                'invitations as active_invitations_count' => function (Builder $query) {
                    $query->whereHas('invite_status', function (Builder $query) {
                        $query->whereNotIn('id', [4, 5, 9]);
                    });
                },
            ])->havingRaw('(`slots`.`capacity` - `slots`.`reserved`) > `active_invitations_count`')                        // only get slots with seats available
            ->whereHas('event', function(Builder $query) {                                  // only get from open events
                $query->where('open', true);
            })->where([
                ['starting_at', '>=', $start_at],                                           // don't schedule for old slots
                ['starting_at', '<', $date_limit],                                          // don't schedule too far out (avoiding registrations from getting one vac and not the other)
            ])->orderBy('starting_at')->limit(10)->get();                                   // grab the slots starting the soonest
    }

    // query valid registrations
    protected static function evaluate($capacity, $date, $event, $where_callback)
    {
        $age_limit = Carbon::today()->subYears(65);

        // new and "improved" process with address grouping
        $address_ids = Registration::select('address_id')
            ->withCount('vaccines as received_vaccines_count')
            ->having('received_vaccines_count', '<', 2)                                 // don't grab those with both vaccinations
            ->has('user')
            ->whereHas('status', function (Builder $query) {                            // only grab registrations in a wait list
                $query->where('name', '=', 'In Wait List');
            })->whereDoesntHave('vaccines', function (Builder $query) use ($date) {     // don't grab those who have waited too long or too little for second vaccine
                $query->whereRaw('DATEDIFF("' . $date . '", date_given) < 26')
                    ->orWhereRaw('DATEDIFF("' . $date . '", date_given) > 30');
            })->whereDoesntHave('invitations', function (Builder $query) use ($event) {
                $query->whereHas('slot', function (Builder $query) use ($event) {
                    $query->where('event_id', '=', $event);                                   // don't invite those who have had invitations to the same event
                });
            })->where($where_callback)                                                  // base of callback mods
            ->where(function ($query) {
                $query->doesntHave('address')
                    ->orWhereHas('address.state', function ($query) {
                        $query->where('abbr', '=', 'FL');
                    });
            })->orderBy('received_vaccines_count', 'desc')                                // prioritize those who need a second vaccine
            ->orderBy('submitted_at', 'asc')                                            // FIFO the registrants
            ->limit($capacity)->pluck('address_id');

        $addresses = Address::select('id')
            ->whereIn(DB::raw("CONCAT(COALESCE(`street_number`, ''),COALESCE(`street_name`, ''),COALESCE(`line_2`, ''))"), function ($query) use ($address_ids) {
                $query->selectRaw("CONCAT(COALESCE(`addr`.`street_number`, ''),COALESCE(`addr`.`street_name`, ''),COALESCE(`addr`.`line_2`, '')) as `concat_address`")->from('addresses as addr')->whereIn('id', $address_ids);
            })->orderBy(DB::raw("CONCAT(COALESCE(`street_number`, ''),COALESCE(`street_name`, ''),COALESCE(`line_2`, ''))"))
            ->pluck('id');

        return Registration::select('id', 'status_id', 'submitted_at')
            ->addSelect(['addr' => Address::selectRaw("CONCAT(COALESCE(`street_number`, ''),COALESCE(`street_name`, ''),COALESCE(`line_2`, '')) as `concat_address`")
                ->whereColumn('addresses.id', 'registrations.address_id')
                ->limit(1)])
            ->withCount('vaccines as received_vaccines_count')
            ->having('received_vaccines_count', '<', 2)                                 // don't grab those with both vaccinations
            ->has('user')
            ->whereHas('status', function (Builder $query) {                            // only grab registrations in a wait list
                $query->where('name', '=', 'In Wait List');
            })->whereDoesntHave('vaccines', function (Builder $query) use ($date) {     // don't grab those who have waited too long or too little for second vaccine
                $query->whereRaw('DATEDIFF("' . $date . '", date_given) < 26')
                    ->orWhereRaw('DATEDIFF("' . $date . '", date_given) > 30');
            })->whereDoesntHave('invitations', function (Builder $query) use ($event) {
                $query->whereHas('slot', function (Builder $query) use ($event) {
                    $query->where('event_id', '=', $event);                                   // don't invite those who have had invitations to the same event
                });
            })->where($where_callback)                                                  // base of callback mods
            ->where(function ($query) {
                $query->doesntHave('address')
                    ->orWhereHas('address.state', function ($query) {
                        $query->where('abbr', '=', 'FL');
                    });
            })->where(function ($query) use ($addresses) {
                $query->whereIn('address_id', $addresses)
                    ->orWhereNull('address_id');
            })->orderBy('received_vaccines_count', 'desc')                              // prioritize those who need a second vaccine
            ->orderBy(
                Address::selectRaw("CONCAT(COALESCE(`street_number`, ''),COALESCE(`street_name`, ''),COALESCE(`line_2`, '')) as `concat_address`")
                    ->whereColumn('addresses.id', 'registrations.address_id')
                    ->limit(1),
                'asc'
            )->orderBy('submitted_at', 'asc')                                            // FIFO the registrants
            ->limit($capacity);


        // previous query (no address grouping)
        /*
        return Registration::select('id', 'status_id')
            ->withCount('vaccines as received_vaccines_count')
            ->having('received_vaccines_count', '<', 2)                                 // don't grab those with both vaccinations
            ->whereHas('status', function (Builder $query) {                            // only grab registrations in a wait list
                $query->where('name', '=', 'In Wait List');
            })->whereDoesntHave('vaccines', function (Builder $query) use ($date) {     // don't grab those who have waited too long or too little for second vaccine
                $query->whereRaw('DATEDIFF("' . $date . '", date_given) < 26')
                    ->orWhereRaw('DATEDIFF("' . $date . '", date_given) > 30');
            })->whereDoesntHave('invitations', function (Builder $query) use ($slot) {
                $query->where('slot_id', '=', $slot);                                   // don't invite those who have had invitations to the same slot
            })->where([    
                ['birth_date', '<=', $age_limit],                                       // only grab age group
            ])->orderBy('received_vaccines_count', 'desc')                              // prioritize those who need a second vaccine
            ->orderBy('submitted_at', 'asc')                                            // FIFO the registrants
            ->limit($capacity);
            */
    }
}