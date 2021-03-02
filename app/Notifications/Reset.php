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

	protected $data;
	private $token;

	public function __construct($data)
    {
        $this->token = $data;
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

		$url = url(config('app_url') . route('password.reset', [
				'token'	=> $this->token,
				'email' => $notifiable->getEmailForPasswordReset(),
			], false));

		return (new ResetPassword($notifiable, $url,'Reset your password'))
			->to($notifiable->email);

    }

}
