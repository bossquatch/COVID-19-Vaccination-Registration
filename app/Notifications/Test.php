<?php

namespace App\Notifications;

use App\Mail\Testing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class Test extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $emailAddress 	= $notifiable->user->email;
        $user_id 		= $notifiable->user->id;
        $regId 			= $notifiable->id;

        return Mail::to($emailAddress)
            ->send(new Testing($notifiable, $user_id, $regId, 'TEST123'));
    }
}
