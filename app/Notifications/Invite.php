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
use Twilio\Rest\Client;

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
            'twilio'    => 'sms',
        ];
    }

    public function via($notifiable)
    {
        return ['mail','database',TwilioChannel::class];
    }

    public function toMail($notifiable)
    {

        $emailAddress = $notifiable->user->email;
        return Mail::to($emailAddress)
            ->send(new Invitation('Polk Health - Vaccination Invitation'));

    }

    public function toArray($notifiable)
    {
        return [
            'user_id' => $notifiable->id,
        ];
    }

    public function toTwilio($notifiable)
    {
//        return (new TwilioSmsMessage())
//            ->content('hell0 '.$notifiable->first_name);
        $sid    = env('TWILIO_ACCOUNT_SID');
        $token  = env('TWILIO_AUTH_TOKEN');
        $twilio = new Client($sid, $token);

        $message = $twilio->messages
            ->create($notifiable->phone_number, // to
                array(
                    "messagingServiceSid" => "MGedc51261d5e15e1dfb7cda27912d7cca",
                    "body" => "hell0 " . $notifiable->first_name
                )
            );
        return $message->sid;
    }
}
