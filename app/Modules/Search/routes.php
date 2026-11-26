<?php

use App\Modules\Search\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

// Search team - Search & Filters

Route::get('/search', [SearchController::class, 'index'])->name('search.index');
