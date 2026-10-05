<section class="relative overflow-hidden bg-white">

    {{-- Decorative background shapes --}}
    <div class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-[#E8F0E5]"></div>
    <div class="pointer-events-none absolute -bottom-32 -left-24 h-80 w-80 rounded-full bg-[#F1F5EF]"></div>

    <div class="relative mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8 lg:py-40">

        <div class="mx-auto max-w-4xl text-center">

            {{-- Small brand marker --}}
            <div class="mb-8 flex items-center justify-center gap-3">
                <span class="h-px w-10 bg-[#8FA58B]"></span>

                <x-tabler-leaf class="h-5 w-5 text-[#5E8067]" stroke-width="1.5" />

                <span class="h-px w-10 bg-[#8FA58B]"></span>
            </div>

            <p class="mb-5 text-xs font-semibold uppercase tracking-[0.3em] text-[#5E8067]">
                Servora Hospitality
            </p>

            <h1 class="text-5xl font-semibold tracking-[-0.04em] text-[#183524] sm:text-6xl lg:text-8xl">
                Good food,
                <span class="block text-[#5E8067]">
                    gathered well.
                </span>
            </h1>

            <p class="mx-auto mt-8 max-w-2xl text-base leading-7 text-[#718076] sm:text-lg sm:leading-8">
                Seasonal dining inspired by the lands, people, and traditions
                that surround us.
            </p>

            <div class="mt-10 flex flex-col items-center justify-center gap-3 sm:flex-row">
                <x-servora.ui.button href="#">
                    Explore Menu

                    <x-tabler-arrow-up-right class="h-4 w-4" />
                </x-servora.ui.button>

                <x-servora.ui.button href="#" variant="secondary">
                    Reserve a Table
                </x-servora.ui.button>
            </div>

        </div>

        {{-- Establishment detail --}}
        <div class="mx-auto mt-20 max-w-xl">
            <div class="flex items-center justify-center gap-5 text-xs uppercase tracking-[0.2em] text-[#8FA58B]">
                <span class="h-px flex-1 bg-[#DCE5DC]"></span>

                <span>Established 472</span>

                <span class="h-px flex-1 bg-[#DCE5DC]"></span>
            </div>
        </div>

    </div>
</section>