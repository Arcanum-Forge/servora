<section class="bg-[#EEF4EB]">
    <div class="mx-auto max-w-7xl px-6 py-20 lg:px-8 lg:py-28">

        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-24">

            {{-- Label --}}
            <div>
                <div class="mb-6 flex items-center gap-3">
                    <x-tabler-sparkles class="h-5 w-5 text-[#5E8067]" stroke-width="1.5" />

                    <span class="text-xs font-semibold uppercase tracking-[0.22em] text-[#5E8067]">
                        Today's Special
                    </span>
                </div>

                <h2 class="max-w-xl text-4xl font-semibold tracking-tight text-[#183524] sm:text-5xl">
                    Emberroot
                    <span class="text-[#5E8067]">Braised Venison</span>
                </h2>

                <p class="mt-6 max-w-lg text-base leading-7 text-[#718076]">
                    Slow-roasted venison served with emberroot,
                    wild herbs, and seasonal vegetables from our
                    local growers.
                </p>

                <div class="mt-8 flex items-center gap-5">
                    <span class="text-xl font-semibold text-[#294936]">
                        18 silver
                    </span>

                    <span class="h-5 w-px bg-[#B9C9B7]"></span>

                    <span class="text-sm text-[#718076]">
                        Available today
                    </span>
                </div>

                <div class="mt-8">
                    <x-servora.ui.button href="#" variant="ghost" class="px-0">
                        View today's dish

                        <x-tabler-arrow-right class="h-4 w-4" />
                    </x-servora.ui.button>
                </div>
            </div>

            {{-- Visual typography block instead of image --}}
            <div class="flex justify-center lg:justify-end">
                <div
                    class="flex aspect-square w-full max-w-md items-center justify-center rounded-[2rem] border border-[#DCE5DC] bg-white p-8">
                    <div
                        class="flex aspect-square w-full items-center justify-center rounded-full border border-[#DCE5DC]">
                        <div class="text-center">
                            <x-tabler-leaf class="mx-auto h-10 w-10 text-[#8FA58B]" stroke-width="1.2" />

                            <p class="mt-5 text-xs uppercase tracking-[0.3em] text-[#8FA58B]">
                                Today's
                            </p>

                            <p class="mt-2 text-2xl font-semibold text-[#294936]">
                                Special
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>