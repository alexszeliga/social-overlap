@props(['community'])

<a href="{{route('community.view', ['community'=>$community])}}">
    <x-h4>c/{{ $community->name }}</x-h4>
</a>