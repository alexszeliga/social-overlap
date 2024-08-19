<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Community;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

new #[Layout('layouts.app')] class extends Component {
    protected $communities;

    public function mount() {
        $query = Community::query();
        if (request()->routeIs('user.community.index')) {
            $query->whereHas('users', function($q) {
                $q->where('user_id', Auth::user()->id);
            });
        }
        $this->communities = $query->paginate(10);
    }
}; ?>

<div>
    <x-header>
        <div class="flex items-center justify-between">
            <x-h1>
                Communities
            </x-h1>
            <div class="flex flex-col space-y-1">
                <x-primary-button-link :href="route('community.create')">
                    Create a Community
                </x-primary-button-link>
            </div>
        </div>
    </x-header>
    <x-content-card>
        <div class="space-y-6">
            @foreach($this->communities as $c)
            <div>
                <a href="{{route('community.view', ['community' => $c])}}">
                    <x-h3>
                        {{ $c->name }}
                    </x-h3>
                </a>
                <x-p>
                    {{ $c->description }}
                </x-p>
            </div>
            @endforeach
        </div>
        {{ $this->communities->links() }}
    </x-content-card>
</div>
