<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
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

    public function mount(?Community $community)
    {   
        if (request()->routeIs('community.create')) {
            $this->pageTitle = "Create Community";
        } else {
            $this->pageTitle = "Edit Community";
            $this->name = $community->name;
            $this->description = $community->description;
        }
    }

};
?>

<div>
    <x-header>
        <x-h1>
            {{ __($pageTitle) }}
        </x-h1>
    </x-header>
    <x-content-card>
        <div class="space-y-6">
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
                    {{ __($pageTitle) }}
                </x-primary-button>
            </form>
        </div>
    </x-content-card>
</div>
