<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component {
    //
}; ?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Social Overlaps Home') }}
        </h2>
    </x-slot>
    <x-content-card>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Home of the Home Page
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Here, I will place home page content when it exists.
            </p>
        </header>
    </x-content-card>
</div>
