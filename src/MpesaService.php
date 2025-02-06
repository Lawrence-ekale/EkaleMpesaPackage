<?php

namespace Ekale\LaravelMpesa;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class MpesaService
{
    protected $client;
    protected $baseUrl;
    protected $consumerKey;
    protected $consumerSecret;
    protected $shortcode;
    protected $passkey;
    protected $callbackUrl;
    protected $testPhoneNumber;


    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = config('mpesa.base_url');
        $this->consumerKey = config('mpesa.consumer_key');
        $this->consumerSecret = config('mpesa.consumer_secret');
        $this->shortcode = config('mpesa.shortcode');
        $this->passkey = config('mpesa.passkey');
        $this->callbackUrl = config('mpesa.callback_url');
        $this->testPhoneNumber = config('mpesa.test_phone_number');
    }

    /**
     * Generate an access token for M-Pesa API authentication.
     */
    protected function generateAccessToken()
    {
        $url = $this->baseUrl . '/oauth/v1/generate?grant_type=client_credentials';
        $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);

        try {
            $response = $this->client->get($url, [
                'headers' => [
                    'Authorization' => 'Basic ' . $credentials,
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            return $data['access_token'];
        } catch (GuzzleException $e) {
            throw new \Exception('Failed to generate access token: ' . $e->getMessage());
        }
    }

    /**
     * Initiate an STK push payment request.
     */
    public function stkPush($amount, $reference,$phone = null)
    {
        $url = $this->baseUrl . '/mpesa/stkpush/v1/processrequest';
        $timestamp = date('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        // Use the test phone number if no phone number is provided
        $phone = $phone ?? $this->testPhoneNumber;

        try {
            $response = $this->client->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->generateAccessToken(),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'BusinessShortCode' => $this->shortcode,
                    'Password' => $password,
                    'Timestamp' => $timestamp,
                    'TransactionType' => 'CustomerPayBillOnline',
                    'Amount' => $amount,
                    'PartyA' => $phone,
                    'PartyB' => $this->shortcode,
                    'PhoneNumber' => $phone,
                    'CallBackURL' => url($this->callbackUrl), // Use the callback URL from config
                    'AccountReference' => $reference,
                    'TransactionDesc' => 'Payment for ' . $reference,
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            throw new \Exception('STK push failed: ' . $e->getMessage());
        }
    }

    /**
     * Query the status of an M-Pesa transaction.
     */
    public function queryTransactionStatus($transactionId)
    {
        $url = $this->baseUrl . '/mpesa/transactionstatus/v1/query';
        $timestamp = date('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        try {
            $response = $this->client->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->generateAccessToken(),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'Initiator' => config('mpesa.initiator'),
                    'SecurityCredential' => $password,
                    'CommandID' => 'TransactionStatusQuery',
                    'TransactionID' => $transactionId,
                    'PartyA' => $this->shortcode,
                    'IdentifierType' => '4',
                    'ResultURL' => config('mpesa.result_url'),
                    'QueueTimeOutURL' => config('mpesa.timeout_url'),
                    'Remarks' => 'Transaction status query',
                    'Occasion' => 'Transaction status',
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            throw new \Exception('Transaction status query failed: ' . $e->getMessage());
        }
    }
}