@props([
    'name',
    'description',
    'price',
    'icon' => 'leaf',
    'badge' => null,
])

<article class="group py-8 first:pt-0 last:pb-0">

    <div class="flex gap-5">

        {{-- Icon --}}
        <div class="hidden shrink-0 sm:flex">
            <div
                class="flex h-12 w-12 items-center justify-center rounded-xl bg-white text-[#5E8067] ring-1 ring-[#DCE5DC]">
                @if ($icon === 'flame')
                    <x-tabler-flame class="h-5 w-5" />
                @elseif ($icon === 'soup')
                    <x-tabler-soup class="h-5 w-5" />
                @elseif ($icon === 'beer')
                    <x-tabler-beer class="h-5 w-5" />
                @elseif ($icon === 'wine')
                    <x-tabler-glass-full class="h-5 w-5" />
                @else
                    <x-tabler-leaf class="h-5 w-5" />
                @endif
            </div>
        </div>

        {{-- Content --}}
        <div class="min-w-0 flex-1">

            <div class="flex flex-col gap-2 sm:flex-row sm:items-baseline sm:justify-between">

                <div class="flex flex-wrap items-center gap-3">

                    <a href="#" class="text-xl font-semibold text-[#183524] transition group-hover:text-[#5E8067]">
                        {{ $name }}
                    </a>

                    @if ($badge)
                        <span
                            class="rounded-full bg-[#E8F0E5] px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.12em] text-[#5E8067]">
                            {{ $badge }}
                        </span>
                    @endif

                </div>

                <span class="shrink-0 text-sm font-semibold text-[#294936]">
                    {{ $price }}
                </span>

            </div>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-[#718076]">
                {{ $description }}
            </p>

            <a href="#"
                class="mt-4 inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-[0.15em] text-[#5E8067] opacity-0 transition group-hover:opacity-100">
                View dish

                <x-tabler-arrow-up-right class="h-3.5 w-3.5" />
            </a>

        </div>

    </div>

</article>