@props(['type'])

@php
    $colors = [
        'high' => 'bg-red-100 text-red-700',
        'medium' => 'bg-yellow-100 text-yellow-700',
        'low' => 'bg-green-100 text-green-700',
        'pending' => 'bg-gray-100 text-gray-700',
        'fulfilled' => 'bg-blue-100 text-blue-700',
        'cancelled' => 'bg-gray-300 text-gray-600',
    ];

    $color = $colors[$type] ?? 'bg-gray-100 text-gray-700';
@endphp

<span class="px-2 py-1 rounded text-xs font-semibold {{ $color }}">
    {{ ucfirst($type) }}
</span>
