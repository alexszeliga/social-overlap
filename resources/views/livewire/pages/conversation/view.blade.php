<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

use App\Models\Comment;
use App\Models\Community;
use App\Models\Contribution;
use App\Models\Conversation;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

new #[Layout('layouts.app')] class extends Component {
    public Conversation $conversation;
    public bool $showRootComment = false;

    public function getListeners() {
        return [
            "echo:comment.{$this->conversation->id},CommentCreated" => 'commentCreated'
        ];
    }

    public function commentCreated() {
        $this->reset(['showRootComment']);
        $this->conversation->refresh();
    }

    public function mount(Community $community, Contribution $contribution) {
        $this->conversation = Conversation::where('community_id', '=', $community->id)
                                          ->where('contribution_id', '=', $contribution->id)
                                          ->sole();
    }

    public function with() {
        return [
            'comments' => $this->conversation->comments()->paginate(10),
        ];
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
                <livewire:components.turn.toggle :root="$conversation" key="vote-{{$conversation->id}}" />
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
    @if($comments->count())
    <x-content-card>
        <x-h2>The Conversation</x-h2>
        <div class="space-y-6">
            @foreach($comments as $comment)
                <livewire:components.comment.card 
                    :comment="$comment"
                    :conversation="$conversation"
                    :root="$comment"
                    :key="$comment->id"/>
            
            @endforeach
        </div>
        {{ $comments->links() }}
    </x-content-card>
    @endif
</div>
