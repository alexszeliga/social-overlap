<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component {
    protected string $pageTitle = "Create Contribution";
};
?>

<div>
    <x-header>
        <x-h1>
            {{ __($this->pageTitle) }}
        </x-h1>
    </x-header>
    <x-content-card>
    </x-content-card>
</div>
