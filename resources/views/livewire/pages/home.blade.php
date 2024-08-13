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
        <x-h2>
            Community Contributions
        </x-h2>
    </x-content-card>
</div>
