<?php

use App\Modules\Orders\Http\Controllers\CheckoutController;
use App\Modules\Orders\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Orders team - Checkout & Orders

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    // TODO (Orders team):
    // Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    // Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

// TODO (Orders team): admin order management
// Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
//     Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
//     Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
//     Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
// });
