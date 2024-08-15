<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

use App\Models\Comment;
use App\Models\Community;
use App\Models\Contribution;
use App\Models\CommunityContribution;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


new #[Layout('layouts.app')] class extends Component {
    public Community $community;
    public Contribution $contribution;
    public CommunityContribution $conversation;
    public bool $showRootComment = false;
    #[Validate('required')]
    public string $rootCommentBody;

    public function createRootComment() {
        Comment::create([
            'community_contribution_id' => $this->conversation->id,
            'user_id' => Auth::user()->id,
            'commentable_id' => $this->conversation->id,
            'commentable_type' => $this->conversation::class,
            'body' => $this->rootCommentBody,
        ]);
        $this->reset(['rootCommentBody','showRootComment']);
    }

    public function mount(Community $community, Contribution $contribution) {
        $this->community = $community;
        $this->contribution = $contribution;
        $this->conversation = CommunityContribution::where('community_id', '=', $this->community->id)
                                                   ->where('contribution_id', '=', $this->contribution->id)
                                                   ->sole();
    }
}; ?>

<div>
    <x-header>
        <div class="flex items-center justify-between">
            <x-h1>
                {{ $contribution->name }}
            </x-h1>
            <div class="flex flex-col space-y-1">
                <x-primary-button wire:click="$toggle('showRootComment')">
                    Comment
                </x-primary-button>
                <x-secondary-button-link :href="$contribution->url" target="_BLANK">
                    Visit
                </x-secondary-button-link>
            </div>
        </div>
    </x-header>
    @if($showRootComment)
    <x-content-card>
        <form wire:submit="createRootComment" class="space-y-6">
            <div>
                <x-input-label>
                    Add Comment
                </x-input-label>
                <x-text-input class="block w-full" wire:model="rootCommentBody"/>
                <x-input-error :messages="$errors->get('rootCommentBody')"/>
            </div>
            <x-primary-button>Submit</x-primary-button>
        </form>
    </x-content-card>
    @endif
    @if($conversation->comments->count() > 0)
    <x-content-card>
        <x-h2>The Conversation</x-h2>
        <ul>
            @foreach($conversation->comments as $comment)
                <li>
                    <x-p>{{$comment->body}}</x-p>
                </li>
            @endforeach
        </ul>
    </x-content-card>
    @endif
</div>
