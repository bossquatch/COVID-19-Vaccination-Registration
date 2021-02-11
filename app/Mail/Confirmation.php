<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Confirmation extends Mailable
{
    use Queueable, SerializesModels;

    protected $registration;
    protected $topic;
    protected $png;

    public function __construct($registration, $topic)
    {
        $this->registration = $registration;
        $this->topic = $topic;
        $this->png = base64_encode(QrCode::format('png')->size(150)->generate('test'));
    }

    public function build()
    {
        return $this->markdown('mail.confirmation')
            ->subject($this->topic)
            ->with([
                'suffix' => $this->registration->suffix,
                'suffixDisplay' => $this->registration->suffix ? $this->registration->suffix->display_name : '',
                'firstName' => $this->registration->first_name,
                'lastName' => $this->registration->last_name,
                'locationName' => $this->registration->invitations->last()->slot->event->location->name,
                'locationAddress' => $this->registration->invitations->last()->slot->event->location->address,
                'locationCity' => $this->registration->invitations->last()->slot->event->location->city,
                'locationState' => $this->registration->invitations->last()->slot->event->location->state,
                'locationZip' => $this->registration->invitations->last()->slot->event->location->zip,
                'apptDate' => $this->registration->invitations->last()->slot->starting_at->format('M j, Y g:i A')
            ])
            ->withSwiftMessage(function($message) {
                $message->getHeaders()->addTextHeader('X-Mailgun-Variables', '{"_RID_": '.$this->registration->id.'}');
                $message->getHeaders()->addTextHeader('X-Mailgun-Variables', '{"_UID_": '.$this->registration->user_id.'}');
                $message->getHeaders()->addTextHeader('X-Mailgun-Tag', 'DPC-TEST');
            });
    }
}
