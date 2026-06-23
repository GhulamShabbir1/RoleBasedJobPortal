<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Recruitment & Job Portal
|--------------------------------------------------------------------------
| All routes serve Blade views. Authentication & role enforcement is handled
| client-side via JWT stored in localStorage and checked in layouts/app.blade.php.
| API routes (resources/data) are in routes/api.php.
|--------------------------------------------------------------------------
*/

// ──────────────────────────────────────────────
// PUBLIC
// ──────────────────────────────────────────────

// Landing / home page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ──────────────────────────────────────────────
// AUTH PAGES
// ──────────────────────────────────────────────

Route::prefix('auth')->name('auth.')->group(function () {

    // Login page
    Route::get('/login', function () {
        return view('auth.login-tailwind');
    })->name('login');

    // Register / Sign-up page
    Route::get('/signup', function () {
        return view('auth.signup-tailwind');
    })->name('signup');

    // Forgot password page
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('forgot-password');
});

// ──────────────────────────────────────────────
// DASHBOARD — role-based redirect (handled by JS in layouts/app.blade.php)
// ──────────────────────────────────────────────

// Generic /dashboard: JS in the page reads role from localStorage and redirects
Route::get('/dashboard', function () {
    // Server-side role detection (works when using Laravel session auth)
    $laravelUser = auth()->user();
    $role = $laravelUser?->role ?? null;

    return match($role) {
        'admin'    => redirect()->route('dashboard.admin'),
        'employer' => redirect()->route('dashboard.employer'),
        default    => redirect()->route('dashboard.candidate'),
    };
})->name('dashboard');

// Role-specific dashboards
Route::get('/dashboard/admin', function () {
    return view('dashboard.admin-dashboard');
})->name('dashboard.admin');

Route::get('/dashboard/employer', function () {
    return view('dashboard.employer-dashboard');
})->name('dashboard.employer');

Route::get('/dashboard/candidate', function () {
    return view('dashboard.candidate-dashboard');
})->name('dashboard.candidate');

// ──────────────────────────────────────────────
// JOBS
// ──────────────────────────────────────────────

// Public job listing with search + advanced filters
Route::get('/jobs', function () {
    return view('jobs.index');
})->name('jobs.index');

// Post a new job (employer only — enforced in JS/layout)
Route::get('/jobs/create', function () {
    return view('jobs.create');
})->name('jobs.create');

// Single job detail + apply button
Route::get('/jobs/{id}', function ($id) {
    return view('jobs.show', compact('id'));
})->name('jobs.show')->where('id', '[0-9]+');

// ──────────────────────────────────────────────
// APPLICATIONS
// ──────────────────────────────────────────────

// Smart redirect — JS detects role and redirects to the correct sub-route
Route::get('/applications', function () {
    return view('applications.index');
})->name('applications.index');

// Candidate: track own application statuses (Pending / Reviewed / Rejected)
Route::get('/applications/mine', function () {
    return view('applications.my-applications');
})->name('applications.mine');

// Employer + Admin: review incoming applications for their jobs
Route::get('/applications/review', function () {
    return view('dashboard.review-applications');
})->name('applications.review');

// ──────────────────────────────────────────────
// COMPANIES
// ──────────────────────────────────────────────

// Public company directory
Route::get('/companies', function () {
    return view('companies.index');
})->name('companies.index');

// Employer: register / edit their company (logo + certificate upload)
// NOTE: must come BEFORE /{id} to avoid being captured by the wildcard
Route::get('/companies/create', function () {
    return view('companies.register');
})->name('companies.create');

// Admin: pending company approvals queue
Route::get('/companies/pending', function () {
    return view('companies.pending-review');
})->name('companies.pending');

// Single company profile
Route::get('/companies/{id}', function ($id) {
    return view('companies.show', compact('id'));
})->name('companies.show')->where('id', '[0-9]+');

// ──────────────────────────────────────────────
// PROFILE & SETTINGS
// ──────────────────────────────────────────────

// User profile — shows name, email, role; allows password change
Route::get('/profile', function () {
    return view('profile.index');
})->name('profile');

// Account settings
Route::get('/settings', function () {
    return view('settings.index');
})->name('settings');

// ──────────────────────────────────────────────
// ADMIN — USER MANAGEMENT
// ──────────────────────────────────────────────

Route::get('/users', function () {
    return view('users.manage');
})->name('users.manage');

// ──────────────────────────────────────────────
// FALLBACK — must be the very last route
// ──────────────────────────────────────────────

Route::fallback(function () {
    return view('welcome');
});
