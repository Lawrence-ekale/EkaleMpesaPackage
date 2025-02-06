<?php

namespace Ekale\LaravelMpesa;

use GuzzleHttp\Client;

class MpesaService
{
    protected $client;
    protected $baseUrl;
    protected $consumerKey;
    protected $consumerSecret;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = config('mpesa.base_url');
        $this->consumerKey = config('mpesa.consumer_key');
        $this->consumerSecret = config('mpesa.consumer_secret');
    }

    public function stkPush($phone, $amount, $reference)
    {

    }

    public function queryTransactionStatus($transactionId)
    {

    }
}