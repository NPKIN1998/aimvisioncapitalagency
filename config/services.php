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

    'truelinegate' => [
        'api_key' => env('MPESA_API_KEY'), // API Key from your .env file
        'channel' => env('MPESA_API_CHANNEL'), // Payment channel identifier
        'callback_url' => env('MPESA_API_CALLBACK'), // Callback URL
    ],

    'whatsapp' => [
        'whatsapp_active' =>  env('WHATSAPP_GROUP_ACTIVE'),
    ],

    'payhero' => [
        'api_username' => env('PAYHERO_API_USERNAME'),
        'api_password' => env('PAYHERO_API_PASSWORD'),
        'api_id' => env('PAYHERO_API_ID'),
        'api_url' => env('PAYHERO_API_URL'),
        'callback_url' => env('PAYHERO_CALLBACK_URL'),
        'channel_id' => (int) env('PAYHERO_CHANNEL_ID'),
    ]


];
