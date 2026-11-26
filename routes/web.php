<?php

use Illuminate\Support\Facades\Route;

/*
| Instructor-owned. Each module registers its own routes in app/Modules/<Module>/routes.php.
| Do not add module routes here.
*/

Route::get('/', fn () => redirect()->route('catalog.index'))->name('home');
