<?php

/*
*       Event Scheduling Helper Class: The Judge
*       Purpose: Views pending invitations and decides whether it can contact the registrant or if the sentence has to be carried out by someone else.
*       Naming: The Judge delivers the sentence
*/

namespace App\Helpers\Scheduling;

use App\Models\Invitation;
use App\Mail\OpenInvitation;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Services\Twilio\Messenger;
use App\Notifications\Invite;

class Judge
{
    protected static $limit = 100;

    // fulfill task
    public static function run()
    {
        // get pending invites
        $cases = self::lineup();

        // got through, case by case...
        foreach ($cases as $case) {
            // determine if contactable and sentence accordingly 
            if ($case->auto_contactable && !$case->partner_handled) {
                self::sendInvite($case);
                
                if ($case->can_sms) {
                    $case->contact_method_id = 6;
                } else {
                    $case->contact_method_id = 4;
                }

                if ($case->isDirty('contact_method_id')) {
                    $case->invite_status_id = 3;
                    $case->contacted_at = Carbon::now();
                    $case->save();
                } else {
                    self::queueForAnother($case);
                }
            } else {
                self::queueForAnother($case);
            }
        }

        return true;
    }

    // get a lineup
    protected static function lineup()
    {
        return Invitation::select('invitations.*')
            ->join('slots', 'invitations.slot_id', '=', 'slots.id')
            ->whereHas('invite_status', function ($query) {
                $query->where('name', 'Assigned');
            })->orderBy('slots.starting_at')->limit(self::$limit)->get();
    }

    // cannot be auto contacted, queue for manual contact
    protected static function queueForAnother($invitation)
    {
        $invitation->invite_status_id = 2;
        $invitation->save();
    }

    // send out an email to the registrant
    protected static function sendEmail($invitation)
    {
        Mail::to($invitation->user)->send(new OpenInvitation($invitation));
        return true;
    }

    // send out an sms to the registrant
    protected static function sendSms($invitation)
    {
        $reg = $invitation->registration;
        $messenger = new Messenger;
        $message = $reg->first_name . ' ' . $reg->last_name . ', your COVID-19 vaccination appointment has been scheduled.  Please sign into register.polk.health in order to accept this invitation.  This invite will expire at ' . Carbon::now()->addHours(config('app.invitation_expire'))->format("h:iA M d, Y") . '.';
        
        return $messenger->sendMessage($invitation->user->phone, $message);
    }

    // queable notifications
    protected static function sendInvite($invitation)
    {
        $registration = $invitation->registration;
        $registration->notify(new Invite());
    }
}