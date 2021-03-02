<?php


namespace App\Services\Twilio;

use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class Messenger
{

    /**
     * @var Client
     */
    private $client;


    /**
     * @var string
     */
    private $verification_sid;

    /**
     * @var string
     */
    private $from_number;

    /**
     * Messenger constructor.
     * @param $client
     * @param string|null $verification_sid
     * @param string|null $phone
     * @throws \Twilio\Exceptions\ConfigurationException
     */
    public function __construct($client = null, string $verification_sid = null, string $phone = null)
    {
        if ($client === null) {
            $sid = config('twilio-notification-channel.account_sid');
			$token = config('twilio-notification-channel.auth_token');
            $client = new Client($sid, $token);
        }
        $this->client = $client;
        $this->verification_sid = $verification_sid ?: config('twilio-notification-channel.verification_sid');
        $this->from_number = $phone ?: config('app.twilio.from_number');
    }


    /**
     * Send a message to a number
     *
     * @param $phone_number
     * @param $channel
     * @return boolean
     */
    public function sendMessage($phone_number, $message)
    {
        try {
            $this->client->messages->create($phone_number,
                ['from' => $this->from_number, 'body' => $message]);
            return true;
        } catch (TwilioException $exception) {
            //return new Result(["Message failed to send: {$exception->getMessage()}"]);
            return false;
        }
    }
}