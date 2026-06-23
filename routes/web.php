<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::prefix('auth')->group(function () {
    Route::get('/login', function () {
        return view('auth.login-tailwind');
    });

    Route::get('/signup', function () {
        return view('auth.signup-tailwind');
    });

    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    });
});

// Dashboard (role-based)
Route::get('/dashboard', function () {
    $role = null;

    // Server-side role detection (only works if using Laravel auth session).
    // This project also stores JWT user data in localStorage for API calls.
    // If no authenticated Laravel user exists, we default to candidate.
    $laravelUser = auth()->user();
    if ($laravelUser && isset($laravelUser->role)) {
        $role = $laravelUser->role;
    }

    $blade = 'dashboard.candidate-dashboard';
    if ($role === 'admin') {
        $blade = 'dashboard.admin-dashboard';
    } elseif ($role === 'employer') {
        $blade = 'dashboard.employer-dashboard';
    }

    return view($blade);

});

Route::get('/dashboard/admin', function () {
    return view('dashboard.admin-dashboard');
});

Route::get('/dashboard/employer', function () {
    return view('dashboard.employer-dashboard');
});

Route::get('/dashboard/candidate', function () {
    return view('dashboard.candidate-dashboard');
});


// Jobs
Route::get('/jobs', function () {
    return view('jobs.index');
});
Route::get('/jobs/create', function () {
    return view('jobs.create');
});
Route::get('/jobs/{id}', function ($id) {
    return view('jobs.show', compact('id'));
});

// Applications
Route::get('/applications', function () {
    return view('applications.index');
});

// Companies
Route::get('/companies', function () {
    return view('companies.index');
});
Route::get('/companies/create', function () {
    return view('companies.create');
});
Route::get('/companies/{id}', function ($id) {
    return view('companies.show', compact('id'));
});

// Profile
Route::get('/profile', function () {
    return view('dashboard.dashboard');
});

// Settings
Route::get('/settings', function () {
    return view('dashboard.dashboard');
});

// Admin users
Route::get('/users', function () {
    return view('users.manage');
});

// Fallback
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
