<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component {
    //
}; ?>

<div>
    <x-header>
        <x-h1>
            {{ __('Social Overlaps') }}
        </x-h1>
    </x-header>
    <x-content-card>
        <header>
            <x-h2>
                Home of the Home Page
            </x-h2>

            <x-p>
                Here, I will place home page content when it exists.
            </x-p>
        </header>
    </x-content-card>
</div>
