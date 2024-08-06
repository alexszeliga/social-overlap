<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Community;
use Livewire\WithPagination;


new #[Layout('layouts.app')] class extends Component {
    protected $communities;

    public function mount() {
        $this->communities = Community::paginate(10);
    }
}; ?>

<div>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mr-5">
                {{ __('Communities') }}
            </h2>
            <x-primary-button-link :href="route('community.create')" class="ml-4">
                Create a Community
            </x-primary-button-link>
        </div>
    </x-slot>
    <x-content-card>
        <div class="space-y-6">
            @foreach($this->communities as $c)
            <div>
                <a href="{{route('community.edit', ['community' => $c])}}">
                    <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">
                        {{ $c->name }}
                    </h3>
                </a>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ $c->description }}
                </p>
            </div>
            @endforeach
        </div>
        {{ $this->communities->links() }}
    </x-content-card>
</div>
