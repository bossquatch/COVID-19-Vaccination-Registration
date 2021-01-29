<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        Session::flash('success', "<p>Appointment Accepted!</p><p>Be sure to fill out a <a href=\"/docs/consent_moderna.pdf\" target=\"_blank\" rel=\"noopener\" download aria-download=\"true\">Moderna Consent Form</a> and bring it to your appointment as well as proof of Florida residency.</p>");
        return redirect('/home');
    }

    public function decline()
    {
        $registration = Auth::user()->registration;
        if(!$registration) { abort(404); }

        $invite = $registration->pending_invitation;
        if(!$invite) { abort(404); }

        $this->declineInvite($registration, $invite);

        Session::flash('success', "<p>Appointment was successfully declined.</p>");
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

        Session::flash('success', "<p>Appointment Accepted!</p><p>Be sure to remind the registrant to bring proof of Florida residency to their appointment.</p>");
        return redirect('/events/'.$invite->event->id.'/pending');
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

        Session::flash('success', "<p>Appointment was successfully declined.</p>");
        return redirect('/events/'.$invite->event->id.'/pending');
    }

    public function leftPhone($id)
    {
        $registration = \App\Models\Registration::findOrFail($id);

        $invite = $registration->pending_invitation;
        if(!$invite) { abort(404); }

        $invite->contacted_by = Auth::id();
        $invite->contacted_at = \Carbon\Carbon::now();
        $invite->contact_method_id = 1;
        $this->updateInviteStatus($invite, 3);

        Session::flash('success', "<p>Registrant contacted via phone call on record.</p>");
        return redirect('/events/'.$invite->event->id.'/pending');
    }

    public function leftEmail($id)
    {
        $registration = \App\Models\Registration::findOrFail($id);

        $invite = $registration->pending_invitation;
        if(!$invite) { abort(404); }

        $invite->contacted_by = Auth::id();
        $invite->contacted_at = \Carbon\Carbon::now();
        $invite->contact_method_id = 2;
        $this->updateInviteStatus($invite, 3);

        Session::flash('success', "<p>Registrant contacted via email on record.</p>");
        return redirect('/events/'.$invite->event->id.'/pending');
    }

    public function checkIn($id)
    {
        $registration = \App\Models\Registration::findOrFail($id);

        $invite = $registration->active_invite;
        if(!$invite) { abort(404); }

        $this->updateInviteStatus($invite, 7);

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
            $this->updateRegistrationStatus($registration, 2);
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

    private function acceptInvite($registration, $invite) 
    {
        $this->runStatusUpdates($registration, 3, $invite, 6);

        $this->logChanges($registration, 'invite accepted', true);
    }
    
    private function declineInvite($registration, $invite) 
    {
        $this->runStatusUpdates($registration, 1, $invite, 5);

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
