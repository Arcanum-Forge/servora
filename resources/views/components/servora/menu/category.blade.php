@props([
    'title',
    'icon' => 'leaf',
    'description' => null,
])

<section class="bg-[#F8FAF6] border-t border-[#DCE5DC]">

    <div class="mx-auto max-w-5xl px-6 py-20 lg:px-8 lg:py-24">

        <div class="mb-12">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#E8F0E5]">
                    @if ($icon === 'flame')
                        <x-tabler-flame class="h-5 w-5 text-[#5E8067]" />
                    @elseif ($icon === 'soup')
                        <x-tabler-soup class="h-5 w-5 text-[#5E8067]" />
                    @elseif ($icon === 'beer')
                        <x-tabler-beer class="h-5 w-5 text-[#5E8067]" />
                    @else
                        <x-tabler-leaf class="h-5 w-5 text-[#5E8067]" />
                    @endif
                </div>

                <div>
                    <h2 class="text-2xl font-semibold text-[#183524] sm:text-3xl">
                        {{ $title }}
                    </h2>
                </div>

            </div>

            @if ($description)
                <p class="mt-4 max-w-2xl text-sm leading-6 text-[#718076]">
                    {{ $description }}
                </p>
            @endif

        </div>

        <div class="divide-y divide-[#DCE5DC]">
            {{ $slot }}
        </div>

    </div>

</section>