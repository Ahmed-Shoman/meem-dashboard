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



use App\Http\Controllers\API\ConsultantController;

Route::get('/consultants', [ConsultantController::class, 'index']);
Route::post('/consultants', [ConsultantController::class, 'store']);
Route::get('/consultants/{id}', [ConsultantController::class, 'show']);
Route::put('/consultants/{id}', [ConsultantController::class, 'update']);
Route::delete('/consultants/{id}', [ConsultantController::class, 'destroy']);

use App\Http\Controllers\API\NewsletterSectionController;

Route::get('/newsletter-section', [NewsletterSectionController::class, 'index']);
Route::post('/newsletter-section', [NewsletterSectionController::class, 'store']);
Route::put('/newsletter-section/{newsletterSection}', [NewsletterSectionController::class, 'update']);


use App\Http\Controllers\API\AudioLibraryController;

Route::prefix('audio-library')->group(function () {
    Route::get('/', [AudioLibraryController::class, 'index']);
    Route::post('/', [AudioLibraryController::class, 'store']);
    Route::get('/{id}', [AudioLibraryController::class, 'show']);
    Route::put('/{id}', [AudioLibraryController::class, 'update']);
    Route::delete('/{id}', [AudioLibraryController::class, 'destroy']);
});

use App\Http\Controllers\API\SliderSectionController;

Route::prefix('slider-sections')->group(function () {
    Route::get('/', [SliderSectionController::class, 'index']);
    Route::get('/{id}', [SliderSectionController::class, 'show']);
    Route::post('/', [SliderSectionController::class, 'store']);
    Route::put('/{id}', [SliderSectionController::class, 'update']);
    Route::delete('/{id}', [SliderSectionController::class, 'destroy']);
});


use App\Http\Controllers\API\CustomerReviewController;

Route::prefix('customer-reviews')->group(function () {
    Route::get('/', [CustomerReviewController::class, 'index']);
    Route::get('/{id}', [CustomerReviewController::class, 'show']);
    Route::post('/', [CustomerReviewController::class, 'store']);
    Route::put('/{id}', [CustomerReviewController::class, 'update']);
    Route::delete('/{id}', [CustomerReviewController::class, 'destroy']);
});

use App\Http\Controllers\API\NewsController;

Route::get('/news', [NewsController::class, 'index']);



// on the fly programs عالطاير

use App\Http\Controllers\API\OnTheFlyController;

Route::apiResource('on-the-fly', OnTheFlyController::class);


use App\Http\Controllers\API\AudiobookEpisodeController;

Route::get('audiobook-episodes', [AudiobookEpisodeController::class, 'index']);
Route::post('audiobook-episodes', [AudiobookEpisodeController::class, 'store']);
Route::put('audiobook-episodes/{id}', [AudiobookEpisodeController::class, 'update']);
Route::delete('audiobook-episodes/{id}', [AudiobookEpisodeController::class, 'destroy']);


use App\Http\Controllers\API\AudiobookController;

Route::get('audiobooks', [AudiobookController::class, 'index']); // عرض جميع الكتب الصوتية
Route::post('audiobooks', [AudiobookController::class, 'store']); // إضافة كتاب صوتي
Route::put('audiobooks/{id}', [AudiobookController::class, 'update']); // تحديث كتاب صوتي
Route::delete('audiobooks/{id}', [AudiobookController::class, 'destroy']); // حذف كتاب صوتي



use App\Http\Controllers\ContactController;

Route::prefix('contacts')->group(function () {
    Route::post('/', [ContactController::class, 'store']);

    Route::get('/', [ContactController::class, 'index']);

    Route::get('{id}', [ContactController::class, 'show']);

    Route::put('{id}', [ContactController::class, 'update']);

    Route::delete('{id}', [ContactController::class, 'destroy']);
});


// Contact Section API

use App\Http\Controllers\API\ContactSectionController;

Route::apiResource('contact-sections', ContactSectionController::class);
