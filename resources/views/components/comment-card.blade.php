<x-card-border>
    <div class="flex flex-col gap-3">
        <div class="flex gap-6">
            <x-h4>u:{{ $comment->user->name }}</x-h4>
            <x-h4>{{ $comment->created_at->diffForHumans() }}</x-h4>
        </div>
        <x-p>{{ $comment->body }}</x-p>
    </div>
</x-card-border>