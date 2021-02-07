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
//        $mailgun_webhook = new MailgunWebhook();
//        try {
//            return $mailgun_webhook->handleFailed($request->all());
//            return response('Success', 200);
//        } catch (Exception $ex) {
//            return response($ex->getMessage(), 406);
//        }

        Log::debug($request);

    }

    public function handleDelivered(array $data)
    {
//        if (!$this->validateWebhook($data['signature'])) {
//            throw new \Exception('Invalid signature!');
//        }

        $currentEmail = new EmailHistory();

        $currentEmail->timestamp = $data['signature']['timestamp'];
        $currentEmail->token = $data['signature']['token'];
        $currentEmail->signature = $data['signature']['signature'];
        $currentEmail->tags = $data['event-data']['tags'];
        $currentEmail->registration_id = $data['event-data']['user-variables']['_RID_'];
        $currentEmail->user_id = $data['event-data']['user-variables']['_UID_'];
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

        $asdf = Arr::get($data, 'event-data.severity','');

        $currentEmail->severity = $asdf;

        $currentEmail->save();

//        $event_data = $data['event-data'];
////        $event_data = $data['user-variables'];
//        $delivered_data = [
//            'tags' => $event_data['tags'],
//            'recipient' => $event_data['recipient'],
//            'headers' => $event_data['message']['headers'],
//            'timestamp' => $event_data['timestamp'],
//        ];



    }

    public function handleFailed(array $data)
    {
        if (!$this->validateWebhook($data['signature'])) {
            throw new \Exception('Invalid signature!');
        }

        $event_data = $data['event-data'];
        $delivered_data = [
            'tags' => $event_data['tags'],
            'recipient' => $event_data['recipient'],
            'headers' => $event_data['message']['headers'],
            'timestamp' => $event_data['timestamp'],
            'delivery_status' => $event_data['delivery-status'],
            'severity' => $event_data['severity'],
        ];
        //return ParseMailFailed::dispatchNow($this->email, $delivered_data);
    }

    public function validateWebhook(array $signature, $api_key = null)
    {
        $timestamp = $signature['timestamp'];
        $token = $signature['token'];
        $signature = $signature['signature'];
        //Concat timestamp and token values
        if (empty($timestamp) || empty($token) || empty($signature)) {
            return false;
        }
        $api_key = $api_key ? $api_key : env('MAILGUN_SECRET');

        $hmac = hash_hmac('sha256', $timestamp . $token, $api_key);
        if (function_exists('hash_equals')) {
            // hash_equals is constant time, but will not be introduced until PHP 5.6
            return hash_equals($hmac, $signature);
        } else {
            return $hmac === $signature;
        }
    }
}
