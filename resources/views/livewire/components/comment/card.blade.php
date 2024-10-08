<?php

use App\Models\Comment;
use App\Models\Conversation;

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Livewire\Attributes\On;


new class extends Component {
    #[Validate('required')]
    public ?string $body;
    public bool $showForm = false;
    public bool $hideComments = true;

    public Comment $comment;
    public Conversation $conversation;
    public $root;

    public function getListeners() {
        return [
            "echo:comment.{$this->comment->id},CommentCreated" => 'commentCreated'
        ];
    }

    public function commentCreated() {
        $this->reset(['showForm']);
        $this->conversation->refresh();
    }
}; ?>


<x-card-border>
    <div class="flex flex-col gap-3">
        <div class="flex gap-6">
            <x-h4>u:{{ $comment->user->name }}</x-h4>
            <x-h4>{{ $comment->created_at->diffForHumans() }}</x-h4>
        </div>
        <x-p>{{ $comment->body }}</x-p>
        <livewire:components.turn.toggle :root="$comment" key="{{'vote-' . $comment->id}}"/>
        @if($showForm)
            <livewire:components.comment.form :conversation="$conversation" :root="$root" key="{{'comment-form-'.$root->id}}"/>
        @else
            <div>
                <x-primary-button wire:click="$toggle('showForm')">Comment</x-primary-button>
            </div>
        @endif
        @if($comment->comments->count() > 0)
            @if($hideComments)
                <div>
                    <x-text-button class="inline" wire:click="$toggle('hideComments')">Show {{ $comment->comments->count() }} comments</x-text-button>
                </div>
            @else
                <div class="space-y-6">      
                @foreach($comment->comments as $subComment)
                    <livewire:components.comment.card 
                        :comment="$subComment"
                        :conversation="$conversation"
                        :root="$subComment"
                        key="{{'comment-card-'.$subComment->id}}" />
                @endforeach
                </div>
                <div>
                    <x-text-button class="inline" wire:click="$toggle('hideComments')">Hide comments</x-text-button>
                </div>
            @endif
        @endif
    </div>
</x-card-border>
