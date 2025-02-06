<?php
use Illuminate\Support\Facades\Route;
use Ekale\LaravelMpesa\Http\Controllers\MpesaController;

//To find an alternative of a user to redefine theirs because of security reason or DDOS attack
Route::post(config('mpesa.callback_url'), [MpesaController::class, 'handleCallback']);