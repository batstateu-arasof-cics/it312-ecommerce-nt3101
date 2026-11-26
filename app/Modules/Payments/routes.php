<?php

use App\Modules\Payments\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

// Payments team - Payments

Route::post('/payments/webhook', WebhookController::class)->name('payments.webhook');

// TODO (Payments team): pages the gateway sends the customer back to
// Route::middleware('auth')->group(function () {
//     Route::get('/payments/success', ...)->name('payments.success');
//     Route::get('/payments/failed', ...)->name('payments.failed');
// });
