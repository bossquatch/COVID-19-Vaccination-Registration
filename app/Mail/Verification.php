<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Verification extends Mailable
{
	use Queueable, SerializesModels;

	protected $topic;
	protected $userName;
	protected $user_id;
	protected $url;
	protected $notifiable;

	public function __construct($notifiable, $url, $userName, $user_id, $topic)
	{
		$this->topic 	= $topic;
		$this->userName = $userName;
		$this->user_id 	= $user_id;
		$this->url 		= $url;
		$this->notifiable = $notifiable;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->markdown('mail.verify')
			->subject($this->topic)
			->with([
				'url'	=> $this->url,
				'name'	=> $this->userName,
			])
			->withSwiftMessage(function($message) {
				$message->getHeaders()->addTextHeader('X-Mailgun-Variables', '{"_UID_": '. intval(strval($this->user_id),36) .'}');
				$message->getHeaders()->addTextHeader('X-Mailgun-Tag', 'Verify');
			});
	}
}
