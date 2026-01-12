<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\Api\HeartbeatController;
use App\Http\Controllers\Api\InstitutionalPerformanceController;
use App\Http\Controllers\Api\ReportCapabilityRequirementController;
use App\Http\Controllers\Api\ReportMatchController;
use App\Http\Controllers\Api\ReportSystemController;
use App\Http\Controllers\Api\ReportTechnologyServiceController;
use App\Http\Controllers\Api\GeocodingController;
use App\Http\Controllers\Api\ReportSniiController;
use App\Http\Controllers\CapabilityMatchController;
use App\Http\Controllers\Api\ChatBotController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Institution\EquipmentController;
use App\Http\Controllers\RequirementMatchController;
use App\Http\Controllers\SearchDetailController;
use App\Models\Faq;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('file/serve/{file}', [FileController::class, 'serveFile'])->name('file.serve')->middleware('signed');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('requirements/{capabilityRequirementMatch}/matches', [RequirementMatchController::class, 'match'])->name('api.requirements.matches');
    Route::get('capabilities/{capabilityRequirementMatch}/matches', [CapabilityMatchController::class, 'match'])->name('api.capabilities.matches');
    Route::post('/heartbeat', HeartbeatController::class)->name('api.heartbeat');

    Route::prefix('reports')->name('api.reports.')->group(function () {
        Route::get('system', [ReportSystemController::class, 'index'])->name('system');
        Route::get('capabilities', [ReportCapabilityRequirementController::class, 'index'])->name('capabilities');
        Route::get('technology-services', [ReportTechnologyServiceController::class, 'index'])->name('technology');
        Route::get('matches', [ReportMatchController::class, 'index'])->name('matches');
        Route::get('institucional-perfomance', [InstitutionalPerformanceController::class, 'index'])->name('institucional.perfomance');
        Route::get('snii', [ReportSniiController::class, 'index'])->name('snii');
    });
    Route::post('/geocode', [GeocodingController::class, 'geocode'])->name('api.geocode');
    Route::get('certifications/resources', [\App\Http\Controllers\Institution\InstitutionCertificationController::class, 'getResources'])->name('institutions.certifications.resources');
});

Route::get('/locations/states', [LocationController::class, 'getStates'])->name('api.locations.states');
Route::get('/locations/states/{state}/municipalities', [LocationController::class, 'getMunicipalities'])->name('api.locations.municipalities');
Route::get('/locations/municipalities/{municipality}/neighborhoods', [LocationController::class, 'getNeighborhoods'])->name('api.locations.neighborhoods');
Route::get('/locations/postalCode/{postalCode}', [LocationController::class, 'getPostalCode'])->name('api.locations.postalCode');

Route::get('photo/serve/{photo}', [FileController::class, 'servePhoto'])->name('photo.serve')->middleware('signed');
Route::get('facilities-by-department/{department}', [EquipmentController::class, 'getFacilitiesByDepartment'])->name('facilities.by.department');

Route::get('/faqs', function () {
    return Faq::select('id', 'question', 'answer')->whereNull('deleted_at')->get();
});
Route::get('searches/detail/{type}/{id}', SearchDetailController::class)->name('search.detail');
Route::post('/chat-bot', [ChatBotController::class, 'process'])->name('chatbot.process');
