<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Testing extends Mailable
{
    use Queueable, SerializesModels;

    protected $topic;
    protected $reg_id;
    protected $user_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_id, $reg_id, $topic)
    {
        $this->topic = $topic;
        if(trim($reg_id) <> '') {
            $this->reg_id = $reg_id;
        }

        $this->user_id = $user_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.test')
            ->subject($this->topic)
            ->withSwiftMessage(function($message) {
                $message->getHeaders()->addTextHeader('X-Mailgun-Variables', '{"_RID_": '. $this->reg_id .'}');
                $message->getHeaders()->addTextHeader('X-Mailgun-Variables', '{"_UID_": '. $this->user_id .'}');
                $message->getHeaders()->addTextHeader('X-Mailgun-Tag', 'DPC-TEST');
            });
    }
}
