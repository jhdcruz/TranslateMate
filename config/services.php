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

    // Azure Cognitive Services
    'az' => [
        'tr1' => env('AZURE_COGNITIVE_KEY1'),
        'tr2' => env('AZURE_COGNITIVE_KEY2'),
        'region' => env('AZURE_COGNITIVE_REGION'),
        'endpoint' => env('AZURE_COGNITIVE_ENDPOINT'),
    ],

    'ai' => [
        'key' => env('OPENAI_KEY'),
        'endpoint' => env('OPENAI_ENDPOINT'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
