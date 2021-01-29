<?php

namespace App\Notifications;

use App\Mail\Confirmation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class Confirm extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function viaQueues()
    {
        return [
            'mail'      => 'emails',
            'array'     => 'database',
//            'twilio'    => 'sms',
        ];
    }

    public function via($notifiable)
    {
        return ['mail','database'];
    }

    public function toMail($notifiable)
    {
        $emailAddress = $notifiable->user->email;
        return Mail::to($emailAddress)
            ->send(new Confirmation('Polk Health - Vaccination Confirmation'));
    }

    public function toArray($notifiable)
    {
        return [
            'user_id' => $notifiable->id,
        ];
    }
}
