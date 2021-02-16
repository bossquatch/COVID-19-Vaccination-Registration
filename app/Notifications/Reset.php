<?php

namespace App\Notifications;

use App\Mail\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Reset extends Notification implements ShouldQueue
{
    use Queueable;

	protected $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

	public function viaQueues()
	{
		return [
			'mail' => 'emails',
		];
	}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {

		$url = $this->url;

		return (new ResetPassword($notifiable, $url,'Reset your password'))
			->to($notifiable->email);

    }

}
