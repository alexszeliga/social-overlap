<?php

use App\Models\Community;
use App\Models\Contribution;
use App\Models\Conversation;
use App\Models\Turn;
use App\Models\TurnType;

use Illuminate\Support\Facades\Auth;

use Livewire\Attributes\Url;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component {
    #[Url(as: 'community'), Validate('exists:communities,slug')]
    public string $slug;

    #[Validate('required|url')]
    public string $url;

    #[Validate('required|min:5|max:512')]
    public string $name;

    public function save() {
        $this->validate();
        $community = Community::where('slug', '=', $this->slug)->sole();
        $contribution = Contribution::create([
                'user_id' => Auth::user()->id,
                'url' => $this->url,
                'name' => $this->name,
        ]);
        $contribution->addCommunity($community);
        return redirect()->to(route('conversation.view', ['community' => $community,'contribution' => $contribution]));
    }
};
?>

<div>
    <x-header>
        <x-h1>Create Contribution</x-h1>
    </x-header>
    <x-content-card>
        <form wire:submit="save" class="space-y-6">
            <div>
                <x-input-label>Select Community</x-input-label>
                <x-select-input wire:model="slug" class="block w-full">
                    @foreach(auth()->user()->communities as $community)
                    <option value="{{$community->slug}}">{{$community->name}}</option>
                    @endforeach
                </x-select-input>
                <x-input-error :messages="$errors->get('slug')" class="mt-2"/>

            </div>
            <div>
                <x-input-label>Url</x-input-label>
                <x-text-input wire:model="url" class="block w-full"/>
                <x-input-error :messages="$errors->get('url')" class="mt-2"/>
            </div>
            <div>
                <x-input-label>Name</x-input-label>
                <x-text-input wire:model="name" class="block w-full"/>
                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
            </div>
            <div>
                <x-primary-button>Contribute</x-primary-button>
            </div>
        </form>
    </x-content-card>
</div>
