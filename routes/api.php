<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes (no authentication required)
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

// Protected routes (authentication required)
Route::middleware('jwt')->group(function () {
    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
    });

    // User profile
    Route::get('/profile', [UserController::class, 'profile']);

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        // Add admin routes here
    });

    // Employer routes
    Route::middleware('role:employer')->prefix('employer')->group(function () {
        // Add employer routes here
    });

    // Candidate routes
    Route::middleware('role:candidate')->prefix('candidate')->group(function () {
        // Add candidate routes here
    });
});
