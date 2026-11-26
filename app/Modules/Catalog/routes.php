<?php

use App\Modules\Catalog\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Catalog team - Product Catalog

Route::get('/products', [ProductController::class, 'index'])->name('catalog.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('catalog.show');

// TODO (Catalog team): category page
// Route::get('/categories/{category:slug}', [ProductController::class, 'category'])->name('catalog.category');

// TODO (Catalog team): admin product and category management
// Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
//     Route::resource('products', AdminProductController::class);
//     Route::resource('categories', AdminCategoryController::class);
// });
