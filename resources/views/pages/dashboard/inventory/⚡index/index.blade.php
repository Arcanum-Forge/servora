<div class="space-y-6">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="flex flex-col gap-5 xl:flex-row xl:items-end xl:justify-between">

        <div>
            <div class="mb-2 flex items-center gap-2 text-sm text-[#718076]">
                <span>Manage</span>
                <x-tabler-chevron-right class="h-4 w-4" />
                <span class="text-[#294936]">Inventory</span>
            </div>

            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-semibold tracking-tight text-[#26342A]">
                    Inventory
                </h1>

                <span class="inline-flex items-center gap-1.5 rounded-full bg-[#E8F0E5] px-2.5 py-1 text-xs font-medium text-[#5E8067]">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#5E8067]"></span>
                    Stockroom healthy
                </span>
            </div>

            <p class="mt-1 text-sm text-[#718076]">
                Track provisions, control food costs, and keep the kitchens supplied.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">

            <button
                type="button"
                wire:click="recordWaste(1)"
                class="inline-flex items-center justify-center gap-2 rounded-full border border-[#DCE5DC] bg-white px-4 py-2.5 text-sm font-medium text-[#294936] transition hover:bg-[#F8FAF6]"
            >
                <x-tabler-trash class="h-4 w-4" />
                Record Waste
            </button>

            <button
                type="button"
                wire:click="createPurchaseOrder"
                class="inline-flex items-center justify-center gap-2 rounded-full bg-[#294936] px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-[#183524]"
            >
                <x-tabler-plus class="h-4 w-4" />
                Purchase Order
            </button>

        </div>
    </div>


    {{-- =========================================================
        COMMAND BAR
    ========================================================== --}}
    <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Inventory value --}}
        <div class="group rounded-2xl border border-[#DCE5DC] bg-white p-4 transition hover:border-[#C7D5C8]">

            <div class="flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                    <x-tabler-building-warehouse class="h-5 w-5" />
                </div>

                <span class="text-xs font-medium text-[#5E8067]">
                    +4.8%
                </span>
            </div>

            <p class="mt-4 text-xs font-medium uppercase tracking-wider text-[#8A968D]">
                Inventory value
            </p>

            <p class="mt-1 text-2xl font-semibold text-[#26342A]">
                4,860
                <span class="text-sm font-medium text-[#718076]">silver</span>
            </p>

            <p class="mt-1 text-xs text-[#718076]">
                48 active ingredients
            </p>
        </div>


        {{-- Low stock --}}
        <div class="group rounded-2xl border border-[#E8D7B4] bg-[#FFFDF8] p-4 transition hover:border-[#DCC596]">

            <div class="flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#FFF4DD] text-[#9A762B]">
                    <x-tabler-alert-triangle class="h-5 w-5" />
                </div>

                <span class="text-xs font-medium text-[#B94A48]">
                    Action needed
                </span>
            </div>

            <p class="mt-4 text-xs font-medium uppercase tracking-wider text-[#8A968D]">
                Low stock
            </p>

            <p class="mt-1 text-2xl font-semibold text-[#26342A]">
                5
            </p>

            <p class="mt-1 text-xs text-[#718076]">
                2 critically low
            </p>
        </div>


        {{-- Orders --}}
        <div class="group rounded-2xl border border-[#DCE5DC] bg-white p-4 transition hover:border-[#C7D5C8]">

            <div class="flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                    <x-tabler-truck-delivery class="h-5 w-5" />
                </div>

                <span class="text-xs font-medium text-[#5E8067]">
                    1 today
                </span>
            </div>

            <p class="mt-4 text-xs font-medium uppercase tracking-wider text-[#8A968D]">
                Open orders
            </p>

            <p class="mt-1 text-2xl font-semibold text-[#26342A]">
                3
            </p>

            <p class="mt-1 text-xs text-[#718076]">
                2 awaiting delivery
            </p>
        </div>


        {{-- Waste --}}
        <div class="group rounded-2xl border border-[#DCE5DC] bg-white p-4 transition hover:border-[#E2C5C3]">

            <div class="flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#FDE8E7] text-[#B94A48]">
                    <x-tabler-trash class="h-5 w-5" />
                </div>

                <span class="text-xs font-medium text-[#B94A48]">
                    3.2%
                </span>
            </div>

            <p class="mt-4 text-xs font-medium uppercase tracking-wider text-[#8A968D]">
                Waste this month
            </p>

            <p class="mt-1 text-2xl font-semibold text-[#26342A]">
                186
                <span class="text-sm font-medium text-[#718076]">silver</span>
            </p>

            <p class="mt-1 text-xs text-[#718076]">
                14 silver above last month
            </p>
        </div>

    </div>


    {{-- =========================================================
        INVENTORY NAVIGATION
    ========================================================== --}}
    <div class="rounded-2xl border border-[#DCE5DC] bg-white p-2">

        <nav class="flex gap-1 overflow-x-auto">

            @foreach ([
                'Ingredients' => ['icon' => 'package', 'description' => 'Catalog'],
                'Stock' => ['icon' => 'boxes', 'description' => 'On hand'],
                'Recipes' => ['icon' => 'notebook', 'description' => 'Food cost'],
                'Suppliers' => ['icon' => 'truck', 'description' => 'Vendors'],
                'Purchase Orders' => ['icon' => 'file-invoice', 'description' => 'Purchasing'],
                'Stock Adjustments' => ['icon' => 'adjustments', 'description' => 'Audit'],
                'Waste' => ['icon' => 'trash', 'description' => 'Loss'],
            ] as $item => $meta)

                <button
                    type="button"
                    wire:click="setView('{{ $item }}')"
                    class="group flex min-w-max items-center gap-2 rounded-xl px-4 py-3 text-left transition
                        {{ $view === $item
                            ? 'bg-[#294936] text-white shadow-sm'
                            : 'text-[#718076] hover:bg-[#F8FAF6] hover:text-[#294936]' }}"
                >

                    @switch($meta['icon'])

                        @case('package')
                            <x-tabler-package class="h-4 w-4" />
                            @break

                        @case('boxes')
                            <x-tabler-box class="h-4 w-4" />
                            @break

                        @case('notebook')
                            <x-tabler-notebook class="h-4 w-4" />
                            @break

                        @case('truck')
                            <x-tabler-truck-delivery class="h-4 w-4" />
                            @break

                        @case('file-invoice')
                            <x-tabler-file-invoice class="h-4 w-4" />
                            @break

                        @case('adjustments')
                            <x-tabler-adjustments class="h-4 w-4" />
                            @break

                        @case('trash')
                            <x-tabler-trash class="h-4 w-4" />
                            @break

                    @endswitch

                    <span>
                        <span class="block text-sm font-medium">
                            {{ $item }}
                        </span>

                        <span class="hidden text-[10px] opacity-70 sm:block">
                            {{ $meta['description'] }}
                        </span>
                    </span>

                </button>

            @endforeach

        </nav>

    </div>


    {{-- =========================================================
        INGREDIENTS
    ========================================================== --}}
    @if ($view === 'Ingredients')

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">

            <div class="overflow-hidden rounded-2xl border border-[#DCE5DC] bg-white">

                <div class="flex flex-col gap-4 border-b border-[#DCE5DC] p-5 lg:flex-row lg:items-center lg:justify-between">

                    <div>
                        <h2 class="font-semibold text-[#26342A]">
                            Ingredient catalog
                        </h2>

                        <p class="mt-1 text-sm text-[#718076]">
                            Every ingredient used across the kingdom's kitchens.
                        </p>
                    </div>

                    <div class="relative w-full lg:w-64">
                        <x-tabler-search class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8FA58B]" />

                        <input
                            type="text"
                            wire:model.live="search"
                            placeholder="Search ingredients..."
                            class="w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] py-2.5 pl-9 pr-3 text-sm outline-none focus:border-[#8FA58B] focus:ring-2 focus:ring-[#E8F0E5]"
                        />
                    </div>

                </div>


                <div class="overflow-x-auto">

                    <table class="w-full min-w-[760px] text-left">

                        <thead class="border-b border-[#DCE5DC] bg-[#F8FAF6]">
                            <tr class="text-[11px] font-semibold uppercase tracking-wider text-[#8A968D]">
                                <th class="px-5 py-3">Ingredient</th>
                                <th class="px-5 py-3">Category</th>
                                <th class="px-5 py-3">On hand</th>
                                <th class="px-5 py-3">Reorder</th>
                                <th class="px-5 py-3">Status</th>
                                <th class="px-5 py-3"></th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#DCE5DC]">

                            @foreach ([
                                [
                                    'name' => 'Ember Drake Meat',
                                    'sub' => 'Fresh · Refrigerated',
                                    'category' => 'Meat',
                                    'stock' => '12 lbs',
                                    'reorder' => '8 lbs',
                                    'status' => 'Healthy',
                                    'color' => 'green',
                                    'icon' => 'meat'
                                ],
                                [
                                    'name' => 'Moonroot',
                                    'sub' => 'Fresh · Produce',
                                    'category' => 'Produce',
                                    'stock' => '43 units',
                                    'reorder' => '50 units',
                                    'status' => 'Critical',
                                    'color' => 'red',
                                    'icon' => 'plant'
                                ],
                                [
                                    'name' => 'Fireberries',
                                    'sub' => 'Fresh · Produce',
                                    'category' => 'Produce',
                                    'stock' => '18 baskets',
                                    'reorder' => '10 baskets',
                                    'status' => 'Healthy',
                                    'color' => 'green',
                                    'icon' => 'flame'
                                ],
                                [
                                    'name' => 'Dwarven Black Ale',
                                    'sub' => 'Cellar · Beverage',
                                    'category' => 'Beverage',
                                    'stock' => '7 barrels',
                                    'reorder' => '4 barrels',
                                    'status' => 'Healthy',
                                    'color' => 'green',
                                    'icon' => 'beer'
                                ],
                                [
                                    'name' => 'Dragon Pepper',
                                    'sub' => 'Dried · Spice',
                                    'category' => 'Spices',
                                    'stock' => '3 jars',
                                    'reorder' => '2 jars',
                                    'status' => 'Healthy',
                                    'color' => 'green',
                                    'icon' => 'pepper'
                                ],
                            ] as $ingredient)

                                <tr class="transition hover:bg-[#F8FAF6]">

                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">

                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl
                                                {{ $ingredient['color'] === 'red'
                                                    ? 'bg-[#FDE8E7] text-[#B94A48]'
                                                    : 'bg-[#E8F0E5] text-[#294936]' }}">

                                                @switch($ingredient['icon'])
                                                    @case('meat')
                                                        <x-tabler-meat class="h-5 w-5" />
                                                        @break
                                                    @case('plant')
                                                        <x-tabler-plant-2 class="h-5 w-5" />
                                                        @break
                                                    @case('flame')
                                                        <x-tabler-flame class="h-5 w-5" />
                                                        @break
                                                    @case('beer')
                                                        <x-tabler-beer class="h-5 w-5" />
                                                        @break
                                                    @case('pepper')
                                                        <x-tabler-pepper class="h-5 w-5" />
                                                        @break
                                                @endswitch

                                            </div>

                                            <div>
                                                <p class="text-sm font-medium text-[#26342A]">
                                                    {{ $ingredient['name'] }}
                                                </p>

                                                <p class="text-xs text-[#718076]">
                                                    {{ $ingredient['sub'] }}
                                                </p>
                                            </div>

                                        </div>
                                    </td>

                                    <td class="px-5 py-4 text-sm text-[#718076]">
                                        {{ $ingredient['category'] }}
                                    </td>

                                    <td class="px-5 py-4 text-sm font-semibold
                                        {{ $ingredient['color'] === 'red' ? 'text-[#B94A48]' : 'text-[#26342A]' }}">
                                        {{ $ingredient['stock'] }}
                                    </td>

                                    <td class="px-5 py-4 text-sm text-[#718076]">
                                        {{ $ingredient['reorder'] }}
                                    </td>

                                    <td class="px-5 py-4">

                                        <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium
                                            {{ $ingredient['color'] === 'red'
                                                ? 'bg-[#FDE8E7] text-[#B94A48]'
                                                : 'bg-[#E8F0E5] text-[#5E8067]' }}">

                                            <span class="h-1.5 w-1.5 rounded-full
                                                {{ $ingredient['color'] === 'red'
                                                    ? 'bg-[#B94A48]'
                                                    : 'bg-[#5E8067]' }}">
                                            </span>

                                            {{ $ingredient['status'] }}

                                        </span>

                                    </td>

                                    <td class="px-5 py-4 text-right">
                                        <button class="rounded-lg p-2 text-[#718076] hover:bg-[#E8F0E5] hover:text-[#294936]">
                                            <x-tabler-dots class="h-5 w-5" />
                                        </button>
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- Ingredient insight --}}
            <div class="space-y-6">

                <div class="rounded-2xl border border-[#E8D7B4] bg-[#FFFDF8] p-5">

                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#FFF4DD] text-[#9A762B]">
                            <x-tabler-alert-triangle class="h-5 w-5" />
                        </div>

                        <div>
                            <p class="font-semibold text-[#26342A]">
                                Replenishment needed
                            </p>

                            <p class="mt-1 text-sm leading-6 text-[#718076]">
                                Two ingredients have fallen below their par levels.
                            </p>
                        </div>

                    </div>

                    <div class="mt-5 space-y-3">

                        <div class="rounded-xl border border-[#F0DFBE] bg-white p-3">

                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-[#26342A]">
                                    Moonroot
                                </span>

                                <span class="text-xs font-semibold text-[#B94A48]">
                                    43 / 50
                                </span>
                            </div>

                            <div class="mt-2 h-1.5 rounded-full bg-[#F1E9DF]">
                                <div class="h-full w-[43%] rounded-full bg-[#B94A48]"></div>
                            </div>

                        </div>

                        <div class="rounded-xl border border-[#F0DFBE] bg-white p-3">

                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-[#26342A]">
                                    Silverleaf
                                </span>

                                <span class="text-xs font-semibold text-[#9A762B]">
                                    6 / 8
                                </span>
                            </div>

                            <div class="mt-2 h-1.5 rounded-full bg-[#F1E9DF]">
                                <div class="h-full w-[75%] rounded-full bg-[#9A762B]"></div>
                            </div>

                        </div>

                    </div>

                    <button
                        type="button"
                        wire:click="createPurchaseOrder"
                        class="mt-4 w-full rounded-xl bg-[#294936] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#183524]"
                    >
                        Replenish stock
                    </button>

                </div>


                <div class="rounded-2xl border border-[#DCE5DC] bg-white">

                    <div class="border-b border-[#DCE5DC] p-5">
                        <h3 class="font-semibold text-[#26342A]">
                            Recently received
                        </h3>
                    </div>

                    <div class="divide-y divide-[#DCE5DC]">

                        @foreach ([
                            ['name' => 'Ember Drake Meat', 'qty' => '12 lbs', 'supplier' => 'Ironroot Provisioners'],
                            ['name' => 'Dragon Pepper', 'qty' => '4 jars', 'supplier' => 'Mystic Spice Co.'],
                            ['name' => 'Dwarven Black Ale', 'qty' => '2 barrels', 'supplier' => 'Stonehall Brewery'],
                        ] as $item)

                            <div class="flex items-center gap-3 p-4">

                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#E8F0E5] text-[#5E8067]">
                                    <x-tabler-package-import class="h-4 w-4" />
                                </div>

                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-[#26342A]">
                                        {{ $item['name'] }}
                                    </p>

                                    <p class="mt-0.5 truncate text-xs text-[#718076]">
                                        {{ $item['qty'] }} · {{ $item['supplier'] }}
                                    </p>
                                </div>

                                <span class="text-xs text-[#8A968D]">
                                    Today
                                </span>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>


    {{-- =========================================================
        STOCK
    ========================================================== --}}
    @elseif ($view === 'Stock')

        <div class="space-y-6">

            {{-- Stockroom header --}}
            <div class="grid gap-6 xl:grid-cols-[1fr_320px]">

                <div class="rounded-2xl border border-[#DCE5DC] bg-white p-6">

                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-[#8A968D]">
                                Stockroom
                            </p>

                            <h2 class="mt-1 text-xl font-semibold text-[#26342A]">
                                What's actually on hand?
                            </h2>

                            <p class="mt-1 text-sm text-[#718076]">
                                Live quantities across your kitchen, cellar, and dry stores.
                            </p>
                        </div>

                        <button
                            type="button"
                            wire:click="setView('Stock Adjustments')"
                            class="inline-flex items-center gap-2 rounded-full border border-[#DCE5DC] px-4 py-2.5 text-sm font-medium text-[#294936] hover:bg-[#F8FAF6]"
                        >
                            <x-tabler-clipboard-check class="h-4 w-4" />
                            Count stock
                        </button>

                    </div>

                    <div class="mt-6 grid gap-3 sm:grid-cols-3">

                        <div class="rounded-xl bg-[#F8FAF6] p-4">
                            <p class="text-xs text-[#718076]">On hand</p>
                            <p class="mt-1 text-lg font-semibold text-[#26342A]">48</p>
                            <p class="text-xs text-[#8A968D]">ingredients</p>
                        </div>

                        <div class="rounded-xl bg-[#FFFDF8] p-4">
                            <p class="text-xs text-[#718076]">Low stock</p>
                            <p class="mt-1 text-lg font-semibold text-[#B94A48]">5</p>
                            <p class="text-xs text-[#8A968D]">need review</p>
                        </div>

                        <div class="rounded-xl bg-[#F8FAF6] p-4">
                            <p class="text-xs text-[#718076]">Expiring soon</p>
                            <p class="mt-1 text-lg font-semibold text-[#9A762B]">7</p>
                            <p class="text-xs text-[#8A968D]">within 3 days</p>
                        </div>

                    </div>

                </div>


                <div class="rounded-2xl border border-[#DCE5DC] bg-[#294936] p-6 text-white">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                        <x-tabler-scale class="h-5 w-5" />
                    </div>

                    <p class="mt-5 text-xs font-medium uppercase tracking-wider text-white/60">
                        Inventory value
                    </p>

                    <p class="mt-1 text-3xl font-semibold">
                        4,860
                        <span class="text-sm font-medium text-white/60">
                            silver
                        </span>
                    </p>

                    <p class="mt-2 text-sm leading-6 text-white/70">
                        Based on current quantities and latest purchase costs.
                    </p>

                </div>

            </div>


            {{-- Stock table --}}
            <div class="overflow-hidden rounded-2xl border border-[#DCE5DC] bg-white">

                <div class="border-b border-[#DCE5DC] p-5">

                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                        <div>
                            <h3 class="font-semibold text-[#26342A]">
                                Current stock
                            </h3>

                            <p class="mt-1 text-sm text-[#718076]">
                                Quantities by storage location.
                            </p>
                        </div>

                        <div class="flex gap-2">

                            <button class="rounded-xl bg-[#F8FAF6] px-3 py-2 text-xs font-medium text-[#294936]">
                                All locations
                            </button>

                            <button class="rounded-xl border border-[#DCE5DC] px-3 py-2 text-xs font-medium text-[#718076]">
                                Expiring
                            </button>

                        </div>

                    </div>

                </div>

                <div class="overflow-x-auto">

                    <table class="w-full min-w-[800px]">

                        <thead class="bg-[#F8FAF6]">
                            <tr class="text-left text-[11px] font-semibold uppercase tracking-wider text-[#8A968D]">
                                <th class="px-5 py-3">Ingredient</th>
                                <th class="px-5 py-3">Location</th>
                                <th class="px-5 py-3">Quantity</th>
                                <th class="px-5 py-3">Unit cost</th>
                                <th class="px-5 py-3">Value</th>
                                <th class="px-5 py-3">Expiry</th>
                                <th class="px-5 py-3"></th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#DCE5DC]">

                            @foreach ([
                                ['Moonroot','Cold Room A','43 units','2.4 silver','103 silver','Tomorrow','critical'],
                                ['Ember Drake Meat','Butcher Room','12 lbs','18 silver','216 silver','2 days','healthy'],
                                ['Fireberries','Produce Room','18 baskets','7 silver','126 silver','4 days','healthy'],
                                ['Dragon Pepper','Dry Store','3 jars','12 silver','36 silver','28 days','healthy'],
                                ['Silverleaf','Produce Room','6 bundles','5 silver','30 silver','3 days','warning'],
                            ] as $stock)

                                <tr class="hover:bg-[#F8FAF6]">

                                    <td class="px-5 py-4 text-sm font-medium text-[#26342A]">
                                        {{ $stock[0] }}
                                    </td>

                                    <td class="px-5 py-4 text-sm text-[#718076]">
                                        {{ $stock[1] }}
                                    </td>

                                    <td class="px-5 py-4 text-sm font-medium text-[#26342A]">
                                        {{ $stock[2] }}
                                    </td>

                                    <td class="px-5 py-4 text-sm text-[#718076]">
                                        {{ $stock[3] }}
                                    </td>

                                    <td class="px-5 py-4 text-sm font-medium text-[#26342A]">
                                        {{ $stock[4] }}
                                    </td>

                                    <td class="px-5 py-4">

                                        <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium
                                            {{ $stock[6] === 'critical'
                                                ? 'bg-[#FDE8E7] text-[#B94A48]'
                                                : ($stock[6] === 'warning'
                                                    ? 'bg-[#FFF4DD] text-[#9A762B]'
                                                    : 'bg-[#E8F0E5] text-[#5E8067]') }}">

                                            {{ $stock[5] }}

                                        </span>

                                    </td>

                                    <td class="px-5 py-4 text-right">
                                        <button class="rounded-lg p-2 text-[#718076] hover:bg-[#E8F0E5] hover:text-[#294936]">
                                            <x-tabler-dots class="h-5 w-5" />
                                        </button>
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


    {{-- =========================================================
        RECIPES
    ========================================================== --}}
    @elseif ($view === 'Recipes')

        <div class="space-y-6">

            <div class="flex flex-col gap-4 rounded-2xl border border-[#DCE5DC] bg-white p-6 md:flex-row md:items-center md:justify-between">

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-[#8A968D]">
                        Recipe costing
                    </p>

                    <h2 class="mt-1 text-xl font-semibold text-[#26342A]">
                        Know what every dish really costs.
                    </h2>

                    <p class="mt-1 text-sm text-[#718076]">
                        Recipes connect menu items to ingredients, portions, and food cost.
                    </p>
                </div>

                <button class="inline-flex items-center gap-2 rounded-full bg-[#294936] px-4 py-2.5 text-sm font-medium text-white">
                    <x-tabler-plus class="h-4 w-4" />
                    New Recipe
                </button>

            </div>


            <div class="grid gap-4 md:grid-cols-3">

                <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5">
                    <p class="text-xs text-[#718076]">Average food cost</p>
                    <p class="mt-2 text-2xl font-semibold text-[#26342A]">28.4%</p>
                    <p class="mt-1 text-xs text-[#5E8067]">Across 36 recipes</p>
                </div>

                <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5">
                    <p class="text-xs text-[#718076]">Recipes needing review</p>
                    <p class="mt-2 text-2xl font-semibold text-[#9A762B]">4</p>
                    <p class="mt-1 text-xs text-[#718076]">Ingredient prices changed</p>
                </div>

                <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5">
                    <p class="text-xs text-[#718076]">Highest food cost</p>
                    <p class="mt-2 text-2xl font-semibold text-[#B94A48]">41.7%</p>
                    <p class="mt-1 text-xs text-[#718076]">Ember Drake Roast</p>
                </div>

            </div>


            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">

                @foreach ([
                    ['name' => 'Dragonfire Roast', 'category' => 'Main Course', 'cost' => '34 silver', 'food' => '26.2%', 'price' => '130 silver'],
                    ['name' => 'Moonroot Stew', 'category' => 'Soups', 'cost' => '18 silver', 'food' => '22.5%', 'price' => '80 silver'],
                    ['name' => 'Ember Drake Roast', 'category' => 'Signature', 'cost' => '67 silver', 'food' => '41.7%', 'price' => '160 silver'],
                    ['name' => 'Fireberry Tart', 'category' => 'Dessert', 'cost' => '12 silver', 'food' => '19.1%', 'price' => '65 silver'],
                    ['name' => 'Silverleaf Salad', 'category' => 'Starter', 'cost' => '9 silver', 'food' => '18.0%', 'price' => '50 silver'],
                    ['name' => 'Dwarven Ale Bread', 'category' => 'Side', 'cost' => '7 silver', 'food' => '16.8%', 'price' => '42 silver'],
                ] as $recipe)

                    <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5 transition hover:-translate-y-0.5 hover:border-[#C7D5C8] hover:shadow-sm">

                        <div class="flex items-start justify-between">

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#F1E9DF] text-[#7D6048]">
                                <x-tabler-chef-hat class="h-5 w-5" />
                            </div>

                            <button class="rounded-lg p-2 text-[#718076] hover:bg-[#F8FAF6]">
                                <x-tabler-dots class="h-5 w-5" />
                            </button>

                        </div>

                        <p class="mt-5 text-xs font-medium text-[#8A968D]">
                            {{ $recipe['category'] }}
                        </p>

                        <h3 class="mt-1 font-semibold text-[#26342A]">
                            {{ $recipe['name'] }}
                        </h3>

                        <div class="mt-5 grid grid-cols-2 gap-3">

                            <div class="rounded-xl bg-[#F8FAF6] p-3">
                                <p class="text-[11px] text-[#718076]">Cost / portion</p>
                                <p class="mt-1 text-sm font-semibold text-[#26342A]">
                                    {{ $recipe['cost'] }}
                                </p>
                            </div>

                            <div class="rounded-xl bg-[#F8FAF6] p-3">
                                <p class="text-[11px] text-[#718076]">Food cost</p>
                                <p class="mt-1 text-sm font-semibold
                                    {{ str_contains($recipe['food'], '41') ? 'text-[#B94A48]' : 'text-[#5E8067]' }}">
                                    {{ $recipe['food'] }}
                                </p>
                            </div>

                        </div>

                        <div class="mt-4 flex items-center justify-between border-t border-[#DCE5DC] pt-4">
                            <span class="text-xs text-[#718076]">
                                Menu price
                            </span>

                            <span class="text-sm font-semibold text-[#294936]">
                                {{ $recipe['price'] }}
                            </span>
                        </div>

                    </div>

                @endforeach

            </div>

        </div>


    {{-- =========================================================
        SUPPLIERS
    ========================================================== --}}
    @elseif ($view === 'Suppliers')

        <div class="space-y-6">

            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-[#8A968D]">
                        Procurement network
                    </p>

                    <h2 class="mt-1 text-xl font-semibold text-[#26342A]">
                        Suppliers
                    </h2>

                    <p class="mt-1 text-sm text-[#718076]">
                        Manage the merchants who keep your kitchens supplied.
                    </p>
                </div>

                <button class="inline-flex items-center gap-2 rounded-full bg-[#294936] px-4 py-2.5 text-sm font-medium text-white">
                    <x-tabler-plus class="h-4 w-4" />
                    Add Supplier
                </button>

            </div>


            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

                <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5">
                    <p class="text-xs text-[#718076]">Active suppliers</p>
                    <p class="mt-2 text-2xl font-semibold text-[#26342A]">12</p>
                </div>

                <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5">
                    <p class="text-xs text-[#718076]">Open orders</p>
                    <p class="mt-2 text-2xl font-semibold text-[#26342A]">3</p>
                </div>

                <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5">
                    <p class="text-xs text-[#718076]">This month's spend</p>
                    <p class="mt-2 text-2xl font-semibold text-[#26342A]">2,480 <span class="text-sm text-[#718076]">silver</span></p>
                </div>

                <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5">
                    <p class="text-xs text-[#718076]">Deliveries pending</p>
                    <p class="mt-2 text-2xl font-semibold text-[#9A762B]">2</p>
                </div>

            </div>


            <div class="grid gap-4 lg:grid-cols-2">

                @foreach ([
                    ['name' => 'Ironroot Provisioners', 'specialty' => 'Meat & Poultry', 'orders' => '18 orders', 'spend' => '1,240 silver', 'status' => 'Preferred'],
                    ['name' => 'Mystic Spice Co.', 'specialty' => 'Herbs & Spices', 'orders' => '9 orders', 'spend' => '420 silver', 'status' => 'Active'],
                    ['name' => 'Stonehall Brewery', 'specialty' => 'Ale & Beverages', 'orders' => '7 orders', 'spend' => '510 silver', 'status' => 'Active'],
                    ['name' => 'Moonvale Farms', 'specialty' => 'Produce', 'orders' => '14 orders', 'spend' => '680 silver', 'status' => 'Active'],
                ] as $supplier)

                    <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5">

                        <div class="flex items-start justify-between">

                            <div class="flex items-center gap-3">

                                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                                    <x-tabler-building-store class="h-5 w-5" />
                                </div>

                                <div>
                                    <h3 class="font-semibold text-[#26342A]">
                                        {{ $supplier['name'] }}
                                    </h3>

                                    <p class="mt-0.5 text-xs text-[#718076]">
                                        {{ $supplier['specialty'] }}
                                    </p>
                                </div>

                            </div>

                            <span class="rounded-full bg-[#E8F0E5] px-2.5 py-1 text-xs font-medium text-[#5E8067]">
                                {{ $supplier['status'] }}
                            </span>

                        </div>

                        <div class="mt-5 grid grid-cols-2 gap-3">

                            <div class="rounded-xl bg-[#F8FAF6] p-3">
                                <p class="text-[11px] text-[#718076]">Orders</p>
                                <p class="mt-1 text-sm font-semibold text-[#26342A]">
                                    {{ $supplier['orders'] }}
                                </p>
                            </div>

                            <div class="rounded-xl bg-[#F8FAF6] p-3">
                                <p class="text-[11px] text-[#718076]">Total spend</p>
                                <p class="mt-1 text-sm font-semibold text-[#26342A]">
                                    {{ $supplier['spend'] }}
                                </p>
                            </div>

                        </div>

                        <div class="mt-4 flex justify-end">
                            <button class="text-xs font-medium text-[#294936] hover:underline">
                                View supplier
                                <x-tabler-arrow-right class="inline h-3.5 w-3.5" />
                            </button>
                        </div>

                    </div>

                @endforeach

            </div>

        </div>


    {{-- =========================================================
        PURCHASE ORDERS
    ========================================================== --}}
    @elseif ($view === 'Purchase Orders')

        <div class="space-y-6">

            <div class="rounded-2xl border border-[#DCE5DC] bg-white p-6">

                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-[#8A968D]">
                            Procurement
                        </p>

                        <h2 class="mt-1 text-xl font-semibold text-[#26342A]">
                            Purchase orders
                        </h2>

                        <p class="mt-1 text-sm text-[#718076]">
                            Follow every order from requisition to delivery.
                        </p>
                    </div>

                    <button
                        wire:click="createPurchaseOrder"
                        class="inline-flex items-center gap-2 rounded-full bg-[#294936] px-4 py-2.5 text-sm font-medium text-white"
                    >
                        <x-tabler-plus class="h-4 w-4" />
                        New Purchase Order
                    </button>

                </div>


                <div class="mt-6 flex flex-wrap gap-2">

                    @foreach (['All', 'Draft', 'Ordered', 'Partially Received', 'Received'] as $status)

                        <button
                            class="rounded-full border border-[#DCE5DC] px-3.5 py-2 text-xs font-medium text-[#718076] transition hover:bg-[#F8FAF6] hover:text-[#294936]"
                        >
                            {{ $status }}
                        </button>

                    @endforeach

                </div>

            </div>


            <div class="overflow-hidden rounded-2xl border border-[#DCE5DC] bg-white">

                <div class="overflow-x-auto">

                    <table class="w-full min-w-[900px]">

                        <thead class="bg-[#F8FAF6]">
                            <tr class="text-left text-[11px] font-semibold uppercase tracking-wider text-[#8A968D]">
                                <th class="px-5 py-3">Order</th>
                                <th class="px-5 py-3">Supplier</th>
                                <th class="px-5 py-3">Items</th>
                                <th class="px-5 py-3">Total</th>
                                <th class="px-5 py-3">Expected</th>
                                <th class="px-5 py-3">Status</th>
                                <th class="px-5 py-3"></th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#DCE5DC]">

                            @foreach ([
                                ['PO-1048','Ironroot Provisioners','8 items','486 silver','Today','In transit','green'],
                                ['PO-1047','Moonvale Farms','12 items','328 silver','Tomorrow','Ordered','blue'],
                                ['PO-1046','Stonehall Brewery','4 items','210 silver','Sep 30','Ordered','blue'],
                                ['PO-1045','Mystic Spice Co.','6 items','148 silver','Sep 28','Partially received','yellow'],
                            ] as $po)

                                <tr class="hover:bg-[#F8FAF6]">

                                    <td class="px-5 py-4">
                                        <span class="text-sm font-semibold text-[#294936]">
                                            {{ $po[0] }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-4 text-sm text-[#26342A]">
                                        {{ $po[1] }}
                                    </td>

                                    <td class="px-5 py-4 text-sm text-[#718076]">
                                        {{ $po[2] }}
                                    </td>

                                    <td class="px-5 py-4 text-sm font-medium text-[#26342A]">
                                        {{ $po[3] }}
                                    </td>

                                    <td class="px-5 py-4 text-sm text-[#718076]">
                                        {{ $po[4] }}
                                    </td>

                                    <td class="px-5 py-4">

                                        <span class="rounded-full px-2.5 py-1 text-xs font-medium
                                            {{ $po[6] === 'green'
                                                ? 'bg-[#E8F0E5] text-[#5E8067]'
                                                : ($po[6] === 'yellow'
                                                    ? 'bg-[#FFF4DD] text-[#9A762B]'
                                                    : 'bg-[#EEF3F7] text-[#567184]') }}">

                                            {{ $po[5] }}

                                        </span>

                                    </td>

                                    <td class="px-5 py-4 text-right">
                                        <button class="rounded-lg p-2 text-[#718076] hover:bg-[#E8F0E5] hover:text-[#294936]">
                                            <x-tabler-chevron-right class="h-4 w-4" />
                                        </button>
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


    {{-- =========================================================
        STOCK ADJUSTMENTS
    ========================================================== --}}
    @elseif ($view === 'Stock Adjustments')

        <div class="space-y-6">

            <div class="grid gap-6 xl:grid-cols-[1fr_320px]">

                <div class="rounded-2xl border border-[#DCE5DC] bg-white p-6">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-[#8A968D]">
                                Inventory audit
                            </p>

                            <h2 class="mt-1 text-xl font-semibold text-[#26342A]">
                                Stock adjustments
                            </h2>

                            <p class="mt-1 text-sm text-[#718076]">
                                Every manual change to inventory, with a reason and record.
                            </p>
                        </div>

                        <button class="hidden rounded-full bg-[#294936] px-4 py-2.5 text-sm font-medium text-white sm:inline-flex">
                            <x-tabler-plus class="mr-2 h-4 w-4" />
                            New adjustment
                        </button>

                    </div>


                    <div class="mt-6 space-y-3">

                        @foreach ([
                            ['ingredient' => 'Moonroot', 'change' => '-5 units', 'reason' => 'Kitchen count correction', 'user' => 'Arannis · Chef', 'time' => '1 hr ago', 'negative' => true],
                            ['ingredient' => 'Ember Drake Meat', 'change' => '+3 lbs', 'reason' => 'Opening count', 'user' => 'Mira · Manager', 'time' => 'Yesterday', 'negative' => false],
                            ['ingredient' => 'Fireberries', 'change' => '-2 baskets', 'reason' => 'Damaged delivery', 'user' => 'Kael · Sous Chef', 'time' => 'Yesterday', 'negative' => true],
                            ['ingredient' => 'Dragon Pepper', 'change' => '+1 jar', 'reason' => 'Found during count', 'user' => 'Mira · Manager', 'time' => '2 days ago', 'negative' => false],
                        ] as $adjustment)

                            <div class="flex flex-col gap-3 rounded-xl border border-[#DCE5DC] p-4 sm:flex-row sm:items-center">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl
                                    {{ $adjustment['negative']
                                        ? 'bg-[#FDE8E7] text-[#B94A48]'
                                        : 'bg-[#E8F0E5] text-[#5E8067]' }}">

                                    @if ($adjustment['negative'])
                                        <x-tabler-arrow-down class="h-5 w-5" />
                                    @else
                                        <x-tabler-arrow-up class="h-5 w-5" />
                                    @endif

                                </div>

                                <div class="min-w-0 flex-1">

                                    <div class="flex flex-wrap items-center gap-2">

                                        <span class="text-sm font-semibold text-[#26342A]">
                                            {{ $adjustment['ingredient'] }}
                                        </span>

                                        <span class="text-sm font-semibold
                                            {{ $adjustment['negative'] ? 'text-[#B94A48]' : 'text-[#5E8067]' }}">
                                            {{ $adjustment['change'] }}
                                        </span>

                                    </div>

                                    <p class="mt-1 text-xs text-[#718076]">
                                        {{ $adjustment['reason'] }}
                                    </p>

                                    <p class="mt-1 text-[11px] text-[#9AA69D]">
                                        {{ $adjustment['user'] }} · {{ $adjustment['time'] }}
                                    </p>

                                </div>

                                <button class="text-xs font-medium text-[#718076] hover:text-[#294936]">
                                    View
                                </button>

                            </div>

                        @endforeach

                    </div>

                </div>


                <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#FFF4DD] text-[#9A762B]">
                        <x-tabler-clipboard-data class="h-5 w-5" />
                    </div>

                    <p class="mt-5 text-xs font-semibold uppercase tracking-wider text-[#8A968D]">
                        This month
                    </p>

                    <p class="mt-1 text-3xl font-semibold text-[#26342A]">
                        28
                    </p>

                    <p class="mt-1 text-sm text-[#718076]">
                        stock adjustments
                    </p>

                    <div class="my-5 h-px bg-[#DCE5DC]"></div>

                    <div class="space-y-4">

                        <div class="flex justify-between">
                            <span class="text-sm text-[#718076]">Positive</span>
                            <span class="text-sm font-medium text-[#5E8067]">11</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-sm text-[#718076]">Negative</span>
                            <span class="text-sm font-medium text-[#B94A48]">17</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-sm text-[#718076]">Net value</span>
                            <span class="text-sm font-medium text-[#26342A]">−74 silver</span>
                        </div>

                    </div>

                </div>

            </div>

        </div>


    {{-- =========================================================
        WASTE
    ========================================================== --}}
    @elseif ($view === 'Waste')

        <div class="space-y-6">

            <div class="grid gap-6 xl:grid-cols-[1fr_340px]">

                <div class="rounded-2xl border border-[#DCE5DC] bg-white p-6">

                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-[#8A968D]">
                                Loss tracking
                            </p>

                            <h2 class="mt-1 text-xl font-semibold text-[#26342A]">
                                Waste
                            </h2>

                            <p class="mt-1 text-sm text-[#718076]">
                                Understand what is being lost and why.
                            </p>
                        </div>

                        <button
                            wire:click="recordWaste(1)"
                            class="inline-flex items-center gap-2 rounded-full bg-[#294936] px-4 py-2.5 text-sm font-medium text-white"
                        >
                            <x-tabler-trash class="h-4 w-4" />
                            Record Waste
                        </button>

                    </div>


                    <div class="mt-6 grid gap-3 sm:grid-cols-3">

                        <div class="rounded-xl bg-[#FDE8E7] p-4">
                            <p class="text-xs text-[#718076]">Total waste</p>
                            <p class="mt-1 text-xl font-semibold text-[#B94A48]">
                                186 silver
                            </p>
                        </div>

                        <div class="rounded-xl bg-[#F8FAF6] p-4">
                            <p class="text-xs text-[#718076]">Waste events</p>
                            <p class="mt-1 text-xl font-semibold text-[#26342A]">
                                34
                            </p>
                        </div>

                        <div class="rounded-xl bg-[#FFFDF8] p-4">
                            <p class="text-xs text-[#718076]">Largest cause</p>
                            <p class="mt-1 text-xl font-semibold text-[#9A762B]">
                                Spoilage
                            </p>
                        </div>

                    </div>

                </div>


                {{-- Waste breakdown --}}
                <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5">

                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-[#26342A]">
                            Waste by reason
                        </h3>

                        <x-tabler-chart-donut class="h-5 w-5 text-[#8A968D]" />
                    </div>

                    <div class="mt-5 space-y-4">

                        @foreach ([
                            ['label' => 'Spoilage', 'value' => '82 silver', 'width' => '72%'],
                            ['label' => 'Preparation', 'value' => '46 silver', 'width' => '48%'],
                            ['label' => 'Overproduction', 'value' => '31 silver', 'width' => '32%'],
                            ['label' => 'Damaged', 'value' => '18 silver', 'width' => '20%'],
                            ['label' => 'Other', 'value' => '9 silver', 'width' => '10%'],
                        ] as $reason)

                            <div>

                                <div class="flex items-center justify-between text-xs">

                                    <span class="font-medium text-[#26342A]">
                                        {{ $reason['label'] }}
                                    </span>

                                    <span class="text-[#718076]">
                                        {{ $reason['value'] }}
                                    </span>

                                </div>

                                <div class="mt-2 h-1.5 rounded-full bg-[#F1E9DF]">
                                    <div
                                        class="h-full rounded-full bg-[#B94A48]"
                                        style="width: {{ $reason['width'] }}"
                                    ></div>
                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>


            {{-- Waste log --}}
            <div class="overflow-hidden rounded-2xl border border-[#DCE5DC] bg-white">

                <div class="border-b border-[#DCE5DC] p-5">

                    <div class="flex items-center justify-between">

                        <div>
                            <h3 class="font-semibold text-[#26342A]">
                                Recent waste
                            </h3>

                            <p class="mt-1 text-sm text-[#718076]">
                                Latest recorded inventory losses.
                            </p>
                        </div>

                        <button class="text-xs font-medium text-[#294936] hover:underline">
                            Export report
                        </button>

                    </div>

                </div>


                <div class="overflow-x-auto">

                    <table class="w-full min-w-[760px]">

                        <thead class="bg-[#F8FAF6]">

                            <tr class="text-left text-[11px] font-semibold uppercase tracking-wider text-[#8A968D]">
                                <th class="px-5 py-3">Ingredient</th>
                                <th class="px-5 py-3">Quantity</th>
                                <th class="px-5 py-3">Value</th>
                                <th class="px-5 py-3">Reason</th>
                                <th class="px-5 py-3">Recorded by</th>
                                <th class="px-5 py-3">Time</th>
                            </tr>

                        </thead>

                        <tbody class="divide-y divide-[#DCE5DC]">

                            @foreach ([
                                ['Fireberries','2 baskets','14 silver','Spoilage','Kael','42 min ago'],
                                ['Ember Drake Meat','1.5 lbs','27 silver','Preparation','Arannis','2 hrs ago'],
                                ['Moonroot','4 units','10 silver','Damaged','Mira','Yesterday'],
                                ['Silverleaf','2 bundles','10 silver','Spoilage','Kael','Yesterday'],
                                ['Dragon Pepper','1 jar','12 silver','Expired','Mira','2 days ago'],
                            ] as $waste)

                                <tr class="hover:bg-[#F8FAF6]">

                                    <td class="px-5 py-4 text-sm font-medium text-[#26342A]">
                                        {{ $waste[0] }}
                                    </td>

                                    <td class="px-5 py-4 text-sm text-[#718076]">
                                        {{ $waste[1] }}
                                    </td>

                                    <td class="px-5 py-4 text-sm font-medium text-[#B94A48]">
                                        {{ $waste[2] }}
                                    </td>

                                    <td class="px-5 py-4">
                                        <span class="rounded-full bg-[#FDE8E7] px-2.5 py-1 text-xs font-medium text-[#B94A48]">
                                            {{ $waste[3] }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-4 text-sm text-[#718076]">
                                        {{ $waste[4] }}
                                    </td>

                                    <td class="px-5 py-4 text-sm text-[#8A968D]">
                                        {{ $waste[5] }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    @endif

</div>