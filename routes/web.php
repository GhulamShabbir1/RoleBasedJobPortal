<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware('jwt')->group(function () {
    Route::get('/profile', [UserController::class, 'profile']);
});

Route::middleware(['jwt', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
});

Route::middleware(['jwt', 'role:employer'])->group(function () {
    Route::get('/employer/jobs', [JobController::class, 'index']);
});

Route::middleware(['jwt', 'role:candidate'])->group(function () {
    Route::get('/jobs', [JobController::class, 'list']);
});