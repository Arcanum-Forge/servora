<div class="min-h-screen bg-[#F8FAF6] text-[#26342A]">

    {{-- Page --}}
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

                    <span class="text-[#294936]">Events</span>
                </div>

                <div class="flex items-center gap-4">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-2xl border border-[#DCE5DC] bg-white text-[#294936] shadow-sm">
                        <x-tabler-calendar-event class="h-6 w-6" />
                    </div>

                    <div>
                        <h1 class="text-2xl font-semibold tracking-tight text-[#26342A] sm:text-3xl">
                            Events
                        </h1>

                        <p class="mt-1 text-sm text-[#718076]">
                            Plan, schedule, and manage your tavern's events and special occasions.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">

                <button type="button"
                    class="inline-flex h-10 items-center gap-2 rounded-xl border border-[#DCE5DC] bg-white px-4 text-sm font-semibold text-[#294936] shadow-sm transition hover:border-[#BFCFC2] hover:bg-[#F4F8F2]">
                    <x-tabler-calendar class="h-4 w-4" />
                    Calendar
                </button>

                <button type="button" wire:click="createEvent"
                    class="inline-flex h-10 items-center gap-2 rounded-xl bg-[#294936] px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-[#183524]">
                    <x-tabler-plus class="h-4 w-4" />
                    Create Event
                </button>

            </div>
        </div>


        {{-- =========================================================
        STATS
        ========================================================== --}}
        <div class="mb-8 grid grid-cols-2 gap-4 xl:grid-cols-4">

            {{-- Upcoming --}}
            <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[#718076]">
                            Upcoming Events
                        </p>

                        <p class="mt-3 text-3xl font-semibold tracking-tight text-[#26342A]">
                            8
                        </p>

                        <p class="mt-1 text-xs text-[#718076]">
                            Next 30 days
                        </p>
                    </div>

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                        <x-tabler-calendar-event class="h-5 w-5" />
                    </div>
                </div>
            </div>

            {{-- This month --}}
            <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[#718076]">
                            This Month
                        </p>

                        <p class="mt-3 text-3xl font-semibold tracking-tight text-[#26342A]">
                            14
                        </p>

                        <p class="mt-1 text-xs text-[#718076]">
                            Events scheduled
                        </p>
                    </div>

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#FFF4DD] text-[#8A6727]">
                        <x-tabler-calendar-month class="h-5 w-5" />
                    </div>
                </div>
            </div>

            {{-- Guests --}}
            <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[#718076]">
                            Guests Expected
                        </p>

                        <p class="mt-3 text-3xl font-semibold tracking-tight text-[#26342A]">
                            486
                        </p>

                        <p class="mt-1 text-xs text-[#718076]">
                            Across upcoming events
                        </p>
                    </div>

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#F1E9DF] text-[#80664D]">
                        <x-tabler-users class="h-5 w-5" />
                    </div>
                </div>
            </div>

            {{-- Revenue --}}
            <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[#718076]">
                            Estimated Revenue
                        </p>

                        <p class="mt-3 text-3xl font-semibold tracking-tight text-[#26342A]">
                            184 <span class="text-base font-medium text-[#718076]">gp</span>
                        </p>

                        <p class="mt-1 text-xs text-[#718076]">
                            From upcoming events
                        </p>
                    </div>

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                        <x-tabler-coins class="h-5 w-5" />
                    </div>
                </div>
            </div>

        </div>


        {{-- =========================================================
        MAIN WORKSPACE
        ========================================================== --}}
        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">

            {{-- =====================================================
            EVENT LIST
            ====================================================== --}}
            <section class="min-w-0 rounded-2xl border border-[#DCE5DC] bg-white shadow-sm">

                {{-- Toolbar --}}
                <div class="border-b border-[#E7ECE7] px-5 py-4 sm:px-6">

                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                        <div class="flex items-center gap-1 rounded-xl bg-[#F4F7F3] p-1">
                            <button type="button"
                                class="rounded-lg bg-white px-4 py-2 text-sm font-semibold text-[#294936] shadow-sm">
                                Upcoming
                            </button>

                            <button type="button"
                                class="rounded-lg px-4 py-2 text-sm font-medium text-[#718076] transition hover:text-[#294936]">
                                Calendar
                            </button>

                            <button type="button"
                                class="rounded-lg px-4 py-2 text-sm font-medium text-[#718076] transition hover:text-[#294936]">
                                Past
                            </button>

                            <button type="button"
                                class="rounded-lg px-4 py-2 text-sm font-medium text-[#718076] transition hover:text-[#294936]">
                                Drafts
                            </button>
                        </div>

                        <div class="flex flex-col gap-2 sm:flex-row">

                            <div class="relative">
                                <x-tabler-search
                                    class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8B978E]" />

                                <input type="search" placeholder="Search events..."
                                    class="h-10 w-full rounded-xl border border-[#DCE5DC] bg-white pl-9 pr-3 text-sm text-[#26342A] outline-none placeholder:text-[#9AA49D] focus:border-[#8FA596] focus:ring-2 focus:ring-[#E8F0E5] sm:w-56" />
                            </div>

                            <button type="button"
                                class="inline-flex h-10 items-center justify-center gap-2 rounded-xl border border-[#DCE5DC] px-3 text-sm font-medium text-[#526057] transition hover:bg-[#F7F9F6]">
                                <x-tabler-adjustments-horizontal class="h-4 w-4" />
                                Filter
                            </button>

                        </div>
                    </div>
                </div>


                {{-- Events --}}
                <div class="divide-y divide-[#E7ECE7]">

                    {{-- Event 1 --}}
                    <a href="#" class="group block px-5 py-5 transition hover:bg-[#FBFCFA] sm:px-6">

                        <div class="flex flex-col gap-5 lg:flex-row lg:items-center">

                            {{-- Date --}}
                            <div class="flex shrink-0 items-center gap-3 lg:w-24 lg:flex-col lg:gap-0 lg:text-center">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#9A6D36]">
                                        OCT
                                    </p>

                                    <p class="text-3xl font-semibold tracking-tight text-[#294936]">
                                        18
                                    </p>
                                </div>

                                <div class="h-px flex-1 bg-[#E7ECE7] lg:hidden"></div>

                                <p class="text-sm text-[#718076] lg:mt-1">
                                    Sat
                                </p>
                            </div>

                            {{-- Main --}}
                            <div class="min-w-0 flex-1">

                                <div class="flex flex-wrap items-center gap-2">
                                    <h2 class="text-base font-semibold text-[#26342A] group-hover:text-[#294936]">
                                        Moonlit Harvest Feast
                                    </h2>

                                    <span
                                        class="rounded-full bg-[#E8F0E5] px-2.5 py-1 text-[11px] font-semibold text-[#42644C]">
                                        Confirmed
                                    </span>
                                </div>

                                <p class="mt-1 text-sm text-[#718076]">
                                    Festival · Grand Hall
                                </p>

                                <div class="mt-3 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-[#718076]">
                                    <span class="inline-flex items-center gap-1.5">
                                        <x-tabler-clock class="h-4 w-4" />
                                        6:00 PM – 11:00 PM
                                    </span>

                                    <span class="inline-flex items-center gap-1.5">
                                        <x-tabler-users class="h-4 w-4" />
                                        84 / 120 guests
                                    </span>

                                    <span class="inline-flex items-center gap-1.5">
                                        <x-tabler-tools-kitchen-2 class="h-4 w-4" />
                                        Royal Banquet Menu
                                    </span>
                                </div>
                            </div>

                            {{-- Action --}}
                            <div class="flex shrink-0 items-center justify-between gap-3 lg:justify-end">

                                <div class="text-right">
                                    <p class="text-xs text-[#718076]">
                                        Expected revenue
                                    </p>

                                    <p class="mt-1 font-semibold text-[#294936]">
                                        62 gp
                                    </p>
                                </div>

                                <x-tabler-chevron-right
                                    class="h-5 w-5 text-[#A2ADA5] transition group-hover:translate-x-1 group-hover:text-[#294936]" />

                            </div>

                        </div>
                    </a>


                    {{-- Event 2 --}}
                    <a href="#" class="group block px-5 py-5 transition hover:bg-[#FBFCFA] sm:px-6">

                        <div class="flex flex-col gap-5 lg:flex-row lg:items-center">

                            <div class="flex shrink-0 items-center gap-3 lg:w-24 lg:flex-col lg:gap-0 lg:text-center">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#9A6D36]">
                                        OCT
                                    </p>

                                    <p class="text-3xl font-semibold tracking-tight text-[#294936]">
                                        22
                                    </p>
                                </div>

                                <div class="h-px flex-1 bg-[#E7ECE7] lg:hidden"></div>

                                <p class="text-sm text-[#718076] lg:mt-1">
                                    Wed
                                </p>
                            </div>

                            <div class="min-w-0 flex-1">

                                <div class="flex flex-wrap items-center gap-2">
                                    <h2 class="text-base font-semibold text-[#26342A] group-hover:text-[#294936]">
                                        Merchant's Guild Dinner
                                    </h2>

                                    <span
                                        class="rounded-full bg-[#E8F0E5] px-2.5 py-1 text-[11px] font-semibold text-[#42644C]">
                                        Confirmed
                                    </span>
                                </div>

                                <p class="mt-1 text-sm text-[#718076]">
                                    Private Banquet · Oak Chamber
                                </p>

                                <div class="mt-3 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-[#718076]">
                                    <span class="inline-flex items-center gap-1.5">
                                        <x-tabler-clock class="h-4 w-4" />
                                        7:00 PM – 10:00 PM
                                    </span>

                                    <span class="inline-flex items-center gap-1.5">
                                        <x-tabler-users class="h-4 w-4" />
                                        24 / 30 guests
                                    </span>

                                    <span class="inline-flex items-center gap-1.5">
                                        <x-tabler-tools-kitchen-2 class="h-4 w-4" />
                                        Tavern Menu
                                    </span>
                                </div>
                            </div>

                            <div class="flex shrink-0 items-center justify-between gap-3 lg:justify-end">
                                <div class="text-right">
                                    <p class="text-xs text-[#718076]">
                                        Expected revenue
                                    </p>

                                    <p class="mt-1 font-semibold text-[#294936]">
                                        28 gp
                                    </p>
                                </div>

                                <x-tabler-chevron-right
                                    class="h-5 w-5 text-[#A2ADA5] transition group-hover:translate-x-1 group-hover:text-[#294936]" />
                            </div>

                        </div>
                    </a>


                    {{-- Event 3 --}}
                    <a href="#" class="group block px-5 py-5 transition hover:bg-[#FBFCFA] sm:px-6">

                        <div class="flex flex-col gap-5 lg:flex-row lg:items-center">

                            <div class="flex shrink-0 items-center gap-3 lg:w-24 lg:flex-col lg:gap-0 lg:text-center">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#9A6D36]">
                                        OCT
                                    </p>

                                    <p class="text-3xl font-semibold tracking-tight text-[#294936]">
                                        25
                                    </p>
                                </div>

                                <div class="h-px flex-1 bg-[#E7ECE7] lg:hidden"></div>

                                <p class="text-sm text-[#718076] lg:mt-1">
                                    Sat
                                </p>
                            </div>

                            <div class="min-w-0 flex-1">

                                <div class="flex flex-wrap items-center gap-2">
                                    <h2 class="text-base font-semibold text-[#26342A] group-hover:text-[#294936]">
                                        Bards & Ballads Night
                                    </h2>

                                    <span
                                        class="rounded-full bg-[#FFF4DD] px-2.5 py-1 text-[11px] font-semibold text-[#856528]">
                                        Open
                                    </span>
                                </div>

                                <p class="mt-1 text-sm text-[#718076]">
                                    Live Entertainment · Main Tavern
                                </p>

                                <div class="mt-3 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-[#718076]">
                                    <span class="inline-flex items-center gap-1.5">
                                        <x-tabler-clock class="h-4 w-4" />
                                        8:00 PM – 12:00 AM
                                    </span>

                                    <span class="inline-flex items-center gap-1.5">
                                        <x-tabler-users class="h-4 w-4" />
                                        96 / 150 guests
                                    </span>

                                    <span class="inline-flex items-center gap-1.5">
                                        <x-tabler-ticket class="h-4 w-4" />
                                        Ticketed
                                    </span>
                                </div>
                            </div>

                            <div class="flex shrink-0 items-center justify-between gap-3 lg:justify-end">
                                <div class="text-right">
                                    <p class="text-xs text-[#718076]">
                                        Expected revenue
                                    </p>

                                    <p class="mt-1 font-semibold text-[#294936]">
                                        34 gp
                                    </p>
                                </div>

                                <x-tabler-chevron-right
                                    class="h-5 w-5 text-[#A2ADA5] transition group-hover:translate-x-1 group-hover:text-[#294936]" />
                            </div>

                        </div>
                    </a>


                    {{-- Event 4 --}}
                    <a href="#" class="group block px-5 py-5 transition hover:bg-[#FBFCFA] sm:px-6">

                        <div class="flex flex-col gap-5 lg:flex-row lg:items-center">

                            <div class="flex shrink-0 items-center gap-3 lg:w-24 lg:flex-col lg:gap-0 lg:text-center">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#9A6D36]">
                                        NOV
                                    </p>

                                    <p class="text-3xl font-semibold tracking-tight text-[#294936]">
                                        02
                                    </p>
                                </div>

                                <div class="h-px flex-1 bg-[#E7ECE7] lg:hidden"></div>

                                <p class="text-sm text-[#718076] lg:mt-1">
                                    Sun
                                </p>
                            </div>

                            <div class="min-w-0 flex-1">

                                <div class="flex flex-wrap items-center gap-2">
                                    <h2 class="text-base font-semibold text-[#26342A] group-hover:text-[#294936]">
                                        Royal Winter Banquet
                                    </h2>

                                    <span
                                        class="rounded-full bg-[#F1E9DF] px-2.5 py-1 text-[11px] font-semibold text-[#80664D]">
                                        Draft
                                    </span>
                                </div>

                                <p class="mt-1 text-sm text-[#718076]">
                                    Royal Feast · Grand Hall
                                </p>

                                <div class="mt-3 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-[#718076]">
                                    <span class="inline-flex items-center gap-1.5">
                                        <x-tabler-clock class="h-4 w-4" />
                                        5:00 PM – 11:00 PM
                                    </span>

                                    <span class="inline-flex items-center gap-1.5">
                                        <x-tabler-users class="h-4 w-4" />
                                        0 / 80 guests
                                    </span>

                                    <span class="inline-flex items-center gap-1.5">
                                        <x-tabler-tools-kitchen-2 class="h-4 w-4" />
                                        Royal Banquet Menu
                                    </span>
                                </div>
                            </div>

                            <div class="flex shrink-0 items-center justify-between gap-3 lg:justify-end">
                                <div class="text-right">
                                    <p class="text-xs text-[#718076]">
                                        Expected revenue
                                    </p>

                                    <p class="mt-1 font-semibold text-[#294936]">
                                        60 gp
                                    </p>
                                </div>

                                <x-tabler-chevron-right
                                    class="h-5 w-5 text-[#A2ADA5] transition group-hover:translate-x-1 group-hover:text-[#294936]" />
                            </div>

                        </div>
                    </a>

                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-between border-t border-[#E7ECE7] px-5 py-4 sm:px-6">
                    <p class="text-xs text-[#718076]">
                        Showing 4 of 8 upcoming events
                    </p>

                    <button type="button"
                        class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#294936] transition hover:text-[#183524]">
                        View all
                        <x-tabler-arrow-right class="h-4 w-4" />
                    </button>
                </div>

            </section>


            {{-- =====================================================
            RIGHT SIDEBAR
            ====================================================== --}}
            <aside class="space-y-6">

                {{-- Quick actions --}}
                <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5 shadow-sm">

                    <div class="mb-4">
                        <h2 class="font-semibold text-[#26342A]">
                            Event Management
                        </h2>

                        <p class="mt-1 text-xs text-[#718076]">
                            Manage your event operations.
                        </p>
                    </div>

                    <div class="space-y-2">

                        <button type="button" wire:click="createEvent"
                            class="flex w-full items-center gap-3 rounded-xl border border-[#DCE5DC] p-3 text-left transition hover:border-[#BFCFC2] hover:bg-[#F7F9F6]">

                            <span
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#E8F0E5] text-[#294936]">
                                <x-tabler-plus class="h-4 w-4" />
                            </span>

                            <span>
                                <span class="block text-sm font-semibold text-[#26342A]">
                                    Create event
                                </span>

                                <span class="block text-xs text-[#718076]">
                                    Schedule something new
                                </span>
                            </span>
                        </button>


                        <button type="button"
                            class="flex w-full items-center gap-3 rounded-xl border border-[#DCE5DC] p-3 text-left transition hover:border-[#BFCFC2] hover:bg-[#F7F9F6]">

                            <span
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#FFF4DD] text-[#856528]">
                                <x-tabler-calendar-plus class="h-4 w-4" />
                            </span>

                            <span>
                                <span class="block text-sm font-semibold text-[#26342A]">
                                    Open calendar
                                </span>

                                <span class="block text-xs text-[#718076]">
                                    View your schedule
                                </span>
                            </span>
                        </button>


                        <button type="button"
                            class="flex w-full items-center gap-3 rounded-xl border border-[#DCE5DC] p-3 text-left transition hover:border-[#BFCFC2] hover:bg-[#F7F9F6]">

                            <span
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#F1E9DF] text-[#80664D]">
                                <x-tabler-report-analytics class="h-4 w-4" />
                            </span>

                            <span>
                                <span class="block text-sm font-semibold text-[#26342A]">
                                    Event reports
                                </span>

                                <span class="block text-xs text-[#718076]">
                                    Review event performance
                                </span>
                            </span>
                        </button>

                    </div>
                </div>


                {{-- Upcoming capacity --}}
                <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5 shadow-sm">

                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="font-semibold text-[#26342A]">
                                Upcoming Capacity
                            </h2>

                            <p class="mt-1 text-xs text-[#718076]">
                                Guest occupancy
                            </p>
                        </div>

                        <x-tabler-users-group class="h-5 w-5 text-[#718076]" />
                    </div>

                    <div class="mt-5">

                        <div class="mb-2 flex items-end justify-between">
                            <span class="text-sm font-semibold text-[#294936]">
                                486 guests
                            </span>

                            <span class="text-xs text-[#718076]">
                                380 reserved
                            </span>
                        </div>

                        <div class="h-2 overflow-hidden rounded-full bg-[#E8EEE8]">
                            <div class="h-full w-[78%] rounded-full bg-[#294936]">
                            </div>
                        </div>

                        <div class="mt-2 flex justify-between text-[11px] text-[#8B978E]">
                            <span>0</span>
                            <span>620 total capacity</span>
                        </div>

                    </div>
                </div>


                {{-- Event types --}}
                <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5 shadow-sm">

                    <div class="mb-4">
                        <h2 class="font-semibold text-[#26342A]">
                            Event Types
                        </h2>

                        <p class="mt-1 text-xs text-[#718076]">
                            Upcoming events by type.
                        </p>
                    </div>

                    <div class="space-y-4">

                        <div>
                            <div class="mb-1.5 flex items-center justify-between">
                                <span class="text-sm text-[#526057]">
                                    Private Banquet
                                </span>

                                <span class="text-xs font-semibold text-[#294936]">
                                    3
                                </span>
                            </div>

                            <div class="h-1.5 rounded-full bg-[#EEF2ED]">
                                <div class="h-full w-[65%] rounded-full bg-[#294936]"></div>
                            </div>
                        </div>

                        <div>
                            <div class="mb-1.5 flex items-center justify-between">
                                <span class="text-sm text-[#526057]">
                                    Festival
                                </span>

                                <span class="text-xs font-semibold text-[#294936]">
                                    2
                                </span>
                            </div>

                            <div class="h-1.5 rounded-full bg-[#EEF2ED]">
                                <div class="h-full w-[45%] rounded-full bg-[#294936]"></div>
                            </div>
                        </div>

                        <div>
                            <div class="mb-1.5 flex items-center justify-between">
                                <span class="text-sm text-[#526057]">
                                    Entertainment
                                </span>

                                <span class="text-xs font-semibold text-[#294936]">
                                    2
                                </span>
                            </div>

                            <div class="h-1.5 rounded-full bg-[#EEF2ED]">
                                <div class="h-full w-[45%] rounded-full bg-[#294936]"></div>
                            </div>
                        </div>

                        <div>
                            <div class="mb-1.5 flex items-center justify-between">
                                <span class="text-sm text-[#526057]">
                                    Royal Feast
                                </span>

                                <span class="text-xs font-semibold text-[#294936]">
                                    1
                                </span>
                            </div>

                            <div class="h-1.5 rounded-full bg-[#EEF2ED]">
                                <div class="h-full w-[25%] rounded-full bg-[#294936]"></div>
                            </div>
                        </div>

                    </div>
                </div>

            </aside>

        </div>

    </div>
</div>