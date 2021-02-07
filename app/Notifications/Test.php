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
        $emailAddress = $notifiable->user->email;
        $user_id = intval(strval($notifiable->user->id),36);
        $regId = intval(strval($notifiable->id),36);

        return Mail::to($emailAddress)
            ->send(new Testing($user_id,$regId,'TEST123'));
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
