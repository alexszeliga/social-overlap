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
            <div class="flex flex-col md:flex-row items-center gap-2">
                <livewire:components.turn.toggle :root="$conversation" key="{{'vote-'.$conversation->id}}" />
                <div class="flex flex-col gap-2">
                    <x-h4>u:{{ $conversation->contribution->user->name }}</x-h4>
                    <x-h1>{{ $conversation->contribution->name }}</x-h1>
                    <x-h4>{{ $conversation->created_at->diffForHumans() }}</x-h4>
                </div>
            </div>
            <div class="flex flex-col gap-2">
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
        <livewire:components.comment.form :conversation="$conversation" :root="$conversation" key="{{'comment-form-'.$conversation->id}}" />
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
                    key="{{'comment-card-'.$comment->id}}"/>
            
            @endforeach
        </div>
        {{ $comments->links() }}
    </x-content-card>
    @endif
</div>
