<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Patient\ContactController;
use App\Http\Controllers\Patient\NextOfKinController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\StaffController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider and assigned to the "api" middleware group.
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
    Route::get('/{patient_id}', [ContactController::class, 'show']);
    Route::post('/', [ContactController::class, 'store']);
    Route::put('/{id}', [ContactController::class, 'update']);
    Route::delete('/{id}', [ContactController::class, 'destroy']);
});

// Next of Kin Routes
Route::prefix('next-of-kin')->group(function () {
    Route::get('/{patient_id}', [NextOfKinController::class, 'show']);
    Route::post('/', [NextOfKinController::class, 'store']);
    Route::put('/{id}', [NextOfKinController::class, 'update']);
    Route::delete('/{id}', [NextOfKinController::class, 'destroy']);
});

// Auth and Staff Routes
Route::post('/login', [AuthController::class, 'login']);

// Routes requiring authentication
Route::middleware('auth:sanctum')->group(function () {
    // Staff changes password (first login)
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    // Admin-only routes protected by isAdmin middleware
    Route::middleware('isAdmin')->group(function () {
        // Admin creates new staff
        Route::post('/admin/staff', [StaffController::class, 'createStaff']);

        // Admin resets a staff password
        Route::post('/admin/staff/reset-password', [AuthController::class, 'resetStaffPassword']);
    });
});
