<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;


new #[Layout('layouts.app')] class extends Component {
    //
}; ?>

<div>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mr-5">
                {{ __('Communities') }}
            </h2>
            <x-primary-button-link :href="route('community.create')" class="ml-4">
                Create a Community
            </x-primary-button-link>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Find your cohort!
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            A list of communities.
                        </p>
                    </header>
                </div>
            </div>
        </div>
    </div>
</div>
