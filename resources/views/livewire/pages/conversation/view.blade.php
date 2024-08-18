<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

use App\Models\Comment;
use App\Models\Community;
use App\Models\Contribution;
use App\Models\CommunityContribution;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

new #[Layout('layouts.app')] class extends Component {
    public CommunityContribution $conversation;
    public bool $showRootComment = false;

    #[On('comment-created')]
    public function commentCreated($rootId) {
        if ($this->conversation->id === $rootId) {
            $this->reset(['showRootComment']);
            $this->conversation->refresh();
        }
    }

    public function mount(Community $community, Contribution $contribution) {
        $this->conversation = CommunityContribution::where('community_id', '=', $community->id)
                                                   ->where('contribution_id', '=', $contribution->id)
                                                   ->sole();
    }
}; ?>

<div>
    <x-header>
        <div class="flex items-center justify-between">
            <x-h1>
                {{ $conversation->contribution->name }}
            </x-h1>
            <div class="flex flex-col space-y-1">
                @if($conversation->community->userIsSubscribed(Auth::user()))
                <x-primary-button wire:click="$toggle('showRootComment')">
                    Comment
                </x-primary-button>
                @endif
                <x-secondary-button-link :href="$conversation->contribution->url" target="_BLANK">
                    Visit
                </x-secondary-button-link>
            </div>
        </div>
    </x-header>
    @if($showRootComment)
    <x-content-card>
        <livewire:components.comment.form :conversation="$conversation" :root="$conversation" :key="$conversation->id" />
    </x-content-card>
    @endif
    @if($conversation->comments->count() > 0)
    <x-content-card>
        <x-h2>The Conversation</x-h2>
        <ul>
            @foreach($conversation->comments as $comment)
                <li wire:key="list-{{ $comment->id }}">
                    <livewire:components.comment.card 
                        :comment="$comment"
                        :conversation="$conversation"
                        :root="$comment"
                        :key="$comment->id"/>
                </li>
            @endforeach
        </ul>
    </x-content-card>
    @endif
</div>
