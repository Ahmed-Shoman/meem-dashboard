<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProgramController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\StudioBookingController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});

 //program api
Route::prefix('programs')->group(function () {
    Route::get('/', [ProgramController::class, 'index']);
    Route::get('/{id}', [ProgramController::class, 'show']);
    Route::post('/', [ProgramController::class, 'store']);
    Route::put('/{id}', [ProgramController::class, 'update']);
    Route::delete('/{id}', [ProgramController::class, 'destroy']);
});




Route::prefix('services')->group(function () {
    Route::get('/', [ServiceController::class, 'index']);
    Route::get('/{id}', [ServiceController::class, 'show']);
    Route::post('/', [ServiceController::class, 'store']);
    Route::put('/{id}', [ServiceController::class, 'update']);
    Route::delete('/{id}', [ServiceController::class, 'destroy']);
});

Route::prefix('studio-bookings')->group(function () {
    Route::get('/', [StudioBookingController::class, 'index']);
    Route::get('/{id}', [StudioBookingController::class, 'show']);
    Route::post('/', [StudioBookingController::class, 'store']);
    Route::put('/{id}', [StudioBookingController::class, 'update']);
    Route::delete('/{id}', [StudioBookingController::class, 'destroy']);
});

use App\Http\Controllers\API\OurWorksController;

Route::prefix('our-works')->group(function () {
    Route::get('/', [OurWorksController::class, 'index']);
    Route::get('/{id}', [OurWorksController::class, 'show']);
    Route::post('/', [OurWorksController::class, 'store']); //
    Route::put('/{id}', [OurWorksController::class, 'update']); //
    Route::delete('/{id}', [OurWorksController::class, 'destroy']); //

});
use App\Http\Controllers\API\HeaderController;

Route::get('/header', [HeaderController::class, 'index']); //
Route::post('/header', [HeaderController::class, 'store']); //
Route::delete('/header', [HeaderController::class, 'destroy']); //



use App\Http\Controllers\API\SubscriptionSectionController;

Route::get('/subscription-section', [SubscriptionSectionController::class, 'index']); //
Route::post('/subscription-section', [SubscriptionSectionController::class, 'store']); //
Route::delete('/subscription-section', [SubscriptionSectionController::class, 'destroy']); //

use App\Http\Controllers\API\AboutSectionController;

Route::prefix('about')->group(function () {
    Route::get('/', [AboutSectionController::class, 'index']); //
    Route::post('/', [AboutSectionController::class, 'store']); //
    Route::put('/{id}', [AboutSectionController::class, 'update']); //
});


//section controller in aboutus page
use App\Http\Controllers\API\StorySectionController;

Route::get('/story-section', [StorySectionController::class, 'index']);
Route::post('/story-section', [StorySectionController::class, 'store']);

use App\Http\Controllers\API\MissionSectionController;

Route::prefix('mission-sections')->group(function () {
    Route::get('/', [MissionSectionController::class, 'index']); // Get all records
    Route::get('/{id}', [MissionSectionController::class, 'show']); // Get single record
    Route::post('/', [MissionSectionController::class, 'store']); // Create new record
    Route::put('/{id}', [MissionSectionController::class, 'update']); // Update record
    Route::delete('/{id}', [MissionSectionController::class, 'destroy']); // Delete record
});

use App\Http\Controllers\API\TeamMemberController;

Route::prefix('team-members')->group(function () {
    Route::get('/', [TeamMemberController::class, 'index']); // Get all records
    Route::get('/{id}', [TeamMemberController::class, 'show']); // Get single record
    Route::post('/', [TeamMemberController::class, 'store']); // Create new record
    Route::put('/{id}', [TeamMemberController::class, 'update']); // Update record
    Route::delete('/{id}', [TeamMemberController::class, 'destroy']); // Delete record
});



use App\Http\Controllers\Api\ConsultantController;

Route::get('/consultants', [ConsultantController::class, 'index']);
Route::post('/consultants', [ConsultantController::class, 'store']);
Route::get('/consultants/{id}', [ConsultantController::class, 'show']);
Route::put('/consultants/{id}', [ConsultantController::class, 'update']);
Route::delete('/consultants/{id}', [ConsultantController::class, 'destroy']);


use App\Http\Controllers\Api\PartnerController;

Route::get('/partners', [PartnerController::class, 'index']);
Route::post('/partners', [PartnerController::class, 'store']);
Route::get('/partners/{id}', [PartnerController::class, 'show']);
Route::put('/partners/{id}', [PartnerController::class, 'update']);
Route::delete('/partners/{id}', [PartnerController::class, 'destroy']);



use App\Http\Controllers\Api\NewsletterSectionController;

Route::get('/newsletter-section', [NewsletterSectionController::class, 'index']);
Route::post('/newsletter-section', [NewsletterSectionController::class, 'store']);
Route::put('/newsletter-section/{newsletterSection}', [NewsletterSectionController::class, 'update']);


use App\Http\Controllers\Api\PartnershipController;

Route::get('/partnerships', [PartnershipController::class, 'index']);
Route::post('/partnerships', [PartnershipController::class, 'store']);
Route::put('/partnerships/{partnership}', [PartnershipController::class, 'update']);
Route::delete('/partnerships/{partnership}', [PartnershipController::class, 'destroy']);


use App\Http\Controllers\ContentSectionController;

Route::get('/content-section', [ContentSectionController::class, 'index']);
Route::post('/content-section', [ContentSectionController::class, 'store']);
Route::put('/content-section/{id}', [ContentSectionController::class, 'update']);
Route::delete('/content-section/{id}', [ContentSectionController::class, 'destroy']);


use App\Http\Controllers\Api\AudioLibraryController;

Route::prefix('audio-library')->group(function () {
    Route::get('/', [AudioLibraryController::class, 'index']);
    Route::post('/', [AudioLibraryController::class, 'store']);
    Route::get('/{id}', [AudioLibraryController::class, 'show']);
    Route::put('/{id}', [AudioLibraryController::class, 'update']);
    Route::delete('/{id}', [AudioLibraryController::class, 'destroy']);
});