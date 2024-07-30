<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('auth')->group(function () {
    Volt::route('/', 'pages.home')
        ->name('home');
    Volt::route('profile', 'pages.profile')
        ->name('profile');
    Volt::route('community/{$slug}', 'pages.community.edit')
        ->name('community.edit');
});

require __DIR__.'/auth.php';
