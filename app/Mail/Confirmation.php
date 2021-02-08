<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Confirmation extends Mailable
{
    use Queueable, SerializesModels;

    protected $topic;
    protected $reg_id;
    protected $user_id;
    protected $userName;

    public function __construct($userName, $user_id, $reg_id, $topic)
    {
        $this->topic = $topic;
        if(trim($reg_id) <> '') {
            $this->reg_id = $reg_id;
        }

        $this->user_id = $user_id;
        $this->userName = $userName;
    }

    public function build()
    {
        return $this->markdown('mail.confirmation')
            ->subject($this->topic)
            ->with('userName', $this->userName)
            ->withSwiftMessage(function($message) {
                $message->getHeaders()->addTextHeader('X-Mailgun-Variables', '{"_RID_": '. $this->reg_id .'}');
                $message->getHeaders()->addTextHeader('X-Mailgun-Variables', '{"_UID_": '. $this->user_id .'}');
                $message->getHeaders()->addTextHeader('X-Mailgun-Tag', 'DPC-TEST');
            });
    }
}
