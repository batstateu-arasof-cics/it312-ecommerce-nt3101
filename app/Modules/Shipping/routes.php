<?php

use Illuminate\Support\Facades\Route;

// Shipping team - Shipping & Tracking

// TODO (Shipping team): customer tracking page
// Route::middleware('auth')->get('/orders/{order}/tracking', [TrackingController::class, 'show'])->name('shipping.tracking');

// TODO (Shipping team): admin shipping
// Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
//     Route::resource('shipping-rates', AdminShippingRateController::class)->except('show');
//     Route::get('/shipments', [AdminShipmentController::class, 'index'])->name('shipments.index');
//     Route::post('/shipments/{shipment}/ship', [AdminShipmentController::class, 'ship'])->name('shipments.ship'); // fires OrderShipped
// });
