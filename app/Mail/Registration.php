<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Registration extends Mailable
{
    use Queueable, SerializesModels;

    protected $topic;
    protected $registration;

    public function __construct(\App\Models\Registration $registration, $topic)
    {
        $this->topic = $topic;
        $this->registration = $registration;
    }

    public function build()
    {
        return $this->markdown('mail.registration')
            ->subject($this->topic)
            ->with('registration', $this->registration)
			->withSwiftMessage(function($message) {
				$message->getHeaders()->addTextHeader('X-Mailgun-Variables', '{"_RID_": '.$this->registration->id.'}');
				$message->getHeaders()->addTextHeader('X-Mailgun-Variables', '{"_UID_": '.$this->registration->user_id.'}');
				$message->getHeaders()->addTextHeader('X-Mailgun-Tag', 'DPC-TEST');
			});
    }
}
