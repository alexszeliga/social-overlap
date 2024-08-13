<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Community;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


new #[Layout('layouts.app')] class extends Component {

}; ?>

<div>
    <x-header>
        <x-h1>
            A Conversation!
        </x-h1>
    </x-header>
    <x-content-card>
        <x-p>The conversation!</x-p>
    </x-content-card>
</div>
