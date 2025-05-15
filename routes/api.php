<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Patient\ContactController;
use App\Http\Controllers\Patient\NextOfKinController;
use Illuminate\Http\Request;

/*
|----------------------------------------------------------------------
| API Routes
|----------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Patient Routes
Route::prefix('patients')->group(function () {
    Route::get('/', [PatientController::class, 'index']);
    Route::post('/', [PatientController::class, 'store']);
    Route::get('/{id}', [PatientController::class, 'show']);
    Route::put('/{id}', [PatientController::class, 'update']);
    Route::delete('/{id}', [PatientController::class, 'destroy']);
});

// Contact Routes
Route::prefix('contacts')->group(function () {
    Route::post('/', [ContactController::class, 'store']);
    Route::put('/{id}', [ContactController::class, 'update']);
    Route::delete('/{id}', [ContactController::class, 'destroy']);
});

// Next of Kin Routes
Route::prefix('next-of-kin')->group(function () {
    Route::post('/', [NextOfKinController::class, 'store']);
    Route::put('/{id}', [NextOfKinController::class, 'update']);
    Route::delete('/{id}', [NextOfKinController::class, 'destroy']);
});
