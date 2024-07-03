<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

// Definisikan rute untuk menangani webhook dari Midtrans
Route::post('/midtrans/webhook', [PaymentController::class, 'handleWebhook']);
