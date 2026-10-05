@props([
    'name',
    'category',
    'price',
    'description',
    'badge' => null,
    'icon' => 'leaf',
    'ingredients' => [
        'Ember-drake',
        'Fireberry',
        'Honey',
        'Pepperroot',
    ],
])

<section class="bg-[#F8FAF6]">

    {{-- Back navigation --}}
    <div class="mx-auto max-w-7xl px-6 pt-8 lg:px-8 lg:pt-10">

        <a href="#"
            class="inline-flex items-center gap-2 text-sm font-medium text-[#718076] transition hover:text-[#294936]">
            <x-tabler-arrow-left class="h-4 w-4" />

            Back to menu
        </a>

    </div>


    {{-- Dish --}}
    <div class="mx-auto max-w-5xl px-6 py-16 lg:px-8 lg:py-24">

        <div class="grid overflow-hidden rounded-3xl border border-[#DCE5DC] bg-white lg:grid-cols-2">

            {{-- Visual --}}
            <div
                class="relative flex min-h-[420px] items-center justify-center overflow-hidden bg-[#EEF4EB] p-10 lg:min-h-[620px]">

                {{-- Decorative circles --}}
                <div class="absolute -right-24 -top-24 h-72 w-72 rounded-full border border-[#DCE5DC]"></div>

                <div class="absolute -bottom-32 -left-24 h-80 w-80 rounded-full border border-[#DCE5DC]"></div>

                <div
                    class="relative flex aspect-square w-full max-w-sm items-center justify-center rounded-full border border-[#C8D8C9]">

                    <div
                        class="flex aspect-[0.82] w-[78%] items-center justify-center rounded-[2rem] border border-[#C8D8C9] bg-white">

                        <div class="text-center">

                            @if ($icon === 'flame')
                                <x-tabler-flame class="mx-auto h-16 w-16 text-[#5E8067]" stroke-width="1.2" />
                            @elseif ($icon === 'soup')
                                <x-tabler-soup class="mx-auto h-16 w-16 text-[#5E8067]" stroke-width="1.2" />
                            @elseif ($icon === 'beer')
                                <x-tabler-beer class="mx-auto h-16 w-16 text-[#5E8067]" stroke-width="1.2" />
                            @elseif ($icon === 'wine')
                                <x-tabler-glass-full class="mx-auto h-16 w-16 text-[#5E8067]" stroke-width="1.2" />
                            @else
                                <x-tabler-leaf class="mx-auto h-16 w-16 text-[#5E8067]" stroke-width="1.2" />
                            @endif

                            <p class="mt-6 text-[10px] font-semibold uppercase tracking-[0.3em] text-[#8FA58B]">
                                Servora
                            </p>

                            <p class="mt-2 text-sm font-medium text-[#294936]">
                                From the Hearth
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Information --}}
            <div class="flex flex-col justify-center p-8 sm:p-12 lg:p-14">

                {{-- Category --}}
                <div class="flex items-center gap-3">

                    <span class="h-px w-8 bg-[#8FA58B]"></span>

                    <span class="text-xs font-semibold uppercase tracking-[0.22em] text-[#5E8067]">
                        {{ $category }}
                    </span>

                </div>


                {{-- Name --}}
                <h1 class="mt-6 text-4xl font-semibold tracking-[-0.03em] text-[#183524] sm:text-5xl">
                    {{ $name }}
                </h1>


                {{-- Price --}}
                <p class="mt-5 text-xl font-semibold text-[#294936]">
                    {{ $price }}
                </p>


                {{-- Description --}}
                <p class="mt-8 text-base leading-7 text-[#718076]">
                    {{ $description }}
                </p>


                {{-- Divider --}}
                <div class="my-8 h-px bg-[#DCE5DC]"></div>


                {{-- Ingredients --}}
                <div>

                    <h2 class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8FA58B]">
                        Ingredients
                    </h2>

                    <ul class="mt-5 space-y-3">

                        @foreach ($ingredients as $ingredient)

                            <li class="flex items-center gap-3 text-sm text-[#26342A]">

                                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-[#E8F0E5]">
                                    <x-tabler-check class="h-3.5 w-3.5 text-[#5E8067]" stroke-width="2" />
                                </span>

                                {{ $ingredient }}

                            </li>

                        @endforeach

                    </ul>

                </div>


                {{-- Badge --}}
                @if ($badge)

                    <div class="mt-8">

                        <span
                            class="inline-flex items-center gap-2 rounded-full bg-[#E8F0E5] px-4 py-2 text-xs font-semibold uppercase tracking-[0.12em] text-[#5E8067]">

                            <x-tabler-star class="h-4 w-4" stroke-width="1.5" />

                            {{ $badge }}

                        </span>

                    </div>

                @endif


                {{-- Actions --}}
                <div class="mt-10 flex flex-col gap-3 sm:flex-row">

                    <a href="#"
                        class="inline-flex items-center justify-center gap-2 rounded-full bg-[#294936] px-6 py-3 text-sm font-medium text-white transition hover:bg-[#183524]">
                        Reserve a Table

                        <x-tabler-calendar-heart class="h-4 w-4" />
                    </a>

                    <a href="#"
                        class="inline-flex items-center justify-center gap-2 rounded-full border border-[#DCE5DC] bg-white px-6 py-3 text-sm font-medium text-[#294936] transition hover:bg-[#E8F0E5]">
                        View Menu

                        <x-tabler-arrow-left class="h-4 w-4" />
                    </a>

                </div>

            </div>

        </div>

    </div>


    {{-- Bottom note --}}
    <div class="border-t border-[#DCE5DC] bg-white">

        <div class="mx-auto max-w-5xl px-6 py-12 text-center lg:px-8">

            <x-tabler-leaf class="mx-auto h-5 w-5 text-[#8FA58B]" stroke-width="1.4" />

            <p class="mx-auto mt-4 max-w-xl text-sm leading-6 text-[#718076]">
                Our menu changes with the seasons and the provisions
                available from the lands around us.
            </p>

        </div>

    </div>

</section>