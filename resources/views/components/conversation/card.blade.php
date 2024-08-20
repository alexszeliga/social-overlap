@props(['hideCommunity' => false, 'conversation'])

<x-card-border>
    <div class="flex gap-6 mb-1">
        @if(!$hideCommunity)
        <x-community.link :community="$conversation->community"/>
        @endif
        <x-h4>{{ $conversation->created_at->diffForHumans() }}</x-h4>
    </div>
    <div class="flex gap-6">
        <livewire:components.turn.toggle :root="$conversation" />
        <a href="{{route('conversation.view', ['community' => $conversation->community,'contribution' => $conversation->contribution])}}">
            <x-h3>{{ $conversation->contribution->name }}</x-h3>
        </a>
    </div>
</x-card-border>