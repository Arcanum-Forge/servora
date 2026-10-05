<div>

    {{-- Header --}}
    <div class="mb-8">

        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8FA58B]">
            Today's overview
        </p>

        <div class="mt-2 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">

            <div>
                <h2 class="text-3xl font-semibold tracking-tight text-[#183524]">
                    Good morning, Admin.
                </h2>

                <p class="mt-2 text-sm text-[#718076]">
                    Here's how Servora is doing today.
                </p>
            </div>

            <a href="#"
                class="inline-flex w-fit items-center gap-2 rounded-full bg-[#294936] px-5 py-2.5 text-sm font-medium text-white transition hover:bg-[#183524]">
                <x-tabler-plus class="h-4 w-4" />
                New order
            </a>

        </div>

    </div>


    {{-- Primary stats --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <x-servora.dashboard.stat-card label="Today's sales" value="1,284 silver" change="+12.4% from yesterday"
            icon="coin" />

        <x-servora.dashboard.stat-card label="Today's orders" value="47" change="+8 orders today" icon="shopping-bag" />

        <x-servora.dashboard.stat-card label="Reservations" value="24" change="68 guests expected" icon="calendar" />

        <x-servora.dashboard.stat-card label="Tables" value="18 / 24" change="18 occupied · 6 free" icon="table" />

    </div>


    {{-- Operations --}}
    <div class="mt-6 grid gap-6 xl:grid-cols-[1.4fr_0.6fr]">

        {{-- Reservations --}}
        <section class="rounded-2xl border border-[#DCE5DC] bg-white">

            <div class="flex items-center justify-between border-b border-[#DCE5DC] px-6 py-5">

                <div>
                    <h3 class="font-semibold text-[#183524]">
                        Today's reservations
                    </h3>

                    <p class="mt-1 text-xs text-[#8A968D]">
                        Upcoming guests
                    </p>
                </div>

                <a href="#" class="text-sm font-medium text-[#5E8067] hover:text-[#294936]">
                    View all
                </a>

            </div>


            <div class="divide-y divide-[#DCE5DC]">

                @foreach ([
                        ['time' => '11:30', 'name' => 'Rowan Hale', 'guests' => 4, 'table' => '08', 'status' => 'Confirmed'],
                        ['time' => '13:00', 'name' => 'Mira Solen', 'guests' => 2, 'table' => '03', 'status' => 'Pending'],
                        ['time' => '18:30', 'name' => 'Taren & Lyra', 'guests' => 6, 'table' => '12', 'status' => 'Confirmed'],
                        ['time' => '20:00', 'name' => 'Sera Windmere', 'guests' => 8, 'table' => '15', 'status' => 'Confirmed'],
                    ] as $reservation)

                    <div class="flex items-center gap-4 px-6 py-5">

                        <div class="w-16 shrink-0">
                            <p class="text-sm font-semibold text-[#294936]">
                                {{ $reservation['time'] }}
                            </p>

                            <p class="mt-1 text-xs text-[#8A968D]">
                                {{ $reservation['time'] < '12:00' ? 'AM' : 'PM' }}
                            </p>
                        </div>

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#E8F0E5]">
                            <span class="text-sm font-semibold text-[#294936]">
                                {{ substr($reservation['name'], 0, 1) }}
                            </span>
                        </div>

                        <div class="min-w-0 flex-1">

                            <p class="truncate text-sm font-medium text-[#294936]">
                                {{ $reservation['name'] }}
                            </p>

                            <p class="mt-1 text-xs text-[#8A968D]">
                                {{ $reservation['guests'] }} guests · Table {{ $reservation['table'] }}
                            </p>

                        </div>

                        <span @class([
                            'rounded-full px-3 py-1 text-xs font-medium',
                            'bg-[#E8F0E5] text-[#5E8067]' => $reservation['status'] === 'Confirmed',
                            'bg-[#FFF4DD] text-[#9A762B]' => $reservation['status'] === 'Pending',
                        ])>
                            {{ $reservation['status'] }}
                        </span>

                    </div>

                @endforeach

            </div>

        </section>


        {{-- Tables --}}
        <section class="rounded-2xl border border-[#DCE5DC] bg-white p-6">

            <div class="flex items-center justify-between">

                <div>
                    <h3 class="font-semibold text-[#183524]">
                        Tables
                    </h3>

                    <p class="mt-1 text-xs text-[#8A968D]">
                        Current floor status
                    </p>
                </div>

                <x-tabler-layout-grid class="h-5 w-5 text-[#8FA58B]" />

            </div>


            <div class="mt-6">

                <div class="flex items-end justify-between">

                    <div>
                        <p class="text-4xl font-semibold tracking-tight text-[#183524]">
                            18
                        </p>

                        <p class="mt-1 text-sm text-[#718076]">
                            occupied
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="text-2xl font-semibold text-[#8FA58B]">
                            6
                        </p>

                        <p class="mt-1 text-sm text-[#718076]">
                            free
                        </p>
                    </div>

                </div>


                {{-- Occupancy bar --}}
                <div class="mt-6 h-3 overflow-hidden rounded-full bg-[#E8F0E5]">

                    <div class="h-full rounded-full bg-[#5E8067]" style="width: 75%"></div>

                </div>

                <div class="mt-3 flex justify-between text-xs text-[#8A968D]">
                    <span>75% occupied</span>
                    <span>24 tables</span>
                </div>

            </div>


            <a href="#"
                class="mt-7 flex items-center justify-between rounded-xl bg-[#F8FAF6] px-4 py-3 text-sm font-medium text-[#294936] transition hover:bg-[#E8F0E5]">
                Manage tables

                <x-tabler-arrow-up-right class="h-4 w-4" />
            </a>

        </section>

    </div>


    {{-- Food & Kitchen --}}
    <div class="mt-6 grid gap-6 lg:grid-cols-2">

        {{-- Popular dishes --}}
        <section class="rounded-2xl border border-[#DCE5DC] bg-white">

            <div class="flex items-center justify-between border-b border-[#DCE5DC] px-6 py-5">

                <div>
                    <h3 class="font-semibold text-[#183524]">
                        Popular dishes
                    </h3>

                    <p class="mt-1 text-xs text-[#8A968D]">
                        Most ordered today
                    </p>
                </div>

                <x-tabler-trending-up class="h-5 w-5 text-[#8FA58B]" />

            </div>


            <div class="divide-y divide-[#DCE5DC]">

                @foreach ([
                        ['name' => 'Dragonfire Roast', 'orders' => 18, 'icon' => 'flame'],
                        ['name' => 'Hunter\'s Feast', 'orders' => 14, 'icon' => 'meat'],
                        ['name' => 'Moonroot Stew', 'orders' => 11, 'icon' => 'soup'],
                    ] as $dish)

                    <div class="flex items-center gap-4 px-6 py-4">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#E8F0E5]">

                            @if ($dish['icon'] === 'flame')
                                <x-tabler-flame class="h-5 w-5 text-[#5E8067]" />
                            @elseif ($dish['icon'] === 'soup')
                                <x-tabler-soup class="h-5 w-5 text-[#5E8067]" />
                            @else
                                <x-tabler-meat class="h-5 w-5 text-[#5E8067]" />
                            @endif

                        </div>

                        <div class="min-w-0 flex-1">

                            <p class="truncate text-sm font-medium text-[#294936]">
                                {{ $dish['name'] }}
                            </p>

                            <p class="mt-1 text-xs text-[#8A968D]">
                                {{ $dish['orders'] }} orders
                            </p>

                        </div>

                        <div class="h-2 w-20 overflow-hidden rounded-full bg-[#E8F0E5]">
                            <div class="h-full rounded-full bg-[#8FA58B]"
                                style="width: {{ min(100, $dish['orders'] * 5) }}%"></div>
                        </div>

                    </div>

                @endforeach

            </div>

        </section>


        {{-- Low stock --}}
        <section class="rounded-2xl border border-[#DCE5DC] bg-white">

            <div class="flex items-center justify-between border-b border-[#DCE5DC] px-6 py-5">

                <div>
                    <h3 class="font-semibold text-[#183524]">
                        Low-stock ingredients
                    </h3>

                    <p class="mt-1 text-xs text-[#8A968D]">
                        Ingredients that need attention
                    </p>
                </div>

                <x-tabler-alert-triangle class="h-5 w-5 text-[#C08A3C]" />

            </div>


            <div class="divide-y divide-[#DCE5DC]">

                @foreach ([
                        ['name' => 'Fireberries', 'amount' => '1.8 kg', 'level' => 'Critical'],
                        ['name' => 'Moonroot', 'amount' => '3.2 kg', 'level' => 'Low'],
                        ['name' => 'Wild Herbs', 'amount' => '2.4 kg', 'level' => 'Low'],
                    ] as $ingredient)

                    <div class="flex items-center gap-4 px-6 py-4">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#FFF4DD]">
                            <x-tabler-package class="h-4 w-4 text-[#C08A3C]" />
                        </div>

                        <div class="min-w-0 flex-1">

                            <p class="text-sm font-medium text-[#294936]">
                                {{ $ingredient['name'] }}
                            </p>

                            <p class="mt-1 text-xs text-[#8A968D]">
                                {{ $ingredient['amount'] }} remaining
                            </p>

                        </div>

                        <span @class([
                            'rounded-full px-3 py-1 text-xs font-medium',
                            'bg-[#FDE8E7] text-[#B94A48]' => $ingredient['level'] === 'Critical',
                            'bg-[#FFF4DD] text-[#9A762B]' => $ingredient['level'] === 'Low',
                        ])>
                            {{ $ingredient['level'] }}
                        </span>

                    </div>

                @endforeach

            </div>


            <div class="p-4">

                <a href="#"
                    class="flex items-center justify-center gap-2 rounded-xl bg-[#F8FAF6] px-4 py-3 text-sm font-medium text-[#294936] transition hover:bg-[#E8F0E5]">
                    View inventory

                    <x-tabler-arrow-right class="h-4 w-4" />
                </a>

            </div>

        </section>

    </div>


    {{-- Kitchen + Staff --}}
    <div class="mt-6 grid gap-6 lg:grid-cols-2">

        {{-- Kitchen status --}}
        <section class="rounded-2xl border border-[#DCE5DC] bg-white">

            <div class="flex items-center justify-between border-b border-[#DCE5DC] px-6 py-5">

                <div>
                    <h3 class="font-semibold text-[#183524]">
                        Kitchen status
                    </h3>

                    <p class="mt-1 text-xs text-[#8A968D]">
                        Current service activity
                    </p>
                </div>

                <span
                    class="flex items-center gap-2 rounded-full bg-[#E8F0E5] px-3 py-1.5 text-xs font-medium text-[#5E8067]">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#5E8067]"></span>
                    Service active
                </span>

            </div>


            <div class="grid grid-cols-3 divide-x divide-[#DCE5DC]">

                <div class="p-5 text-center">
                    <p class="text-2xl font-semibold text-[#183524]">
                        8
                    </p>

                    <p class="mt-1 text-xs text-[#8A968D]">
                        Preparing
                    </p>
                </div>

                <div class="p-5 text-center">
                    <p class="text-2xl font-semibold text-[#183524]">
                        5
                    </p>

                    <p class="mt-1 text-xs text-[#8A968D]">
                        Ready
                    </p>
                </div>

                <div class="p-5 text-center">
                    <p class="text-2xl font-semibold text-[#183524]">
                        2
                    </p>

                    <p class="mt-1 text-xs text-[#8A968D]">
                        Delayed
                    </p>
                </div>

            </div>


            <div class="border-t border-[#DCE5DC] px-6 py-5">

                <div class="flex items-center justify-between text-sm">

                    <span class="text-[#718076]">
                        Current kitchen load
                    </span>

                    <span class="font-medium text-[#294936]">
                        64%
                    </span>

                </div>

                <div class="mt-3 h-2 overflow-hidden rounded-full bg-[#E8F0E5]">
                    <div class="h-full w-[64%] rounded-full bg-[#5E8067]"></div>
                </div>

            </div>

        </section>


        {{-- Staff --}}
        <section class="rounded-2xl border border-[#DCE5DC] bg-white">

            <div class="flex items-center justify-between border-b border-[#DCE5DC] px-6 py-5">

                <div>
                    <h3 class="font-semibold text-[#183524]">
                        Staff currently working
                    </h3>

                    <p class="mt-1 text-xs text-[#8A968D]">
                        12 team members on shift
                    </p>
                </div>

                <x-tabler-users class="h-5 w-5 text-[#8FA58B]" />

            </div>


            <div class="p-6">

                <div class="flex -space-x-2">

                    @foreach (['A', 'M', 'R', 'S', 'T', 'L'] as $initial)

                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-white bg-[#E8F0E5] text-xs font-semibold text-[#294936]">
                            {{ $initial }}
                        </div>

                    @endforeach

                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-white bg-[#294936] text-xs font-semibold text-white">
                        +6
                    </div>

                </div>


                <div class="mt-6 grid grid-cols-2 gap-3">

                    <div class="rounded-xl bg-[#F8FAF6] p-4">

                        <div class="flex items-center gap-2">

                            <x-tabler-chef-hat class="h-4 w-4 text-[#5E8067]" />

                            <span class="text-xs text-[#8A968D]">
                                Kitchen
                            </span>

                        </div>

                        <p class="mt-2 text-lg font-semibold text-[#294936]">
                            5 staff
                        </p>

                    </div>


                    <div class="rounded-xl bg-[#F8FAF6] p-4">

                        <div class="flex items-center gap-2">

                            <x-tabler-tools-kitchen-2 class="h-4 w-4 text-[#5E8067]" />

                            <span class="text-xs text-[#8A968D]">
                                Floor
                            </span>

                        </div>

                        <p class="mt-2 text-lg font-semibold text-[#294936]">
                            7 staff
                        </p>

                    </div>

                </div>

            </div>

        </section>

    </div>

</div>