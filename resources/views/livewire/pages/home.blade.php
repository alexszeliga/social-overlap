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
            Community Conversations
        </x-h2>
        <ul>
            @foreach(Auth::user()->homepageQuery()->get() as $conversation)
            <li>
                <x-conversation.card :conversation="$conversation" />
            </li>
            @endforeach
        </ul>
    </x-content-card>
</div>
