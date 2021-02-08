<?php

namespace App\Notifications;

use App\Mail\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use NotificationChannels\Twilio\TwilioChannel;
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
            'mail'                  => 'emails',
            'database'              => 'database',
            TwilioChannel::class    => 'sms',
        ];
    }

    public function via($notifiable)
    {
        if ($notifiable->auto_contactable) {
            if ($notifiable->can_sms) {
                return ['mail','database',TwilioChannel::class];
            } else {
                return ['mail','database'];
            }
        } else {
            return ['database'];
        }
    }

    public function toMail($notifiable)
    {

        $emailAddress = $notifiable->user->email;
        $user_id = intval(strval($notifiable->user->id),36);
        $regId = intval(strval($notifiable->id),36);

        return Mail::to($emailAddress)
            ->send(new Invitation($user_id,$regId,'Polk Health - Vaccination Invitation'));

    }

    public function toArray($notifiable)
    {
        return [
            'user_id' => $notifiable->id,
        ];
    }

    public function toTwilio($notifiable)
    {

        $sid    = env('TWILIO_ACCOUNT_SID');
        $token  = env('TWILIO_AUTH_TOKEN');
        $twilio = new Client($sid, $token);

        $message = $twilio->messages
            ->create($notifiable->phone_number,
                array(
                    "messagingServiceSid" => env('TWILIO_SMS_SERVICE_SID'),
                    "body" => $notifiable->first_name . ', you are invited to our next COVID-19 vaccination event. Please login to your account to accept. ' . url('/home')
                )
            );
        return $message->sid;
    }
}
