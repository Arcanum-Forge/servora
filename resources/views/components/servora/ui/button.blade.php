@props([
    'href' => '#',
    'variant' => 'primary',
])

@php
    $classes = match ($variant) {
        'secondary' =>
            'border border-[#DCE5DC] bg-white text-[#294936] hover:bg-[#E8F0E5]',

        'ghost' =>
            'text-[#294936] hover:bg-[#E8F0E5]',

        default =>
            'bg-[#294936] text-white hover:bg-[#183524]',
    };
@endphp

<a href="{{ $href }}" {{ $attributes->merge([
    'class' => "inline-flex items-center justify-center gap-2 rounded-full px-6 py-3 text-sm font-medium transition {$classes}",
]) }}>
    {{ $slot }}
</a>