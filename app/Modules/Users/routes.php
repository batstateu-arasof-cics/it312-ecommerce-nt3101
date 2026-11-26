<?php

use App\Modules\Users\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Users team - Users & Auth

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// TODO (Users team): profile and address routes, e.g.
// Route::middleware('auth')->group(function () {
//     Route::get('/account', ...)->name('account.edit');
//     Route::resource('/account/addresses', AddressController::class);
// });
