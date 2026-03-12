@props(['color' => 'blue', 'href' => null, 'type' => 'button'])

@php
    $base = "px-4 py-2 rounded font-semibold text-white bg-$color-600 hover:bg-$color-700 transition";
@endphp

@if($href)
    <a href="{{ $href }}" class="{{ $base }}">
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" class="{{ $base }}">
        {{ $slot }}
    </button>
@endif
