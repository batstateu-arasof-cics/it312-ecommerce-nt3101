<?php

use App\Modules\Cart\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

// Cart team - Cart & Wishlist

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add');

    // TODO (Cart team):
    // Route::patch('/cart/items/{item}', [CartController::class, 'update'])->name('cart.update');
    // Route::delete('/cart/items/{item}', [CartController::class, 'remove'])->name('cart.remove');
    // Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    // Route::post('/wishlist/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    // Route::post('/wishlist/{product}/move-to-cart', [WishlistController::class, 'moveToCart'])->name('wishlist.move');
});
