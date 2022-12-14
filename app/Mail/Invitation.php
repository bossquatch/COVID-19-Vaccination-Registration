<?php

namespace App\Mail;

use DateInterval;
use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Invitation extends Mailable
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
        return $this->markdown('mail.invitation')
            ->subject($this->topic)
            ->with([
                'actionText' 		=> 'Login to my account',
                'actionUrl' 		=> config('app.url').'/home',
                'suffix' 			=> $this->registration->suffix,
                'suffixDisplay' 	=> $this->registration->suffix ? $this->registration->suffix->display_name : '',
                'firstName' 		=> $this->registration->first_name,
                'lastName' 			=> $this->registration->last_name,
                'invitationExpires' => $this->registration->pending_invitation->contacted_at->add(new DateInterval('PT'.config('app.invitation_expire').'H'))->format('M j, Y g:i A'),
				'message'			=> $this->registration->pending_invitation->event->hasMessage() ? $this->registration->pending_invitation->event->eventMessage->message : '' ,

            ])
            ->withSwiftMessage(function($message) {
				$message->getHeaders()->addTextHeader('X-Mailgun-Variables', '{"_RID_": '. intval(strval($this->registration->id),36) .'}');
				$message->getHeaders()->addTextHeader('X-Mailgun-Variables', '{"_UID_": '. intval(strval($this->registration->user_id),36) .'}');
                $message->getHeaders()->addTextHeader('X-Mailgun-Tag', 'Invite');
            });
    }
}
