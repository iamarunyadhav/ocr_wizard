<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResumeWizardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/resume', ResumeWizardController::class)->name('resume.wizard');
