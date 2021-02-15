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
    protected $current_registration;

    public function __construct($current_registration, $topic)
    {
        $this->topic = $topic;
        $this->current_registration = $current_registration;
    }

    public function build()
    {
        return $this->markdown('mail.registration')
            ->subject($this->topic)
            ->with('registration', $this->current_registration)
			->withSwiftMessage(function($message) {
				$message->getHeaders()->addTextHeader('X-Mailgun-Variables', '{"_RID_": '. intval(strval($this->current_registration->id),36) .'}');
				$message->getHeaders()->addTextHeader('X-Mailgun-Variables', '{"_UID_": '. intval(strval($this->current_registration->user_id),36) .'}');
				$message->getHeaders()->addTextHeader('X-Mailgun-Tag', 'Register');
			});
    }
}
