<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' 				=> env('MAIL_DOMAIN'),
        'secret' 				=> env('MAIL_SECRET'),
        'endpoint' 				=> env('MAIL_ENDPOINT', 'api.mailgun.net'),
		'webhook_signing_key' 	=> env('MAIL_WEBHOOK_SIGNING_KEY'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'maps_key'   => env('GOOGLE_MAPS_API_KEY'),
        'maps_locale'   => env('GOOGLE_MAPS_LOCALE'),
    ],

];
