<?php

return [
    'api_username' => env('PAYHERO_API_USERNAME'),
    'api_password' => env('PAYHERO_API_PASSWORD'),
    'api_id' => env('PAYHERO_API_ID'),
    'api_url' => env('PAYHERO_API_URL'),
    'callback_url' => env('PAYHERO_CALLBACK_URL'),
    'channel_id' => (int) env('PAYHERO_CHANNEL_ID'),

    'cashout_api_username' => env('CASHOUT_PAYHERO_API_USERNAME'),
    'cashout_api_password' => env('CASHOUT_PAYHERO_API_PASSWORD'),
    'cashout_api_url' => env('CASHOUT_PAYHERO_API_URL'),
    'cashout_callback_url' => env('CASHOUT_PAYHERO_CALLBACK_URL'),
    'cashout_channel_id' => env('CASHOUT_PAYHERO_CHANNEL_ID'),
    'cashout_api_key' => env('CASHOUT_PAYHERO_API_TOKEN'),
];
