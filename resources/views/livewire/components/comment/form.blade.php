<?php

use App\Jobs\InsertComment;
use App\Models\Comment;
use App\Models\Conversation;

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    #[Validate('required')]
    public string $body;

    public Conversation $conversation;
    public $root;

    public bool $loading = false;

    public function getListeners() {
        return [
            "echo:comment.{$this->conversation->id},CommentCreated" => 'commentSubmitted'
        ];
    }

    public function submit() 
    {
        $this->loading = true;
        $this->validate();
        InsertComment::dispatch(
            $this->conversation,
            Auth::user(),
            $this->root,
            $this->body,
        );
    }

    public function commentSubmitted() 
    {
        $this->loading = false;
    }
}; ?>

<form wire:submit="submit" class="space-y-6 @if($loading) opacity-25 @endif" wire:loading.attr='disabled'>
    <div>
        <x-input-label>Add Comment</x-input-label>
        <x-text-input class="block w-full" wire:model="body" wire:loading.attr='disabled'/>
        <x-input-error :messages="$errors->get('body')"/>
    </div>
<x-primary-button :disabled="$loading">Submit</x-primary-button>
</form>
