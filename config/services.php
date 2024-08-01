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

    'razorpay' => [
        'key' => env('RAZORPAY_KEY_ID'),
        'secret' => env('RAZORPAY_KEY_SECRET'),
        'api_url' => "https://api.razorpay.com/v1",
    ],

    'github' => [
        'api_url' => "https://api.github.com",
        'template_repository' => env('GITHUB_TEMPLATE_REPOSITORY'),
        'oauth_url' => env('GITHUB_OAUTH_URL'),
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => env('GITHUB_CALLBACK_URL'),
    ],

    'xtream' => [
        'server' => env('XTREAM_SERVER'),
        'username' => env('XTREAM_USERNAME'),
        'password' => env('XTREAM_PASSWORD'),
    ],

    'chatai' => [
        'organization_id' => env('CHATAI_ORGANIZATION_ID'),
        'project_id' => env('CHATAI_PROJECT_ID'),
        'project_key' => env('CHATAI_PROJECT_KEY'),
    ],

    'gemini' => [
        'api_key' => env('GOOGLE_GEMINI_API_KEY'),
    ]
];
