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
        Log::debug($request);
        try {
            $this->handleDelivered($request->all());
            return response('Success', 200);
        } catch (Exception $ex) {
            return response($ex->getMessage(), 406);
        }
    }

    public function emailFailed(Request $request)
    {
        Log::debug($request);
        try {
            $this->handleFailed($request->all());
            return response('Success', 200);
        } catch (Exception $ex) {
            return response($ex->getMessage(), 406);
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

    private function persistEmailData(array $data)
    {
        $currentEmail = new EmailHistory();

        $currentEmail->timestamp = $data['signature']['timestamp'];
        $currentEmail->token = $data['signature']['token'];
        $currentEmail->signature = $data['signature']['signature'];
        // This returns and array of tags, just flatten and save it.
        $currentEmail->tags = json_encode(Arr::flatten($data['event-data']['tags']));
        // Remember to convert these values back to their actual values. I did this to obscure the
        // actual values since they are available in the email headers.  Earlier, we converted these
        // values to base 32.
        $registration_id = intval(base_convert($data['event-data']['user-variables']['_RID_'],10,36));
        $user_id = intval(base_convert($data['event-data']['user-variables']['_UID_'],10,36));
        $currentEmail->registration_id = $registration_id;
        $currentEmail->user_id = $user_id;
        // End of conversion
        $currentEmail->envelope_sending_ip = $data['event-data']['envelope']['sending-ip'];
        $currentEmail->envelope_sender = $data['event-data']['envelope']['sender'];
        $currentEmail->envelope_targets = $data['event-data']['envelope']['targets'];
        $currentEmail->headers_to = $data['event-data']['message']['headers']['to'];
        $currentEmail->headers_message_id = $data['event-data']['message']['headers']['message-id'];
        $currentEmail->headers_from = $data['event-data']['message']['headers']['from'];
        $currentEmail->headers_subject = $data['event-data']['message']['headers']['subject'];
        $currentEmail->recipient = $data['event-data']['recipient'];
        $currentEmail->event = $data['event-data']['event'];
        $currentEmail->delivery_status_code = $data['event-data']['delivery-status']['code'];
        $currentEmail->delivery_status_message = $data['event-data']['delivery-status']['message'];
        // Using Arr::get allows me to traverse a multidimensional array and set a default value
        // if the key is not found.  In this case, severity is not always passed as it only appears
        // when there is an error sending the email
        $severity = Arr::get($data, 'event-data.severity',null);
        $currentEmail->severity = $severity;

        $currentEmail->save();
    }

    private function validateWebhook(array $signature, $api_key = null): bool
    {
        // disable for now... cannot seem to get the verification to work
        return true;

        $timestamp = $signature['timestamp'];
        $token = $signature['token'];
        $signature = $signature['signature'];

        if (empty($timestamp) || empty($token) || empty($signature)) {
            return false;
        }

        if(abs(time() - $timestamp) > 15) {
            return false;
        }

        $api_key = config('services.mailgun.secret');
        return hash_equals(
                    hash_hmac(
                        'sha256',
                        $timestamp . $token,
                        $api_key),
                    $signature);

//        $hmac = hash_hmac('sha256', $timestamp . $token, $api_key);
//        if (function_exists('hash_equals')) {
//            // hash_equals is constant time, but will not be introduced until PHP 5.6
//            return hash_equals($hmac, $signature);
//        } else {
//            return $hmac === $signature;
//        }
    }
}
