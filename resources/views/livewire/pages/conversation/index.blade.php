<?php
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component {

};
?>

<div>
    <x-header>
        <x-h1>My Conversations</x-h1>
    </x-header>
    <x-content-card>
        <div class="space-y-6">
        @foreach(Auth::user()->conversations as $conversation)
            <x-conversation.card :conversation="$conversation" />
        @endforeach
        </div>
    </x-content-card>
</div>