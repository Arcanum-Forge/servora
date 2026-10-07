{{-- pos/⚡index/index.blade.php --}}

<div>

    @php
        use Illuminate\Support\Str;

        $subtotal = (float) ($order?->subtotal ?? 0);
        $serviceCharge = (float) ($order?->service_charge ?? 0);
        $tax = (float) ($order?->tax ?? 0);
        $total = (float) ($order?->total ?? 0);
        $itemCount = (int) ($order?->items->sum('quantity') ?? 0);
        $canCharge = $diningTableId && $order && $order->items->isNotEmpty() && $order->status === 'open';

        $pickChip = 'inline-flex rounded-full border border-[#DCE5DC] bg-[#F8FAF6] px-4 py-2 text-sm font-medium text-[#718076] transition peer-checked:border-[#294936] peer-checked:bg-[#294936] peer-checked:text-white';
    @endphp

    {{-- Page header --}}
    <div class="mb-6">
        <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-sm text-[#718076]">
            <span>Operations</span>
            <x-tabler-chevron-right class="h-4 w-4 text-[#C8D8C9]" />
            <span>Point of Sale</span>
            <x-tabler-chevron-right class="h-4 w-4 text-[#C8D8C9]" />
            <span class="font-medium text-[#183524]">{{ $order?->diningTable?->name ?? 'No table' }}</span>
        </nav>
        <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#183524]">Point of Sale</h1>
        <p class="mt-1 text-sm text-[#718076]">Take orders, adjust quantities and collect payment for a table.</p>
    </div>


    @if ($supplyNotices->isNotEmpty())
        <div class="mb-6 flex items-start gap-3 rounded-2xl border border-[#E5DCC8] bg-[#FBF7EE] px-4 py-3">
            <x-tabler-alert-triangle class="mt-0.5 h-4 w-4 shrink-0 text-[#9A7B45]" />
    
            <div class="min-w-0 text-[#5E4A2F]">
                <p class="text-sm font-semibold">Supply notice</p>
                <ul class="mt-1 space-y-0.5 text-xs">
                    @foreach ($supplyNotices->take(3) as $impact)
                        <li wire:key="supply-notice-{{ $impact->id }}">
                            <strong class="font-semibold">{{ $impact->threatReport?->title }}:</strong>
                            {{ $impact->ingredient->name }}
                            {{ $impact->effect === 'unavailable' ? 'is unavailable.' : 'is in limited supply.' }}
                        </li>
                    @endforeach
                    @if ($supplyNotices->count() > 3)
                        <li>and {{ $supplyNotices->count() - 3 }} more.</li>
                    @endif
                </ul>
            </div>
        </div>
    @endif

    {{-- Hero --}}
    <div class="rounded-3xl bg-[#294936] p-6 text-white sm:p-7">

        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/10">
                    <x-tabler-cash-register class="h-6 w-6" />
                </div>
                <div>
                    <h2 class="text-2xl font-bold tracking-tight">
                        {{ $order?->diningTable?->name ?? 'Select a table' }}
                    </h2>
                    <p class="mt-0.5 text-sm text-white/60">
                        {{ $order ? $order->order_number : ($diningTableId ? 'No order started' : 'No table selected') }}
                        · {{ now()->format('l, d F') }}
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <button type="button" wire:click="openTablePicker"
                    class="inline-flex items-center gap-2 rounded-full {{ $diningTableId ? 'border border-white/20 bg-white/10 text-white hover:bg-white/20' : 'bg-white font-semibold text-[#183524] hover:bg-[#E8F0E5]' }} px-5 py-2.5 text-sm font-medium transition">
                    <x-tabler-armchair class="h-4 w-4" />
                    {{ $diningTableId ? 'Change table' : 'Choose table' }}
                </button>
            </div>

        </div>

        @php
            $tiles = [
                ['Status', $diningTableId ? ($order ? Str::headline($order->status) : 'Ready') : 'Locked', 'circle-check'],
                ['Guests', $guestCount, 'users'],
                ['Items', $itemCount, 'shopping-bag'],
                ['Total (silver)', number_format($total, 2), 'coins'],
            ];
        @endphp
        <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-4">
            @foreach ($tiles as [$tileLabel, $tileValue, $tileIcon])
                <div class="rounded-2xl bg-white/10 px-4 py-3">
                    <div class="flex items-center justify-between">
                        <p class="text-[11px] font-medium uppercase tracking-wide text-white/60">{{ $tileLabel }}</p>
                        <x-dynamic-component :component="'tabler-'.$tileIcon" class="h-4 w-4 text-white/40" />
                    </div>
                    <p class="mt-1 text-3xl font-bold leading-none">{{ $tileValue }}</p>
                </div>
            @endforeach
        </div>

    </div>

    {{-- Category tabs + search --}}
    <div class="mt-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between {{ $diningTableId ? '' : 'opacity-60' }}">

        <div class="inline-flex max-w-full self-start overflow-x-auto rounded-full bg-[#F0F3EF] p-1 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">

            <button type="button" wire:click="$set('activeCategory', 'All')" @disabled(!$diningTableId)
                class="inline-flex shrink-0 items-center gap-2 rounded-full px-4 py-2 text-sm font-medium transition disabled:cursor-not-allowed
                        {{ $activeCategory === 'All' ? 'bg-white text-[#183524] shadow-sm' : 'text-[#718076] hover:text-[#294936]' }}">
                <x-tabler-layout-grid class="h-4 w-4" />
                All
            </button>

            @foreach ($categories as $category)
                <button type="button" wire:click="$set('activeCategory', @js($category->name))" @disabled(!$diningTableId)
                    class="inline-flex shrink-0 items-center gap-2 rounded-full px-4 py-2 text-sm font-medium transition disabled:cursor-not-allowed
                            {{ $activeCategory === $category->name ? 'bg-white text-[#183524] shadow-sm' : 'text-[#718076] hover:text-[#294936]' }}">

                    @switch($category->icon)
                        @case('flame')
                            <x-tabler-flame class="h-4 w-4" />
                        @break
                        @case('soup')
                            <x-tabler-soup class="h-4 w-4" />
                        @break
                        @case('glass')
                        @case('glass-full')
                            <x-tabler-glass-full class="h-4 w-4" />
                        @break
                        @case('cake')
                            <x-tabler-cake class="h-4 w-4" />
                        @break
                        @default
                            <x-tabler-bowl-spoon class="h-4 w-4" />
                    @endswitch

                    {{ $category->name }}
                    <span class="text-[10px] text-[#8FA58B]">{{ $category->items_count }}</span>
                </button>
            @endforeach

        </div>

        <div class="relative">
            <x-tabler-search class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8FA58B]" />
            <input type="search" wire:model.live.debounce.250ms="search" placeholder="Search dishes…" @disabled(!$diningTableId)
                class="w-full rounded-full border border-[#DCE5DC] bg-white py-2.5 pl-10 pr-10 text-sm text-[#26342A] outline-none placeholder:text-[#9AA79D] focus:border-[#8FA58B] focus:ring-2 focus:ring-[#E8F0E5] disabled:cursor-not-allowed disabled:bg-[#F1F4F1] sm:w-64" />
            <div wire:loading wire:target="search" class="absolute right-3.5 top-1/2 -translate-y-1/2">
                <svg class="h-4 w-4 animate-spin text-[#5E8067]" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
            </div>
        </div>

    </div>

    {{-- Workspace --}}
    <div class="mt-6 grid gap-6 xl:grid-cols-[1fr_380px]">

        {{-- ===================== MENU ===================== --}}
        <section class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-[#E6EDE6]">

            <div class="flex flex-col gap-1 border-b border-[#F0F3EF] p-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-bold text-[#183524]">Menu</h2>
                    <p class="mt-0.5 text-xs text-[#718076]">
                        @if ($diningTableId)
                            Tap a dish to add it to the order.
                        @else
                            Choose a table before adding dishes.
                        @endif
                    </p>
                </div>
                <span class="text-xs text-[#8FA58B]">{{ $menuItems->count() }} {{ Str::plural('dish', $menuItems->count()) }}</span>
            </div>

            {{-- Table required notice --}}
            @unless ($diningTableId)
                <div class="flex items-center gap-3 border-b border-[#E5DCC8] bg-[#FBF7EE] px-5 py-3">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#F3E8D1] text-[#9A7B45]">
                        <x-tabler-armchair-2 class="h-4 w-4" />
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-[#5E4A2F]">Select a dining table</p>
                        <p class="mt-0.5 text-xs text-[#8A968D]">Orders are attached to a table.</p>
                    </div>
                    <button type="button" wire:click="openTablePicker"
                        class="ml-auto inline-flex shrink-0 items-center gap-1.5 rounded-full bg-[#294936] px-4 py-2 text-xs font-semibold text-white transition hover:bg-[#183524]">
                        Choose table
                        <x-tabler-arrow-right class="h-3.5 w-3.5" />
                    </button>
                </div>
            @endunless

            <div class="bg-[#F8FAF6] p-4 sm:p-5">

                @if ($menuItems->isNotEmpty())

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 2xl:grid-cols-3">

                        @foreach ($menuItems as $item)

                            @php
                                $customizable = $item->modifierGroups->isNotEmpty();
                            @endphp

                            <button type="button"
                                wire:key="menu-item-{{ $item->id }}"
                                wire:click="addToOrder({{ $item->id }})"
                                wire:loading.attr="disabled"
                                wire:target="addToOrder({{ $item->id }})"
                                @disabled(!$diningTableId)
                                class="group relative flex min-h-[200px] flex-col overflow-hidden rounded-2xl bg-white p-5 text-left shadow-sm ring-1 ring-[#E6EDE6] transition hover:shadow-md disabled:pointer-events-none disabled:cursor-not-allowed">

                                <div class="flex flex-1 flex-col transition {{ $diningTableId ? '' : 'opacity-45' }}">

                                    <div class="flex items-start justify-between gap-4">

                                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#5E8067]">
                                            <x-dynamic-component :component="'tabler-' . ($item->icon ?: 'bowl-spoon')" class="h-5 w-5" />
                                        </div>

                                        <span class="shrink-0 text-sm font-bold text-[#183524]">
                                            {{ number_format($item->price, 2) }}
                                            <span class="text-[10px] font-medium text-[#8A968D]">silver</span>
                                        </span>

                                    </div>

                                    <div class="mt-4">
                                        <h3 class="font-bold text-[#183524]">{{ $item->name }}</h3>
                                        <p class="mt-1.5 line-clamp-3 text-xs leading-5 text-[#718076]">{{ $item->description }}</p>
                                    </div>

                                    <div class="mt-auto flex items-center justify-between gap-2 pt-4">

                                        <div class="flex min-w-0 flex-wrap items-center gap-1.5">
                                            <span class="inline-flex items-center rounded-full bg-[#F8FAF6] px-2.5 py-1 text-[11px] font-semibold text-[#718076]">
                                                {{ $item->category->name }}
                                            </span>

                                            @if ($customizable)
                                                <span class="inline-flex items-center gap-1 rounded-full bg-[#E8F0E5] px-2.5 py-1 text-[11px] font-semibold text-[#5E8067]">
                                                    <x-tabler-adjustments-horizontal class="h-3 w-3" />
                                                    Options
                                                </span>
                                            @endif

                                            @if ($item->supply_status === 'limited')
                                                <span title="{{ $item->availability_reason }}"
                                                    class="inline-flex items-center rounded-full bg-[#FFF4DD] px-2.5 py-1 text-[11px] font-semibold text-[#9A762B]">
                                                    Limited supply
                                                </span>
                                            @endif

                                            @if ($item->servings_left !== null && $item->servings_left <= \App\Models\MenuItem::LOW_SERVINGS)
                                                <span class="inline-flex items-center rounded-full bg-[#FFF4DD] px-2.5 py-1 text-[11px] font-semibold text-[#9A762B]">
                                                    {{ $item->servings_left }} left
                                                </span>
                                            @endif
                                        </div>

                                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#E8F0E5] text-[#294936] transition group-hover:bg-[#294936] group-hover:text-white">
                                            <x-tabler-plus class="h-4 w-4" />
                                        </span>

                                    </div>

                                </div>

                                {{-- Locked overlay --}}
                                @unless ($diningTableId)
                                    <div class="absolute inset-0 z-10 flex items-center justify-center bg-white/60 backdrop-blur-[2px]">
                                        <div class="flex items-center gap-2 rounded-full border border-[#E5DCC8] bg-[#FBF7EE] px-3.5 py-2 text-xs font-semibold text-[#5E4A2F] shadow-sm">
                                            <x-tabler-lock class="h-3.5 w-3.5 text-[#9A7B45]" />
                                            Select a table first
                                        </div>
                                    </div>
                                @endunless

                                {{-- Loading overlay --}}
                                <div wire:loading wire:target="addToOrder({{ $item->id }})"
                                    class="absolute inset-0 z-20 flex items-center justify-center rounded-2xl bg-white/75 backdrop-blur-[1px]">
                                    <div class="flex items-center gap-2 rounded-full border border-[#DCE5DC] bg-white px-3.5 py-2 text-xs font-semibold text-[#294936] shadow-sm">
                                        <svg class="h-4 w-4 animate-spin text-[#294936]" viewBox="0 0 24 24" fill="none">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                        </svg>
                                        Adding…
                                    </div>
                                </div>

                            </button>

                        @endforeach

                    </div>

                @else

                    <div class="flex min-h-[320px] items-center justify-center">
                        <div class="max-w-sm text-center">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white ring-1 ring-[#E6EDE6]">
                                <x-tabler-search-off class="h-6 w-6 text-[#8FA58B]" />
                            </div>
                            <p class="mt-3 text-sm font-medium text-[#294936]">No dishes found</p>
                            <p class="mt-1 text-xs text-[#8FA58B]">Try another search or choose a different category. Dishes that are switched off, out of stock or affected by a supply disruption are hidden.</p>

                            @if (filled($search))
                                <button type="button" wire:click="$set('search', '')"
                                    class="mt-4 rounded-full border border-[#DCE5DC] bg-white px-4 py-2 text-xs font-semibold text-[#294936] transition hover:bg-[#F8FAF6]">
                                    Clear search
                                </button>
                            @endif
                        </div>
                    </div>

                @endif

            </div>

        </section>


        {{-- ===================== ORDER ===================== --}}
        <aside class="self-start xl:sticky xl:top-6">

            <section class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-[#E6EDE6]">

                {{-- Header --}}
                <div class="p-5">

                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#E8F0E5] text-[#294936]">
                                <x-tabler-receipt class="h-5 w-5" />
                            </div>
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-[#8FA58B]">Current order</p>
                                <h2 class="text-lg font-bold leading-tight text-[#183524]">
                                    {{ $order?->diningTable?->name ?? 'Table' }}
                                </h2>
                            </div>
                        </div>

                        @if ($order && $order->status === 'open')
                            <button type="button" wire:click="clearOrder" wire:confirm="Clear all items from this order?"
                                class="rounded-full px-3 py-1.5 text-xs font-medium text-[#B94A48] transition hover:bg-[#FBEAEA]">
                                Clear
                            </button>
                        @endif
                    </div>

                    {{-- Guests --}}
                    <div class="mt-5 flex items-center justify-between rounded-2xl bg-[#F8FAF6] p-3">

                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-white shadow-sm">
                                <x-tabler-users class="h-4 w-4 {{ $diningTableId ? 'text-[#5E8067]' : 'text-[#A1ACA3]' }}" />
                            </div>
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-wide text-[#8A968D]">Guests</p>
                                <p class="mt-0.5 text-sm font-semibold {{ $diningTableId ? 'text-[#183524]' : 'text-[#A1ACA3]' }}">
                                    {{ $guestCount }} {{ Str::plural('guest', $guestCount) }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center rounded-full border border-[#DCE5DC] bg-white p-0.5">
                            <button type="button" wire:click="decreaseGuests" @disabled(!$diningTableId)
                                class="flex h-8 w-8 items-center justify-center rounded-full text-[#718076] transition hover:bg-[#F8FAF6] hover:text-[#294936] disabled:cursor-not-allowed disabled:opacity-50">
                                <x-tabler-minus class="h-3.5 w-3.5" />
                            </button>
                            <span class="flex h-8 min-w-8 items-center justify-center text-xs font-bold text-[#183524]">{{ $guestCount }}</span>
                            <button type="button" wire:click="increaseGuests" @disabled(!$diningTableId)
                                class="flex h-8 w-8 items-center justify-center rounded-full text-[#718076] transition hover:bg-[#F8FAF6] hover:text-[#294936] disabled:cursor-not-allowed disabled:opacity-50">
                                <x-tabler-plus class="h-3.5 w-3.5" />
                            </button>
                        </div>

                    </div>

                </div>

                {{-- Items --}}
                <div class="max-h-[380px] min-h-[200px] overflow-y-auto border-t border-[#F0F3EF]">

                    @if ($order && $order->items->isNotEmpty())

                        @foreach ($order->items as $orderItem)

                            <div wire:key="order-item-{{ $orderItem->id }}" class="border-b border-[#F0F3EF] px-5 py-4 last:border-b-0">

                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-[#183524]">{{ $orderItem->menuItem->name }}</p>

                                        @if ($orderItem->modifiers->isNotEmpty())
                                            <p class="mt-0.5 text-xs text-[#5E8067]">{{ $orderItem->modifier_summary }}</p>
                                        @endif

                                        @if (filled($orderItem->notes))
                                            <p class="mt-0.5 text-xs italic text-[#8A968D]">“{{ $orderItem->notes }}”</p>
                                        @endif

                                        <p class="mt-0.5 text-xs text-[#8A968D]">{{ number_format($orderItem->unit_price, 2) }} silver each</p>
                                    </div>
                                    <p class="shrink-0 text-sm font-bold text-[#183524]">
                                        {{ number_format($orderItem->subtotal, 2) }}
                                        <span class="text-[10px] font-medium text-[#8A968D]">silver</span>
                                    </p>
                                </div>

                                <div class="mt-3 flex items-center justify-between">

                                    <button type="button" wire:click="removeFromOrder({{ $orderItem->id }})"
                                        class="rounded-full px-2.5 py-1 text-xs font-medium text-[#B94A48] transition hover:bg-[#FBEAEA]">
                                        Remove
                                    </button>

                                    <div class="flex items-center rounded-full border border-[#DCE5DC] p-0.5">
                                        <button type="button" wire:click="decreaseQuantity({{ $orderItem->id }})"
                                            class="flex h-7 w-7 items-center justify-center rounded-full text-[#718076] transition hover:bg-[#F8FAF6] hover:text-[#294936]">
                                            <x-tabler-minus class="h-3.5 w-3.5" />
                                        </button>
                                        <span class="flex h-7 min-w-8 items-center justify-center text-xs font-bold text-[#183524]">{{ $orderItem->quantity }}</span>
                                        <button type="button" wire:click="increaseQuantity({{ $orderItem->id }})"
                                            class="flex h-7 w-7 items-center justify-center rounded-full text-[#718076] transition hover:bg-[#F8FAF6] hover:text-[#294936]">
                                            <x-tabler-plus class="h-3.5 w-3.5" />
                                        </button>
                                    </div>

                                </div>

                            </div>

                        @endforeach

                    @else

                        <div class="flex min-h-[200px] flex-col items-center justify-center px-8 py-8 text-center">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#F8FAF6]">
                                @if ($diningTableId)
                                    <x-tabler-shopping-bag class="h-6 w-6 text-[#8FA58B]" />
                                @else
                                    <x-tabler-lock class="h-6 w-6 text-[#8FA58B]" />
                                @endif
                            </div>
                            <p class="mt-3 text-sm font-medium text-[#294936]">
                                {{ $diningTableId ? 'Your order is empty' : 'No table selected' }}
                            </p>
                            <p class="mt-1 max-w-xs text-xs text-[#8FA58B]">
                                {{ $diningTableId ? 'Choose dishes from the menu to start this order.' : 'Select a dining table to start an order.' }}
                            </p>

                            @unless ($diningTableId)
                                <button type="button" wire:click="openTablePicker"
                                    class="mt-4 inline-flex items-center gap-2 rounded-full bg-[#294936] px-4 py-2 text-xs font-semibold text-white transition hover:bg-[#183524]">
                                    Choose table
                                    <x-tabler-arrow-right class="h-3.5 w-3.5" />
                                </button>
                            @endunless
                        </div>

                    @endif

                </div>

                {{-- Payment --}}
                <div class="border-t border-[#F0F3EF] p-5">

                    <div class="space-y-2.5 rounded-2xl bg-[#F8FAF6] p-4 {{ $diningTableId ? '' : 'opacity-50' }}">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-[#718076]">Subtotal</span>
                            <span class="font-medium text-[#183524]">{{ number_format($subtotal, 2) }} silver</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-[#718076]">Service charge <span class="text-[10px] text-[#A1ACA3]">(10%)</span></span>
                            <span class="font-medium text-[#183524]">{{ number_format($serviceCharge, 2) }} silver</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-[#718076]">Tax <span class="text-[10px] text-[#A1ACA3]">(10%)</span></span>
                            <span class="font-medium text-[#183524]">{{ number_format($tax, 2) }} silver</span>
                        </div>
                        <div class="flex items-end justify-between border-t border-[#DCE5DC] pt-3">
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-wide text-[#8FA58B]">Total</p>
                                <p class="mt-0.5 text-2xl font-bold leading-none tracking-tight text-[#183524]">
                                    {{ number_format($total, 2) }}
                                    <span class="text-sm font-semibold text-[#718076]">silver</span>
                                </p>
                            </div>
                            <span class="text-xs text-[#8A968D]">{{ $itemCount }} {{ Str::plural('item', $itemCount) }}</span>
                        </div>
                    </div>

                    {{-- Payment method (segmented, like the tabs) --}}
                    <div class="mt-4 inline-flex w-full rounded-full bg-[#F0F3EF] p-1 {{ $diningTableId ? '' : 'opacity-50' }}">
                        <button type="button" wire:click="selectPaymentMethod('cash')" @disabled(!$diningTableId)
                            class="inline-flex flex-1 items-center justify-center gap-2 rounded-full px-4 py-2 text-sm font-medium transition disabled:cursor-not-allowed
                                    {{ $paymentMethod === 'cash' ? 'bg-white text-[#183524] shadow-sm' : 'text-[#718076] hover:text-[#294936]' }}">
                            <x-tabler-cash class="h-4 w-4" />
                            Cash
                        </button>
                        <button type="button" wire:click="selectPaymentMethod('card')" @disabled(!$diningTableId)
                            class="inline-flex flex-1 items-center justify-center gap-2 rounded-full px-4 py-2 text-sm font-medium transition disabled:cursor-not-allowed
                                    {{ $paymentMethod === 'card' ? 'bg-white text-[#183524] shadow-sm' : 'text-[#718076] hover:text-[#294936]' }}">
                            <x-tabler-credit-card class="h-4 w-4" />
                            Card
                        </button>
                    </div>

                    {{-- Charge --}}
                    <button type="button" wire:click="charge" wire:loading.attr="disabled" wire:target="charge" @disabled(!$canCharge)
                        class="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-full bg-[#294936] px-5 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#183524] disabled:cursor-not-allowed disabled:bg-[#B9C5BA]">

                        <span wire:loading.remove wire:target="charge">
                            @if ($canCharge)
                                Charge {{ number_format($total, 2) }} silver
                            @elseif ($diningTableId)
                                Add dishes to charge
                            @else
                                Select a table
                            @endif
                        </span>

                        <span wire:loading wire:target="charge" class="inline-flex items-center gap-2">
                            <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                            Processing…
                        </span>

                    </button>

                </div>

            </section>

        </aside>

    </div>

    {{-- Table picker modal --}}
    @if ($showTablePicker)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
            wire:click.self="closeTablePicker">

            <div class="max-h-[90vh] w-full max-w-5xl overflow-y-auto rounded-3xl bg-white p-6 shadow-xl">

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                            <x-tabler-armchair class="h-5 w-5" />
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-[#183524]">Choose a table</h2>
                            <p class="text-xs text-[#718076]">Pick an occupied table to continue its order, or a free one to start a new order.</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        @if ($halls->count() > 1)
                            <div class="relative">
                                <select wire:model.live="pickerHallId"
                                    class="appearance-none rounded-full border border-[#DCE5DC] bg-white py-2 pl-4 pr-9 text-sm text-[#294936] outline-none focus:border-[#8FA58B] focus:ring-2 focus:ring-[#E8F0E5]">
                                    @foreach ($halls as $hall)
                                        <option value="{{ $hall->id }}">{{ $hall->name }}</option>
                                    @endforeach
                                </select>
                                <x-tabler-chevron-down class="pointer-events-none absolute right-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8FA58B]" />
                            </div>
                        @endif

                        <button wire:click="closeTablePicker" type="button"
                            class="flex h-8 w-8 items-center justify-center rounded-full text-[#8FA58B] hover:bg-[#F8FAF6]">
                            <x-tabler-x class="h-4 w-4" />
                        </button>
                    </div>
                </div>

                <div class="mt-5">
                    <x-floor-table-picker
                        :tables="$pickerTables"
                        :elements="$pickerElements"
                        :selected="$diningTableId"
                        model="diningTableId"
                        wire:key="pos-picker-{{ $pickerHallId }}"
                    />
                </div>

            </div>

        </div>
    @endif

    {{-- Dish customization modal --}}
    @if ($picking)

        @php $maxPick = $picking->servings_left ?? 99; @endphp

        <div class="fixed inset-0 z-50 flex items-end justify-center bg-black/40 p-4 sm:items-center"
            wire:click.self="closePicker">

            <div class="max-h-[90vh] w-full max-w-md overflow-y-auto rounded-3xl bg-white p-6 shadow-xl">

                {{-- Header --}}
                <div class="flex items-start gap-4">

                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#E8F0E5] text-[#5E8067]">
                        <x-dynamic-component :component="'tabler-' . ($picking->icon ?: 'bowl-spoon')" class="h-6 w-6" />
                    </div>

                    <div class="min-w-0 flex-1">
                        <h2 class="text-lg font-bold text-[#183524]">{{ $picking->name }}</h2>
                        <p class="mt-0.5 text-sm text-[#718076]">{{ number_format($picking->price, 2) }} silver</p>
                    </div>

                    <button type="button" wire:click="closePicker" aria-label="Close"
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-[#8FA58B] hover:bg-[#F8FAF6]">
                        <x-tabler-x class="h-4 w-4" />
                    </button>

                </div>

                {{-- Groups --}}
                <div class="mt-6 space-y-5">

                    @foreach ($picking->modifierGroups as $group)

                        <div wire:key="pick-group-{{ $group->id }}">

                            <div class="mb-2 flex items-center justify-between">
                                <p class="text-sm font-bold text-[#183524]">{{ $group->name }}</p>
                                <span class="text-[11px] {{ $group->is_required ? 'font-semibold text-[#9A762B]' : 'text-[#8FA58B]' }}">
                                    {{ $group->is_required ? 'Required' : 'Optional' }}
                                    · {{ $group->type === 'multiple' ? 'choose any' : 'choose one' }}
                                </span>
                            </div>

                            <div class="flex flex-wrap gap-2">

                                @foreach ($group->options as $option)

                                    <label class="cursor-pointer" wire:key="pick-option-{{ $option->id }}">

                                        @if ($group->type === 'multiple')
                                            <input type="checkbox" class="peer sr-only"
                                                value="{{ $option->id }}"
                                                wire:model.live="pickSelected.{{ $group->id }}">
                                        @else
                                            <input type="radio" class="peer sr-only"
                                                name="pick-group-{{ $group->id }}"
                                                value="{{ $option->id }}"
                                                wire:model.live="pickSelected.{{ $group->id }}">
                                        @endif

                                        <span class="{{ $pickChip }}">
                                            {{ $option->name }}
                                            @if ((float) $option->price_delta !== 0.0)
                                                <span class="ml-1 opacity-70">{{ $option->price_delta > 0 ? '+' : '' }}{{ rtrim(rtrim(number_format((float) $option->price_delta, 2), '0'), '.') }}</span>
                                            @endif
                                        </span>

                                    </label>

                                @endforeach

                            </div>

                        </div>

                    @endforeach

                    <div>
                        <label class="mb-1.5 block text-sm font-bold text-[#183524]">
                            Kitchen note <span class="text-[11px] font-normal text-[#8FA58B]">(optional)</span>
                        </label>
                        <input type="text" wire:model="pickNotes" maxlength="200" placeholder="No onions, allergy, etc."
                            class="w-full rounded-full border border-[#DCE5DC] bg-white px-4 py-2.5 text-sm text-[#26342A] outline-none placeholder:text-[#9AA79D] focus:border-[#8FA58B] focus:ring-2 focus:ring-[#E8F0E5]">
                    </div>

                </div>

                {{-- Footer --}}
                <div class="mt-6 flex items-center gap-3 border-t border-[#F0F3EF] pt-5">

                    <div class="flex items-center rounded-full border border-[#DCE5DC] p-0.5">
                        <button type="button"
                            wire:click="$set('pickQuantity', {{ max(1, $pickQuantity - 1) }})"
                            aria-label="Decrease quantity"
                            class="flex h-9 w-9 items-center justify-center rounded-full text-[#718076] transition hover:bg-[#F8FAF6] hover:text-[#294936]">
                            <x-tabler-minus class="h-3.5 w-3.5" />
                        </button>
                        <span class="flex h-9 min-w-8 items-center justify-center text-sm font-bold text-[#183524]">{{ $pickQuantity }}</span>
                        <button type="button"
                            wire:click="$set('pickQuantity', {{ min($maxPick, $pickQuantity + 1) }})"
                            aria-label="Increase quantity"
                            class="flex h-9 w-9 items-center justify-center rounded-full text-[#718076] transition hover:bg-[#F8FAF6] hover:text-[#294936]">
                            <x-tabler-plus class="h-3.5 w-3.5" />
                        </button>
                    </div>

                    <button type="button" wire:click="confirmPick" wire:loading.attr="disabled" wire:target="confirmPick"
                        class="inline-flex flex-1 items-center justify-between rounded-full bg-[#294936] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#183524] disabled:cursor-not-allowed disabled:bg-[#B9C5BA]">
                        <span>Add to order</span>
                        <span>{{ number_format($pickUnitPrice * $pickQuantity, 2) }} silver</span>
                    </button>

                </div>

            </div>

        </div>

    @endif

    {{-- Notice (stock, validation) --}}
    @if ($notice)
        <div class="fixed right-5 top-5 z-[60] flex max-w-sm items-start gap-3 rounded-2xl border border-[#E5DCC8] bg-[#FBF7EE] py-3 pl-4 pr-3 text-sm font-medium text-[#5E4A2F] shadow-lg">
            <x-tabler-alert-triangle class="mt-0.5 h-4 w-4 shrink-0 text-[#9A7B45]" />
            <span>{{ $notice }}</span>
            <button type="button" wire:click="dismissNotice" aria-label="Dismiss"
                class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full text-[#9A7B45] hover:bg-[#F3E8D1]">
                <x-tabler-x class="h-3.5 w-3.5" />
            </button>
        </div>
    @endif

    {{-- Flash message --}}
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3500)" x-show="show" x-transition
            class="fixed bottom-5 right-5 z-50 flex items-center gap-3 rounded-full bg-white py-2.5 pl-3 pr-5 text-sm font-medium text-[#294936] shadow-lg ring-1 ring-[#E6EDE6]">
            <div class="flex h-7 w-7 items-center justify-center rounded-full bg-[#E8F0E5]">
                <x-tabler-check class="h-4 w-4 text-[#5E8067]" />
            </div>
            {{ session('success') }}
        </div>
    @endif

</div>