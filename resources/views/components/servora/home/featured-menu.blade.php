<section class="bg-[#F8FAF6]">
    <div class="mx-auto max-w-7xl px-6 py-24 lg:px-8 lg:py-32">

        <x-servora.ui.section-heading eyebrow="From Our Kitchen" title="Featured from the menu"
            description="A few of the dishes currently finding their way to our tables." />

        <div class="mt-16 grid gap-5 md:grid-cols-3">

            {{-- Menu item --}}
            <article
                class="rounded-2xl border border-[#DCE5DC] bg-white p-7 transition hover:-translate-y-1 hover:shadow-sm">

                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-[0.18em] text-[#8FA58B]">
                        Starter
                    </span>

                    <span class="text-sm font-semibold text-[#294936]">
                        7 silver
                    </span>
                </div>

                <h3 class="mt-8 text-xl font-semibold text-[#183524]">
                    Moonroot Salad
                </h3>

                <p class="mt-3 text-sm leading-6 text-[#718076]">
                    Young greens, moonroot, toasted seeds,
                    and our house herb dressing.
                </p>

                <div class="mt-8">
                    <x-tabler-leaf class="h-5 w-5 text-[#8FA58B]" stroke-width="1.4" />
                </div>

            </article>

            {{-- Menu item --}}
            <article
                class="rounded-2xl border border-[#DCE5DC] bg-white p-7 transition hover:-translate-y-1 hover:shadow-sm">

                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-[0.18em] text-[#8FA58B]">
                        Main
                    </span>

                    <span class="text-sm font-semibold text-[#294936]">
                        18 silver
                    </span>
                </div>

                <h3 class="mt-8 text-xl font-semibold text-[#183524]">
                    Emberroot Venison
                </h3>

                <p class="mt-3 text-sm leading-6 text-[#718076]">
                    Slow-roasted venison, emberroot,
                    wild herbs, and seasonal vegetables.
                </p>

                <div class="mt-8">
                    <x-tabler-flame class="h-5 w-5 text-[#8FA58B]" stroke-width="1.4" />
                </div>

            </article>

            {{-- Menu item --}}
            <article
                class="rounded-2xl border border-[#DCE5DC] bg-white p-7 transition hover:-translate-y-1 hover:shadow-sm">

                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-[0.18em] text-[#8FA58B]">
                        Dessert
                    </span>

                    <span class="text-sm font-semibold text-[#294936]">
                        6 silver
                    </span>
                </div>

                <h3 class="mt-8 text-xl font-semibold text-[#183524]">
                    Mooncream Tart
                </h3>

                <p class="mt-3 text-sm leading-6 text-[#718076]">
                    Delicate cream, wild berries,
                    honey pastry, and candied herbs.
                </p>

                <div class="mt-8">
                    <x-tabler-star class="h-5 w-5 text-[#8FA58B]" stroke-width="1.4" />
                </div>

            </article>

        </div>

        <div class="mt-12 text-center">
            <x-servora.ui.button href="#" variant="secondary">
                View Full Menu

                <x-tabler-arrow-up-right class="h-4 w-4" />
            </x-servora.ui.button>
        </div>

    </div>
</section>