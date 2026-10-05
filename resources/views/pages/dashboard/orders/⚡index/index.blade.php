<div>

    {{-- Header --}}
    <div class="mb-8">

        <div class="flex flex-col justify-between gap-5 lg:flex-row lg:items-end">

            <div>

                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8FA58B]">
                    Operations
                </p>

                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-[#183524]">
                    Orders
                </h1>

                <p class="mt-2 text-sm text-[#718076]">
                    Monitor and manage every order across Servora.
                </p>

            </div>


            <div class="flex gap-3">

                <a href="#"
                    class="inline-flex items-center gap-2 rounded-xl border border-[#DCE5DC] bg-white px-4 py-2.5 text-sm font-medium text-[#294936] transition hover:bg-[#F8FAF6]">
                    <x-tabler-refresh class="h-4 w-4" />
                    Refresh
                </a>

                <a href="#"
                    class="inline-flex items-center gap-2 rounded-xl bg-[#294936] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-[#183524]">
                    <x-tabler-plus class="h-4 w-4" />
                    New order
                </a>

            </div>

        </div>

    </div>


    {{-- Status overview --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">

        <button type="button" wire:click="$set('status', 'All Orders')"
            class="rounded-2xl border border-[#DCE5DC] bg-white p-5 text-left transition hover:border-[#B9CCBA]">

            <div class="flex items-center justify-between">

                <span class="text-sm text-[#718076]">
                    All orders
                </span>

                <x-tabler-list class="h-5 w-5 text-[#8FA58B]" />

            </div>

            <p class="mt-3 text-3xl font-semibold tracking-tight text-[#183524]">
                128
            </p>

            <p class="mt-1 text-xs text-[#8A968D]">
                Today
            </p>

        </button>


        <button type="button" wire:click="$set('status', 'New Orders')"
            class="rounded-2xl border border-[#DCE5DC] bg-white p-5 text-left transition hover:border-[#B9CCBA]">

            <div class="flex items-center justify-between">

                <span class="text-sm text-[#718076]">
                    New
                </span>

                <span class="flex h-2 w-2 rounded-full bg-[#C08A3C]"></span>

            </div>

            <p class="mt-3 text-3xl font-semibold tracking-tight text-[#183524]">
                12
            </p>

            <p class="mt-1 text-xs text-[#8A968D]">
                Need attention
            </p>

        </button>


        <button type="button" wire:click="$set('status', 'Preparing')"
            class="rounded-2xl border border-[#DCE5DC] bg-white p-5 text-left transition hover:border-[#B9CCBA]">

            <div class="flex items-center justify-between">

                <span class="text-sm text-[#718076]">
                    Preparing
                </span>

                <x-tabler-chef-hat class="h-5 w-5 text-[#8FA58B]" />

            </div>

            <p class="mt-3 text-3xl font-semibold tracking-tight text-[#183524]">
                18
            </p>

            <p class="mt-1 text-xs text-[#8A968D]">
                In kitchen
            </p>

        </button>


        <button type="button" wire:click="$set('status', 'Ready')"
            class="rounded-2xl border border-[#DCE5DC] bg-white p-5 text-left transition hover:border-[#B9CCBA]">

            <div class="flex items-center justify-between">

                <span class="text-sm text-[#718076]">
                    Ready
                </span>

                <x-tabler-bell-ringing class="h-5 w-5 text-[#5E8067]" />

            </div>

            <p class="mt-3 text-3xl font-semibold tracking-tight text-[#183524]">
                7
            </p>

            <p class="mt-1 text-xs text-[#8A968D]">
                Waiting for pickup
            </p>

        </button>


        <button type="button" wire:click="$set('status', 'Completed')"
            class="rounded-2xl border border-[#DCE5DC] bg-white p-5 text-left transition hover:border-[#B9CCBA]">

            <div class="flex items-center justify-between">

                <span class="text-sm text-[#718076]">
                    Completed
                </span>

                <x-tabler-circle-check class="h-5 w-5 text-[#5E8067]" />

            </div>

            <p class="mt-3 text-3xl font-semibold tracking-tight text-[#183524]">
                91
            </p>

            <p class="mt-1 text-xs text-[#8A968D]">
                Finished today
            </p>

        </button>

    </div>


    {{-- Orders workspace --}}
    <div class="mt-6 overflow-hidden rounded-2xl border border-[#DCE5DC] bg-white">

        {{-- Toolbar --}}
        <div class="border-b border-[#DCE5DC] p-5">

            <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">

                {{-- Status tabs --}}
                <div class="flex gap-1 overflow-x-auto">

                    @foreach ([
                            'All Orders',
                            'New Orders',
                            'Preparing',
                            'Ready',
                            'Completed',
                            'Cancelled',
                        ] as $tab)

                        <button type="button" wire:click="$set('status', '{{ $tab }}')" @class([
                            'shrink-0 rounded-lg px-3.5 py-2 text-sm font-medium transition',
                            'bg-[#294936] text-white' => $status === $tab,
                            'text-[#718076] hover:bg-[#F8FAF6] hover:text-[#294936]' => $status !== $tab,
                        ])>
                            {{ $tab }}
                        </button>

                    @endforeach

                </div>


                {{-- Search --}}
                <div class="relative w-full xl:max-w-xs">

                    <x-tabler-search
                        class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8FA58B]" />

                    <input type="search" wire:model.live="search" placeholder="Search order..."
                        class="w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] py-2.5 pl-10 pr-4 text-sm text-[#26342A] outline-none transition placeholder:text-[#A1ACA3] focus:border-[#8FA58B] focus:bg-white focus:ring-2 focus:ring-[#E8F0E5]" />

                </div>

            </div>


            {{-- Order type filters --}}
            <div class="mt-5 flex flex-wrap gap-2">

                <span class="mr-2 self-center text-xs font-medium uppercase tracking-[0.15em] text-[#A1ACA3]">
                    Order type
                </span>

                @foreach ([
                        'All' => 'All',
                        'Dine-in' => 'Dine-in',
                        'Takeaway' => 'Takeaway',
                        'Delivery' => 'Delivery',
                        'Online' => 'Online',
                    ] as $value => $label)

                    <button type="button" wire:click="$set('orderType', '{{ $value }}')" @class([
                        'inline-flex items-center gap-2 rounded-full border px-3.5 py-1.5 text-xs font-medium transition',
                        'border-[#294936] bg-[#E8F0E5] text-[#294936]' => $orderType === $value,
                        'border-[#DCE5DC] bg-white text-[#718076] hover:bg-[#F8FAF6]' => $orderType !== $value,
                    ])>

                        @if ($value === 'Dine-in')
                            <x-tabler-tools-kitchen-2 class="h-3.5 w-3.5" />
                        @elseif ($value === 'Takeaway')
                            <x-tabler-shopping-bag class="h-3.5 w-3.5" />
                        @elseif ($value === 'Delivery')
                            <x-tabler-truck class="h-3.5 w-3.5" />
                        @elseif ($value === 'Online')
                            <x-tabler-world class="h-3.5 w-3.5" />
                        @else
                            <x-tabler-layout-grid class="h-3.5 w-3.5" />
                        @endif

                        {{ $label }}

                    </button>

                @endforeach

            </div>

        </div>


        {{-- Order list --}}
        <div class="divide-y divide-[#DCE5DC]">

            {{-- Order 1048 --}}
            <article class="p-5 transition hover:bg-[#FCFDFC] lg:p-6">

                <div class="flex flex-col gap-5 xl:flex-row xl:items-center">

                    {{-- Order identity --}}
                    <div class="flex min-w-0 items-start gap-4 xl:w-[280px]">

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#E8F0E5]">
                            <x-tabler-tools-kitchen-2 class="h-5 w-5 text-[#5E8067]" />
                        </div>

                        <div class="min-w-0">

                            <div class="flex items-center gap-2">

                                <h3 class="font-semibold text-[#294936]">
                                    #1048
                                </h3>

                                <span
                                    class="rounded-full bg-[#E8F0E5] px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.1em] text-[#5E8067]">
                                    Dine-in
                                </span>

                            </div>

                            <p class="mt-1 text-sm text-[#718076]">
                                Rowan Hale · Table 08
                            </p>

                            <p class="mt-1 text-xs text-[#A1ACA3]">
                                4 guests · 11:42 AM
                            </p>

                        </div>

                    </div>


                    {{-- Items --}}
                    <div class="min-w-0 flex-1">

                        <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#A1ACA3]">
                            Items
                        </p>

                        <p class="mt-2 text-sm text-[#294936]">
                            1× Dragonfire Roast,
                            2× Moonroot Stew,
                            1× Mooncream Tart
                        </p>

                    </div>


                    {{-- Total --}}
                    <div class="xl:w-32 xl:text-right">

                        <p class="text-xs text-[#8A968D]">
                            Total
                        </p>

                        <p class="mt-1 font-semibold text-[#294936]">
                            42 silver
                        </p>

                    </div>


                    {{-- Status --}}
                    <div class="xl:w-28">

                        <span
                            class="inline-flex rounded-full bg-[#FFF4DD] px-3 py-1.5 text-xs font-medium text-[#9A762B]">
                            New
                        </span>

                    </div>


                    {{-- Action --}}
                    <div>

                        <button type="button"
                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-[#DCE5DC] text-[#718076] transition hover:bg-[#F8FAF6] hover:text-[#294936]">
                            <x-tabler-chevron-right class="h-4 w-4" />
                        </button>

                    </div>

                </div>

            </article>


            {{-- Order 1047 --}}
            <article class="p-5 transition hover:bg-[#FCFDFC] lg:p-6">

                <div class="flex flex-col gap-5 xl:flex-row xl:items-center">

                    <div class="flex min-w-0 items-start gap-4 xl:w-[280px]">

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#E8F0E5]">
                            <x-tabler-tools-kitchen-2 class="h-5 w-5 text-[#5E8067]" />
                        </div>

                        <div class="min-w-0">

                            <div class="flex items-center gap-2">

                                <h3 class="font-semibold text-[#294936]">
                                    #1047
                                </h3>

                                <span
                                    class="rounded-full bg-[#E8F0E5] px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.1em] text-[#5E8067]">
                                    Dine-in
                                </span>

                            </div>

                            <p class="mt-1 text-sm text-[#718076]">
                                Mira Solen · Table 03
                            </p>

                            <p class="mt-1 text-xs text-[#A1ACA3]">
                                2 guests · 11:28 AM
                            </p>

                        </div>

                    </div>

                    <div class="min-w-0 flex-1">

                        <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#A1ACA3]">
                            Items
                        </p>

                        <p class="mt-2 text-sm text-[#294936]">
                            1× Hunter's Feast,
                            1× Dwarven Black Ale
                        </p>

                    </div>

                    <div class="xl:w-32 xl:text-right">

                        <p class="text-xs text-[#8A968D]">
                            Total
                        </p>

                        <p class="mt-1 font-semibold text-[#294936]">
                            18 silver
                        </p>

                    </div>

                    <div class="xl:w-28">

                        <span
                            class="inline-flex rounded-full bg-[#E8F0E5] px-3 py-1.5 text-xs font-medium text-[#5E8067]">
                            Preparing
                        </span>

                    </div>

                    <div>

                        <button type="button"
                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-[#DCE5DC] text-[#718076] transition hover:bg-[#F8FAF6] hover:text-[#294936]">
                            <x-tabler-chevron-right class="h-4 w-4" />
                        </button>

                    </div>

                </div>

            </article>


            {{-- Order 1046 --}}
            <article class="p-5 transition hover:bg-[#FCFDFC] lg:p-6">

                <div class="flex flex-col gap-5 xl:flex-row xl:items-center">

                    <div class="flex min-w-0 items-start gap-4 xl:w-[280px]">

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#E8F0E5]">
                            <x-tabler-shopping-bag class="h-5 w-5 text-[#5E8067]" />
                        </div>

                        <div class="min-w-0">

                            <div class="flex items-center gap-2">

                                <h3 class="font-semibold text-[#294936]">
                                    #1046
                                </h3>

                                <span
                                    class="rounded-full bg-[#F8FAF6] px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.1em] text-[#718076]">
                                    Takeaway
                                </span>

                            </div>

                            <p class="mt-1 text-sm text-[#718076]">
                                Elira Vane
                            </p>

                            <p class="mt-1 text-xs text-[#A1ACA3]">
                                1 guest · 11:14 AM
                            </p>

                        </div>

                    </div>

                    <div class="min-w-0 flex-1">

                        <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#A1ACA3]">
                            Items
                        </p>

                        <p class="mt-2 text-sm text-[#294936]">
                            1× Dragonfire Roast,
                            1× Mooncream Tart
                        </p>

                    </div>

                    <div class="xl:w-32 xl:text-right">

                        <p class="text-xs text-[#8A968D]">
                            Total
                        </p>

                        <p class="mt-1 font-semibold text-[#294936]">
                            24 silver
                        </p>

                    </div>

                    <div class="xl:w-28">

                        <span
                            class="inline-flex rounded-full bg-[#DCEBF7] px-3 py-1.5 text-xs font-medium text-[#47708F]">
                            Ready
                        </span>

                    </div>

                    <div>

                        <button type="button"
                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-[#DCE5DC] text-[#718076] transition hover:bg-[#F8FAF6] hover:text-[#294936]">
                            <x-tabler-chevron-right class="h-4 w-4" />
                        </button>

                    </div>

                </div>

            </article>


            {{-- Order 1045 --}}
            <article class="p-5 transition hover:bg-[#FCFDFC] lg:p-6">

                <div class="flex flex-col gap-5 xl:flex-row xl:items-center">

                    <div class="flex min-w-0 items-start gap-4 xl:w-[280px]">

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#E8F0E5]">
                            <x-tabler-truck class="h-5 w-5 text-[#5E8067]" />
                        </div>

                        <div class="min-w-0">

                            <div class="flex items-center gap-2">

                                <h3 class="font-semibold text-[#294936]">
                                    #1045
                                </h3>

                                <span
                                    class="rounded-full bg-[#F8FAF6] px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.1em] text-[#718076]">
                                    Delivery
                                </span>

                            </div>

                            <p class="mt-1 text-sm text-[#718076]">
                                Captain Orin
                            </p>

                            <p class="mt-1 text-xs text-[#A1ACA3]">
                                3 guests · 10:56 AM
                            </p>

                        </div>

                    </div>

                    <div class="min-w-0 flex-1">

                        <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#A1ACA3]">
                            Items
                        </p>

                        <p class="mt-2 text-sm text-[#294936]">
                            2× Hunter's Feast,
                            2× Dwarven Black Ale
                        </p>

                    </div>

                    <div class="xl:w-32 xl:text-right">

                        <p class="text-xs text-[#8A968D]">
                            Total
                        </p>

                        <p class="mt-1 font-semibold text-[#294936]">
                            36 silver
                        </p>

                    </div>

                    <div class="xl:w-28">

                        <span
                            class="inline-flex rounded-full bg-[#E8F0E5] px-3 py-1.5 text-xs font-medium text-[#5E8067]">
                            Completed
                        </span>

                    </div>

                    <div>

                        <button type="button"
                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-[#DCE5DC] text-[#718076] transition hover:bg-[#F8FAF6] hover:text-[#294936]">
                            <x-tabler-chevron-right class="h-4 w-4" />
                        </button>

                    </div>

                </div>

            </article>


            {{-- Order 1044 --}}
            <article class="p-5 transition hover:bg-[#FCFDFC] lg:p-6">

                <div class="flex flex-col gap-5 xl:flex-row xl:items-center">

                    <div class="flex min-w-0 items-start gap-4 xl:w-[280px]">

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#E8F0E5]">
                            <x-tabler-world class="h-5 w-5 text-[#5E8067]" />
                        </div>

                        <div class="min-w-0">

                            <div class="flex items-center gap-2">

                                <h3 class="font-semibold text-[#294936]">
                                    #1044
                                </h3>

                                <span
                                    class="rounded-full bg-[#F8FAF6] px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.1em] text-[#718076]">
                                    Online
                                </span>

                            </div>

                            <p class="mt-1 text-sm text-[#718076]">
                                Sera Windmere
                            </p>

                            <p class="mt-1 text-xs text-[#A1ACA3]">
                                2 guests · 10:41 AM
                            </p>

                        </div>

                    </div>

                    <div class="min-w-0 flex-1">

                        <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#A1ACA3]">
                            Items
                        </p>

                        <p class="mt-2 text-sm text-[#294936]">
                            1× Moonroot Stew,
                            1× Mooncream Tart
                        </p>

                    </div>

                    <div class="xl:w-32 xl:text-right">

                        <p class="text-xs text-[#8A968D]">
                            Total
                        </p>

                        <p class="mt-1 font-semibold text-[#294936]">
                            15 silver
                        </p>

                    </div>

                    <div class="xl:w-28">

                        <span
                            class="inline-flex rounded-full bg-[#FDE8E7] px-3 py-1.5 text-xs font-medium text-[#B94A48]">
                            Cancelled
                        </span>

                    </div>

                    <div>

                        <button type="button"
                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-[#DCE5DC] text-[#718076] transition hover:bg-[#F8FAF6] hover:text-[#294936]">
                            <x-tabler-chevron-right class="h-4 w-4" />
                        </button>

                    </div>

                </div>

            </article>

        </div>


        {{-- Pagination --}}
        <div
            class="flex flex-col justify-between gap-4 border-t border-[#DCE5DC] px-6 py-4 sm:flex-row sm:items-center">

            <p class="text-xs text-[#8A968D]">
                Showing 5 of 128 orders
            </p>

            <div class="flex items-center gap-2">

                <button type="button"
                    class="flex h-8 w-8 items-center justify-center rounded-lg border border-[#DCE5DC] text-[#A1ACA3]"
                    disabled>
                    <x-tabler-chevron-left class="h-4 w-4" />
                </button>

                <button type="button"
                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#294936] text-xs font-medium text-white">
                    1
                </button>

                <button type="button"
                    class="flex h-8 w-8 items-center justify-center rounded-lg border border-[#DCE5DC] text-xs text-[#718076] hover:bg-[#F8FAF6]">
                    2
                </button>

                <button type="button"
                    class="flex h-8 w-8 items-center justify-center rounded-lg border border-[#DCE5DC] text-xs text-[#718076] hover:bg-[#F8FAF6]">
                    3
                </button>

                <button type="button"
                    class="flex h-8 w-8 items-center justify-center rounded-lg border border-[#DCE5DC] text-[#718076] hover:bg-[#F8FAF6]">
                    <x-tabler-chevron-right class="h-4 w-4" />
                </button>

            </div>

        </div>

    </div>

</div>