<?php

// config/mpesa.php
return [
    'base_url' => env('MPESA_BASE_URL', 'https://sandbox.safaricom.co.ke'),
    'consumer_key' => env('MPESA_CONSUMER_KEY'),
    'consumer_secret' => env('MPESA_CONSUMER_SECRET'),
    'shortcode' => env('MPESA_SHORTCODE'),
    'passkey' => env('MPESA_PASSKEY'),
];