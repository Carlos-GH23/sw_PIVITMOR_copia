<?php

use App\Http\Controllers\AcademicDegreeController;
use GuzzleHttp\Psr7\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    // intitutions
    Route::get('/installations', function () {
        return Inertia::render('Shared/Searches/Pages/Installations');
    })->name('installations.index');

    // company
    Route::get('/vinculations/capabilities', function () {
        return Inertia::render('Shared/Vinculation/Pages/Capabilities');
    })->name('vinculation.capabilities');
    Route::get('/vinculations/requirements', function () {
        return Inertia::render('Shared/Vinculation/Pages/Requirements');
    })->name('vinculation.requirements');

    // academic
    Route::prefix('academic')->group(function () {
        Route::get('/academic-degrees', [AcademicDegreeController::class, 'index'])->name('academics.academic_degrees.index');
        Route::get('/academic-degrees/create', [AcademicDegreeController::class, 'create'])->name('academics.academic_degrees.create');
    });

    // catalogs
    Route::get('/backups-settings', function () {
        return Inertia::render('Core/Settings/Backups/Pages/Index');
    })->name('backup.settings');

    Route::get('/CommunityOrganization/Profile', function () {
        return Inertia::render('Domains/NonProfitOrganization/Profile/Pages/Profile', [
            'title' => 'Organización No Gubernamental',
            'routeName' => 'communityOrganization.',
        ]);
    })->name('communityOrganization.profile');
});

require __DIR__ . '/auth.php';
