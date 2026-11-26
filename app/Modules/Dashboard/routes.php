<?php

use App\Modules\Dashboard\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Dashboard team - Admin Dashboard & Reports

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // TODO (Dashboard team):
    // Route::get('/reports/sales', [DashboardController::class, 'report'])->name('reports.sales');
    // Route::get('/reports/sales/export', [DashboardController::class, 'export'])->name('reports.export');
});
