<?php

use App\Http\Controllers\Company\InterviewController;
use App\Http\Controllers\HiringController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\Auth\CompanyLoginController;


// web.php
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{project}/get', [JobController::class, 'show'])->name('jobs.show');
Route::post('/jobs/{id}/apply', [JobController::class, 'apply'])->name('jobs.apply');

Route::get("/questionnaire/{application:id}", [JobController::class, "questionnaire"])->name("job.questionnaire");
Route::post("/questionnaire/{application:id}/create", [QuestionnaireController::class, "store"])->name("candidate.questionnaire.answers");

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

    Route::get("/questionnaire/{application:id}", [App\Http\Controllers\Company\QuestionnaireController::class, "get"])->name("job.questionnaire");

    Route::post("/application/{application}/interview", [InterviewController::class, "interview"])->name("candidate.interview");

    Route::get("{application:id}/hiring", [HiringController::class, "hire"])->name("candidate.hire");
});

