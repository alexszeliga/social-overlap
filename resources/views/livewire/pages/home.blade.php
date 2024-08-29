<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;


new #[Layout('layouts.app')] class extends Component {
    public function with() {
        $query = Auth::user()->homepageQuery();

        return [
            'conversations' => $query->paginate(10),
        ];
    }
}; ?>

<div>
    <x-header>
        <x-h1>
            {{ __('Social Overlaps') }}
        </x-h1>
    </x-header>
    @if($conversations->count())
    <x-content-card>
        <x-h2>
            Community Conversations
        </x-h2>
        <div class="space-y-6">
        @foreach($conversations as $conversation)
            <x-conversation.card :conversation="$conversation" />
        @endforeach
        </div>
        {{ $conversations->links() }}
    </x-content-card>
    @endif
</div>
