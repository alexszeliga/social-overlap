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

    public function submit() 
    {
        $this->validate();
        InsertComment::dispatch(
            $this->conversation,
            Auth::user(),
            $this->root,
            $this->body,
        );
    }
}; ?>

<form wire:submit="submit" class="space-y-6">
    <div>
        <x-input-label>Add Comment</x-input-label>
        <x-text-input class="block w-full" wire:model="body" />
        <x-input-error :messages="$errors->get('body')"/>
    </div>
    <x-primary-button>Submit</x-primary-button>
</form>
