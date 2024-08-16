<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Community;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;


new #[Layout('layouts.app')] class extends Component {
    public Community $community;

    public function claim() {
        Auth::user()->claimCommunity($this->community);
        $this->community->refresh();
    }

    public function disown() {
        Auth::user()->disownCommunity($this->community);
        $this->community->refresh();
    }

    public function mount(Community $community) {
        $this->community = $community;
    }
}; ?>

<div>
    <x-header>
        <div class="flex justify-between">
            <div class="space-y-2">
                <x-h1>
                    {{ $community->name }}
                </x-h1>
                <x-p>
                    {{ $community->description }}
                </x-p>
            </div>
            <div class="flex flex-col space-y-1">
                @if( $community->userIsSubscribed(Auth::user()) )
                    <x-primary-button-link :href="route('contribution.create', ['community'=> $community->slug])">Contribute</x-primary-button-link>
                    <x-secondary-button wire:loading.attr="disabled" wire:click="disown">Disown</x-primary-button>
                @else
                    <x-primary-button wire:loading.attr="disabled" wire:click="claim">Claim</x-primary-button>
                @endif
            </div>
        </div>
    </x-header>
    <x-content-card>
        <x-h2>Conversations</x-h2>
        <ul>
            @foreach($community->conversations as $conversation)
            <li>
                <x-conversation-card :conversation="$conversation" :hideCommunity="true" />
            </li>
            @endforeach
        </ul>
    </x-content-card>
</div>
