<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Confirmation extends Mailable
{
    use Queueable, SerializesModels;

    protected $registration;
    protected $topic;

    public function __construct($registration, $topic)
    {
        $this->registration = $registration;
        $this->topic = $topic;
    }

    public function build()
    {
        return $this->markdown('mail.confirmation')
            ->subject($this->topic)
            ->with([
                'actionText' => 'Login to my account',
                'actionUrl' => config('app.url').'/home',
                'suffix' => $this->registration->suffix,
                'suffixDisplay' => $this->registration->suffix ? $this->registration->suffix->display_name : '',
                'firstName' => $this->registration->first_name,
                'lastName' => $this->registration->last_name,
                'locationName' => $this->registration->invitations->last()->slot->event->location->name,
                'locationAddress' => $this->registration->invitations->last()->slot->event->location->address,
                'locationCity' => $this->registration->invitations->last()->slot->event->location->city,
                'locationState' => $this->registration->invitations->last()->slot->event->location->state,
                'locationZip' => $this->registration->invitations->last()->slot->event->location->zip,
                'apptDate' => $this->registration->invitations->last()->slot->starting_at->format('M j, Y g:i A'),
                'code' => $this->registration->code
            ])
            ->withSwiftMessage(function($message) {
                $message->getHeaders()->addTextHeader('X-Mailgun-Variables', '{"_RID_": '.$this->registration->id.'}');
                $message->getHeaders()->addTextHeader('X-Mailgun-Variables', '{"_UID_": '.$this->registration->user_id.'}');
                $message->getHeaders()->addTextHeader('X-Mailgun-Tag', 'DPC-TEST');
            });
    }
}
