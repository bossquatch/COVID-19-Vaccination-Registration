<?php

namespace App\Notifications;

use App\Mail\Verification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class Verify extends Notification implements ShouldQueue
{
	use Queueable;

	public function __construct()
	{
		//
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

		$userName 		= $notifiable->first_name;
		$user_id 		= $notifiable->id;
		$url 			= $this->verificationUrl($notifiable);

		return (new Verification($notifiable, $url, $userName, $user_id,'Registration not complete. Please verify your email address'))
			->to($notifiable->email);

//		try {
//			return (new Verification($notifiable, $url, $userName, $user_id,'Registration not complete. Please verify your email address'))
//				->to($notifiable->email);
//		} catch (\Exception $e){
//			Log::error('Here is the problem: ' . $e);
//			return false;
//		}
	}

	protected function verificationUrl($notifiable)
	{
		return URL::temporarySignedRoute(
			'verification.verify',
			Carbon::now()->addMinutes(
				Config::get('auth.verification.expire', 60)),
			[
				'id' => $notifiable->getKey(),
				'hash' => sha1($notifiable->getEmailForVerification()),
			]
		);
	}
}
