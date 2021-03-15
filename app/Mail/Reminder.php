<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Reminder extends Mailable
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
        return $this->markdown('mail.reminder')
            ->subject($this->topic)
            ->with([
                'actionText' 		=> 'Login to my account',
                'actionUrl' 		=> config('app.url').'/home',
                'suffix' 			=> $this->registration->suffix,
                'suffixDisplay' 	=> $this->registration->suffix ? $this->registration->suffix->display_name : '',
                'firstName' 		=> $this->registration->first_name,
                'lastName' 			=> $this->registration->last_name,
                'locationName' 		=> $this->registration->appointment->event->location->name,
                'locationAddress' 	=> $this->registration->appointment->event->location->address,
                'locationCity' 		=> $this->registration->appointment->event->location->city,
                'locationState' 	=> $this->registration->appointment->event->location->state,
                'locationZip' 		=> $this->registration->appointment->event->location->zip,
                'apptDate' 			=> $this->registration->appointment->starting_at->format('M j, Y g:i A'),
                'code' 				=> $this->registration->code,
                'userId' 			=> $this->registration->user_id,
                'regId' 			=> $this->registration->id,
				'message'			=> $this->registration->appointment->event->hasMessage() ? $this->registration->appointment->event->eventMessage->message : '',
            ])
            ->withSwiftMessage(function($message) {
				$message->getHeaders()->addTextHeader('X-Mailgun-Variables', '{"_RID_": '. intval(strval($this->registration->id),36) .'}');
				$message->getHeaders()->addTextHeader('X-Mailgun-Variables', '{"_UID_": '. intval(strval($this->registration->user_id),36) .'}');
                $message->getHeaders()->addTextHeader('X-Mailgun-Tag', 'Reminder');
            });
    }
}
