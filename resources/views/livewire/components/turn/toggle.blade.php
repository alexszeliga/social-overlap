<?php

use Livewire\Volt\Component;
use App\Models\TurnType;
use App\Jobs\ProcessTurn;
use Illuminate\Support\Facades\Auth;


new class extends Component {
    public $root;
    public string $userVote = "";
    public function toggleTurn(TurnType $type) {
        if ($this->userVote === $type->name) {
            $this->userVote = "";
        } 
        else {
            $this->userVote = $type->name;
        }
        ProcessTurn::dispatch($type, Auth()->user(), $this->root);
    }
}; ?>

<div class="flex">
    <button class="border rounded-l-md p-1 border-gray-300 dark:border-gray-500" wire:click="toggleTurn({{TurnType::SUPPORT}})">
        <x-on-bg>
            @if($userVote == "Support")
                @svg('heroicon-o-chevron-double-up', 'h-6 w-6')
            @else
                @svg('heroicon-o-chevron-up', 'h-6 w-6')
            @endif
        </x-on-bg>
    </button>
    <div class="border p-1 border-gray-300 dark:border-gray-500">
        <x-p>{{ $root->getScore() }}</x-p>
    </div>
    <button class="border rounded-r-md p-1 border-gray-300 dark:border-gray-500" wire:click="toggleTurn({{TurnType::DISSENT}})">
        <x-on-bg>
            @if($userVote == "Dissent")
                @svg('heroicon-o-chevron-double-down', 'h-6 w-6')
            @else
                @svg('heroicon-o-chevron-down', 'h-6 w-6')
            @endif
        </x-on-bg>
    </button>
</div>
