<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Community;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;


new #[Layout('layouts.app')] class extends Component {
    public Community $community;
    protected $conversations;

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
    
    public function with() {
        return [
            'conversations' => $this->community->conversations()->paginate(10),
        ];
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
    @if($conversations->count())
    <x-content-card>
        <x-h2>Conversations</x-h2>
        <div class="space-y-6">
            @foreach($conversations as $conversation)
            <x-conversation.card :conversation="$conversation" :hideCommunity="true" />
            @endforeach
        </div>
        {{ $conversations->links() }}
    </x-content-card>
    @endif
</div>
