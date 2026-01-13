<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
|
| Here you can register public routes for your application.
|
*/

Route::get('/welcome', function () {
    return inertia('Interface/Public/Welcome');
})->name('welcome');
