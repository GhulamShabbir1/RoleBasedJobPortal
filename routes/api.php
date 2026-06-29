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
// IMPORTANT: job post form calls GET /api/categories, so this route MUST exist.
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);      // GET /api/categories
    Route::get('/search', [CategoryController::class, 'filter']);
    Route::get('/{id}', [CategoryController::class, 'show'])->where('id', '[0-9]+');
});

// Public candidate profiles (no auth required)
Route::prefix('candidate-profiles')->group(function () {
    Route::get('/', [CandidateProfileController::class, 'index']);
    Route::get('/search', [CandidateProfileController::class, 'filter']);
    Route::get('/{id}', [CandidateProfileController::class, 'show'])->where('id', '[0-9]+');
});


// Public job listings (no auth required)
Route::prefix('jobs')->group(function () {
    Route::get('/', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/{id}', [JobController::class, 'show'])->name('jobs.show');
});

// Protected routes (authentication required)
Route::middleware('jwt')->group(function () {

    // NOTE: categories index route exists above (public): GET /api/categories
    // The job create form calls GET /api/categories, so keep it enabled.

    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::post('/change-password', [AuthController::class, 'changePassword']);
    });

    // User profile
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');

    // Debug endpoint (TEMPORARY - remove in production)
    Route::get('/debug/candidate-profiles', [CandidateProfileController::class, 'debugListAllProfiles']);

    // Candidate routes
    Route::middleware('role:candidate')->prefix('candidate')->group(function () {
        // Candidate profile management
        Route::prefix('profiles')->group(function () {
            Route::get('/me', [CandidateProfileController::class, 'me'])->name('candidate-profiles.me');
            Route::post('/', [CandidateProfileController::class, 'store'])->name('candidate-profiles.store');
            Route::put('/{id}', [CandidateProfileController::class, 'update'])->name('candidate-profiles.update');
            Route::delete('/{id}', [CandidateProfileController::class, 'destroy'])->name('candidate-profiles.destroy');
        });

        // Job browsing and applications
        Route::get('/jobs', [JobController::class, 'index'])->name('candidate.jobs.index');
        Route::get('/jobs/{id}', [JobController::class, 'show'])->name('candidate.jobs.show');
        Route::post('/jobs/{id}/apply', [JobController::class, 'apply'])
            ->middleware('throttle:uploads')
            ->name('jobs.apply');

        // View own applications
        Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/{id}', [ApplicationController::class, 'show'])->name('applications.show');
        Route::get('/applications/{id}/download', [ApplicationController::class, 'downloadResume'])->name('applications.download');

        // Spec-aligned resume download endpoint
        Route::get('/resumes/download/{application_id}', [ApplicationController::class, 'downloadResumeByApplicationId'])->name('resumes.download');
    });


    // Employer routes
    Route::middleware('role:employer')->prefix('employer')->group(function () {
        // Company management - explicit routes for clarity
        Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
        Route::post('/companies', [CompanyController::class, 'store'])
            ->middleware('throttle:uploads')
            ->name('companies.store');
        Route::get('/companies/{id}', [CompanyController::class, 'show'])->name('companies.show');
        Route::put('/companies/{id}', [CompanyController::class, 'update'])
            ->middleware('throttle:uploads')
            ->name('companies.update');
        Route::delete('/companies/{id}', [CompanyController::class, 'destroy'])->name('companies.destroy');

        // Employer: get own company status (for UI gating)
        Route::get('/my-company-status', [\App\Http\Controllers\CompanyStatusController::class, 'myCompanyStatus'])
            ->name('employer.company-status');

        // Job management
        Route::get('/jobs', [JobController::class, 'employerIndex'])->name('employer.jobs.index');
        Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
        Route::put('/jobs/{id}', [JobController::class, 'update'])->name('jobs.update');
        Route::delete('/jobs/{id}', [JobController::class, 'destroy'])->name('jobs.destroy');
        Route::post('/jobs/{id}/close', [JobController::class, 'close'])->name('jobs.close');

        // Application review
        Route::get('/applications', [ApplicationController::class, 'index'])->name('employer.applications.index');
        Route::get('/applications/{id}', [ApplicationController::class, 'show'])->name('employer.applications.show');
        Route::put('/applications/{id}/review', [ApplicationController::class, 'review'])->name('applications.review');
        Route::get('/applications/{id}/download', [ApplicationController::class, 'downloadResume'])->name('employer.applications.download');
    });

    // Admin routes
    Route::middleware('role:admin')->group(function () {
        // Company approval/rejection
        Route::post('/companies/{id}/approve', [CompanyController::class, 'approve'])->name('companies.approve');
        Route::post('/companies/{id}/reject', [CompanyController::class, 'reject'])->name('companies.reject');
        Route::get('/companies', [CompanyController::class, 'index'])->name('admin.companies.index');

        // Category management
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Applications management
        Route::get('/admin/applications', [ApplicationController::class, 'index'])->name('admin.applications.index');
        Route::get('/admin/applications/{id}', [ApplicationController::class, 'show'])->name('admin.applications.show');
        Route::put('/admin/applications/{id}', [ApplicationController::class, 'update'])->name('applications.update');
        Route::delete('/admin/applications/{id}', [ApplicationController::class, 'destroy'])->name('applications.destroy');
        Route::get('/admin/applications/{id}/download', [ApplicationController::class, 'downloadResume'])->name('admin.applications.download');

        // User management
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/filter', [UserController::class, 'filter'])->name('users.filter');
        Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::put('/users/{id}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        // Admin can manage jobs
        Route::get('/admin/jobs', [JobController::class, 'adminIndex'])->name('admin.jobs.index');
        Route::post('/admin/jobs/{id}/close', [JobController::class, 'close'])->name('admin.jobs.close');
        Route::delete('/admin/jobs/{id}', [JobController::class, 'adminDestroy'])->name('admin.jobs.destroy');
    });

    // Dashboard stats for all roles
    Route::prefix('dashboard')->group(function () {
        Route::get('/admin', [\App\Http\Controllers\DashboardController::class, 'adminStats'])->middleware('role:admin');
        Route::get('/employer', [\App\Http\Controllers\DashboardController::class, 'employerStats'])->middleware('role:employer');
        Route::get('/candidate', [\App\Http\Controllers\DashboardController::class, 'candidateStats'])->middleware('role:candidate');
    });
});

