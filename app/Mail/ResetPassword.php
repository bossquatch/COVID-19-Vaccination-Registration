<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

	protected $notifiable;
	protected $url;
	protected $topic;

	public function __construct($notifiable, $url, $topic)
    {
		$this->notifiable = $notifiable;
		$this->url = $url;
		$this->topic = $topic;
	}

    public function build()
    {

		return $this->markdown('mail.resetpassword')
			->subject($this->topic)
			->with([
				'url'	=> $this->url,
				'name'	=> $this->notifiable->first_name,
			])
			->withSwiftMessage(function($message) {
				$message->getHeaders()->addTextHeader('X-Mailgun-Variables', '{"_UID_": '. intval(strval($this->notifiable->id),36) .'}');
				$message->getHeaders()->addTextHeader('X-Mailgun-Tag', 'Reset');
			});
    }
}
