<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::prefix('auth')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    });

    Route::get('/signup', function () {
        return view('auth.signup');
    });

    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    });
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
});

// Jobs
Route::get('/jobs', function () {
    return view('jobs.index');
});

// Applications
Route::get('/applications', function () {
    return view('applications.index');
});

// Companies
Route::get('/companies', function () {
    return view('companies.index');
});

// Profile
Route::get('/profile', function () {
    return view('dashboard.dashboard');
});

// Settings
Route::get('/settings', function () {
    return view('dashboard.dashboard');
});

// Fallback
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
