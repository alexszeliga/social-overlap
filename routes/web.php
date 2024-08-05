<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('auth')->group(function () {
    Volt::route('/',                            'pages.home')           ->name('home');
    Volt::route('profile',                      'pages.profile')        ->name('profile');
    Volt::route('community/create',             'pages.community.edit') ->name('community.create');
    Volt::route('community/{community:slug}',   'pages.community.edit') ->name('community.edit');
    Volt::route('communities',                  'pages.community.index')->name('community.index');
});

require __DIR__.'/auth.php';
