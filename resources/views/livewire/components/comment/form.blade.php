<?php

use App\Models\Comment;
use App\Models\CommunityContribution;

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    #[Validate('required')]
    public string $body;

    public CommunityContribution $conversation;
    public $root;

    public function submit() 
    {
        $this->validate();
        Comment::create([
            'community_contribution_id' => $this->conversation->id,
            'user_id' => Auth::user()->id,
            'commentable_id' => $this->root->id,
            'commentable_type' => $this->root::class,
            'body' => $this->body,
        ]);
        $this->dispatch('comment-created', rootId: $this->root->id);
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
