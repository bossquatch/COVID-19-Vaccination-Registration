<?php

namespace App\Http\Controllers;

use App\Models\EmailHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use function Illuminate\Events\queueable;

class WebhookController extends Controller
{
    public function emailDelivered(Request $request)
    {
        try {
            $this->handleDelivered($request->all());
            return response('Success', 200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(), 406);
        }
    }

    public function emailFailed(Request $request)
    {
        try {
            $this->handleFailed($request->all());
            return response('Success', 200);
        } catch (\Exception $ex) {
            return response($ex->getMessage(), 406);
        }
    }

    public function emailIncoming(Request $request)
	{
		try {
			$this->handleIncoming($request->all());
			return response('Success', 200);
		} catch (\Exception $e) {
			return response($e->getMessage(), 406);
		}
	}

    private function handleDelivered(array $data)
    {
        if (!$this->validateWebhook($data['signature'])) {
            throw new \Exception('Invalid signature!');
        }
        $this->persistEmailData($data);
    }

    private function handleFailed(array $data)
    {
        if (!$this->validateWebhook($data['signature'])) {
            throw new \Exception('Invalid signature!');
        }
        $this->persistEmailData($data);
    }

    private function handleIncoming(array $data)
	{
		if(!$this->validateWebhook([$data['signature'],$data['timestamp'],$data['token']])) {
			throw new \Exception('Invalid signature!');
		}
		$this->persistIncomingEmail($data);
	}

    private function persistEmailData(array $data)
    {
        $currentEmail = new EmailHistory();
        $currentEmail->timestamp 				= $data['signature']['timestamp'];
        $currentEmail->token 					= $data['signature']['token'];
        $currentEmail->signature 				= $data['signature']['signature'];
        $currentEmail->tags 					= json_encode(Arr::flatten($data['event-data']['tags']));

        // Remember to convert these values back to their actual values. I did this to obscure the
        // actual values since they are available in the email headers.  Earlier, we converted these
        // values to base 36.

		// Using Arr::get allows me to traverse a multidimensional array and set a default value
		// if the key is not found.

        $registration_id 						= Arr::get($data, 'event-data.user-variables._RID_', 0);
        $currentEmail->registration_id 			= intval(base_convert($registration_id,10,36));
        $user_id 								= Arr::get($data, 'event-data.user-variables._UID_', 0);
        $currentEmail->user_id 					= intval(base_convert($user_id,10,36));
        $currentEmail->envelope_sending_ip 		= Arr::get($data, 'event-data.envelope.sending-ip', null);
        $currentEmail->envelope_sender 			= Arr::get($data, 'event-data.envelope.sender',null);
        $currentEmail->envelope_targets 		= Arr::get($data, 'event-data.envelope.targets', null);
        $currentEmail->headers_to 				= Arr::get($data, 'event-data.message.headers.to',null);
        $currentEmail->headers_message_id 		= Arr::get($data, 'event-data.message.headers.message-id', null);
        $currentEmail->headers_from 			= Arr::get($data, 'event-data.message.headers.from', null);
        $currentEmail->headers_subject 			= Arr::get($data, 'event-data.message.headers.subject', null);
        $currentEmail->recipient 				= Arr::get($data, 'event-data.recipient', null);
        $currentEmail->event 					= Arr::get($data, 'event-data.event', null);
        $currentEmail->delivery_status_code 	= Arr::get($data, 'event-data.delivery-status.code', null);
        $currentEmail->delivery_status_message 	= Arr::get($data, 'event-data.delivery-status.message', null);
		$currentEmail->severity 				= Arr::get($data, 'event-data.severity',null);

		try {
			$currentEmail->save();
			return true;
		} catch (\Exception $e) {
			return $e->getCode();
		}

    }

    private function persistIncomingEmail(array $data)
	{
		Log::debug(json_encode(Arr::flatten($data)));
	}

    private function validateWebhook(array $signature, $api_key = null): bool
    {

        $timestamp = $signature['timestamp'];
        $token = $signature['token'];
        $signature = $signature['signature'];

        if (empty($timestamp) || empty($token) || empty($signature)) {
            return false;
        }

        if(abs(time() - $timestamp) > 15) {
            return false;
        }

        $api_key = config('services.mailgun.webhook_signing_key');

        return hash_equals(hash_hmac('sha256',$timestamp . $token, $api_key), $signature);

    }
}
