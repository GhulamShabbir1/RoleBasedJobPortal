<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CandidateProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes (no authentication required)
Route::prefix('auth')->middleware('throttle:auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

// Public categories (no auth required)
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/search', [CategoryController::class, 'filter']);
    Route::get('/{id}', [CategoryController::class, 'show']);
});

// Public candidate profiles (no auth required)
Route::prefix('candidate-profiles')->group(function () {
    Route::get('/', [CandidateProfileController::class, 'index']);
    Route::get('/search', [CandidateProfileController::class, 'filter']);
    Route::get('/{id}', [CandidateProfileController::class, 'show']);
});

// Public job listings (no auth required)
Route::prefix('jobs')->group(function () {
    Route::get('/', [JobController::class, 'index']);
    Route::get('/{id}', [JobController::class, 'show']);
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

    // Protected candidate profile routes
    Route::prefix('candidate-profiles')->middleware('role:candidate')->group(function () {
        Route::get('/me', [CandidateProfileController::class, 'me']);
        Route::post('/', [CandidateProfileController::class, 'store']);
        Route::put('/{id}', [CandidateProfileController::class, 'update']);
        Route::delete('/{id}', [CandidateProfileController::class, 'destroy']);
    });

    // Company routes (all authenticated users)
    Route::apiResource('companies', CompanyController::class)->only(['index', 'show']);

    // Applications routes (all authenticated users)
    Route::apiResource('applications', ApplicationController::class)->only(['index', 'show']);

    // Candidate routes
    Route::middleware('role:candidate')->group(function () {
        // Candidate profile management
        Route::prefix('candidate-profiles')->group(function () {
            Route::post('/', [CandidateProfileController::class, 'store']);
            Route::put('/{id}', [CandidateProfileController::class, 'update']);
            Route::delete('/{id}', [CandidateProfileController::class, 'destroy']);
        });

        // Job browsing and applications
        Route::prefix('jobs')->group(function () {
            Route::get('/', [JobController::class, 'index']);
            Route::get('/{id}', [JobController::class, 'show']);
            Route::post('/{id}/apply', [JobController::class, 'apply'])
                ->middleware('throttle:uploads');
        });

        // Apply for job (spec: candidate applies via job-based endpoint)
        // Note: POST /applications is intentionally disabled for candidates to avoid
        // inconsistent payload/schema with ApplyApplicationFeature.

        // View own applications
        Route::get('/applications', [ApplicationController::class, 'index']);
        Route::get('/applications/{id}', [ApplicationController::class, 'show']);
        Route::get('/applications/{id}/download', [ApplicationController::class, 'downloadResume']);
    });

    // Employer routes
    Route::middleware('role:employer')->group(function () {
        // Company management
        Route::apiResource('companies', CompanyController::class)->only(['store', 'update', 'destroy'])
            ->middleware('throttle:uploads');

        // Employer: get own company status (for UI gating)
        Route::get('/employer/my-company-status', [\App\Http\Controllers\CompanyStatusController::class, 'myCompanyStatus']);

        // Job management
        Route::prefix('jobs')->group(function () {
            Route::post('/', [JobController::class, 'store']);
            Route::get('/', [JobController::class, 'index']);
            Route::put('/{id}', [JobController::class, 'update']);
            Route::delete('/{id}', [JobController::class, 'destroy']);
            Route::post('/{id}/close', [JobController::class, 'close']);
        });

        // Application review
        Route::put('/applications/{id}/review', [ApplicationController::class, 'review']);
        Route::get('/applications/{id}/download', [ApplicationController::class, 'downloadResume']);
    });

    // Admin routes
    Route::middleware('role:admin')->group(function () {
        // Company approval/rejection
        Route::prefix('companies')->group(function () {
            Route::post('/{id}/approve', [CompanyController::class, 'approve']);
            Route::post('/{id}/reject', [CompanyController::class, 'reject']);
        });

        // Applications management
        Route::put('/applications/{id}', [ApplicationController::class, 'update']);
        Route::delete('/applications/{id}', [ApplicationController::class, 'destroy']);
        Route::get('/applications/{id}/download', [ApplicationController::class, 'downloadResume']);
        
        // Admin can close any job
        Route::prefix('jobs')->group(function () {
            Route::get('/', [JobController::class, 'adminIndex']);
            Route::post('/{id}/close', [JobController::class, 'close']);
            Route::delete('/{id}', [JobController::class, 'adminDestroy']);
        });
    });

    // Dashboard stats for all roles
    Route::prefix('dashboard')->group(function () {
        Route::get('/admin', [\App\Http\Controllers\DashboardController::class, 'adminStats'])->middleware('role:admin');
        Route::get('/employer', [\App\Http\Controllers\DashboardController::class, 'employerStats'])->middleware('role:employer');
        Route::get('/candidate', [\App\Http\Controllers\DashboardController::class, 'candidateStats'])->middleware('role:candidate');
    });
});

