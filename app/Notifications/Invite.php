<?php

namespace App\Notifications;

use App\Mail\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use NotificationChannels\Twilio\Twilio;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class Invite extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {

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
        // ,TwilioChannel::class
        return ['mail','database'];
    }

    public function toMail($notifiable)
    {

        $emailAddress = $notifiable->user->email;
        return Mail::to($emailAddress)
            ->send(new Invitation('Polk Health - vaccination invitation'));

    }

    public function toArray($notifiable)
    {
        return [
            'user_id' => $notifiable->id,
        ];
    }

//    public function toTwilio($notifiable)
//    {
//        return (new TwilioSmsMessage())
//            ->content('hell0 {$notifiable->first_name}');
//
//    }
}
