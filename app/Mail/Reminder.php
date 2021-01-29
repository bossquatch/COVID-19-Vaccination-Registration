<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Reminder extends Mailable
{
    use Queueable, SerializesModels;

    public $topic;

    public function __construct(string $topic)
    {
        $this->topic = $topic;
    }

    public function build()
    {
        return $this->markdown('mail.reminder')
            ->subject($this->topic);
    }
}
