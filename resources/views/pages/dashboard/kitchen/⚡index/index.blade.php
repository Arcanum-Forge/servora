<div>

    {{-- Header --}}
    <div class="flex flex-col gap-4 border-b border-[#DCE5DC] pb-6 lg:flex-row lg:items-center lg:justify-between">

        <div>
            <div class="flex items-center gap-2 text-sm text-[#718076]">
                <span>Operations</span>
                <x-tabler-chevron-right class="h-4 w-4" />
                <span>Kitchen</span>
            </div>

            <div class="mt-2 flex items-center gap-3">
                <h1 class="text-2xl font-semibold tracking-tight text-[#183524]">
                    Kitchen Display
                </h1>

                <span
                    class="inline-flex items-center gap-2 rounded-full bg-[#E8F0E5] px-3 py-1 text-xs font-semibold text-[#5E8067]">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#5E8067]"></span>
                    Service Active
                </span>
            </div>

            <p class="mt-1 text-sm text-[#718076]">
                Main Kitchen · Lunch Service
            </p>
        </div>

        <div class="flex items-center gap-3">

            <div class="hidden text-right sm:block">
                <p class="text-xs uppercase tracking-[0.16em] text-[#8FA58B]">
                    Current time
                </p>

                <p class="mt-1 text-sm font-medium text-[#294936]">
                    12:48 PM
                </p>
            </div>

            <button type="button"
                class="inline-flex items-center gap-2 rounded-xl border border-[#DCE5DC] bg-white px-4 py-2.5 text-sm font-medium text-[#294936] transition hover:bg-[#E8F0E5]">
                <x-tabler-refresh class="h-4 w-4" />
                Refresh
            </button>

        </div>

    </div>


    {{-- Status Overview --}}
    <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-5">

        <button wire:click="setStatus('All')" class="rounded-2xl border p-4 text-left transition
                {{ $status === 'All'
    ? 'border-[#294936] bg-[#294936] text-white'
    : 'border-[#DCE5DC] bg-white hover:bg-[#F8FAF6]' }}">
            <p class="text-xs font-medium {{ $status === 'All' ? 'text-white/70' : 'text-[#718076]' }}">
                All tickets
            </p>

            <p class="mt-2 text-2xl font-semibold">
                27
            </p>
        </button>

        <button wire:click="setStatus('New')"
            class="rounded-2xl border border-[#DCE5DC] bg-white p-4 text-left transition hover:bg-[#F8FAF6]">
            <p class="text-xs text-[#718076]">
                New
            </p>

            <p class="mt-2 text-2xl font-semibold text-[#183524]">
                12
            </p>
        </button>

        <button wire:click="setStatus('Preparing')"
            class="rounded-2xl border border-[#DCE5DC] bg-white p-4 text-left transition hover:bg-[#F8FAF6]">
            <p class="text-xs text-[#718076]">
                Preparing
            </p>

            <p class="mt-2 text-2xl font-semibold text-[#183524]">
                8
            </p>
        </button>

        <button wire:click="setStatus('Ready')"
            class="rounded-2xl border border-[#DCE5DC] bg-white p-4 text-left transition hover:bg-[#F8FAF6]">
            <p class="text-xs text-[#718076]">
                Ready
            </p>

            <p class="mt-2 text-2xl font-semibold text-[#183524]">
                5
            </p>
        </button>

        <button wire:click="setStatus('Delayed')"
            class="rounded-2xl border border-[#DCE5DC] bg-white p-4 text-left transition hover:bg-[#F8FAF6]">
            <p class="text-xs text-[#718076]">
                Delayed
            </p>

            <p class="mt-2 text-2xl font-semibold text-[#B94A48]">
                2
            </p>
        </button>

    </div>


    {{-- Station Filter --}}
    <div class="mt-6 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">

        <div>
            <h2 class="text-sm font-semibold text-[#294936]">
                Preparation Queue
            </h2>

            <p class="mt-1 text-xs text-[#718076]">
                Tickets currently moving through the kitchen.
            </p>
        </div>

        <div class="flex gap-2 overflow-x-auto pb-1">

            @foreach ([
                        'All Stations',
                        'Hearth',
                        'Cauldron',
                        'Butchery',
                        'Bakery',
                        'Bar',
                    ] as $item)

                    <button wire:click="setStation('{{ $item }}')"
                        class="whitespace-nowrap rounded-full px-4 py-2 text-xs font-medium transition
                                {{ $station === $item
                ? 'bg-[#294936] text-white'
                : 'border border-[#DCE5DC] bg-white text-[#718076] hover:bg-[#E8F0E5] hover:text-[#294936]' }}">
                        {{ $item }}
                    </button>

            @endforeach

        </div>

    </div>


    {{-- Tickets --}}
    <div class="mt-5 grid gap-5 xl:grid-cols-3">

        {{-- New --}}
        <section>

            <div class="mb-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-[#9A762B]"></span>

                    <h3 class="text-sm font-semibold text-[#294936]">
                        New
                    </h3>

                    <span class="text-xs text-[#8FA58B]">
                        12
                    </span>
                </div>

                <x-tabler-clock class="h-4 w-4 text-[#8FA58B]" />
            </div>


            <div class="space-y-4">

                {{-- Ticket --}}
                <article class="rounded-2xl border border-[#DCE5DC] bg-white p-5">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm font-semibold text-[#183524]">
                                #1048
                            </p>

                            <p class="mt-1 text-xs text-[#718076]">
                                Table 08 · 4 guests
                            </p>
                        </div>

                        <span
                            class="rounded-full bg-[#FFF4DD] px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-[#9A762B]">
                            New
                        </span>

                    </div>

                    <div class="my-4 h-px bg-[#DCE5DC]"></div>

                    <div class="space-y-3">

                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <span
                                    class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#E8F0E5] text-xs font-semibold text-[#294936]">
                                    1
                                </span>

                                <div>
                                    <p class="text-sm font-medium text-[#26342A]">
                                        Dragonfire Roast
                                    </p>

                                    <p class="text-[11px] text-[#8FA58B]">
                                        Hearth
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <span
                                    class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#E8F0E5] text-xs font-semibold text-[#294936]">
                                    2
                                </span>

                                <div>
                                    <p class="text-sm font-medium text-[#26342A]">
                                        Moonroot Stew
                                    </p>

                                    <p class="text-[11px] text-[#8FA58B]">
                                        Cauldron
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <span
                                    class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#E8F0E5] text-xs font-semibold text-[#294936]">
                                    1
                                </span>

                                <div>
                                    <p class="text-sm font-medium text-[#26342A]">
                                        Mooncream Tart
                                    </p>

                                    <p class="text-[11px] text-[#8FA58B]">
                                        Bakery
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <button wire:click="startTicket(1048)"
                        class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-[#294936] px-4 py-3 text-sm font-medium text-white transition hover:bg-[#183524]">
                        <x-tabler-player-play class="h-4 w-4" />
                        Start Preparing
                    </button>

                </article>


                <article class="rounded-2xl border border-[#DCE5DC] bg-white p-5">

                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-semibold text-[#183524]">
                                #1049
                            </p>

                            <p class="mt-1 text-xs text-[#718076]">
                                Table 12 · 2 guests
                            </p>
                        </div>

                        <span
                            class="rounded-full bg-[#FFF4DD] px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-[#9A762B]">
                            New
                        </span>
                    </div>

                    <div class="my-4 h-px bg-[#DCE5DC]"></div>

                    <div class="space-y-3">

                        <div class="flex items-center gap-3">
                            <span
                                class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#E8F0E5] text-xs font-semibold text-[#294936]">
                                1
                            </span>

                            <div>
                                <p class="text-sm font-medium text-[#26342A]">
                                    Hunter's Feast
                                </p>

                                <p class="text-[11px] text-[#8FA58B]">
                                    Butchery
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <span
                                class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#E8F0E5] text-xs font-semibold text-[#294936]">
                                1
                            </span>

                            <div>
                                <p class="text-sm font-medium text-[#26342A]">
                                    Dwarven Black Ale
                                </p>

                                <p class="text-[11px] text-[#8FA58B]">
                                    Bar
                                </p>
                            </div>
                        </div>

                    </div>

                    <button wire:click="startTicket(1049)"
                        class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-[#294936] px-4 py-3 text-sm font-medium text-white transition hover:bg-[#183524]">
                        <x-tabler-player-play class="h-4 w-4" />
                        Start Preparing
                    </button>

                </article>

            </div>

        </section>


        {{-- Preparing --}}
        <section>

            <div class="mb-3 flex items-center justify-between">

                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-[#5E8067]"></span>

                    <h3 class="text-sm font-semibold text-[#294936]">
                        Preparing
                    </h3>

                    <span class="text-xs text-[#8FA58B]">
                        8
                    </span>
                </div>

                <x-tabler-tools-kitchen-2 class="h-4 w-4 text-[#8FA58B]" />

            </div>


            <div class="space-y-4">

                <article class="rounded-2xl border border-[#C8D8C9] bg-white p-5">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm font-semibold text-[#183524]">
                                #1047
                            </p>

                            <p class="mt-1 text-xs text-[#718076]">
                                Table 03 · 2 guests
                            </p>
                        </div>

                        <span
                            class="rounded-full bg-[#E8F0E5] px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-[#5E8067]">
                            14 min
                        </span>

                    </div>

                    <div class="my-4 h-px bg-[#DCE5DC]"></div>

                    <div class="space-y-3">

                        <div class="flex items-center gap-3">
                            <span
                                class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#E8F0E5] text-xs font-semibold text-[#294936]">
                                1
                            </span>

                            <div>
                                <p class="text-sm font-medium text-[#26342A]">
                                    Hunter's Feast
                                </p>

                                <p class="text-[11px] text-[#8FA58B]">
                                    Butchery
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <span
                                class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#E8F0E5] text-xs font-semibold text-[#294936]">
                                1
                            </span>

                            <div>
                                <p class="text-sm font-medium text-[#26342A]">
                                    Dwarven Black Ale
                                </p>

                                <p class="text-[11px] text-[#8FA58B]">
                                    Bar
                                </p>
                            </div>
                        </div>

                    </div>

                    <button wire:click="markReady(1047)"
                        class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-4 py-3 text-sm font-medium text-[#294936] transition hover:bg-[#E8F0E5]">
                        <x-tabler-check class="h-4 w-4" />
                        Mark Ready
                    </button>

                </article>


                <article class="rounded-2xl border border-[#DCE5DC] bg-white p-5">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm font-semibold text-[#183524]">
                                #1044
                            </p>

                            <p class="mt-1 text-xs text-[#718076]">
                                Table 05 · 3 guests
                            </p>
                        </div>

                        <span
                            class="rounded-full bg-[#FDE8E7] px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-[#B94A48]">
                            Delayed
                        </span>

                    </div>

                    <div class="my-4 h-px bg-[#DCE5DC]"></div>

                    <div class="space-y-3">

                        <div class="flex items-center gap-3">
                            <span
                                class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#E8F0E5] text-xs font-semibold text-[#294936]">
                                2
                            </span>

                            <div>
                                <p class="text-sm font-medium text-[#26342A]">
                                    Hunter's Feast
                                </p>

                                <p class="text-[11px] text-[#8FA58B]">
                                    Butchery
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <span
                                class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#E8F0E5] text-xs font-semibold text-[#294936]">
                                2
                            </span>

                            <div>
                                <p class="text-sm font-medium text-[#26342A]">
                                    Dwarven Black Ale
                                </p>

                                <p class="text-[11px] text-[#8FA58B]">
                                    Bar
                                </p>
                            </div>
                        </div>

                    </div>

                    <button
                        class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl border border-[#F1C9C7] bg-[#FFF8F7] px-4 py-3 text-sm font-medium text-[#B94A48]">
                        <x-tabler-alert-circle class="h-4 w-4" />
                        View Delay
                    </button>

                </article>

            </div>

        </section>


        {{-- Ready --}}
        <section>

            <div class="mb-3 flex items-center justify-between">

                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-[#47708F]"></span>

                    <h3 class="text-sm font-semibold text-[#294936]">
                        Ready
                    </h3>

                    <span class="text-xs text-[#8FA58B]">
                        5
                    </span>
                </div>

                <x-tabler-bell-ringing class="h-4 w-4 text-[#8FA58B]" />

            </div>


            <div class="space-y-4">

                <article class="rounded-2xl border border-[#DCE5DC] bg-white p-5">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm font-semibold text-[#183524]">
                                #1046
                            </p>

                            <p class="mt-1 text-xs text-[#718076]">
                                Takeaway · Elira Vane
                            </p>
                        </div>

                        <span
                            class="rounded-full bg-[#DCEBF7] px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-[#47708F]">
                            Ready
                        </span>

                    </div>

                    <div class="my-4 h-px bg-[#DCE5DC]"></div>

                    <div class="space-y-3">

                        <div class="flex items-center gap-3">
                            <x-tabler-check class="h-4 w-4 text-[#5E8067]" />

                            <p class="text-sm text-[#26342A]">
                                Dragonfire Roast
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <x-tabler-check class="h-4 w-4 text-[#5E8067]" />

                            <p class="text-sm text-[#26342A]">
                                Mooncream Tart
                            </p>
                        </div>

                    </div>

                    <button wire:click="completeTicket(1046)"
                        class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-[#294936] px-4 py-3 text-sm font-medium text-white transition hover:bg-[#183524]">
                        <x-tabler-check class="h-4 w-4" />
                        Complete Ticket
                    </button>

                </article>

            </div>

        </section>

    </div>

</div>