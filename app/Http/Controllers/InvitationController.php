<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\Confirm;
use App\Notifications\Decline;
use App\Notifications\Postpone;
use Session;

class InvitationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['verified']);
    }

    public function accept()
    {
        $registration = Auth::user()->registration;
        if(!$registration) { abort(404); }

        $invite = $registration->pending_invitation;
        if(!$invite) { abort(404); }

        $this->acceptInvite($registration, $invite);
        $registration->comments()->create([
            'user_id' => Auth::id(),
            'text' => 'Appointment was accepted via user.',
            'system_notification' => true,
        ]);
        if ($registration->auto_contactable) {
            $registration->notify(new Confirm());
        }

        Session::flash('success', "<p>Appointment Accepted!</p><p>Be sure to fill out a <a href=\"/docs/consent_moderna.pdf\" target=\"_blank\" rel=\"noopener\" download aria-download=\"true\">Moderna Consent Form</a> and bring it to your appointment as well as proof of Florida residency.</p><p>If you are receiving the 
        inoculation as extremely vulnerable you must bring a completed <a href=\"/docs/EO-21-47-Form.pdf\" target=\"_blank\" rel=\"noopener\" download aria-download=\"true\">EO-21-47-Form</a> 
        and include a statement from the physician that the patient meets eligibility criteria outlined on the <a href=\"https://floridahealthcovid19.gov/high-risk-populations/\">
        Florida Department of Health website</a>.");
        return redirect('/home');
    }

    public function postpone()
    {
        $registration = Auth::user()->registration;
        if(!$registration) { abort(404); }

        $invite = $registration->pending_invitation;
        if(!$invite) { abort(404); }

        $this->postponeInvite($registration, $invite);
        $registration->comments()->create([
            'user_id' => Auth::id(),
            'text' => 'Appointment was postponed via user.',
            'system_notification' => true,
        ]);
        if ($registration->auto_contactable) {
            $registration->notify(new Postpone());
        }

        Session::flash('success', "<p>You have declined your invitation and will be returned to the wait list. We will attempt to invite you to our next event.</p>");
        return redirect('/home');
    }

    public function decline()
    {
        $registration = Auth::user()->registration;
        if(!$registration) { abort(404); }

        $invite = $registration->pending_invitation;
        if(!$invite) { abort(404); }

        $this->declineInvite($registration, $invite);
        $registration->comments()->create([
            'user_id' => Auth::id(),
            'text' => 'Appointment was declined via user.',
            'system_notification' => true,
        ]);
        if ($registration->auto_contactable) {
            $registration->notify(new Decline());
        }

        Session::flash('success', "<p>You have declined your invitation to any of our events and will not be contacted again for further appointments. If you would like to be placed back on the wait list at a later time please contact our call center at <a href=\"tel:863-298-7500\">(863) 298-7500</a>.</p>");
        return redirect('/home');
    }

    public function acceptCallback($id)
    {
        $registration = \App\Models\Registration::findOrFail($id);

        $invite = $registration->pending_invitation;
        if(!$invite) { abort(404); }

        $invite->contacted_by = Auth::id();
        $invite->contacted_at = \Carbon\Carbon::now();
        $invite->contact_method_id = 1;
        $this->acceptInvite($registration, $invite);
        $registration->comments()->create([
            'user_id' => Auth::id(),
            'text' => 'Appointment was accepted via call center.',
        ]);
        if ($registration->auto_contactable) {
            $registration->notify(new Confirm());
        }

        Session::flash('success', "<p>Appointment Accepted!</p><p>Be sure to remind the registrant to bring proof of Florida residency to their appointment.</p>");
        return redirect('/events/'.$invite->event->id.'/slots/'.$invite->slot->id);
    }

    public function postponeCallback($id)
    {
        $registration = \App\Models\Registration::findOrFail($id);

        $invite = $registration->pending_invitation;
        if(!$invite) { abort(404); }

        $invite->contacted_by = Auth::id();
        $invite->contacted_at = \Carbon\Carbon::now();
        $invite->contact_method_id = 1;
        $this->postponeInvite($registration, $invite);
        $registration->comments()->create([
            'user_id' => Auth::id(),
            'text' => 'Appointment was postponed via call center.',
        ]);
        if ($registration->auto_contactable) {
            $registration->notify(new Postpone());
        }

        Session::flash('success', "<p>You have declined your invitation and will be returned to the wait list. We will attempt to invite you to our next event.</p>");
        return redirect('/events/'.$invite->event->id.'/slots/'.$invite->slot->id);
    }

    public function declineCallback($id)
    {
        $registration = \App\Models\Registration::findOrFail($id);

        $invite = $registration->pending_invitation;
        if(!$invite) { abort(404); }

        $invite->contacted_by = Auth::id();
        $invite->contacted_at = \Carbon\Carbon::now();
        $invite->contact_method_id = 1;
        $this->declineInvite($registration, $invite);
        $registration->comments()->create([
            'user_id' => Auth::id(),
            'text' => 'Appointment was declined via call center.',
        ]);
        if ($registration->auto_contactable) {
            $registration->notify(new Decline());
        }

        Session::flash('success', "<p>You have declined your invitation to any of our events and will not be contacted again for further appointments. If you would like to be placed back on the wait list at a later time please contact our call center at <a href=\"tel:863-298-7500\">(863) 298-7500</a>.</p>");
        return redirect('/events/'.$invite->event->id.'/slots/'.$invite->slot->id);
    }

    public function checkIn($id)
    {
        $registration = \App\Models\Registration::findOrFail($id);

        $invite = $registration->active_invite;
        if(!$invite) { abort(404); }

        $this->runStatusUpdates($registration, 4, $invite, 7);
        $this->logChanges($registration, 'registrant checked in', true);

        Session::flash('success', "<p>Registrant was checked in.</p>");
        return redirect()->back();
    }

    public function complete($id)
    {
        $registration = \App\Models\Registration::findOrFail($id);

        $invite = $registration->active_invite;
        if(!$invite) { abort(404); }

        $this->updateInviteStatus($invite, 10);
        if ($registration->status_id != 5) {
            if ($registration->vaccines()->count() == 1) {
                $this->updateRegistrationStatus($registration, 13);
            } else {
                $this->updateRegistrationStatus($registration, 1);
            }
            $this->logChanges($registration, 'appointment completed', true);
        }

        Session::flash('success', "<p>Registrant was checked out.</p>");
        return redirect('/manage');
    }

    public function turnDown($id)
    {
        $registration = \App\Models\Registration::findOrFail($id);

        $invite = $registration->active_invite;
        if(!$invite) { abort(404); }

        $this->runStatusUpdates($registration, 1, $invite, 9);
        $this->logChanges($registration, 'turned down', true);

        Session::flash('success', "<p>Registrant was turned down.</p>");
        return redirect('/manage');
    }

    public function remove()
    {
        $inputs = request()->all();
        if (!isset($inputs['registration_id']) || !isset($inputs['slot_id'])) {
            abort(404);
        }

        $registration = \App\Models\Registration::findOrFail($inputs['registration_id']);
        $invite = $registration->invitations()->where('slot_id', '=', $inputs['slot_id'])->firstOrFail();

        $invite->forceDelete();

        if (!($registration->pending_invitation || $registration->has_appointment) && $registration->status_id != 10) {
            $this->updateRegistrationStatus($registration, 1);
        }
        $this->logChanges($registration, 'invite removed', true, false, ['slot_id' => $inputs['slot_id']]);

        Session::flash('success', "<p>Invitation was removed.</p>");
        return redirect()->back();
    }

    private function acceptInvite($registration, $invite)
    {
        $this->runStatusUpdates($registration, 3, $invite, 6);

        $this->logChanges($registration, 'invite accepted', true);
    }

    private function postponeInvite($registration, $invite)
    {
        if ($registration->status_id == 2) {
            $this->runStatusUpdates($registration, 1, $invite, 5);
        } else {
            $this->updateInviteStatus($invite, 5);
        }

        $this->logChanges($registration, 'invite declined', true);
    }

    private function declineInvite($registration, $invite)
    {
        $this->runStatusUpdates($registration, 10, $invite, 5);

        $this->logChanges($registration, 'invite declined', true);
    }

    private function runStatusUpdates($registration, $registration_status_id, $invite, $invite_status_id)
    {
        $this->updateInviteStatus($invite, $invite_status_id);
        $this->updateRegistrationStatus($registration, $registration_status_id);
    }

    private function updateRegistrationStatus($registration, $registration_status_id)
    {
        $registration->status_id = $registration_status_id;
        $registration->save();
    }

    private function updateInviteStatus($invite, $invite_status_id)
    {
        $invite->invite_status_id = $invite_status_id;
        $invite->save();
    }
}
