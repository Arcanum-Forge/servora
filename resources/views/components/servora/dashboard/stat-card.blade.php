@props([
    'label',
    'value',
    'change' => null,
    'icon' => 'leaf',
])

<div class="rounded-2xl border border-[#DCE5DC] bg-white p-5">

    <div class="flex items-start justify-between">

        <div>
            <p class="text-sm text-[#718076]">
                {{ $label }}
            </p>

            <p class="mt-3 text-3xl font-semibold tracking-tight text-[#183524]">
                {{ $value }}
            </p>

            @if ($change)
                <p class="mt-2 text-xs font-medium text-[#5E8067]">
                    {{ $change }}
                </p>
            @endif
        </div>

        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F0E5]">

            @if ($icon === 'calendar')
                <x-tabler-calendar-event class="h-5 w-5 text-[#5E8067]" />
            @elseif ($icon === 'users')
                <x-tabler-users class="h-5 w-5 text-[#5E8067]" />
            @elseif ($icon === 'coin')
                <x-tabler-coin class="h-5 w-5 text-[#5E8067]" />
            @elseif ($icon === 'star')
                <x-tabler-star class="h-5 w-5 text-[#5E8067]" />
            @elseif ($icon === 'shopping-bag')
                <x-tabler-shopping-bag class="h-5 w-5 text-[#5E8067]" />
            @elseif ($icon === 'table')
                <x-tabler-table class="h-5 w-5 text-[#5E8067]" />
            @else
                <x-tabler-leaf class="h-5 w-5 text-[#5E8067]" />

            @endif

        </div>

    </div>

</div>