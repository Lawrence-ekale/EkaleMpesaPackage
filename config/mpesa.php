<?php

// config/mpesa.php
return [
    'base_url' => env('MPESA_BASE_URL', 'https://sandbox.safaricom.co.ke'),
    'consumer_key' => env('MPESA_CONSUMER_KEY'),
    'consumer_secret' => env('MPESA_CONSUMER_SECRET'),
    'shortcode' => env('MPESA_SHORTCODE'),
    'passkey' => env('MPESA_PASSKEY'),
    'callback_url' => env('MPESA_CALLBACK_URL', '/mpesa/callback'), // Allow users to customize the callback path
    'test_phone_number' => env('MPESA_TEST_PHONE_NUMBER', '254712345678'),
];