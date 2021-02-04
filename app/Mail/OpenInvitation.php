<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Invitation;
use Carbon\Carbon;

class OpenInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $invitation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invitation $invite)
    {
        $this->invitation = $invite;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.event.invitation')
                    ->with([
                        'registration' => $this->invitation->registration,
                        'location' => $this->invitation->event->location,
                        'slot' => $this->invitation->slot,
                        'expires' => Carbon::now()->addHours(config('app.invitation_expire'))->format("h:iA M d, Y"),
                    ]);
    }
}
