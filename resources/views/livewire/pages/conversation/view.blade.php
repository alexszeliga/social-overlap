<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Community;
use App\Models\Contribution;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


new #[Layout('layouts.app')] class extends Component {
    public Community $community;
    public Contribution $contribution;
    public function mount(Community $community, Contribution $contribution) {
        $this->community = $community;
        $this->contribution = $contribution;
    }
}; ?>

<div>
    <x-header>
        <div class="flex items-center justify-between">
            <x-h1>
                {{ $contribution->name }}
            </x-h1>
            <x-primary-button-link :href="$contribution->url" target="_BLANK">
                Visit
            </x-primary-button-link>
        </div>
    </x-header>
    <x-content-card>
        <x-p>The conversation!</x-p>
    </x-content-card>
</div>
