<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('auth')->group(function () {
    Volt::route('/', 'pages.dashboard')
        ->name('welcome');
    Volt::route('profile', 'pages.profile')
        ->name('profile');
});

require __DIR__.'/auth.php';
