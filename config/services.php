<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */
    'facebook' => [
        'client_id' => '177289922932294',         // Your GitHub Client ID
        'client_secret' => '50a68367ea2c7490d7dde8de771fc32a', // Your GitHub Client Secret
        'redirect' => 'https://flexigigs.me/en/login/facebook/callback',
        'redirect_ar' => 'https://flexigigs.me/ar/login/facebook/callback',
    ],
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'firebase' => [
        'api_key' => 'API_KEY', // Only used for JS integration
        'auth_domain' => 'AUTH_DOMAIN', // Only used for JS integration
        'database_url' => 'https://your-database-at.firebaseio.com',
        'secret' => 'DATABASE_SECRET',
        'storage_bucket' => 'STORAGE_BUCKET', // Only used for JS integration
    ],
    'ses' => [
        'key' => 'AKIAJQOKRBCZNPNYQR7A',
        'secret' => 'Ar1PKWdX1d0dFWFSrHIUH7YfFaUlANOngHMUjKiNxqGg',
        'region' => 'us-east-1',  // e.g. us-east-1
    ],
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],
];
