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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'twilio'    =>  [
        'token' =>  env('TWILIO_AUTH_TOKEN'),
        'sid' =>  env('TWILIO_ACCOUNT_SID'),
    ],

    'firebase'  =>  [
        'fcm_token' =>  env('FCM_SERVER_KEY')
    ],
    'google'    =>  [
        'map'   =>  [
            'key'   =>  env('GOOGLE_MAP_API')
        ]
    ],
    'openai' => [
        'api_key' => env('OPENAI_API_KEY'),
        'vector_id' => env('OPENAI_VECTOR_ID'),
    ],
];
