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
    Route::get('/', [OurWorksController::class, 'index']); // ✅ جلب كل البيانات
    Route::get('/{id}', [OurWorksController::class, 'show']); // ✅ جلب سجل واحد
    Route::post('/', [OurWorksController::class, 'store']); // ✅ إنشاء سجل جديد
    Route::put('/{id}', [OurWorksController::class, 'update']); // ✅ تحديث بيانات
    Route::delete('/{id}', [OurWorksController::class, 'destroy']); // ✅ حذف سجل
});


use App\Http\Controllers\API\HeaderController;

Route::get('/header', [HeaderController::class, 'index']); // عرض بيانات الهيدر
Route::post('/header', [HeaderController::class, 'store']); // إنشاء أو تعديل بيانات الهيدر
Route::delete('/header', [HeaderController::class, 'destroy']); // حذف بيانات الهيدر



use App\Http\Controllers\API\SubscriptionSectionController;

Route::get('/subscription-section', [SubscriptionSectionController::class, 'index']); // جلب البيانات
Route::post('/subscription-section', [SubscriptionSectionController::class, 'store']); // إنشاء أو تعديل
Route::delete('/subscription-section', [SubscriptionSectionController::class, 'destroy']); // حذف

use App\Http\Controllers\API\AboutSectionController;

Route::prefix('about')->group(function () {
    Route::get('/', [AboutSectionController::class, 'index']); // عرض البيانات
    Route::post('/', [AboutSectionController::class, 'store']); // إنشاء البيانات
    Route::put('/{id}', [AboutSectionController::class, 'update']); // تعديل البيانات
});