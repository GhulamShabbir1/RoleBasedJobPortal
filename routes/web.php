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

// Reset password page
Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('password.reset');

// ──────────────────────────────────────────────
// DASHBOARD — role-based redirect (handled by JS in layouts/app.blade.php)
// ──────────────────────────────────────────────

// Generic /dashboard: JS in the page reads role from localStorage and redirects
// JWT Auth middleware for checking token from localStorage
Route::get('/dashboard', function () {
    // Check JWT token from header or redirect to login
    $token = request()->bearerToken() ?? request()->query('token');

    if (!$token && !auth()->check()) {
        return redirect()->route('auth.login');
    }

    // Try to get role from localStorage-sent headers
    $role = request()->header('X-User-Role');

    if ($role) {
        return match($role) {
            'admin'    => redirect()->route('dashboard.admin'),
            'employer' => redirect()->route('dashboard.employer'),
            'candidate' => redirect()->route('dashboard.candidate'),
            default    => redirect()->route('auth.login'),
        };
    }

    // Fallback: redirect to jobs if no role detected
    return redirect()->route('jobs.index');
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

// Edit an existing job (employer only — enforced in JS/layout)
Route::get('/jobs/{id}/edit', function ($id) {
    return view('jobs.edit');
})->name('jobs.edit')->where('id', '[0-9]+');

// Single job detail + apply button
Route::get('/jobs/{id}', function ($id) {
    return view('jobs.show', compact('id'));
})->name('jobs.show')->where('id', '[0-9]+');

// Admin: manage jobs
Route::get('/admin/jobs', function () {
    return view('jobs.admin-manage');
})->name('admin.jobs.manage');

// Employer: my jobs
Route::get('/employer/jobs', function () {
    return view('jobs.employer-jobs');
})->name('employer.jobs');

// ──────────────────────────────────────────────
// APPLICATIONS
// ──────────────────────────────────────────────

// Smart redirect — JS detects role and redirects to the correct sub-route
Route::get('/applications', function () {
    return view('applications.index');
})->name('page.applications.index');

// Candidate: track own application statuses (Pending / Reviewed / Rejected)
Route::get('/applications/mine', function () {
    return view('applications.my-applications');
})->name('applications.mine');

// Employer + Admin: review incoming applications for their jobs
Route::get('/applications/review', function () {
    return view('applications.review');
})->name('page.applications.review');

// Admin: view all applications
Route::get('/admin/applications', function () {
    return view('applications.admin-review');
})->name('page.admin.applications.index');

// Admin: view all candidate profiles
Route::get('/candidate-profiles', function () {
    return view('candidate-profiles.index');
})->name('candidate-profiles.index');

// View single candidate profile
Route::get('/candidate-profiles/{id}', function ($id) {
    return view('candidate-profiles.show', compact('id'));
})->name('candidate-profiles.show')->where('id', '[0-9]+');

// ──────────────────────────────────────────────
// COMPANIES
// ──────────────────────────────────────────────

// Public company directory
Route::get('/companies', function () {
    return view('companies.index');
})->name('page.companies.index');

// Employer: manage their company (checks if exists, shows form or view)
Route::get('/employer/company', function () {
    return view('companies.employer-manage');
})->name('employer.company');

// Employer: register / edit their company (logo + certificate upload)
// NOTE: must come BEFORE /{id} to avoid being captured by the wildcard
Route::get('/companies/create', function () {
    return view('companies.register');
})->name('companies.create');

// Employer: edit their company
Route::get('/companies/{id}/edit', function ($id) {
    return view('companies.edit', compact('id'));
})->name('companies.edit')->where('id', '[0-9]+');

// Admin: pending company approvals queue
Route::get('/companies/pending', function () {
    return view('companies.admin-index');
})->name('companies.pending');

// Admin: view all companies
Route::get('/admin/companies', function () {
    return view('companies.admin-index');
})->name('page.admin.companies.index');

// Single company profile
Route::get('/companies/{id}', function ($id) {
    return view('companies.show', compact('id'));
})->name('page.companies.show')->where('id', '[0-9]+');

// ──────────────────────────────────────────────
// CATEGORIES
// ──────────────────────────────────────────────

// Public categories list
Route::get('/categories', function () {
    return view('categories.index');
})->name('categories.index');

// Admin: manage categories
Route::get('/admin/categories', function () {
    return view('categories.manage');
})->name('admin.categories.manage');

// Admin: create category
Route::get('/categories/create', function () {
    return view('categories.create');
})->name('categories.create');

// Admin: edit category
Route::get('/categories/{id}/edit', function ($id) {
    return view('categories.edit', compact('id'));
})->name('categories.edit')->where('id', '[0-9]+');

// ──────────────────────────────────────────────
// CANDIDATE PROFILES
// ──────────────────────────────────────────────

// Candidate: create profile
Route::get('/candidate/profile/create', function () {
    return view('candidate-profiles.create');
})->name('candidate.profile.create');

// Candidate: edit profile
Route::get('/candidate/profile/edit', function () {
    return view('candidate-profiles.edit');
})->name('candidate.profile.edit');

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
