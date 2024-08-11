<?php


use Livewire\Attributes\Url;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component {
    #[Url(as: 'community')]
    public ?string $slug;
};
?>

<div>
    <x-header>
        <x-h1>Create Contribution</x-h1>
    </x-header>
    <x-content-card>
        <form wire:submit="save" class="space-y-6">
            <div>
                <x-select-input class="block w-full">
                    @foreach(auth()->user()->communities as $community)
                    <option{{ $slug === $community->slug ? ' selected ' : ' ' }}value="{{$community->slug}}">{{$community->name}}</option>
                    @endforeach
                </x-select-input>
            </div>
        </form>
    </x-content-card>
</div>
