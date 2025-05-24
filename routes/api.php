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
Route::prefix('patients')->middleware('auth:sanctum')->group(function () {
    // Anyone logged in can get patients
    Route::get('/', [PatientController::class, 'index']);
    Route::get('/{id}', [PatientController::class, 'show']);

    // Only admin or recorder can create
    Route::post('/', [PatientController::class, 'store'])->middleware('isRecorderOrAdmin');

    // Only admin can update
    Route::put('/{id}', [PatientController::class, 'update'])->middleware('isAdmin');

    // No delete route (no one can delete)
});

// Contact Routes
Route::prefix('contacts')->middleware('auth:sanctum')->group(function () {
    // Anyone logged in can get contacts
    Route::get('/{patient_id}', [ContactController::class, 'show']);

    // Only admin or recorder can create
    Route::post('/', [ContactController::class, 'store'])->middleware('isRecorderOrAdmin');

    // Only admin can update
    Route::put('/{id}', [ContactController::class, 'update'])->middleware('isAdmin');

    // No delete route
});

// Next of Kin Routes
Route::prefix('next-of-kin')->middleware('auth:sanctum')->group(function () {
    // Anyone logged in can get next of kin info
    Route::get('/{patient_id}', [NextOfKinController::class, 'show']);

    // Only admin or recorder can create
    Route::post('/', [NextOfKinController::class, 'store'])->middleware('isRecorderOrAdmin');

    // Only admin can update
    Route::put('/{id}', [NextOfKinController::class, 'update'])->middleware('isAdmin');

    // No delete route
});

// Authentication Routes
Route::post('/login', [AuthController::class, 'login']);

// Routes requiring authentication
Route::middleware('auth:sanctum')->group(function () {
    // Staff changes password (first login)
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    // Admin-only routes
    Route::middleware('isAdmin')->group(function () {
        // Admin creates new staff
        Route::post('/admin/staff', [StaffController::class, 'createStaff']);

        // Admin resets a staff password
        Route::post('/admin/staff/reset-password', [AuthController::class, 'resetStaffPassword']);
    });
});
