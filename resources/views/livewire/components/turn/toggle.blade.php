<?php

use Livewire\Volt\Component;
use App\Models\TurnType;
use App\Jobs\ProcessTurn;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On; 

new class extends Component {
    public $root;
    public $score;
    public string $userVote;
    public bool $loading = false;

    public function getListeners() {
        return [
            "echo:turn.{$this->root->id},TurnProcessed" => 'handleTurnProcessed'
        ];
    }

    public function toggleSupport() {
        $this->loading = true;
        $support = TurnType::support();
        if ($this->userVote === $support->name) {
            $this->userVote = "";
        } 
        else {
            $this->userVote = $support->name;
        }
        ProcessTurn::dispatch($support, Auth::user(), $this->root);
    }

    public function toggleDissent() {
        $this->loading = true;
        $dissent = TurnType::dissent();
        if ($this->userVote === $dissent->name) {
            $this->userVote = "";
        } else {
            $this->userVote = $dissent->name;
        }
        ProcessTurn::dispatch($dissent, Auth::user(), $this->root);
    }

    public function handleTurnProcessed($event) {
        $this->getRootScore();
        $this->loading = false;
    }

    public function mount() {
        $this->getRootScore();
    }

    private function getRootScore() {
        $this->userVote = $this->root->getUserSupportTypeName(Auth::user());
        $this->score = $this->root->getScore();
    }
}; ?>
<div>
    <div class="flex">
        <button class="border rounded-l-md p-1 border-gray-300 dark:border-gray-500" wire:click="toggleSupport">
            <x-on-bg>
                @if($userVote == "Support")
                    @svg('heroicon-o-chevron-double-up', 'h-6 w-6')
                @else
                    @svg('heroicon-o-chevron-up', 'h-6 w-6')
                @endif
            </x-on-bg>
        </button>
        <div class="border p-1 border-gray-300 dark:border-gray-500">
            <div class="@if($loading) animate-bounce @endif">
                <x-p>{{ $root->getScore() }}</x-p>
            </div>
        </div>
        <button class="border rounded-r-md p-1 border-gray-300 dark:border-gray-500" wire:click="toggleDissent">
            <x-on-bg>
                @if($userVote == "Dissent")
                    @svg('heroicon-o-chevron-double-down', 'h-6 w-6')
                @else
                    @svg('heroicon-o-chevron-down', 'h-6 w-6')
                @endif
            </x-on-bg>
        </button>
    </div>
</div>