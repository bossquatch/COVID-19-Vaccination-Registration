<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Invitation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    public $topic;

    /**
     * Create a new message instance.
     *
     * @param string $topic
     */
    public function __construct(string $topic)
    {
        $this->topic = $topic;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.invitation')
            ->subject($this->topic);
    }
}
