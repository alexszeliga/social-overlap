<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Log;
use App\Models\Community;
use Illuminate\Support\Str;

new #[Layout('layouts.app')] class extends Component {
    public string $pageTitle;
    public string $name;
    public string $slug;
    public string $description;

    protected function rules() : array {
        return Community::rules();
    }

    public function save()
    {
        $this->slug = Str::slug($this->name);
        $this->validate();
        Community::create([
            'name' => $this->name,
            'description' => $this->description,
            'slug' => $this->slug,
        ]);

        return redirect()->to(route('community.index'));
    }

    public function mount()
    {
        $isCreate = request()->routeIs('community.create');
        $this->pageTitle = $isCreate ? "Create Community" : "Edit Community";
    }

};
?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __($pageTitle) }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="space-y-6">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Prolly Community Name
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            A form to edit the community.
                        </p>
                    </header>
                    <form wire:submit="save" class="space-y-6">
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input wire:model="name" id="name" class="block w-full" type="text" autofocus/>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-input wire:model="description" id="description" class="block w-full" type="text"/>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        <div class="flex items-center justify-end mt-4"></div>
                        <x-primary-button>
                            {{ __('Create Community') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
