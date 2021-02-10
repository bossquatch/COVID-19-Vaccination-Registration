<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Invitation extends Mailable
{
    use Queueable, SerializesModels;

    protected $topic;
    protected $registration;

    /*
    protected $reg_id;
    protected $user_id;
    protected $userName;
    */

    /*
    public function __construct($userName, $user_id, $reg_id, $topic)
    {
        $this->topic = $topic;
        if(trim($reg_id) <> '') {
            $this->reg_id = $reg_id;
        }

        $this->user_id = $user_id;
        $this->userName = $userName;
    }
    */

    public function __construct($registration, $topic)
    {
        $this->topic = $topic;
        $this->registration = $registration;
    }

    public function build()
    {
        return $this->markdown('mail.invitation')
            ->subject($this->topic)
            ->with('registration', $this->registration)
            ->withSwiftMessage(function($message) {
                $message->getHeaders()->addTextHeader('X-Mailgun-Variables', '{"_RID_": '. $this->registration->id .'}');
                $message->getHeaders()->addTextHeader('X-Mailgun-Variables', '{"_UID_": '. $this->registration->user_id .'}');
                $message->getHeaders()->addTextHeader('X-Mailgun-Tag', 'DPC-TEST');
            });
    }
}
