<?php

use Livewire\Volt\Component;

new class extends Component {
    public $root;
}; ?>

<div class="flex">
    <button class="border rounded-l-md p-1 border-gray-300 dark:border-gray-500">support</button>
    <div class="border p-1 border-gray-300 dark:border-gray-500">
        <x-p>{{ $root->getScore() }}</x-p>
    </div>
    <button class="border rounded-r-md p-1 border-gray-300 dark:border-gray-500">dissent</button>
</div>
