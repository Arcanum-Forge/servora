<section class="bg-white">
    <div class="mx-auto max-w-7xl px-6 py-24 lg:px-8 lg:py-32">

        <div class="grid gap-12 lg:grid-cols-2 lg:gap-24">

            <div>
                <x-servora.ui.section-heading eyebrow="Get in Touch" title="We'd love to hear from you."
                    description="Questions about reservations, private dining, events, or simply want to say hello?"
                    :centered="false" />
            </div>

            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-1">

                <div class="flex gap-4">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#E8F0E5]">
                        <x-tabler-mail class="h-5 w-5 text-[#294936]" />
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#8FA58B]">
                            Email
                        </p>

                        <p class="mt-2 text-sm font-medium text-[#294936]">
                            hello@servora.test
                        </p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#E8F0E5]">
                        <x-tabler-phone class="h-5 w-5 text-[#294936]" />
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#8FA58B]">
                            Phone
                        </p>

                        <p class="mt-2 text-sm font-medium text-[#294936]">
                            +00 123 456 789
                        </p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#E8F0E5]">
                        <x-tabler-clock class="h-5 w-5 text-[#294936]" />
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#8FA58B]">
                            Hours
                        </p>

                        <p class="mt-2 text-sm font-medium text-[#294936]">
                            Daily · 11:00 — 23:00
                        </p>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>