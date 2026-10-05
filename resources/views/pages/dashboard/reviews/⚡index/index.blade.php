<div class="min-h-screen bg-[#F8FAF6] text-[#26342A]">

    <div class="mx-auto max-w-[1600px] px-5 py-8 sm:px-8 lg:px-10">

        {{-- =========================================================
        HEADER
        ========================================================== --}}
        <div class="mb-8 flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

            <div>
                <div class="mb-3 flex items-center gap-2 text-sm font-medium text-[#718076]">
                    <a href="{{ route('dashboard') }}" class="transition hover:text-[#294936]">
                        Dashboard
                    </a>

                    <x-tabler-chevron-right class="h-4 w-4" />

                    <span class="text-[#294936]">Reviews</span>
                </div>

                <div class="flex items-center gap-4">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-2xl border border-[#DCE5DC] bg-white text-[#294936] shadow-sm">
                        <x-tabler-message-star class="h-6 w-6" />
                    </div>

                    <div>
                        <h1 class="text-2xl font-semibold tracking-tight text-[#26342A] sm:text-3xl">
                            Reviews
                        </h1>

                        <p class="mt-1 text-sm text-[#718076]">
                            Monitor guest feedback, respond to reviews, and understand your tavern's reputation.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">

                <button type="button"
                    class="inline-flex h-10 items-center gap-2 rounded-xl border border-[#DCE5DC] bg-white px-4 text-sm font-semibold text-[#294936] shadow-sm transition hover:border-[#BFCFC2] hover:bg-[#F4F8F2]">
                    <x-tabler-chart-bar class="h-4 w-4" />
                    Review Insights
                </button>

                <button type="button"
                    class="inline-flex h-10 items-center gap-2 rounded-xl bg-[#294936] px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-[#183524]">
                    <x-tabler-message-plus class="h-4 w-4" />
                    Request Review
                </button>

            </div>
        </div>


        {{-- =========================================================
        STATS
        ========================================================== --}}
        <div class="mb-8 grid grid-cols-2 gap-4 xl:grid-cols-4">

            {{-- Average --}}
            <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[#718076]">
                            Average Rating
                        </p>

                        <div class="mt-3 flex items-center gap-2">
                            <p class="text-3xl font-semibold tracking-tight text-[#26342A]">
                                4.7
                            </p>

                            <div class="flex items-center gap-0.5 text-[#C68A32]">
                                <x-tabler-star-filled class="h-4 w-4" />
                                <x-tabler-star-filled class="h-4 w-4" />
                                <x-tabler-star-filled class="h-4 w-4" />
                                <x-tabler-star-filled class="h-4 w-4" />
                                <x-tabler-star-filled class="h-4 w-4" />
                            </div>
                        </div>

                        <p class="mt-1 text-xs text-[#718076]">
                            From 286 reviews
                        </p>
                    </div>

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#FFF4DD] text-[#9A6D36]">
                        <x-tabler-star-filled class="h-5 w-5" />
                    </div>

                </div>
            </div>


            {{-- New reviews --}}
            <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[#718076]">
                            New Reviews
                        </p>

                        <p class="mt-3 text-3xl font-semibold tracking-tight text-[#26342A]">
                            24
                        </p>

                        <p class="mt-1 text-xs text-[#718076]">
                            This month
                        </p>
                    </div>

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                        <x-tabler-message-circle class="h-5 w-5" />
                    </div>

                </div>
            </div>


            {{-- Response rate --}}
            <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[#718076]">
                            Response Rate
                        </p>

                        <p class="mt-3 text-3xl font-semibold tracking-tight text-[#26342A]">
                            92%
                        </p>

                        <p class="mt-1 text-xs text-[#718076]">
                            Reviews answered
                        </p>
                    </div>

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                        <x-tabler-message-check class="h-5 w-5" />
                    </div>

                </div>
            </div>


            {{-- Needs attention --}}
            <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[#718076]">
                            Needs Attention
                        </p>

                        <p class="mt-3 text-3xl font-semibold tracking-tight text-[#26342A]">
                            6
                        </p>

                        <p class="mt-1 text-xs text-[#718076]">
                            Unanswered reviews
                        </p>
                    </div>

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#F1E9DF] text-[#80664D]">
                        <x-tabler-message-exclamation class="h-5 w-5" />
                    </div>

                </div>
            </div>

        </div>


        {{-- =========================================================
        MAIN CONTENT
        ========================================================== --}}
        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_340px]">


            {{-- =====================================================
            REVIEWS
            ====================================================== --}}
            <section class="min-w-0 rounded-2xl border border-[#DCE5DC] bg-white shadow-sm">

                {{-- Toolbar --}}
                <div class="border-b border-[#E7ECE7] px-5 py-4 sm:px-6">

                    <div class="flex flex-col gap-4">

                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                            {{-- Tabs --}}
                            <div class="flex items-center gap-1 rounded-xl bg-[#F4F7F3] p-1">

                                <button type="button"
                                    class="rounded-lg bg-white px-4 py-2 text-sm font-semibold text-[#294936] shadow-sm">
                                    All Reviews
                                </button>

                                <button type="button"
                                    class="rounded-lg px-4 py-2 text-sm font-medium text-[#718076] transition hover:text-[#294936]">
                                    Unanswered
                                </button>

                                <button type="button"
                                    class="rounded-lg px-4 py-2 text-sm font-medium text-[#718076] transition hover:text-[#294936]">
                                    5 Star
                                </button>

                                <button type="button"
                                    class="rounded-lg px-4 py-2 text-sm font-medium text-[#718076] transition hover:text-[#294936]">
                                    Critical
                                </button>

                            </div>

                            {{-- Search / Filter --}}
                            <div class="flex flex-col gap-2 sm:flex-row">

                                <div class="relative">
                                    <x-tabler-search
                                        class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8B978E]" />

                                    <input type="search" placeholder="Search reviews..."
                                        class="h-10 w-full rounded-xl border border-[#DCE5DC] bg-white pl-9 pr-3 text-sm text-[#26342A] outline-none placeholder:text-[#9AA49D] focus:border-[#8FA596] focus:ring-2 focus:ring-[#E8F0E5] sm:w-56" />
                                </div>

                                <button type="button"
                                    class="inline-flex h-10 items-center justify-center gap-2 rounded-xl border border-[#DCE5DC] px-3 text-sm font-medium text-[#526057] transition hover:bg-[#F7F9F6]">
                                    <x-tabler-adjustments-horizontal class="h-4 w-4" />
                                    Filter
                                </button>

                            </div>

                        </div>

                        {{-- Filter chips --}}
                        <div class="flex flex-wrap items-center gap-2">

                            <span class="text-xs font-medium text-[#8B978E]">
                                Filter by:
                            </span>

                            <button
                                class="rounded-full border border-[#DCE5DC] bg-white px-3 py-1.5 text-xs font-medium text-[#526057] transition hover:border-[#BFCFC2] hover:text-[#294936]">
                                All time
                                <x-tabler-chevron-down class="ml-1 inline h-3 w-3" />
                            </button>

                            <button
                                class="rounded-full border border-[#DCE5DC] bg-white px-3 py-1.5 text-xs font-medium text-[#526057] transition hover:border-[#BFCFC2] hover:text-[#294936]">
                                All locations
                                <x-tabler-chevron-down class="ml-1 inline h-3 w-3" />
                            </button>

                            <button
                                class="rounded-full border border-[#DCE5DC] bg-white px-3 py-1.5 text-xs font-medium text-[#526057] transition hover:border-[#BFCFC2] hover:text-[#294936]">
                                All ratings
                                <x-tabler-chevron-down class="ml-1 inline h-3 w-3" />
                            </button>

                        </div>

                    </div>
                </div>


                {{-- =================================================
                REVIEW 1
                ================================================== --}}
                <article class="border-b border-[#E7ECE7] px-5 py-6 sm:px-6">

                    <div class="flex gap-4">

                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#E8F0E5] text-sm font-semibold text-[#294936]">
                            AE
                        </div>

                        <div class="min-w-0 flex-1">

                            <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                                <div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h3 class="text-sm font-semibold text-[#26342A]">
                                            Arin Evervale
                                        </h3>

                                        <span class="text-xs text-[#9AA49D]">
                                            ·
                                        </span>

                                        <span class="text-xs text-[#718076]">
                                            2 days ago
                                        </span>
                                    </div>

                                    <div class="mt-1 flex items-center gap-1">
                                        <div class="flex gap-0.5 text-[#C68A32]">
                                            <x-tabler-star-filled class="h-3.5 w-3.5" />
                                            <x-tabler-star-filled class="h-3.5 w-3.5" />
                                            <x-tabler-star-filled class="h-3.5 w-3.5" />
                                            <x-tabler-star-filled class="h-3.5 w-3.5" />
                                            <x-tabler-star-filled class="h-3.5 w-3.5" />
                                        </div>

                                        <span class="ml-2 text-xs font-medium text-[#526057]">
                                            Moonlit Harvest Feast
                                        </span>
                                    </div>
                                </div>

                                <button
                                    class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#718076] transition hover:text-[#294936]">
                                    <x-tabler-dots class="h-4 w-4" />
                                </button>

                            </div>

                            <p class="mt-4 text-sm leading-6 text-[#526057]">
                                Absolutely wonderful evening. The roast was perfectly prepared and the atmosphere
                                during the harvest feast was beautiful. Our whole party had an excellent time.
                            </p>

                            <div class="mt-4 flex flex-wrap items-center gap-2">
                                <span
                                    class="rounded-full bg-[#F4F7F3] px-2.5 py-1 text-[11px] font-medium text-[#66736A]">
                                    Food
                                </span>

                                <span
                                    class="rounded-full bg-[#F4F7F3] px-2.5 py-1 text-[11px] font-medium text-[#66736A]">
                                    Atmosphere
                                </span>

                                <span
                                    class="rounded-full bg-[#F4F7F3] px-2.5 py-1 text-[11px] font-medium text-[#66736A]">
                                    Service
                                </span>
                            </div>

                            {{-- Response --}}
                            <div class="mt-5 rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] p-4">

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#294936] text-white">
                                            <x-tabler-building-store class="h-4 w-4" />
                                        </span>

                                        <div>
                                            <p class="text-xs font-semibold text-[#294936]">
                                                Tavern response
                                            </p>

                                            <p class="text-[11px] text-[#8B978E]">
                                                Yesterday
                                            </p>
                                        </div>
                                    </div>

                                    <span class="text-[11px] font-medium text-[#6E7B72]">
                                        Responded
                                    </span>
                                </div>

                                <p class="mt-3 text-sm leading-6 text-[#526057]">
                                    Thank you, Arin. We're delighted that you enjoyed the harvest feast.
                                    We hope to welcome your party back again soon.
                                </p>

                            </div>

                        </div>
                    </div>
                </article>


                {{-- =================================================
                REVIEW 2
                ================================================== --}}
                <article class="border-b border-[#E7ECE7] px-5 py-6 sm:px-6">

                    <div class="flex gap-4">

                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#FFF4DD] text-sm font-semibold text-[#856528]">
                            TH
                        </div>

                        <div class="min-w-0 flex-1">

                            <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                                <div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h3 class="text-sm font-semibold text-[#26342A]">
                                            Torin Hearthward
                                        </h3>

                                        <span class="text-xs text-[#9AA49D]">
                                            ·
                                        </span>

                                        <span class="text-xs text-[#718076]">
                                            3 days ago
                                        </span>
                                    </div>

                                    <div class="mt-1 flex items-center gap-1">
                                        <div class="flex gap-0.5 text-[#C68A32]">
                                            <x-tabler-star-filled class="h-3.5 w-3.5" />
                                            <x-tabler-star-filled class="h-3.5 w-3.5" />
                                            <x-tabler-star-filled class="h-3.5 w-3.5" />
                                            <x-tabler-star-filled class="h-3.5 w-3.5" />
                                            <x-tabler-star class="h-3.5 w-3.5" />
                                        </div>

                                        <span class="ml-2 text-xs font-medium text-[#526057]">
                                            Tavern Visit
                                        </span>
                                    </div>
                                </div>

                                <button
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-[#FFF4DD] px-2.5 py-1.5 text-xs font-semibold text-[#856528]">
                                    Needs response
                                </button>

                            </div>

                            <p class="mt-4 text-sm leading-6 text-[#526057]">
                                The food was good and the tavern itself is lovely, but our order took quite
                                a while to arrive. We waited nearly forty minutes before everything came out.
                            </p>

                            <div class="mt-4 flex flex-wrap items-center gap-2">
                                <span
                                    class="rounded-full bg-[#F4F7F3] px-2.5 py-1 text-[11px] font-medium text-[#66736A]">
                                    Food
                                </span>

                                <span
                                    class="rounded-full bg-[#FFF4DD] px-2.5 py-1 text-[11px] font-medium text-[#856528]">
                                    Wait Time
                                </span>
                            </div>

                            <div class="mt-4">
                                <button type="button"
                                    class="inline-flex items-center gap-2 rounded-lg bg-[#294936] px-3.5 py-2 text-xs font-semibold text-white transition hover:bg-[#183524]">
                                    <x-tabler-message-plus class="h-4 w-4" />
                                    Respond
                                </button>
                            </div>

                        </div>
                    </div>
                </article>


                {{-- =================================================
                REVIEW 3
                ================================================== --}}
                <article class="border-b border-[#E7ECE7] px-5 py-6 sm:px-6">

                    <div class="flex gap-4">

                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#F1E9DF] text-sm font-semibold text-[#80664D]">
                            LM
                        </div>

                        <div class="min-w-0 flex-1">

                            <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                                <div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h3 class="text-sm font-semibold text-[#26342A]">
                                            Lyra Moonbrook
                                        </h3>

                                        <span class="text-xs text-[#9AA49D]">
                                            ·
                                        </span>

                                        <span class="text-xs text-[#718076]">
                                            5 days ago
                                        </span>
                                    </div>

                                    <div class="mt-1 flex items-center gap-1">
                                        <div class="flex gap-0.5 text-[#C68A32]">
                                            <x-tabler-star-filled class="h-3.5 w-3.5" />
                                            <x-tabler-star-filled class="h-3.5 w-3.5" />
                                            <x-tabler-star-filled class="h-3.5 w-3.5" />
                                            <x-tabler-star-filled class="h-3.5 w-3.5" />
                                            <x-tabler-star-filled class="h-3.5 w-3.5" />
                                        </div>

                                        <span class="ml-2 text-xs font-medium text-[#526057]">
                                            Private Banquet
                                        </span>
                                    </div>
                                </div>

                                <span
                                    class="rounded-full bg-[#E8F0E5] px-2.5 py-1 text-[11px] font-semibold text-[#42644C]">
                                    Responded
                                </span>

                            </div>

                            <p class="mt-4 text-sm leading-6 text-[#526057]">
                                We hosted our guild dinner here and everything was handled beautifully.
                                The staff made the evening feel special, and the private room was exactly
                                what we needed.
                            </p>

                            <div class="mt-4 flex flex-wrap items-center gap-2">
                                <span
                                    class="rounded-full bg-[#F4F7F3] px-2.5 py-1 text-[11px] font-medium text-[#66736A]">
                                    Private Events
                                </span>

                                <span
                                    class="rounded-full bg-[#F4F7F3] px-2.5 py-1 text-[11px] font-medium text-[#66736A]">
                                    Service
                                </span>

                            </div>

                        </div>
                    </div>
                </article>


                {{-- =================================================
                REVIEW 4
                ================================================== --}}
                <article class="px-5 py-6 sm:px-6">

                    <div class="flex gap-4">

                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#E8F0E5] text-sm font-semibold text-[#294936]">
                            RK
                        </div>

                        <div class="min-w-0 flex-1">

                            <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                                <div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h3 class="text-sm font-semibold text-[#26342A]">
                                            Rowan Kestrel
                                        </h3>

                                        <span class="text-xs text-[#9AA49D]">
                                            ·
                                        </span>

                                        <span class="text-xs text-[#718076]">
                                            1 week ago
                                        </span>
                                    </div>

                                    <div class="mt-1 flex items-center gap-1">
                                        <div class="flex gap-0.5 text-[#C68A32]">
                                            <x-tabler-star-filled class="h-3.5 w-3.5" />
                                            <x-tabler-star-filled class="h-3.5 w-3.5" />
                                            <x-tabler-star-filled class="h-3.5 w-3.5" />
                                            <x-tabler-star-filled class="h-3.5 w-3.5" />
                                            <x-tabler-star-filled class="h-3.5 w-3.5" />
                                        </div>

                                        <span class="ml-2 text-xs font-medium text-[#526057]">
                                            Moonroot Stew
                                        </span>
                                    </div>
                                </div>

                                <span
                                    class="rounded-full bg-[#E8F0E5] px-2.5 py-1 text-[11px] font-semibold text-[#42644C]">
                                    Responded
                                </span>

                            </div>

                            <p class="mt-4 text-sm leading-6 text-[#526057]">
                                The Moonroot Stew was incredible. Rich, hearty, and exactly what I needed
                                after a long journey. I will definitely be returning.
                            </p>

                            <div class="mt-4 flex flex-wrap items-center gap-2">
                                <span
                                    class="rounded-full bg-[#F4F7F3] px-2.5 py-1 text-[11px] font-medium text-[#66736A]">
                                    Food
                                </span>

                                <span
                                    class="rounded-full bg-[#F4F7F3] px-2.5 py-1 text-[11px] font-medium text-[#66736A]">
                                    Menu
                                </span>

                            </div>

                        </div>
                    </div>
                </article>


                {{-- Footer --}}
                <div class="flex items-center justify-between border-t border-[#E7ECE7] px-5 py-4 sm:px-6">

                    <p class="text-xs text-[#718076]">
                        Showing 4 of 286 reviews
                    </p>

                    <button type="button"
                        class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#294936] transition hover:text-[#183524]">
                        View all reviews
                        <x-tabler-arrow-right class="h-4 w-4" />
                    </button>

                </div>

            </section>


            {{-- =====================================================
            RIGHT SIDEBAR
            ====================================================== --}}
            <aside class="space-y-6">


                {{-- Rating breakdown --}}
                <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5 shadow-sm">

                    <div class="mb-5">
                        <h2 class="font-semibold text-[#26342A]">
                            Rating Breakdown
                        </h2>

                        <p class="mt-1 text-xs text-[#718076]">
                            Guest ratings across all reviews.
                        </p>
                    </div>

                    <div class="space-y-3">

                        {{-- 5 --}}
                        <div class="flex items-center gap-3">

                            <div class="flex w-8 items-center gap-1 text-xs font-semibold text-[#526057]">
                                5
                                <x-tabler-star-filled class="h-3 w-3 text-[#C68A32]" />
                            </div>

                            <div class="h-2 flex-1 overflow-hidden rounded-full bg-[#EEF2ED]">
                                <div class="h-full w-[78%] rounded-full bg-[#294936]"></div>
                            </div>

                            <span class="w-8 text-right text-xs text-[#718076]">
                                78%
                            </span>

                        </div>

                        {{-- 4 --}}
                        <div class="flex items-center gap-3">

                            <div class="flex w-8 items-center gap-1 text-xs font-semibold text-[#526057]">
                                4
                                <x-tabler-star-filled class="h-3 w-3 text-[#C68A32]" />
                            </div>

                            <div class="h-2 flex-1 overflow-hidden rounded-full bg-[#EEF2ED]">
                                <div class="h-full w-[14%] rounded-full bg-[#294936]"></div>
                            </div>

                            <span class="w-8 text-right text-xs text-[#718076]">
                                14%
                            </span>

                        </div>

                        {{-- 3 --}}
                        <div class="flex items-center gap-3">

                            <div class="flex w-8 items-center gap-1 text-xs font-semibold text-[#526057]">
                                3
                                <x-tabler-star-filled class="h-3 w-3 text-[#C68A32]" />
                            </div>

                            <div class="h-2 flex-1 overflow-hidden rounded-full bg-[#EEF2ED]">
                                <div class="h-full w-[5%] rounded-full bg-[#294936]"></div>
                            </div>

                            <span class="w-8 text-right text-xs text-[#718076]">
                                5%
                            </span>

                        </div>

                        {{-- 2 --}}
                        <div class="flex items-center gap-3">

                            <div class="flex w-8 items-center gap-1 text-xs font-semibold text-[#526057]">
                                2
                                <x-tabler-star-filled class="h-3 w-3 text-[#C68A32]" />
                            </div>

                            <div class="h-2 flex-1 overflow-hidden rounded-full bg-[#EEF2ED]">
                                <div class="h-full w-[2%] rounded-full bg-[#294936]"></div>
                            </div>

                            <span class="w-8 text-right text-xs text-[#718076]">
                                2%
                            </span>

                        </div>

                        {{-- 1 --}}
                        <div class="flex items-center gap-3">

                            <div class="flex w-8 items-center gap-1 text-xs font-semibold text-[#526057]">
                                1
                                <x-tabler-star-filled class="h-3 w-3 text-[#C68A32]" />
                            </div>

                            <div class="h-2 flex-1 overflow-hidden rounded-full bg-[#EEF2ED]">
                                <div class="h-full w-[1%] rounded-full bg-[#294936]"></div>
                            </div>

                            <span class="w-8 text-right text-xs text-[#718076]">
                                1%
                            </span>

                        </div>

                    </div>

                </div>


                {{-- Review themes --}}
                <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5 shadow-sm">

                    <div class="mb-5">
                        <h2 class="font-semibold text-[#26342A]">
                            Review Themes
                        </h2>

                        <p class="mt-1 text-xs text-[#718076]">
                            Common topics mentioned by guests.
                        </p>
                    </div>

                    <div class="space-y-4">

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <span
                                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#E8F0E5] text-[#294936]">
                                    <x-tabler-tools-kitchen-2 class="h-4 w-4" />
                                </span>

                                <span class="text-sm font-medium text-[#526057]">
                                    Food
                                </span>
                            </div>

                            <span class="text-xs font-semibold text-[#294936]">
                                92%
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <span
                                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#FFF4DD] text-[#856528]">
                                    <x-tabler-building-store class="h-4 w-4" />
                                </span>

                                <span class="text-sm font-medium text-[#526057]">
                                    Atmosphere
                                </span>
                            </div>

                            <span class="text-xs font-semibold text-[#294936]">
                                88%
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <span
                                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#F1E9DF] text-[#80664D]">
                                    <x-tabler-users class="h-4 w-4" />
                                </span>

                                <span class="text-sm font-medium text-[#526057]">
                                    Service
                                </span>
                            </div>

                            <span class="text-xs font-semibold text-[#294936]">
                                84%
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <span
                                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#F4F7F3] text-[#66736A]">
                                    <x-tabler-clock class="h-4 w-4" />
                                </span>

                                <span class="text-sm font-medium text-[#526057]">
                                    Wait Time
                                </span>
                            </div>

                            <span class="text-xs font-semibold text-[#80664D]">
                                63%
                            </span>
                        </div>

                    </div>

                </div>


                {{-- Response performance --}}
                <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5 shadow-sm">

                    <div class="flex items-start justify-between">

                        <div>
                            <h2 class="font-semibold text-[#26342A]">
                                Response Performance
                            </h2>

                            <p class="mt-1 text-xs text-[#718076]">
                                How quickly your team responds.
                            </p>
                        </div>

                        <x-tabler-message-check class="h-5 w-5 text-[#294936]" />

                    </div>

                    <div class="mt-5 grid grid-cols-2 gap-3">

                        <div class="rounded-xl bg-[#F7F9F6] p-3">
                            <p class="text-xs text-[#718076]">
                                Response rate
                            </p>

                            <p class="mt-1 text-xl font-semibold text-[#294936]">
                                92%
                            </p>
                        </div>

                        <div class="rounded-xl bg-[#F7F9F6] p-3">
                            <p class="text-xs text-[#718076]">
                                Avg. response
                            </p>

                            <p class="mt-1 text-xl font-semibold text-[#294936]">
                                4h
                            </p>
                        </div>

                    </div>

                    <div class="mt-4 rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] p-3">

                        <div class="flex items-start gap-2.5">
                            <x-tabler-bulb class="mt-0.5 h-4 w-4 shrink-0 text-[#9A6D36]" />

                            <p class="text-xs leading-5 text-[#718076]">
                                Responding to guest feedback promptly helps keep your review conversations active.
                            </p>
                        </div>

                    </div>

                </div>

            </aside>

        </div>

    </div>
</div>