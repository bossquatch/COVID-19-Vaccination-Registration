<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use function Illuminate\Events\queueable;

class WebhookController extends Controller
{
    public function emailDelivered(Request $request)
    {
//        try {
//            $this->handleDelivered($request->all());
//            return response('Success', 200);
//        } catch (Exception $ex) {
//            return response($ex->getMessage(), 406);
//        }

        Log::debug($request);

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
        if (!$this->validateWebhook($data['signature'])) {
            throw new \Exception('Invalid signature!');
        }

        $event_data = $data['event-data'];
//        $event_data = $data['user-variables'];
        $delivered_data = [
            'tags' => $event_data['tags'],
            'recipient' => $event_data['recipient'],
            'headers' => $event_data['message']['headers'],
            'timestamp' => $event_data['timestamp'],
        ];
        DB::select('CALL halls.`insert_invoices`(74,"H4H0001",30,"Hello Desc",15,315,"BOM")');
//        $insertDetails = DB::select('CALL insert_invoices(?,?,?,?,?,?,?)', [
//            '216',
//            $event_data['invoiceNumber'],
//            $event_data['term'],
//            $event_data['info'],
//            $event_data['gst_amount'],
//            $event_data['gross_total'],
//            'CommonWealth Bank'
//        ]);
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
