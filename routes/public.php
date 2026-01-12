<?php

use App\Http\Controllers\Api\HomeNoticeController;
use App\Http\Controllers\SmartSearchController;
use App\Http\Controllers\EcosystemMapController;
use App\Http\Controllers\SuccessStoryController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Rutas públicas welcome
Route::get('/', [WelcomeController::class, 'home'])->name('welcome');

Route::get('/organization-registrations/create', [WelcomeController::class, 'create'])
    ->name('organization-registrations.create');
Route::post('/organization-registrations', [WelcomeController::class, 'store'])
    ->name('organization-registrations.store');

Route::get('/home-b', function () {
    return Inertia::render('Interface/Welcome/Pages/HomeB');
})->name('welcome.homeB');

Route::get('/que-es-PIVITMor', function () {
    return Inertia::render('Interface/Welcome/Pages/AboutPivitmor');
})->name('aboutPivitmor');

Route::get('/casos-de-exito', [SuccessStoryController::class, 'index'])->name('welcome.successStories');

Route::get('/contacto', function () {
    return Inertia::render('Interface/Welcome/Pages/Contact');
})->name('contact');

Route::get('/buscador-inteligente', [SmartSearchController::class, 'index'])->name('welcome.smartSearch');

Route::get('/mapa-ecosistema', [EcosystemMapController::class, 'index'])->name('welcome.ecosystemMap');

Route::get('/noticias',[HomeNoticeController::class, 'index'])->name('welcome.notices');

Route::get('/noticias/{slug?}/{id}', [HomeNoticeController::class, 'show'])
    ->name('welcome.notices.details');
