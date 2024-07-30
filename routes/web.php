<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'dashboard')
     ->middleware(['auth'])
     ->name('welcome');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
