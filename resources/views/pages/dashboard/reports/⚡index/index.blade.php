<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

        <div>
            <div class="mb-2 flex items-center gap-2 text-sm text-[#718076]">
                <span>Workspace</span>
                <x-tabler-chevron-right class="h-4 w-4" />
                <span class="text-[#294936]">Reports</span>
            </div>

            <h1 class="text-2xl font-semibold tracking-tight text-[#26342A]">
                Reports
            </h1>

            <p class="mt-1 text-sm text-[#718076]">
                Understand sales, operations, costs, and guest activity across Servora.
            </p>
        </div>

        <div class="flex items-center gap-3">

            <button
                type="button"
                class="inline-flex items-center gap-2 rounded-full border border-[#DCE5DC] bg-white px-5 py-2.5 text-sm font-medium text-[#294936] transition hover:bg-[#E8F0E5]"
            >
                <x-tabler-calendar class="h-4 w-4" />
                {{ $period }}
            </button>

            <button
                type="button"
                wire:click="exportReport"
                class="inline-flex items-center gap-2 rounded-full bg-[#294936] px-5 py-2.5 text-sm font-medium text-white transition hover:bg-[#183524]"
            >
                <x-tabler-download class="h-4 w-4" />
                Export Report
            </button>

        </div>
    </div>

    {{-- Report navigation --}}
    <div class="overflow-x-auto border-b border-[#DCE5DC]">

        <nav class="flex min-w-max items-center gap-7">

            @foreach ([
                'Sales',
                'Orders',
                'Menu Performance',
                'Inventory',
                'Food Cost',
                'Labor',
                'Payments',
                'Reservations',
                'Customers',
            ] as $item)

                <button
                    type="button"
                    wire:click="setView('{{ $item }}')"
                    class="relative pb-3 text-sm font-medium transition
                        {{ $view === $item
                            ? 'text-[#294936]'
                            : 'text-[#718076] hover:text-[#294936]' }}"
                >
                    {{ $item }}

                    @if ($view === $item)
                        <span class="absolute inset-x-0 -bottom-px h-0.5 rounded-full bg-[#294936]"></span>
                    @endif
                </button>

            @endforeach

        </nav>

    </div>

    {{-- Date range --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="font-semibold text-[#26342A]">
                {{ $view }}
            </h2>

            <p class="mt-1 text-sm text-[#718076]">
                12th Day of Harvest · Royal Dining Hall
            </p>
        </div>

        <div class="flex items-center gap-1 rounded-xl border border-[#DCE5DC] bg-white p-1">

            @foreach (['Today', '7 Days', '30 Days', 'Custom'] as $range)

                <button
                    type="button"
                    wire:click="setPeriod('{{ $range }}')"
                    class="rounded-lg px-3 py-2 text-xs font-medium transition
                        {{ $period === $range
                            ? 'bg-[#E8F0E5] text-[#294936]'
                            : 'text-[#718076] hover:bg-[#F8FAF6]' }}"
                >
                    {{ $range }}
                </button>

            @endforeach

        </div>

    </div>

    @if ($view === 'Sales')

        {{-- Sales overview --}}
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

            <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5">

                <div class="flex items-center justify-between">
                    <span class="text-sm text-[#718076]">
                        Gross Sales
                    </span>

                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                        <x-tabler-coins class="h-5 w-5" />
                    </span>
                </div>

                <p class="mt-4 text-2xl font-semibold text-[#26342A]">
                    1,284
                    <span class="text-sm font-medium text-[#718076]">silver</span>
                </p>

                <p class="mt-1 text-xs text-[#5E8067]">
                    ↑ 8.4% from previous period
                </p>

            </div>

            <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5">

                <div class="flex items-center justify-between">
                    <span class="text-sm text-[#718076]">
                        Net Sales
                    </span>

                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                        <x-tabler-trending-up class="h-5 w-5" />
                    </span>
                </div>

                <p class="mt-4 text-2xl font-semibold text-[#26342A]">
                    1,198
                    <span class="text-sm font-medium text-[#718076]">silver</span>
                </p>

                <p class="mt-1 text-xs text-[#718076]">
                    After discounts and refunds
                </p>

            </div>

            <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5">

                <div class="flex items-center justify-between">
                    <span class="text-sm text-[#718076]">
                        Average Order
                    </span>

                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                        <x-tabler-receipt class="h-5 w-5" />
                    </span>
                </div>

                <p class="mt-4 text-2xl font-semibold text-[#26342A]">
                    27.30
                    <span class="text-sm font-medium text-[#718076]">silver</span>
                </p>

                <p class="mt-1 text-xs text-[#5E8067]">
                    ↑ 4.2% from previous period
                </p>

            </div>

            <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5">

                <div class="flex items-center justify-between">
                    <span class="text-sm text-[#718076]">
                        Guests Served
                    </span>

                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                        <x-tabler-users class="h-5 w-5" />
                    </span>
                </div>

                <p class="mt-4 text-2xl font-semibold text-[#26342A]">
                    68
                </p>

                <p class="mt-1 text-xs text-[#718076]">
                    Across 47 orders
                </p>

            </div>

        </div>

        {{-- Sales chart --}}
        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">

            <div class="rounded-2xl border border-[#DCE5DC] bg-white p-6">

                <div class="flex items-start justify-between">

                    <div>
                        <h3 class="font-semibold text-[#26342A]">
                            Sales over time
                        </h3>

                        <p class="mt-1 text-sm text-[#718076]">
                            Revenue across the selected period.
                        </p>
                    </div>

                    <button class="rounded-lg p-2 text-[#718076] hover:bg-[#F8FAF6]">
                        <x-tabler-dots-vertical class="h-5 w-5" />
                    </button>

                </div>

                {{-- Chart placeholder --}}
                <div class="mt-8">

                    <div class="flex h-64 items-end gap-3 border-b border-l border-[#DCE5DC] px-4 pb-0">

                        @foreach ([38, 52, 46, 68, 61, 82, 74, 91, 77, 86, 68, 95] as $height)

                            <div class="flex h-full flex-1 items-end">

                                <div
                                    class="w-full rounded-t-lg bg-[#8FA58B] transition hover:bg-[#294936]"
                                    style="height: {{ $height }}%"
                                ></div>

                            </div>

                        @endforeach

                    </div>

                    <div class="mt-3 flex justify-between pl-4 text-[11px] text-[#9AA69D]">
                        <span>08:00</span>
                        <span>10:00</span>
                        <span>12:00</span>
                        <span>14:00</span>
                        <span>16:00</span>
                        <span>18:00</span>
                        <span>20:00</span>
                    </div>

                </div>

            </div>

            {{-- Sales breakdown --}}
            <div class="rounded-2xl border border-[#DCE5DC] bg-white">

                <div class="border-b border-[#DCE5DC] p-5">

                    <h3 class="font-semibold text-[#26342A]">
                        Sales by channel
                    </h3>

                    <p class="mt-1 text-sm text-[#718076]">
                        Where today's orders came from.
                    </p>

                </div>

                <div class="space-y-5 p-5">

                    @foreach ([
                        ['name' => 'Dine-in', 'amount' => '824', 'percent' => 64],
                        ['name' => 'Takeaway', 'amount' => '214', 'percent' => 17],
                        ['name' => 'Online', 'amount' => '162', 'percent' => 13],
                        ['name' => 'Delivery', 'amount' => '84', 'percent' => 6],
                    ] as $channel)

                        <div>

                            <div class="flex items-center justify-between text-sm">

                                <span class="font-medium text-[#26342A]">
                                    {{ $channel['name'] }}
                                </span>

                                <span class="text-[#718076]">
                                    {{ $channel['amount'] }} silver
                                </span>

                            </div>

                            <div class="mt-2 h-2 overflow-hidden rounded-full bg-[#E8F0E5]">

                                <div
                                    class="h-full rounded-full bg-[#5E8067]"
                                    style="width: {{ $channel['percent'] }}%"
                                ></div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

    @elseif ($view === 'Menu Performance')

        {{-- Menu Performance --}}
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

            <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5">
                <p class="text-sm text-[#718076]">
                    Items Sold
                </p>

                <p class="mt-3 text-2xl font-semibold text-[#26342A]">
                    665
                </p>

                <p class="mt-1 text-xs text-[#5E8067]">
                    ↑ 12.6% from previous period
                </p>
            </div>

            <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5">
                <p class="text-sm text-[#718076]">
                    Menu Revenue
                </p>

                <p class="mt-3 text-2xl font-semibold text-[#26342A]">
                    8,942
                    <span class="text-sm font-medium text-[#718076]">silver</span>
                </p>

                <p class="mt-1 text-xs text-[#718076]">
                    Before discounts
                </p>
            </div>

            <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5">
                <p class="text-sm text-[#718076]">
                    Average Item Price
                </p>

                <p class="mt-3 text-2xl font-semibold text-[#26342A]">
                    13.45
                    <span class="text-sm font-medium text-[#718076]">silver</span>
                </p>

                <p class="mt-1 text-xs text-[#718076]">
                    Across all categories
                </p>
            </div>

            <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5">
                <p class="text-sm text-[#718076]">
                    Out of Stock
                </p>

                <p class="mt-3 text-2xl font-semibold text-[#B94A48]">
                    5
                </p>

                <p class="mt-1 text-xs text-[#718076]">
                    Currently unavailable
                </p>
            </div>

        </div>

        {{-- Top items --}}
        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">

            <div class="overflow-hidden rounded-2xl border border-[#DCE5DC] bg-white">

                <div class="border-b border-[#DCE5DC] p-5">

                    <div class="flex items-center justify-between">

                        <div>
                            <h3 class="font-semibold text-[#26342A]">
                                Top menu items
                            </h3>

                            <p class="mt-1 text-sm text-[#718076]">
                                Product mix for {{ $period }}.
                            </p>
                        </div>

                        <button class="text-sm font-medium text-[#294936] hover:underline">
                            View all
                        </button>

                    </div>

                </div>

                <div class="divide-y divide-[#DCE5DC]">

                    @foreach ([
                        ['name' => 'Elven Moonwine', 'category' => 'Beverages', 'sold' => 204, 'revenue' => '1,428', 'percent' => 100],
                        ['name' => 'Dragonfire Roast', 'category' => 'Main Courses', 'sold' => 183, 'revenue' => '3,294', 'percent' => 90],
                        ['name' => 'Moonroot Stew', 'category' => 'Soups & Stews', 'sold' => 157, 'revenue' => '1,413', 'percent' => 77],
                        ['name' => "Hunter's Feast", 'category' => 'Main Courses', 'sold' => 121, 'revenue' => '1,694', 'percent' => 59],
                        ['name' => 'Mooncream Tart', 'category' => 'Desserts', 'sold' => 96, 'revenue' => '576', 'percent' => 47],
                    ] as $index => $item)

                        <div class="flex items-center gap-4 px-5 py-4">

                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#F8FAF6] text-xs font-semibold text-[#718076]">
                                {{ $index + 1 }}
                            </div>

                            <div class="min-w-0 flex-1">

                                <div class="flex items-center justify-between gap-4">

                                    <div>
                                        <p class="text-sm font-medium text-[#26342A]">
                                            {{ $item['name'] }}
                                        </p>

                                        <p class="mt-1 text-xs text-[#718076]">
                                            {{ $item['category'] }}
                                        </p>
                                    </div>

                                    <div class="text-right">

                                        <p class="text-sm font-semibold text-[#26342A]">
                                            {{ $item['sold'] }}
                                        </p>

                                        <p class="mt-1 text-xs text-[#718076]">
                                            sold
                                        </p>

                                    </div>

                                </div>

                                <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-[#E8F0E5]">

                                    <div
                                        class="h-full rounded-full bg-[#5E8067]"
                                        style="width: {{ $item['percent'] }}%"
                                    ></div>

                                </div>

                            </div>

                            <div class="hidden w-24 text-right sm:block">

                                <p class="text-sm font-medium text-[#294936]">
                                    {{ $item['revenue'] }}
                                </p>

                                <p class="mt-1 text-xs text-[#718076]">
                                    silver
                                </p>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

            {{-- Categories --}}
            <div class="rounded-2xl border border-[#DCE5DC] bg-white">

                <div class="border-b border-[#DCE5DC] p-5">

                    <h3 class="font-semibold text-[#26342A]">
                        Category performance
                    </h3>

                    <p class="mt-1 text-sm text-[#718076]">
                        Revenue contribution by group.
                    </p>

                </div>

                <div class="space-y-5 p-5">

                    @foreach ([
                        ['name' => 'Main Courses', 'value' => '4,988', 'percent' => 56],
                        ['name' => 'Beverages', 'value' => '1,862', 'percent' => 21],
                        ['name' => 'Soups & Stews', 'value' => '1,013', 'percent' => 11],
                        ['name' => 'Desserts', 'value' => '642', 'percent' => 7],
                        ['name' => 'Sides', 'value' => '437', 'percent' => 5],
                    ] as $category)

                        <div>

                            <div class="flex items-center justify-between text-sm">

                                <span class="font-medium text-[#26342A]">
                                    {{ $category['name'] }}
                                </span>

                                <span class="text-[#718076]">
                                    {{ $category['value'] }}
                                </span>

                            </div>

                            <div class="mt-2 h-2 overflow-hidden rounded-full bg-[#E8F0E5]">

                                <div
                                    class="h-full rounded-full bg-[#8FA58B]"
                                    style="width: {{ $category['percent'] }}%"
                                ></div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

        {{-- Item details --}}
        <div class="rounded-2xl border border-[#DCE5DC] bg-white">

            <div class="border-b border-[#DCE5DC] p-5">

                <h3 class="font-semibold text-[#26342A]">
                    Item details
                </h3>

                <p class="mt-1 text-sm text-[#718076]">
                    Sales, pricing, modifiers, and availability.
                </p>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full min-w-[760px] text-left">

                    <thead class="border-b border-[#DCE5DC] bg-[#F8FAF6]">

                        <tr class="text-xs font-medium uppercase tracking-wider text-[#718076]">
                            <th class="px-5 py-3">Item</th>
                            <th class="px-5 py-3">Sold</th>
                            <th class="px-5 py-3">Revenue</th>
                            <th class="px-5 py-3">Avg. Price</th>
                            <th class="px-5 py-3">Modifiers</th>
                            <th class="px-5 py-3">Availability</th>
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-[#DCE5DC]">

                        @foreach ([
                            ['name' => 'Dragonfire Roast', 'sold' => 183, 'revenue' => '3,294', 'price' => '18', 'mods' => 48, 'availability' => '98%'],
                            ['name' => 'Moonroot Stew', 'sold' => 157, 'revenue' => '1,413', 'price' => '9', 'mods' => 21, 'availability' => '86%'],
                            ['name' => "Hunter's Feast", 'sold' => 121, 'revenue' => '1,694', 'price' => '14', 'mods' => 37, 'availability' => '100%'],
                            ['name' => 'Elven Moonwine', 'sold' => 204, 'revenue' => '1,428', 'price' => '7', 'mods' => 12, 'availability' => '100%'],
                        ] as $item)

                            <tr class="hover:bg-[#F8FAF6]">

                                <td class="px-5 py-4">
                                    <span class="text-sm font-medium text-[#26342A]">
                                        {{ $item['name'] }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-sm text-[#718076]">
                                    {{ $item['sold'] }}
                                </td>

                                <td class="px-5 py-4 text-sm font-medium text-[#294936]">
                                    {{ $item['revenue'] }}
                                </td>

                                <td class="px-5 py-4 text-sm text-[#718076]">
                                    {{ $item['price'] }} silver
                                </td>

                                <td class="px-5 py-4 text-sm text-[#718076]">
                                    {{ $item['mods'] }}
                                </td>

                                <td class="px-5 py-4">

                                    <span class="inline-flex rounded-full bg-[#E8F0E5] px-2.5 py-1 text-xs font-medium text-[#5E8067]">
                                        {{ $item['availability'] }}
                                    </span>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    @else

        {{-- Other reports --}}
        <div class="grid gap-6 lg:grid-cols-3">

            @foreach ([
                [
                    'name' => 'Inventory',
                    'description' => 'Stock value, low-stock items, movements, and waste.',
                    'icon' => 'package',
                ],
                [
                    'name' => 'Food Cost',
                    'description' => 'Recipe costs, margins, ingredient prices, and food cost percentage.',
                    'icon' => 'coins',
                ],
                [
                    'name' => 'Labor',
                    'description' => 'Hours worked, staffing costs, overtime, and labor percentage.',
                    'icon' => 'users',
                ],
                [
                    'name' => 'Payments',
                    'description' => 'Tender types, refunds, discounts, and payment activity.',
                    'icon' => 'credit-card',
                ],
                [
                    'name' => 'Reservations',
                    'description' => 'Bookings, no-shows, covers, and table utilization.',
                    'icon' => 'calendar-event',
                ],
                [
                    'name' => 'Customers',
                    'description' => 'Visits, spending, retention, loyalty, and guest behavior.',
                    'icon' => 'users',
                ],
            ] as $report)

                <button
                    type="button"
                    class="group rounded-2xl border border-[#DCE5DC] bg-white p-6 text-left transition hover:-translate-y-0.5 hover:border-[#C8D5C9] hover:shadow-sm"
                >

                    <div class="flex items-start justify-between">

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">

                            @switch($report['icon'])

                                @case('package')
                                    <x-tabler-package class="h-5 w-5" />
                                    @break

                                @case('coins')
                                    <x-tabler-coins class="h-5 w-5" />
                                    @break

                                @case('users')
                                    <x-tabler-users class="h-5 w-5" />
                                    @break

                                @case('credit-card')
                                    <x-tabler-credit-card class="h-5 w-5" />
                                    @break

                                @case('calendar-event')
                                    <x-tabler-calendar-event class="h-5 w-5" />
                                    @break

                            @endswitch

                        </div>

                        <x-tabler-arrow-up-right
                            class="h-5 w-5 text-[#9AA69D] transition group-hover:text-[#294936]"
                        />

                    </div>

                    <h3 class="mt-5 font-semibold text-[#26342A]">
                        {{ $report['name'] }}
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-[#718076]">
                        {{ $report['description'] }}
                    </p>

                </button>

            @endforeach

        </div>

        {{-- Coming report summary --}}
        <div class="rounded-2xl border border-[#DCE5DC] bg-white p-6">

            <div class="flex items-start gap-4">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                    <x-tabler-chart-dots-3 class="h-5 w-5" />
                </div>

                <div>

                    <h3 class="font-semibold text-[#26342A]">
                        {{ $view }} report
                    </h3>

                    <p class="mt-1 max-w-2xl text-sm leading-6 text-[#718076]">
                        Detailed {{ strtolower($view) }} reporting will connect
                        directly to Servora's operational data, giving you
                        historical comparisons, trends, and exportable records.
                    </p>

                </div>

            </div>

        </div>

    @endif

</div>