<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\Auth\CompanyLoginController;


// web.php
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{project}/get', [JobController::class, 'show'])->name('jobs.show');
Route::post('/jobs/{id}/apply', [JobController::class, 'apply'])->name('jobs.apply');

// COMPANY LOGIN
Route::get('/company/login', [CompanyLoginController::class, 'showLoginForm'])->name('company.login');
Route::post('/company/login', [CompanyLoginController::class, 'login']);

// Group routes with 'company' prefix and middleware (auth:company)
Route::prefix('company')->middleware(['auth:company'])->name('company.')->group(function () {

    // Dashboard - list jobs
    Route::get('/dashboard', [App\Http\Controllers\Company\JobController::class, 'index'])->name('dashboard');

    // Show form to create a new job
    Route::get('/jobs/create', [\App\Http\Controllers\Company\JobController::class, 'create'])->name('jobs.create');

    // Store new job
    Route::post('/jobs', [\App\Http\Controllers\Company\JobController::class, 'store'])->name('jobs.store');

    // View job applications
    Route::get('/jobs/{job}/applications', [App\Http\Controllers\Company\ApplicationController::class, 'index'])->name('jobs.applications');

});

