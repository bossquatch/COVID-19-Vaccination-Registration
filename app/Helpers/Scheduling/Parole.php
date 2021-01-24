<?php

/*
*       Event Scheduling Helper Class: The Parole (Officer)
*       Purpose: views active invitations and automatically denies invitations that expired
*       Naming: The PO monitors the parolee's behavior to see whether or not they need to be sent back to prison
*/

namespace App\Helpers\Scheduling;

use App\Models\Invitation;
use App\Models\InviteStatus;
use App\Models\Registration;
use Carbon\Carbon;

class Parole
{
    // easy-to-set revert status id for registrations that got invitations expired
    protected static $revert_id = 1;

    // fulfill task
    public static function run()
    {
        // stage ruleset
        $hours = config('app.invitation_expire');
        $stamp = Carbon::now()->subHours($hours);

        // query for active and contacted invitations within time period
        $report = self::report($stamp);

        // grab registration ids to update
        $registrations = $report->get()->pluck('registration_id');

        // expire the invitations
        self::expire($report);

        // update registrations
        self::revert($registrations);

        return true;
    }

    // create report for expiring invitations
    protected static function report($expire_stamp)
    {
        return Invitation::whereHas('invite_status', function ($query) {
                $query->where('name', 'Awaiting Response');
            })->whereNotNull('contacted_at')
            ->where([
                ['contacted_at', '<=', $expire_stamp]
            ]);
    }

    // expire the invitations
    protected static function expire($report) 
    {
        $status_id = InviteStatus::where('name', 'Expired')->first()->id;
        $report->update(['invite_status_id' => $status_id]);
    }

    // revert failed registrations back to where they belong
    protected static function revert($ids) 
    {
        Registration::whereIn('id', $ids)
            ->update(['status_id' => self::$revert_id]);
    }
}