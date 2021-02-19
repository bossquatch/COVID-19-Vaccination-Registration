<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RemindAbandoned extends Mailable
{
    use Queueable, SerializesModels;

	private $notifiable;
	private $url;
	private $userName;
	private $user_id;
	private $topic;

    public function __construct($notifiable, $url, $userName, $user_id, $topic)
    {

		$this->notifiable = $notifiable;
		$this->url = $url;
		$this->userName = $userName;
		$this->user_id = $user_id;
		$this->topic = $topic;
	}

    public function build()
    {
        return $this->markdown('mail.RemindAbandoned')
			->subject($this->topic)
			->with([
				'url'			=> $this->url,
				'name'			=> $this->userName,
				'actionText' 	=> 'Verify My Email',
			])
			->withSwiftMessage(function($message) {
				$message->getHeaders()->addTextHeader('X-Mailgun-Variables', '{"_UID_": '. intval(strval($this->user_id),36) .'}');
				$message->getHeaders()->addTextHeader('X-Mailgun-Tag', 'Verify');
			});
    }
}
