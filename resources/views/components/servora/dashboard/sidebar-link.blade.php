@props([
    'route',
    'icon',
    'badge' => null,
    'collapsed' => false,
])

@php
    $active = request()->routeIs($route);
@endphp

<a href="{{ route($route) }}" @class([
    'group relative flex items-center rounded-xl text-sm font-medium transition',
    'bg-[#E8F0E5] text-[#294936]' => $active,
    'text-[#718076] hover:bg-[#F8FAF6] hover:text-[#294936]' => !$active,
])
    :class="collapsed
        ? 'justify-center px-0 py-3'
        : 'gap-3 px-3 py-2.5'" :title="collapsed ? '{{ $slot }}' : ''">

    <x-dynamic-component :component="'tabler-' . $icon" class="h-5 w-5 shrink-0" stroke-width="1.5" />


    {{-- Label --}}
    <span x-show="!collapsed" class="min-w-0 flex-1 truncate">
        {{ $slot }}
    </span>


    @if ($badge !== null)

        {{-- Expanded badge --}}
        <span x-show="!collapsed"
            class="ml-auto shrink-0 rounded-full bg-[#FFF4DD] px-2 py-0.5 text-[10px] font-semibold text-[#9A762B]">
            {{ $badge }}
        </span>


        {{-- Collapsed notification --}}
        <span x-show="collapsed" class="absolute right-1 top-1 h-2 w-2 rounded-full bg-[#D6A94C]"></span>

    @endif

</a>