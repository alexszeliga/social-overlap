<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('auth')->group(function () {
    Volt::route('/',                                    'pages.home')              ->name('home');
    Volt::route('u/profile',                            'pages.profile')           ->name('profile');
    Volt::route('u/conversations',                      'pages.conversation.index')->name('user.conversation.index');
    Volt::route('u/communities',                        'pages.community.index')   ->name('user.community.index');
    Volt::route('contribution/create',                  'pages.contribution.edit') ->name('contribution.create');
    Volt::route('c',                                    'pages.community.index')   ->name('community.index');
    Volt::route('c/create',                             'pages.community.edit')    ->name('community.create');
    Volt::route('c/{community:slug}',                   'pages.community.view')    ->name('community.view');
    Volt::route('c/{community:slug}/edit',              'pages.community.edit')    ->name('community.edit');
    Volt::route('c/{community:slug}/{contribution:id}', 'pages.conversation.view') ->name('conversation.view');
});

require __DIR__.'/auth.php';
