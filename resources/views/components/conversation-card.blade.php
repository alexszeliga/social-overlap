@props(['hideCommunity' => false, 'conversation'])

<x-card-border>
    <div class="flex gap-6 mb-1">
        @if(!$hideCommunity)
        <a href="{{route('community.view', ['community'=>$conversation->community])}}">
            <x-h4>c/{{ $conversation->community->name }}</x-h4>
        </a>
        @endif
        <x-h4>{{ $conversation->created_at->diffForHumans() }}</x-h4>
    </div>
    <a href="{{route('conversation.view', ['community' => $conversation->community,'contribution' => $conversation->contribution])}}">
        <x-h3>{{ $conversation->contribution->name }}</x-h3>
    </a>
</x-card-border>