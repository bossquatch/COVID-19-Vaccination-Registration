<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Postponement extends Mailable
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
        return $this->markdown('mail.postpone')
            ->subject($this->topic)
            ->with([
                'actionText' => 'Login to my account',
                'actionUrl' => config('app.url').'/home',
                'suffix' => $this->registration->suffix,
                'suffixDisplay' => $this->registration->suffix ? $this->registration->suffix->display_name : '',
                'firstName' => $this->registration->first_name,
                'lastName' => $this->registration->last_name,
            ])
            ->withSwiftMessage(function($message) {
				$message->getHeaders()->addTextHeader('X-Mailgun-Variables', '{"_RID_": '. intval(strval($this->registration->id),36) .'}');
				$message->getHeaders()->addTextHeader('X-Mailgun-Variables', '{"_UID_": '. intval(strval($this->registration->user_id),36) .'}');
                $message->getHeaders()->addTextHeader('X-Mailgun-Tag', 'Postpone');
            });
    }
}
