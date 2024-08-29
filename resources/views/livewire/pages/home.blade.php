<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;


new #[Layout('layouts.app')] class extends Component {
    protected $conversations;

    public function mount() {
        $query = Auth::user()->homepageQuery();
        $this->conversations = $query->paginate(10);
    }
}; ?>

<div>
    <x-header>
        <x-h1>
            {{ __('Social Overlaps') }}
        </x-h1>
    </x-header>
    <x-content-card>
        <x-h2>
            Community Conversations
        </x-h2>
        <div class="space-y-6">
        @foreach($this->conversations as $conversation)
            <x-conversation.card :conversation="$conversation" />
        @endforeach
        </div>
        {{ $this->conversations->links() }}
    </x-content-card>
</div>
