<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Wizard\Step1Upload;

// web.php
Route::get('/', \App\Http\Livewire\WizardContainer::class)->name('wizard.start');
