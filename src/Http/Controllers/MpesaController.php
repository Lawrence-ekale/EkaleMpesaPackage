<?php

namespace Ekale\LaravelMpesa\Http\Controllers;

use Ekale\LaravelMpesa\Models\EkaleMpesa;
use Illuminate\Support\Facades\Request;

class MpesaController
{

    public function handleCallback(Request $request)
    {
        $request->validate([
            'mpesaReceiptNumber' => 'required',
            'transactionAmount' => 'required',
            'transactionId' => 'required',
        ]);

        EkaleMpesa::create([
            'reference' => $request->mpesaReceiptNumber,
            'amount' => $request->transactionAmount,
            'transactionId' => $request->transactionId,
            'phone' => $request->phone
        ]);
    }
}