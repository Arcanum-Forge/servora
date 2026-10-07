{{-- menu/⚡index/index.blade.php --}}

<div class="space-y-8">

    @php
        $fmt = fn($v) => rtrim(rtrim(number_format((float) $v, 2), '0'), '.');
        $qty = fn($v) => rtrim(rtrim(number_format((float) $v, 3), '0'), '.');

        $badge = [
            'Available' => 'bg-[#E8F0E5] text-[#5E8067]',
            'Healthy' => 'bg-[#E8F0E5] text-[#5E8067]',
            'Published' => 'bg-[#E8F0E5] text-[#5E8067]',
            'Live' => 'bg-[#E8F0E5] text-[#5E8067]',
            'Low stock' => 'bg-[#FFF4DD] text-[#9A762B]',
            'Scheduled' => 'bg-[#EEF2F8] text-[#62738A]',
            'Off hours' => 'bg-[#F1F4F0] text-[#718076]',
            'Draft' => 'bg-[#F1F4F0] text-[#718076]',
            'Expired' => 'bg-[#F1F4F0] text-[#718076]',
            'Unavailable' => 'bg-[#FDE8E7] text-[#B94A48]',
            'Out of stock' => 'bg-[#FDE8E7] text-[#B94A48]',
        ];

        $dot = [
            'Published' => 'bg-[#5E8067]',
            'Scheduled' => 'bg-[#9A762B]',
            'Draft' => 'bg-[#A8B0AA]',
        ];

        $input = 'w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm text-[#26342A] outline-none placeholder:text-[#9AA69D] focus:border-[#8FA58B] focus:ring-2 focus:ring-[#E8F0E5]';
        $label = 'mb-1 block text-xs font-medium text-[#718076]';
        $btnPrimary = 'inline-flex items-center justify-center gap-2 rounded-xl bg-[#294936] px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-[#183524]';
        $btnGhost = 'inline-flex items-center justify-center gap-2 rounded-xl border border-[#DCE5DC] bg-white px-4 py-2.5 text-sm font-medium text-[#294936] transition hover:bg-[#F8FAF6]';
        $iconBtn = 'flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-[#8A958D] transition hover:bg-[#E8F0E5] hover:text-[#294936]';
        $chip = 'inline-flex rounded-lg border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-1.5 text-xs text-[#718076] transition peer-checked:border-[#294936] peer-checked:bg-[#294936] peer-checked:text-white';

        $dayNames = [1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat', 7 => 'Sun'];
        $iconChoices = ['tools-kitchen-2', 'meat', 'bowl-spoon', 'salad', 'carrot', 'cake', 'glass', 'cup', 'bread', 'fish'];
        $units = ['kg', 'g', 'L', 'ml', 'pcs'];
    @endphp


    {{-- =========================================================
    HEADER / MENU STUDIO
    ========================================================== --}}
    <div class="relative overflow-hidden rounded-3xl border border-[#DCE5DC] bg-[#F8FAF6]">

        <div
            class="pointer-events-none absolute -right-20 -top-24 h-72 w-72 rounded-full bg-[#E8F0E5] opacity-70 blur-3xl">
        </div>
        <div
            class="pointer-events-none absolute -bottom-32 left-1/3 h-64 w-64 rounded-full bg-[#F1E9DF] opacity-60 blur-3xl">
        </div>

        <div class="relative p-6 sm:p-8">

            <div class="mb-6 flex items-center gap-2 text-xs font-medium uppercase tracking-[0.12em] text-[#8A958D]">
                <span>Manage</span>
                <x-tabler-chevron-right class="h-3.5 w-3.5" />
                <span class="text-[#294936]">Menu Studio</span>
            </div>

            <div class="flex flex-col gap-7 xl:flex-row xl:items-end xl:justify-between">

                <div class="max-w-2xl">

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#294936] text-white shadow-sm">
                            <x-tabler-tools-kitchen-2 class="h-5 w-5" />
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[#718076]">
                                Restaurant Operations
                            </p>

                            <h1 class="mt-0.5 text-2xl font-semibold tracking-tight text-[#26342A] sm:text-3xl">
                                Menu Studio
                            </h1>
                        </div>

                    </div>

                    <p class="mt-4 max-w-xl text-sm leading-6 text-[#718076]">
                        Shape what your guests see and order. Manage menus,
                        dishes, categories, modifiers, ingredients, and availability
                        from one workspace.
                    </p>

                </div>

                <div class="flex flex-wrap items-center gap-3">

                    <button type="button" wire:click="createMenu" class="{{ $btnGhost }} shadow-sm">
                        <x-tabler-notebook class="h-4 w-4" />
                        New menu
                    </button>

                    <button type="button" wire:click="createItem" class="{{ $btnPrimary }}">
                        <x-tabler-plus class="h-4 w-4" />
                        Add menu item
                    </button>

                </div>

            </div>

            {{-- Quick status --}}
            <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-3 border-t border-[#DCE5DC] pt-5">

                <div class="flex items-center gap-2 text-sm text-[#718076]">
                    <span
                        class="h-2 w-2 rounded-full {{ $this->stats['live'] > 0 ? 'bg-[#5E8067]' : 'bg-[#A8B0AA]' }}"></span>
                    <span>
                        <strong class="font-semibold text-[#26342A]">{{ $this->stats['live'] }}</strong>
                        {{ Str::plural('menu', $this->stats['live']) }} live now
                    </span>
                </div>

                <div class="h-4 w-px bg-[#DCE5DC]"></div>

                <div class="text-sm text-[#718076]">
                    <strong class="font-semibold text-[#26342A]">{{ $this->stats['orderable'] }}</strong>
                    available dishes
                </div>

                <div class="h-4 w-px bg-[#DCE5DC]"></div>

                <div class="text-sm text-[#718076]">
                    <strong class="font-semibold text-[#26342A]">{{ $this->stats['attention'] }}</strong>
                    need attention
                </div>

            </div>

        </div>

    </div>


    {{-- Notice --}}
    @if ($notice)
        <div
            class="flex items-start justify-between gap-4 rounded-2xl border border-[#E9DCC4] bg-[#FFFDF8] px-4 py-3 text-sm text-[#9A762B]">
            <span>{{ $notice }}</span>
            <button type="button" wire:click="$set('notice', null)" class="shrink-0" aria-label="Dismiss">
                <x-tabler-x class="h-4 w-4" />
            </button>
        </div>
    @endif

    @if ($this->supplyImpacts->isNotEmpty())
        <div class="rounded-2xl border border-[#E9DCC4] bg-[#FFFDF8] px-4 py-3">
            <div class="flex items-start gap-3">
                <x-tabler-alert-triangle class="mt-0.5 h-4 w-4 shrink-0 text-[#9A762B]" />

                <div class="min-w-0 flex-1 text-[#9A762B]">
                    <p class="text-sm font-medium">Supply notice</p>
                    <ul class="mt-1 space-y-0.5 text-xs">
                        @foreach ($this->supplyImpacts->take(3) as $impact)
                            <li wire:key="notice-{{ $impact->id }}">
                                <strong class="font-semibold">{{ $impact->threatReport?->title }}:</strong>
                                {{ $impact->ingredient->name }}
                                {{ $impact->effect === 'unavailable' ? 'is unavailable.' : 'is in limited supply.' }}
                            </li>
                        @endforeach
                        @if ($this->supplyImpacts->count() > 3)
                            <li>and {{ $this->supplyImpacts->count() - 3 }} more.</li>
                        @endif
                    </ul>
                </div>

                <button type="button" wire:click="setView('Ingredients')"
                    class="shrink-0 text-xs font-medium text-[#294936]">Review →</button>
            </div>
        </div>
    @endif


    {{-- =========================================================
    WORKSPACE NAVIGATION
    ========================================================== --}}
    <div class="overflow-x-auto">
        <nav
            class="inline-flex min-w-max items-center gap-1 rounded-2xl border border-[#DCE5DC] bg-white p-1.5 shadow-sm">

            @foreach ([
                        'Menus' => 'notebook',
                        'Categories' => 'category',
                        'Items' => 'tools-kitchen-2',
                        'Modifiers' => 'adjustments-horizontal',
                        'Ingredients' => 'carrot',
                        'Availability' => 'calendar-check',
                        'Ledger' => 'database',
                    ] as $tab => $icon)

                    <button type="button" wire:key="tab-{{ $tab }}" wire:click="setView('{{ $tab }}')" class="inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium transition
                                                {{ $view === $tab
                ? 'bg-[#294936] text-white shadow-sm'
                : 'text-[#718076] hover:bg-[#F8FAF6] hover:text-[#294936]' }}">
                        <x-dynamic-component :component="'tabler-' . $icon" class="h-4 w-4" />
                        {{ $tab }}
                    </button>

            @endforeach

        </nav>
    </div>


    {{-- =========================================================
    MENUS
    ========================================================== --}}
    @if ($view === 'Menus')

        <div class="grid gap-4 sm:grid-cols-3">

            <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-[0.1em] text-[#8A958D]">Live menus</p>
                        <p class="mt-2 text-2xl font-semibold tracking-tight text-[#26342A]">{{ $this->stats['live'] }}</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                        <x-tabler-world-check class="h-5 w-5" />
                    </div>
                </div>
                <p class="mt-3 text-xs text-[#718076]">Open for ordering right now</p>
            </div>

            <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-[0.1em] text-[#8A958D]">Menu items</p>
                        <p class="mt-2 text-2xl font-semibold tracking-tight text-[#26342A]">{{ $this->stats['total'] }}</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#F1E9DF] text-[#7D6048]">
                        <x-tabler-tools-kitchen-2 class="h-5 w-5" />
                    </div>
                </div>
                <p class="mt-3 text-xs text-[#718076]">{{ $this->stats['orderable'] }} available for ordering</p>
            </div>

            <button type="button" wire:click="setView('Availability')"
                class="rounded-2xl border border-[#DCE5DC] bg-white p-5 text-left transition hover:border-[#C8D5C9]">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-[0.1em] text-[#8A958D]">Attention</p>
                        <p class="mt-2 text-2xl font-semibold tracking-tight text-[#26342A]">{{ $this->stats['attention'] }}
                        </p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#FFF4DD] text-[#9A762B]">
                        <x-tabler-alert-triangle class="h-5 w-5" />
                    </div>
                </div>
                <p class="mt-3 text-xs text-[#718076]">Dishes unavailable or low on stock</p>
            </button>

        </div>


        <div class="grid gap-6 xl:grid-cols-[300px_minmax(0,1fr)]">

            {{-- Menu collection --}}
            <aside class="h-fit overflow-hidden rounded-2xl border border-[#DCE5DC] bg-white">

                <div class="border-b border-[#DCE5DC] p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-medium uppercase tracking-[0.1em] text-[#8A958D]">Your collection</p>
                            <h2 class="mt-1 text-lg font-semibold text-[#26342A]">Menus</h2>
                        </div>

                        <button type="button" wire:click="createMenu" aria-label="New menu"
                            class="flex h-9 w-9 items-center justify-center rounded-xl border border-[#DCE5DC] text-[#294936] transition hover:bg-[#E8F0E5]">
                            <x-tabler-plus class="h-4 w-4" />
                        </button>
                    </div>
                </div>

                <div class="p-2">

                    @forelse ($this->menus as $m)

                        @php $ms = $m->displayStatus(); @endphp

                        <button type="button" wire:key="menu-{{ $m->id }}" wire:click="selectMenu({{ $m->id }})" class="group w-full rounded-xl p-3 text-left transition
                                                    {{ $selectedMenuId === $m->id ? 'bg-[#E8F0E5]' : 'hover:bg-[#F8FAF6]' }}">
                            <div class="flex gap-3">

                                <div
                                    class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg
                                                        {{ $selectedMenuId === $m->id ? 'bg-[#294936] text-white' : 'bg-[#F1F4F0] text-[#718076]' }}">
                                    <x-tabler-notebook class="h-4 w-4" />
                                </div>

                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="truncate text-sm font-medium text-[#26342A]">{{ $m->name }}</p>
                                        <span class="h-2 w-2 shrink-0 rounded-full {{ $dot[$ms] }}"></span>
                                    </div>

                                    @if ($m->description)
                                        <p class="mt-0.5 truncate text-xs text-[#8A958D]">{{ $m->description }}</p>
                                    @endif

                                    <div class="mt-2 flex items-center gap-2 text-[11px] text-[#718076]">
                                        <span>{{ $m->items_count }} items</span>
                                        <span>·</span>
                                        <span>{{ $ms }}</span>
                                    </div>
                                </div>

                            </div>
                        </button>

                    @empty

                        <p class="px-3 py-6 text-center text-sm text-[#8A958D]">
                            No menus yet. Create your first one.
                        </p>

                    @endforelse

                </div>

                <div class="border-t border-[#DCE5DC] p-3">
                    <button type="button" wire:click="setView('Availability')"
                        class="flex w-full items-center justify-between rounded-xl px-3 py-2.5 text-sm font-medium text-[#718076] transition hover:bg-[#F8FAF6] hover:text-[#294936]">
                        <span class="flex items-center gap-2">
                            <x-tabler-calendar-check class="h-4 w-4" />
                            Menu schedules
                        </span>
                        <x-tabler-chevron-right class="h-4 w-4" />
                    </button>
                </div>

            </aside>


            {{-- Selected menu --}}
            <section class="min-w-0 overflow-hidden rounded-2xl border border-[#DCE5DC] bg-white">

                @php $menu = $this->selectedMenu; @endphp

                @if (!$menu)

                    <div class="flex flex-col items-center gap-4 px-6 py-16 text-center">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#E8F0E5] text-[#294936]">
                            <x-tabler-notebook class="h-6 w-6" />
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-[#26342A]">Create your first menu</h2>
                            <p class="mt-1 text-sm text-[#718076]">Menus group dishes and decide when guests can order them.</p>
                        </div>
                        <button type="button" wire:click="createMenu" class="{{ $btnPrimary }}">
                            <x-tabler-plus class="h-4 w-4" />
                            New menu
                        </button>
                    </div>

                @else

                    @php
                        $menuStatus = $menu->displayStatus();
                        $firstSchedule = $menu->schedules->first();
                    @endphp

                    {{-- Menu identity --}}
                    <div class="border-b border-[#DCE5DC] p-6 sm:p-7">
                        <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">

                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h2 class="text-2xl font-semibold tracking-tight text-[#26342A]">{{ $menu->name }}</h2>

                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $badge[$menuStatus] }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $dot[$menuStatus] }}"></span>
                                        {{ $menuStatus }}
                                    </span>

                                    @if ($menu->isLiveNow())
                                        <span
                                            class="rounded-full bg-[#E8F0E5] px-2.5 py-1 text-[11px] font-semibold text-[#5E8067]">Live
                                            now</span>
                                    @endif
                                </div>

                                <p class="mt-2 max-w-2xl text-sm leading-6 text-[#718076]">
                                    {{ $menu->description ?: 'No description yet.' }}
                                </p>

                                <div class="mt-4 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-[#8A958D]">
                                    <span class="inline-flex items-center gap-1.5">
                                        <x-tabler-tools-kitchen-2 class="h-3.5 w-3.5" />
                                        {{ $menu->items_count }} items
                                    </span>
                                    <span class="inline-flex items-center gap-1.5">
                                        <x-tabler-category class="h-3.5 w-3.5" />
                                        {{ $this->sections->count() }} {{ Str::plural('section', $this->sections->count()) }}
                                    </span>
                                    <span class="inline-flex items-center gap-1.5">
                                        <x-tabler-clock class="h-3.5 w-3.5" />
                                        @if ($firstSchedule)
                                            {{ $firstSchedule->window_label }} · {{ $firstSchedule->days_label }}
                                            @if ($menu->schedules->count() > 1)
                                                (+{{ $menu->schedules->count() - 1 }} more)
                                            @endif
                                        @else
                                            Always on when published
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="flex shrink-0 flex-wrap items-center gap-2">
                                <button type="button" wire:click="editMenu({{ $menu->id }})" class="{{ $btnGhost }}">
                                    <x-tabler-pencil class="h-4 w-4" />
                                    Edit
                                </button>

                                <button type="button" wire:click="togglePublish({{ $menu->id }})" class="{{ $btnGhost }}">
                                    @if ($menu->status === 'published')
                                        <x-tabler-eye-off class="h-4 w-4" />
                                        Unpublish
                                    @else
                                        <x-tabler-world-upload class="h-4 w-4" />
                                        Publish
                                    @endif
                                </button>

                                <button type="button" wire:click="deleteMenu({{ $menu->id }})"
                                    wire:confirm="Delete “{{ $menu->name }}”? Its dishes stay in your catalog."
                                    aria-label="Delete menu"
                                    class="flex h-10 w-10 items-center justify-center rounded-xl border border-[#DCE5DC] text-[#B94A48] transition hover:bg-[#FDE8E7]">
                                    <x-tabler-trash class="h-4 w-4" />
                                </button>
                            </div>

                        </div>
                    </div>


                    {{-- Sections --}}
                    <div class="border-b border-[#DCE5DC] bg-[#FCFDFC] px-6 pt-5 sm:px-7">

                        <p class="mb-3 text-xs font-medium uppercase tracking-[0.1em] text-[#8A958D]">Menu sections</p>

                        <div class="flex gap-2 overflow-x-auto pb-5">

                            <button type="button" wire:click="selectCategory(null)" class="shrink-0 rounded-xl border px-4 py-2.5 text-sm font-medium transition
                                                                {{ $selectedCategoryId === null
                    ? 'border-[#294936] bg-[#294936] text-white'
                    : 'border-[#DCE5DC] bg-white text-[#718076] hover:border-[#C8D5C9] hover:bg-[#F8FAF6]' }}">
                                All
                                <span class="ml-1 text-xs opacity-70">{{ $menu->items_count }}</span>
                            </button>

                            @foreach ($this->sections as $section)
                                    <button type="button" wire:key="section-{{ $section->id }}"
                                        wire:click="selectCategory({{ $section->id }})"
                                        class="shrink-0 rounded-xl border px-4 py-2.5 text-sm font-medium transition
                                                                                                    {{ $selectedCategoryId === $section->id
                                ? 'border-[#294936] bg-[#294936] text-white'
                                : 'border-[#DCE5DC] bg-white text-[#718076] hover:border-[#C8D5C9] hover:bg-[#F8FAF6]' }}">
                                        {{ $section->name }}
                                        <span class="ml-1 text-xs opacity-70">{{ $section->items_count }}</span>
                                    </button>
                            @endforeach

                        </div>

                    </div>


                    {{-- Dish list --}}
                    <div class="p-6 sm:p-7">

                        <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

                            <div>
                                <div class="flex items-center gap-3">
                                    <h3 class="text-lg font-semibold text-[#26342A]">
                                        {{ $selectedCategoryId ? $this->sections->firstWhere('id', $selectedCategoryId)?->name : 'All dishes' }}
                                    </h3>
                                    <span class="rounded-full bg-[#F1F4F0] px-2 py-0.5 text-[11px] font-medium text-[#718076]">
                                        {{ $this->items->count() }} {{ Str::plural('dish', $this->items->count()) }}
                                    </span>
                                </div>
                                <p class="mt-1 text-sm text-[#8A958D]">Dishes currently on this menu.</p>
                            </div>

                            <div class="flex items-center gap-2">
                                <div class="relative w-full sm:w-60">
                                    <x-tabler-search class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#9AA69D]" />
                                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search dishes..."
                                        class="w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] py-2.5 pl-9 pr-3 text-sm outline-none placeholder:text-[#9AA69D] focus:border-[#8FA58B] focus:ring-2 focus:ring-[#E8F0E5]" />
                                </div>

                                <button type="button" wire:click="createItem"
                                    class="hidden h-10 shrink-0 items-center gap-2 rounded-xl bg-[#294936] px-3.5 text-sm font-medium text-white transition hover:bg-[#183524] sm:inline-flex">
                                    <x-tabler-plus class="h-4 w-4" />
                                    Add
                                </button>
                            </div>

                        </div>


                        <div class="space-y-2">

                            @forelse ($this->items as $item)

                                    @php $status = $item->availability_status; @endphp

                                    <div wire:key="dish-{{ $item->id }}" class="group rounded-2xl border p-4 transition
                                                                                                    {{ $status === 'Available'
                                ? 'border-[#DCE5DC] hover:border-[#C8D5C9] hover:bg-[#FCFDFC]'
                                : 'border-[#E9DCC4] bg-[#FFFDF8] hover:border-[#DCCAA9]' }}">

                                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">

                                            <div class="flex min-w-0 flex-1 items-center gap-4">

                                                <div
                                                    class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl
                                                                                                            {{ $status === 'Available' ? 'bg-[#F1E9DF] text-[#7D6048]' : 'bg-[#FFF4DD] text-[#9A762B]' }}">
                                                    <x-dynamic-component :component="'tabler-' . ($item->icon ?: 'tools-kitchen-2')"
                                                        class="h-6 w-6" />
                                                </div>

                                                <div class="min-w-0">
                                                    <div class="flex flex-wrap items-center gap-2">
                                                        <h4 class="font-semibold text-[#26342A]">{{ $item->name }}</h4>
                                                        <span
                                                            class="rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $badge[$status] }}">{{ $status }}</span>
                                                    </div>

                                                    @if ($item->description)
                                                        <p class="mt-1 max-w-xl truncate text-sm text-[#718076]">{{ $item->description }}
                                                        </p>
                                                    @endif

                                                    <div
                                                        class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-1 text-[11px] text-[#8A958D]">
                                                        <span>{{ $item->category?->name }}</span>
                                                        @if ($item->ingredients->isNotEmpty())
                                                            <span>{{ $item->ingredients->count() }} ingredients</span>
                                                            <span>{{ $item->servings_left }} servings left</span>
                                                        @endif
                                                        <span>{{ $item->order_items_count }}
                                                            {{ Str::plural('order', $item->order_items_count) }}</span>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="flex items-center justify-between gap-3 sm:justify-end">

                                                <p class="font-semibold text-[#294936]">{{ $fmt($item->price) }} silver</p>

                                                <x-menu-switch :on="$item->is_available"
                                                    wire:click="toggleAvailability({{ $item->id }})"
                                                    title="Turn availability on or off" />

                                                <button type="button" wire:click="editItem({{ $item->id }})" class="{{ $iconBtn }}"
                                                    aria-label="Edit dish">
                                                    <x-tabler-pencil class="h-4 w-4" />
                                                </button>

                                                <button type="button" wire:click="removeFromMenu({{ $item->id }})"
                                                    wire:confirm="Remove “{{ $item->name }}” from this menu?" class="{{ $iconBtn }}"
                                                    aria-label="Remove from menu" title="Remove from this menu">
                                                    <x-tabler-playlist-x class="h-4 w-4" />
                                                </button>

                                            </div>

                                        </div>

                                    </div>

                            @empty

                                <p
                                    class="rounded-2xl border border-dashed border-[#C8D5C9] py-10 text-center text-sm text-[#8A958D]">
                                    No dishes here yet. Add one below, or assign existing dishes from the Items tab.
                                </p>

                            @endforelse


                            <button type="button" wire:click="createItem"
                                class="group flex w-full items-center justify-center gap-2 rounded-2xl border border-dashed border-[#C8D5C9] py-4 text-sm font-medium text-[#718076] transition hover:border-[#8FA58B] hover:bg-[#F8FAF6] hover:text-[#294936]">
                                <span
                                    class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#F1F4F0] transition group-hover:bg-[#E8F0E5]">
                                    <x-tabler-plus class="h-4 w-4" />
                                </span>
                                Add dish to {{ $menu->name }}
                            </button>

                        </div>

                    </div>

                @endif

            </section>

        </div>


        {{-- =========================================================
        CATEGORIES
        ========================================================== --}}
    @elseif ($view === 'Categories')

        <div class="space-y-6">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-medium uppercase tracking-[0.1em] text-[#8A958D]">Menu structure</p>
                    <h2 class="mt-1 text-xl font-semibold text-[#26342A]">Categories</h2>
                    <p class="mt-1 text-sm text-[#718076]">Organize dishes into sections guests can easily browse.</p>
                </div>

                <button type="button" wire:click="createCategory" class="{{ $btnPrimary }}">
                    <x-tabler-plus class="h-4 w-4" />
                    Add category
                </button>
            </div>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">

                @forelse ($this->categories as $category)

                    <div wire:key="category-{{ $category->id }}"
                        class="group rounded-2xl border border-[#DCE5DC] bg-white p-5 transition hover:border-[#C8D5C9] hover:shadow-sm">

                        <div class="flex items-start justify-between">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                                <x-tabler-category class="h-5 w-5" />
                            </div>

                            <button type="button" wire:click="editCategory({{ $category->id }})" class="{{ $iconBtn }}"
                                aria-label="Edit category">
                                <x-tabler-pencil class="h-4 w-4" />
                            </button>
                        </div>

                        <h3 class="mt-5 font-semibold text-[#26342A]">{{ $category->name }}</h3>

                        <div class="mt-5 flex items-center justify-between border-t border-[#EDF0EC] pt-4">
                            <span class="text-xs text-[#8A958D]">{{ $category->items_count }} menu
                                {{ Str::plural('item', $category->items_count) }}</span>

                            <button type="button" wire:click="viewCategoryItems({{ $category->id }})"
                                class="text-xs font-medium text-[#294936]">
                                View items →
                            </button>
                        </div>

                    </div>

                @empty

                    <p
                        class="rounded-2xl border border-dashed border-[#C8D5C9] py-10 text-center text-sm text-[#8A958D] md:col-span-2 xl:col-span-3">
                        No categories yet. Add one to start organizing dishes.
                    </p>

                @endforelse

            </div>

        </div>


        {{-- =========================================================
        ITEMS
        ========================================================== --}}
    @elseif ($view === 'Items')

        <div class="space-y-6">

            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-xs font-medium uppercase tracking-[0.1em] text-[#8A958D]">Dish catalog</p>
                    <h2 class="mt-1 text-xl font-semibold text-[#26342A]">Menu Items</h2>
                    <p class="mt-1 text-sm text-[#718076]">Manage every dish, drink and offering available across your
                        menus.</p>
                </div>

                <button type="button" wire:click="createItem" class="{{ $btnPrimary }}">
                    <x-tabler-plus class="h-4 w-4" />
                    Add menu item
                </button>
            </div>


            {{-- Filters --}}
            <div class="flex flex-col gap-3 rounded-2xl border border-[#DCE5DC] bg-white p-4 lg:flex-row">

                <div class="relative flex-1">
                    <x-tabler-search class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#9AA69D]" />
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search dishes..."
                        class="w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] py-2.5 pl-9 pr-3 text-sm outline-none focus:border-[#8FA58B] focus:ring-2 focus:ring-[#E8F0E5]" />
                </div>

                <select wire:model.live="categoryFilter"
                    class="rounded-xl border border-[#DCE5DC] bg-white px-3 py-2.5 text-sm text-[#718076] outline-none focus:border-[#8FA58B]">
                    <option value="">All categories</option>
                    @foreach ($this->categories as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>

                <select wire:model.live="statusFilter"
                    class="rounded-xl border border-[#DCE5DC] bg-white px-3 py-2.5 text-sm text-[#718076] outline-none focus:border-[#8FA58B]">
                    <option value="all">All statuses</option>
                    <option value="available">Available</option>
                    <option value="attention">Needs attention</option>
                </select>

            </div>


            <div class="overflow-hidden rounded-2xl border border-[#DCE5DC] bg-white">

                <div
                    class="hidden border-b border-[#DCE5DC] bg-[#F8FAF6] px-5 py-3 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#8A958D] md:grid md:grid-cols-[1fr_150px_110px_120px_110px] md:gap-4">
                    <span>Item</span>
                    <span>Category</span>
                    <span>Price</span>
                    <span>Status</span>
                    <span></span>
                </div>

                <div class="divide-y divide-[#EDF0EC]">

                    @forelse ($this->items as $item)

                        @php $status = $item->availability_status; @endphp

                        <div wire:key="row-{{ $item->id }}"
                            class="p-5 transition hover:bg-[#FCFDFC] md:grid md:grid-cols-[1fr_150px_110px_120px_110px] md:items-center md:gap-4">

                            <div class="flex items-center gap-4">
                                <div
                                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#F1F4F0] text-[#718076]">
                                    <x-dynamic-component :component="'tabler-' . ($item->icon ?: 'tools-kitchen-2')"
                                        class="h-5 w-5" />
                                </div>

                                <div class="min-w-0">
                                    <p class="font-medium text-[#26342A]">{{ $item->name }}</p>
                                    <p class="mt-0.5 truncate text-xs text-[#8A958D]">
                                        {{ $item->menus->isNotEmpty() ? $item->menus->pluck('name')->join(', ') : 'Not on any menu' }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-3 text-xs text-[#718076] md:mt-0">{{ $item->category?->name }}</div>

                            <div class="mt-2 font-semibold text-[#294936] md:mt-0">{{ $fmt($item->price) }} silver</div>

                            <div class="mt-2 md:mt-0">
                                <span
                                    class="rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $badge[$status] }}">{{ $status }}</span>
                            </div>

                            <div class="mt-3 flex items-center gap-2 md:mt-0 md:justify-end">
                                <x-menu-switch :on="$item->is_available" wire:click="toggleAvailability({{ $item->id }})" />
                                <button type="button" wire:click="editItem({{ $item->id }})" class="{{ $iconBtn }}"
                                    aria-label="Edit dish">
                                    <x-tabler-pencil class="h-4 w-4" />
                                </button>
                            </div>

                        </div>

                    @empty

                        <p class="py-10 text-center text-sm text-[#8A958D]">No dishes match your filters.</p>

                    @endforelse

                </div>

            </div>

        </div>


        {{-- =========================================================
        MODIFIERS
        ========================================================== --}}
    @elseif ($view === 'Modifiers')

        <div class="space-y-6">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-medium uppercase tracking-[0.1em] text-[#8A958D]">Guest customization</p>
                    <h2 class="mt-1 text-xl font-semibold text-[#26342A]">Modifiers</h2>
                    <p class="mt-1 text-sm text-[#718076]">Give guests choices without creating separate menu items.</p>
                </div>

                <button type="button" wire:click="createModifierGroup" class="{{ $btnPrimary }}">
                    <x-tabler-plus class="h-4 w-4" />
                    Add modifier
                </button>
            </div>

            <div class="grid gap-4 lg:grid-cols-2">

                @forelse ($this->modifierGroups as $group)

                    <div wire:key="group-{{ $group->id }}" class="rounded-2xl border border-[#DCE5DC] bg-white p-5">

                        <div class="flex items-start justify-between">
                            <div>
                                <div class="flex items-center gap-2">
                                    <div
                                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#E8F0E5] text-[#294936]">
                                        <x-tabler-adjustments-horizontal class="h-4 w-4" />
                                    </div>
                                    <h3 class="font-semibold text-[#26342A]">{{ $group->name }}</h3>
                                </div>

                                <div class="mt-2 flex items-center gap-2 text-xs text-[#8A958D]">
                                    <span>{{ $group->type_label }}</span>
                                    @if ($group->is_required)
                                        <span
                                            class="rounded-full bg-[#FFF4DD] px-2 py-0.5 text-[10px] font-semibold text-[#9A762B]">Required</span>
                                    @endif
                                </div>
                            </div>

                            <button type="button" wire:click="editModifierGroup({{ $group->id }})" class="{{ $iconBtn }}"
                                aria-label="Edit modifier">
                                <x-tabler-pencil class="h-4 w-4" />
                            </button>
                        </div>

                        <div class="mt-5 flex flex-wrap gap-2">
                            @foreach ($group->options as $option)
                                <span class="rounded-lg border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-1.5 text-xs text-[#718076]">
                                    {{ $option->name }}
                                    @if ((float) $option->price_delta !== 0.0)
                                        <span
                                            class="text-[#294936]">{{ $option->price_delta > 0 ? '+' : '' }}{{ $fmt($option->price_delta) }}</span>
                                    @endif
                                </span>
                            @endforeach
                        </div>

                        <div class="mt-5 border-t border-[#EDF0EC] pt-4">
                            <p class="text-[11px] uppercase tracking-[0.08em] text-[#9AA69D]">Used by</p>
                            <p class="mt-1 text-xs text-[#718076]">
                                @if ($group->items->isEmpty())
                                    No dishes yet. Assign it from a dish's edit form.
                                @else
                                    {{ $group->items->take(4)->pluck('name')->join(', ') }}
                                    @if ($group->items->count() > 4)
                                        and {{ $group->items->count() - 4 }} more
                                    @endif
                                @endif
                            </p>
                        </div>

                    </div>

                @empty

                    <p
                        class="rounded-2xl border border-dashed border-[#C8D5C9] py-10 text-center text-sm text-[#8A958D] lg:col-span-2">
                        No modifiers yet. Add one, like “Cooking Preference” or “Drink Size”.
                    </p>

                @endforelse

            </div>

        </div>


        {{-- =========================================================
        INGREDIENTS
        ========================================================== --}}
    @elseif ($view === 'Ingredients')

        <div class="space-y-6">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-medium uppercase tracking-[0.1em] text-[#8A958D]">Recipe & inventory</p>
                    <h2 class="mt-1 text-xl font-semibold text-[#26342A]">Ingredients</h2>
                    <p class="mt-1 text-sm text-[#718076]">Track the ingredients behind every dish on your menu.</p>
                </div>

                <button type="button" wire:click="createIngredient" class="{{ $btnPrimary }}">
                    <x-tabler-plus class="h-4 w-4" />
                    Add ingredient
                </button>
            </div>


            @if ($this->supplyImpacts->isNotEmpty())
                <div class="rounded-2xl border border-[#E9DCC4] bg-[#FFFDF8] p-5">

                    <div class="mb-4">
                        <h3 class="font-semibold text-[#26342A]">Supply notices</h3>
                        <p class="mt-1 text-sm text-[#718076]">Ledger threat reports that affect your ingredients. Mark as
                            unavailable to take dishes off the menu, or dismiss.</p>
                    </div>

                    <div class="space-y-3">
                        @foreach ($this->supplyImpacts as $impact)
                            <div wire:key="impact-{{ $impact->id }}"
                                class="flex flex-col gap-3 rounded-xl border border-[#EDE3CE] bg-white p-4 sm:flex-row sm:items-center sm:justify-between">

                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-[#26342A]">{{ $impact->ingredient->name }}</p>
                                    <p class="mt-1 text-xs text-[#8A958D]">
                                        {{ $impact->threatReport?->title }} · {{ $impact->threatReport?->level }}
                                        · affects {{ $impact->ingredient->items->count() }}
                                        {{ Str::plural('dish', $impact->ingredient->items->count()) }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-2">
                                    <x-supply-effect-toggle :impact="$impact" />
                                    <button type="button" wire:click="dismissImpact({{ $impact->id }})" class="{{ $iconBtn }}"
                                        aria-label="Dismiss notice" title="Dismiss">
                                        <x-tabler-x class="h-4 w-4" />
                                    </button>
                                </div>

                            </div>
                        @endforeach
                    </div>

                </div>
            @endif

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

                @forelse ($this->ingredients as $ingredient)

                    @php $istatus = $ingredient->status_label; @endphp

                    <div wire:key="ingredient-{{ $ingredient->id }}" class="rounded-2xl border border-[#DCE5DC] bg-white p-5">

                        <div class="flex items-start justify-between">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#F1E9DF] text-[#7D6048]">
                                <x-tabler-carrot class="h-5 w-5" />
                            </div>

                            <div class="flex items-center gap-1">
                                <span
                                    class="rounded-full px-2 py-1 text-[10px] font-semibold {{ $badge[$istatus] }}">{{ $istatus }}</span>
                                <button type="button" wire:click="editIngredient({{ $ingredient->id }})" class="{{ $iconBtn }}"
                                    aria-label="Edit ingredient">
                                    <x-tabler-pencil class="h-4 w-4" />
                                </button>
                            </div>
                        </div>

                        <h3 class="mt-4 font-medium text-[#26342A]">{{ $ingredient->name }}</h3>
                        @if ($ingredient->monster)
                            <p class="mt-1 text-[11px] text-[#8A958D]">Sourced from {{ $ingredient->monster->name }}</p>
                        @endif
                        @foreach ($ingredient->activeSupplyImpacts as $impact)
                            <div wire:key="card-impact-{{ $impact->id }}"
                                class="mt-3 rounded-xl border border-[#E9DCC4] bg-[#FFFDF8] p-3">
                                <p class="mb-2 truncate text-[11px] text-[#9A762B]">{{ $impact->threatReport?->title }}</p>
                                <x-supply-effect-toggle :impact="$impact" />
                            </div>
                        @endforeach


                        @foreach ($ingredient->dismissedSupplyImpacts as $impact)
                            <div wire:key="card-dismissed-{{ $impact->id }}"
                                class="mt-3 flex items-center justify-between gap-2 rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2">
                                <p class="truncate text-[11px] text-[#8A958D]">{{ $impact->threatReport?->title }} · dismissed</p>
                                <button type="button" wire:click="restoreImpact({{ $impact->id }})"
                                    class="shrink-0 text-[11px] font-medium text-[#294936]">Restore</button>
                            </div>
                        @endforeach

                        <p class="mt-1 text-2xl font-semibold text-[#294936]">
                            {{ $fmt($ingredient->stock) }} <span
                                class="text-sm font-medium text-[#8A958D]">{{ $ingredient->unit }}</span>
                        </p>

                        <div class="mt-3 flex items-center justify-between text-xs text-[#8A958D]">
                            <span>Current stock</span>
                            <span>{{ $ingredient->items_count }} {{ Str::plural('dish', $ingredient->items_count) }}</span>
                        </div>

                        <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-[#EDF0EC]">
                            <div class="h-full rounded-full {{ $istatus === 'Healthy' ? 'bg-[#5E8067]' : 'bg-[#C39A45]' }}"
                                style="width: {{ $ingredient->stock_percent }}%"></div>
                        </div>

                        <p class="mt-2 text-[11px] text-[#9AA69D]">Low at {{ $fmt($ingredient->low_stock_threshold) }}
                            {{ $ingredient->unit }}
                        </p>

                    </div>

                @empty

                    <p
                        class="rounded-2xl border border-dashed border-[#C8D5C9] py-10 text-center text-sm text-[#8A958D] sm:col-span-2 xl:col-span-4">
                        No ingredients yet. Add stock to start tracking low-stock warnings.
                    </p>

                @endforelse

            </div>


            {{-- Recipe relationship --}}
            <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5">

                <div class="mb-5">
                    <h3 class="font-semibold text-[#26342A]">Ingredient usage</h3>
                    <p class="mt-1 text-sm text-[#718076]">What goes into each dish, per serving. Set recipes from a dish's
                        edit form.</p>
                </div>

                <div class="divide-y divide-[#EDF0EC]">

                    @forelse ($this->recipeItems as $recipeItem)

                        <div wire:key="recipe-item-{{ $recipeItem->id }}"
                            class="flex flex-col gap-2 py-4 sm:flex-row sm:items-center sm:justify-between">

                            <p class="text-sm font-medium text-[#26342A]">{{ $recipeItem->name }}</p>

                            <p class="text-xs text-[#718076] sm:text-right">
                                {{ $recipeItem->ingredients->map(fn($i) => $i->name . ' ' . $qty($i->pivot->quantity) . ' ' . $i->unit)->join(' · ') }}
                            </p>

                        </div>

                    @empty

                        <p class="py-6 text-center text-sm text-[#8A958D]">No recipes yet.</p>

                    @endforelse

                </div>

            </div>

        </div>


        {{-- =========================================================
        AVAILABILITY
        ========================================================== --}}
    @elseif ($view === 'Availability')

        <div class="space-y-6">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-medium uppercase tracking-[0.1em] text-[#8A958D]">Service control</p>
                    <h2 class="mt-1 text-xl font-semibold text-[#26342A]">Availability</h2>
                    <p class="mt-1 text-sm text-[#718076]">Control when menus and dishes are available for ordering.</p>
                </div>

                <button type="button" wire:click="createSchedule" class="{{ $btnPrimary }}">
                    <x-tabler-plus class="h-4 w-4" />
                    Add schedule
                </button>
            </div>


            {{-- Menu schedules --}}
            <div class="overflow-hidden rounded-2xl border border-[#DCE5DC] bg-white">

                <div class="border-b border-[#DCE5DC] bg-[#F8FAF6] p-5">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div>
                            <div class="flex items-center gap-2">
                                <span
                                    class="h-2.5 w-2.5 rounded-full {{ $this->liveNow->isNotEmpty() ? 'bg-[#5E8067]' : 'bg-[#A8B0AA]' }}"></span>
                                <h3 class="font-semibold text-[#26342A]">Current service</h3>
                            </div>

                            <p class="mt-1 text-sm text-[#718076]">
                                {{ $this->liveNow->isNotEmpty() ? $this->liveNow->pluck('name')->join(' · ') : 'No menu is live right now' }}
                            </p>
                        </div>

                        <span
                            class="rounded-full px-3 py-1.5 text-xs font-semibold {{ $this->liveNow->isNotEmpty() ? 'bg-[#E8F0E5] text-[#5E8067]' : 'bg-[#F1F4F0] text-[#718076]' }}">
                            {{ $this->liveNow->isNotEmpty() ? 'Active now' : 'Closed' }}
                        </span>

                    </div>
                </div>

                <div class="divide-y divide-[#EDF0EC]">

                    @forelse ($this->schedules as $schedule)

                        @php $sstate = $schedule->state(); @endphp

                        <div wire:key="schedule-{{ $schedule->id }}"
                            class="flex flex-col gap-4 p-5 sm:flex-row sm:items-center sm:justify-between">

                            <div class="flex items-center gap-4">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#F1F4F0] text-[#718076]">
                                    <x-tabler-calendar-event class="h-5 w-5" />
                                </div>

                                <div>
                                    <p class="font-medium text-[#26342A]">{{ $schedule->menu->name }}</p>
                                    <div class="mt-1 flex flex-wrap items-center gap-2 text-xs text-[#8A958D]">
                                        <span>{{ $schedule->window_label }}</span>
                                        <span>·</span>
                                        <span>{{ $schedule->days_label }}</span>
                                        @if ($schedule->date_range_label)
                                            <span>·</span>
                                            <span>{{ $schedule->date_range_label }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between gap-3 sm:justify-end">
                                <span
                                    class="rounded-full px-2.5 py-1 text-[10px] font-semibold {{ $badge[$sstate] }}">{{ $sstate }}</span>

                                <button type="button" wire:click="editSchedule({{ $schedule->id }})" class="{{ $iconBtn }}"
                                    aria-label="Edit schedule">
                                    <x-tabler-pencil class="h-4 w-4" />
                                </button>
                            </div>

                        </div>

                    @empty

                        <p class="p-8 text-center text-sm text-[#8A958D]">
                            No schedules yet. Published menus without a schedule are always on.
                        </p>

                    @endforelse

                </div>

            </div>


            {{-- Item availability --}}
            <div class="rounded-2xl border border-[#DCE5DC] bg-white p-5">

                <div class="mb-5">
                    <h3 class="font-semibold text-[#26342A]">Item availability</h3>
                    <p class="mt-1 text-sm text-[#718076]">Dishes that are off, out of stock, or running low.</p>
                </div>

                <div class="space-y-3">

                    @forelse ($this->attentionItems as $item)

                        @php $status = $item->availability_status; @endphp

                        <div wire:key="attention-{{ $item->id }}"
                            class="flex flex-col gap-3 rounded-xl border border-[#EDF0EC] p-4 sm:flex-row sm:items-center sm:justify-between">

                            <div>
                                <p class="text-sm font-medium text-[#26342A]">{{ $item->name }}</p>
                                <p class="mt-1 text-xs text-[#8A958D]">{{ $item->availability_reason }}</p>
                            </div>

                            <div class="flex items-center gap-3">
                                <span
                                    class="inline-flex rounded-full px-2.5 py-1 text-[10px] font-semibold {{ $badge[$status] }}">{{ $status }}</span>
                                <x-menu-switch :on="$item->is_available" wire:click="toggleAvailability({{ $item->id }})" />
                                <button type="button" wire:click="editItem({{ $item->id }})" class="{{ $iconBtn }}"
                                    aria-label="Edit dish">
                                    <x-tabler-pencil class="h-4 w-4" />
                                </button>
                            </div>

                        </div>

                    @empty

                        <p class="rounded-xl border border-dashed border-[#C8D5C9] py-8 text-center text-sm text-[#8A958D]">
                            Every dish is available and well stocked.
                        </p>

                    @endforelse

                </div>

            </div>

        </div>


    {{-- =========================================================
    LEDGER (read-only)
    ========================================================== --}}
    @elseif ($view === 'Ledger')

        @php
            $levelStyle = fn($level) => match ($level) {
                'Critical' => 'bg-[#FDE8E7] text-[#B94A48]',
                'Severe' => 'bg-[#FFF4DD] text-[#9A762B]',
                default => 'bg-[#F1F4F0] text-[#718076]',
            };
        @endphp

        <div class="space-y-6">

            <div>
                <p class="text-xs font-medium uppercase tracking-[0.1em] text-[#8A958D]">Synced from the Ledger</p>
                <h2 class="mt-1 text-xl font-semibold text-[#26342A]">Ledger data</h2>
                <p class="mt-1 text-sm text-[#718076]">Read-only. This data is mirrored by
                    <code>php artisan ledger:sync</code>
                    and can only be changed in the Ledger.</p>
            </div>

            {{-- Sync status --}}
            <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                @foreach (['kingdoms' => 'Kingdoms', 'factions' => 'Factions', 'monsters' => 'Monsters', 'threat-reports' => 'Threat reports'] as $resource => $resourceLabel)
                    @php $state = $this->ledgerSyncStates->get($resource); @endphp
                    <div wire:key="sync-{{ $resource }}" class="rounded-2xl border border-[#DCE5DC] bg-white p-4">
                        <p class="text-xs font-medium uppercase tracking-[0.1em] text-[#8A958D]">{{ $resourceLabel }}</p>
                        <p class="mt-2 text-sm font-medium text-[#26342A]">
                            {{ $state?->last_synced_at ? \Illuminate\Support\Carbon::parse($state->last_synced_at)->diffForHumans() : 'Never synced' }}
                        </p>
                        @if ($state?->last_error)
                            <p class="mt-1 truncate text-[11px] text-[#B94A48]" title="{{ $state->last_error }}">
                                Last error: {{ $state->last_error }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Sub tabs --}}
            <div class="overflow-x-auto">
                <nav
                    class="inline-flex min-w-max items-center gap-1 rounded-2xl border border-[#DCE5DC] bg-white p-1 shadow-sm">
                    @foreach (['Threat reports', 'Monsters'] as $sub)
                        <button type="button" wire:key="ledger-tab-{{ $sub }}" wire:click="setLedgerTab('{{ $sub }}')"
                            class="rounded-xl px-4 py-2 text-sm font-medium transition
                                            {{ $ledgerTab === $sub ? 'bg-[#294936] text-white shadow-sm' : 'text-[#718076] hover:bg-[#F8FAF6] hover:text-[#294936]' }}">
                            {{ $sub }}
                        </button>
                    @endforeach
                </nav>
            </div>


            {{-- ---------- Threat reports ---------- --}}
            @if ($ledgerTab === 'Threat reports')

                <div class="space-y-3">
                    @forelse ($this->ledgerThreatReports as $report)
                        @php
                            $isLive = in_array($report->status, \App\Models\LedgerThreatReport::LIVE_STATUSES, true);
                            $impacts = $this->impactsByReport->get($report->id, collect());
                        @endphp

                        <div wire:key="lr-{{ $report->id }}"
                            class="rounded-2xl border bg-white p-5 {{ $isLive ? 'border-[#E9DCC4]' : 'border-[#DCE5DC]' }}">

                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                <div class="min-w-0">
                                    <p class="text-[11px] text-[#8A958D]">{{ $report->report_number }}</p>
                                    <h3 class="font-semibold text-[#26342A]">{{ $report->title }}</h3>
                                    <p class="mt-1 text-xs text-[#8A958D]">
                                        {{ $report->type }} · {{ $report->region_name ?? 'Unknown region' }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span
                                        class="rounded-full px-2.5 py-1 text-[10px] font-semibold {{ $levelStyle($report->level) }}">{{ $report->level }}</span>
                                    <span
                                        class="rounded-full px-2.5 py-1 text-[10px] font-semibold {{ $isLive ? 'bg-[#E8F0E5] text-[#5E8067]' : 'bg-[#F1F4F0] text-[#718076]' }}">
                                        {{ $report->status }}
                                    </span>
                                </div>
                            </div>

                            @if ($report->description)
                                <p class="mt-3 text-sm leading-6 text-[#718076]">{{ $report->description }}</p>
                            @endif

                            <div class="mt-4 grid gap-4 border-t border-[#EDF0EC] pt-4 sm:grid-cols-2">
                                <div>
                                    <p class="text-[11px] uppercase tracking-[0.08em] text-[#9AA69D]">Monsters</p>
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        @forelse ($report->monsters as $monster)
                                            <span
                                                class="rounded-lg border border-[#DCE5DC] bg-[#F8FAF6] px-2.5 py-1 text-xs text-[#718076]">{{ $monster->name }}</span>
                                        @empty
                                            <span class="text-xs text-[#8A958D]">None linked</span>
                                        @endforelse
                                    </div>
                                </div>

                                <div>
                                    <p class="text-[11px] uppercase tracking-[0.08em] text-[#9AA69D]">Affects your ingredients</p>
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        @forelse ($impacts as $impact)
                                            <span
                                                class="rounded-lg border px-2.5 py-1 text-xs
                                                                    {{ $impact->dismissed_at ? 'border-[#DCE5DC] bg-[#F1F4F0] text-[#8A958D] line-through' : ($impact->effect === 'unavailable' ? 'border-[#F3C9C7] bg-[#FDE8E7] text-[#B94A48]' : 'border-[#E9DCC4] bg-[#FFF4DD] text-[#9A762B]') }}">
                                                {{ $impact->ingredient->name }} ·
                                                {{ $impact->dismissed_at ? 'dismissed' : $impact->effect }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-[#8A958D]">No linked ingredients</span>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                        </div>
                    @empty
                        <p class="rounded-2xl border border-dashed border-[#C8D5C9] py-10 text-center text-sm text-[#8A958D]">
                            No threat reports synced yet. Run <code>php artisan ledger:sync</code>.
                        </p>
                    @endforelse
                </div>


                {{-- ---------- Monsters ---------- --}}
            @elseif ($ledgerTab === 'Monsters')

                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @forelse ($this->ledgerMonsters as $monster)
                        <div wire:key="lm-{{ $monster->id }}" class="rounded-2xl border border-[#DCE5DC] bg-white p-5">

                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h3 class="font-semibold text-[#26342A]">{{ $monster->name }}</h3>
                                    <p class="mt-0.5 text-xs text-[#8A958D]">
                                        {{ $monster->classification ?? 'Unknown' }} · {{ $monster->habitat ?? 'Unknown' }}
                                    </p>
                                </div>
                                <span
                                    class="rounded-full px-2.5 py-1 text-[10px] font-semibold {{ $levelStyle($monster->threat === 'High' || $monster->threat === 'Extreme' ? 'Severe' : '') }}">
                                    {{ $monster->threat ?? '—' }}
                                </span>
                            </div>

                            @if ($monster->description)
                                <p class="mt-3 line-clamp-3 text-xs leading-5 text-[#718076]">{{ $monster->description }}</p>
                            @endif

                            <div class="mt-4 border-t border-[#EDF0EC] pt-3">
                                <p class="text-[11px] uppercase tracking-[0.08em] text-[#9AA69D]">Ingredients sourced</p>
                                <p class="mt-1 text-xs text-[#718076]">
                                    {{ $this->ingredientsByMonster->has($monster->id)
                            ? $this->ingredientsByMonster[$monster->id]->pluck('name')->join(', ')
                            : 'None linked' }}
                                </p>
                            </div>

                        </div>
                    @empty
                        <p
                            class="rounded-2xl border border-dashed border-[#C8D5C9] py-10 text-center text-sm text-[#8A958D] md:col-span-2 xl:col-span-3">
                            No monsters synced yet.
                        </p>
                    @endforelse
                </div>
            @endif

        </div>

    @endif


    {{-- =========================================================
    MODALS
    ========================================================== --}}
    @if ($modal)

        @php
            $saveAction = [
                'item' => 'saveItem',
                'menu' => 'saveMenu',
                'category' => 'saveCategory',
                'ingredient' => 'saveIngredient',
                'modifier' => 'saveModifierGroup',
                'schedule' => 'saveSchedule',
            ][$modal];

            $deleteCall = match ($modal) {
                'item' => $itemId ? "deleteItem({$itemId})" : null,
                'menu' => $menuId ? "deleteMenu({$menuId})" : null,
                'category' => $categoryId ? "deleteCategory({$categoryId})" : null,
                'ingredient' => $ingredientId ? "deleteIngredient({$ingredientId})" : null,
                'modifier' => $groupId ? "deleteModifierGroup({$groupId})" : null,
                'schedule' => $scheduleId ? "deleteSchedule({$scheduleId})" : null,
                default => null,
            };

            $deleteConfirm = match ($modal) {
                'item' => 'Delete this dish? Dishes with order history are turned off instead.',
                'menu' => 'Delete this menu? Its dishes stay in your catalog.',
                'category' => 'Delete this category?',
                'ingredient' => 'Delete this ingredient? It will be removed from every recipe.',
                'modifier' => 'Delete this modifier and all of its options?',
                'schedule' => 'Delete this schedule?',
                default => 'Delete?',
            };
        @endphp

        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 p-4" wire:click.self="closeModal">

            <div
                class="max-h-[90vh] w-full overflow-y-auto rounded-3xl border border-[#DCE5DC] bg-white p-6 shadow-xl {{ $modal === 'item' ? 'max-w-2xl' : 'max-w-lg' }}">

                @if ($errors->any())
                    <div class="mb-4 rounded-xl border border-[#F3C9C7] bg-[#FDE8E7] px-4 py-3 text-xs text-[#B94A48]">
                        <ul class="space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                {{-- ---------- Item ---------- --}}
                @if ($modal === 'item')

                    <h3 class="text-lg font-semibold text-[#26342A]">{{ $itemId ? 'Edit dish' : 'New dish' }}</h3>

                    <div class="mt-5 space-y-5">

                        <div class="grid gap-3 sm:grid-cols-2">

                            <div class="sm:col-span-2">
                                <label class="{{ $label }}">Name</label>
                                <input type="text" wire:model="name" class="{{ $input }}" placeholder="Dragonfire Roast">
                            </div>

                            <div>
                                <label class="{{ $label }}">Category</label>
                                <select wire:model="menu_category_id" class="{{ $input }}">
                                    <option value="">Select a category</option>
                                    @foreach ($this->categories as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="{{ $label }}">Price (silver)</label>
                                <input type="number" step="0.01" min="0" wire:model="price" class="{{ $input }}"
                                    placeholder="18">
                            </div>

                            <div>
                                <label class="{{ $label }}">Icon</label>
                                <select wire:model="icon" class="{{ $input }}">
                                    @foreach ($iconChoices as $choice)
                                        <option value="{{ $choice }}">{{ $choice }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex items-end">
                                <label class="flex items-center gap-2 pb-2.5 text-sm text-[#718076]">
                                    <input type="checkbox" wire:model="is_available"
                                        class="rounded border-[#DCE5DC] text-[#294936]">
                                    Available for ordering
                                </label>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="{{ $label }}">Description</label>
                                <textarea wire:model="description" rows="2" class="{{ $input }}"
                                    placeholder="What guests will read on the menu"></textarea>
                            </div>

                        </div>


                        <div>
                            <label class="{{ $label }}">On these menus</label>
                            <div class="flex flex-wrap gap-2">
                                @forelse ($this->menus as $m)
                                    <label class="cursor-pointer" wire:key="pick-menu-{{ $m->id }}">
                                        <input type="checkbox" value="{{ $m->id }}" wire:model="menuIds" class="peer sr-only">
                                        <span class="{{ $chip }}">{{ $m->name }}</span>
                                    </label>
                                @empty
                                    <p class="text-xs text-[#8A958D]">Create a menu first.</p>
                                @endforelse
                            </div>
                        </div>


                        <div>
                            <label class="{{ $label }}">Modifiers</label>
                            <div class="flex flex-wrap gap-2">
                                @forelse ($this->modifierGroups as $g)
                                    <label class="cursor-pointer" wire:key="pick-group-{{ $g->id }}">
                                        <input type="checkbox" value="{{ $g->id }}" wire:model="modifierGroupIds"
                                            class="peer sr-only">
                                        <span class="{{ $chip }}">{{ $g->name }}</span>
                                    </label>
                                @empty
                                    <p class="text-xs text-[#8A958D]">No modifiers created yet.</p>
                                @endforelse
                            </div>
                        </div>


                        <div>
                            <label class="{{ $label }}">Recipe (per serving)</label>

                            <div class="space-y-2">
                                @foreach ($recipe as $i => $row)
                                    <div class="flex items-center gap-2" wire:key="recipe-row-{{ $i }}">
                                        <select wire:model="recipe.{{ $i }}.ingredient_id" class="{{ $input }}">
                                            <option value="">Ingredient</option>
                                            @foreach ($this->ingredients as $ing)
                                                <option value="{{ $ing->id }}">{{ $ing->name }} ({{ $ing->unit }})</option>
                                            @endforeach
                                        </select>

                                        <input type="number" step="0.001" min="0" wire:model="recipe.{{ $i }}.quantity"
                                            placeholder="Qty" class="{{ $input }} max-w-[7rem]">

                                        <button type="button" wire:click="removeRecipeRow({{ $i }})" class="{{ $iconBtn }}"
                                            aria-label="Remove ingredient">
                                            <x-tabler-x class="h-4 w-4" />
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" wire:click="addRecipeRow"
                                class="mt-2 inline-flex items-center gap-1.5 text-xs font-medium text-[#294936]">
                                <x-tabler-plus class="h-3.5 w-3.5" />
                                Add ingredient
                            </button>

                            <p class="mt-1 text-[11px] text-[#9AA69D]">Dishes with a recipe go out of stock automatically when
                                an ingredient runs out.</p>
                        </div>

                    </div>


                    {{-- ---------- Menu ---------- --}}
                @elseif ($modal === 'menu')

                    <h3 class="text-lg font-semibold text-[#26342A]">{{ $menuId ? 'Edit menu' : 'New menu' }}</h3>

                    <div class="mt-5 space-y-4">
                        <div>
                            <label class="{{ $label }}">Name</label>
                            <input type="text" wire:model="menuName" class="{{ $input }}" placeholder="Tavern Menu">
                        </div>

                        <div>
                            <label class="{{ $label }}">Description</label>
                            <textarea wire:model="menuDescription" rows="2" class="{{ $input }}"
                                placeholder="Everyday dining"></textarea>
                        </div>

                        <div>
                            <label class="{{ $label }}">Status</label>
                            <select wire:model="menuStatus" class="{{ $input }}">
                                <option value="draft">Draft (hidden from guests)</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                    </div>


                    {{-- ---------- Category ---------- --}}
                @elseif ($modal === 'category')

                    <h3 class="text-lg font-semibold text-[#26342A]">{{ $categoryId ? 'Edit category' : 'New category' }}</h3>

                    <div class="mt-5">
                        <label class="{{ $label }}">Name</label>
                        <input type="text" wire:model="categoryName" class="{{ $input }}" placeholder="Starters">
                    </div>


                    {{-- ---------- Ingredient ---------- --}}
                @elseif ($modal === 'ingredient')

                    <h3 class="text-lg font-semibold text-[#26342A]">{{ $ingredientId ? 'Edit ingredient' : 'New ingredient' }}
                    </h3>

                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label class="{{ $label }}">Name</label>
                            <input type="text" wire:model="ingName" class="{{ $input }}" placeholder="Moonroot">
                        </div>

                        <div>
                            <label class="{{ $label }}">Unit</label>
                            <select wire:model="ingUnit" class="{{ $input }}">
                                @foreach ($units as $u)
                                    <option value="{{ $u }}">{{ $u }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="{{ $label }}">Current stock</label>
                            <input type="number" step="0.01" min="0" wire:model="ingStock" class="{{ $input }}">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="{{ $label }}">Warn me when stock drops to</label>
                            <input type="number" step="0.01" min="0" wire:model="ingThreshold" class="{{ $input }}">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="{{ $label }}">Sourced from monster (optional)</label>
                            <select wire:model="ingMonsterId" class="{{ $input }}">
                                <option value="">Not monster-sourced</option>
                                @foreach ($this->ledgerMonsters as $monster)
                                    <option value="{{ $monster->id }}">{{ $monster->name }}</option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-[11px] text-[#9AA69D]">While a Ledger threat report involving this monster is
                                active,
                                dishes using this ingredient show a supply notice.</p>
                        </div>
                    </div>


                    {{-- ---------- Modifier group ---------- --}}
                @elseif ($modal === 'modifier')

                    <h3 class="text-lg font-semibold text-[#26342A]">{{ $groupId ? 'Edit modifier' : 'New modifier' }}</h3>

                    <div class="mt-5 space-y-4">

                        <div>
                            <label class="{{ $label }}">Name</label>
                            <input type="text" wire:model="groupName" class="{{ $input }}" placeholder="Cooking Preference">
                        </div>

                        <div class="grid gap-3 sm:grid-cols-2">
                            <div>
                                <label class="{{ $label }}">Guests can choose</label>
                                <select wire:model="groupType" class="{{ $input }}">
                                    <option value="single">One option</option>
                                    <option value="multiple">Several options</option>
                                </select>
                            </div>

                            <div class="flex items-end">
                                <label class="flex items-center gap-2 pb-2.5 text-sm text-[#718076]">
                                    <input type="checkbox" wire:model="groupRequired"
                                        class="rounded border-[#DCE5DC] text-[#294936]">
                                    Guests must choose
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="{{ $label }}">Options (price change in silver)</label>

                            <div class="space-y-2">
                                @foreach ($options as $i => $option)
                                    <div class="flex items-center gap-2" wire:key="option-{{ $i }}">
                                        <input type="text" wire:model="options.{{ $i }}.name" placeholder="Option name"
                                            class="{{ $input }}">
                                        <input type="number" step="0.01" wire:model="options.{{ $i }}.price" placeholder="0"
                                            class="{{ $input }} max-w-[6rem]">
                                        <button type="button" wire:click="removeOption({{ $i }})" class="{{ $iconBtn }}"
                                            aria-label="Remove option">
                                            <x-tabler-x class="h-4 w-4" />
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" wire:click="addOption"
                                class="mt-2 inline-flex items-center gap-1.5 text-xs font-medium text-[#294936]">
                                <x-tabler-plus class="h-3.5 w-3.5" />
                                Add option
                            </button>
                        </div>

                    </div>


                    {{-- ---------- Schedule ---------- --}}
                @elseif ($modal === 'schedule')

                    <h3 class="text-lg font-semibold text-[#26342A]">{{ $scheduleId ? 'Edit schedule' : 'New schedule' }}</h3>

                    <div class="mt-5 space-y-4">

                        <div>
                            <label class="{{ $label }}">Menu</label>
                            <select wire:model="scheduleMenuId" class="{{ $input }}">
                                <option value="">Select a menu</option>
                                @foreach ($this->menus as $m)
                                    <option value="{{ $m->id }}">{{ $m->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="{{ $label }}">Days</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($dayNames as $num => $dayName)
                                    <label class="cursor-pointer" wire:key="day-{{ $num }}">
                                        <input type="checkbox" value="{{ $num }}" wire:model="scheduleDays" class="peer sr-only">
                                        <span class="{{ $chip }}">{{ $dayName }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid gap-3 sm:grid-cols-2">
                            <div>
                                <label class="{{ $label }}">Opens</label>
                                <input type="time" wire:model="startsAt" class="{{ $input }}">
                            </div>
                            <div>
                                <label class="{{ $label }}">Closes</label>
                                <input type="time" wire:model="endsAt" class="{{ $input }}">
                            </div>
                        </div>

                        <p class="-mt-2 text-[11px] text-[#9AA69D]">A closing time earlier than the opening time runs past
                            midnight.</p>

                        <div class="grid gap-3 sm:grid-cols-2">
                            <div>
                                <label class="{{ $label }}">Starts on (optional)</label>
                                <input type="date" wire:model="activeFrom" class="{{ $input }}">
                            </div>
                            <div>
                                <label class="{{ $label }}">Ends on (optional)</label>
                                <input type="date" wire:model="activeUntil" class="{{ $input }}">
                            </div>
                        </div>

                    </div>

                @endif


                {{-- Footer --}}
                <div class="mt-6 flex items-center justify-between gap-2">

                    <div>
                        @if ($deleteCall)
                            <button type="button" wire:click="{{ $deleteCall }}" wire:confirm="{{ $deleteConfirm }}"
                                class="inline-flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-medium text-[#B94A48] transition hover:bg-[#FDE8E7]">
                                <x-tabler-trash class="h-4 w-4" />
                                Delete
                            </button>
                        @endif
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" wire:click="closeModal" class="{{ $btnGhost }}">Cancel</button>
                        <button type="button" wire:click="{{ $saveAction }}" class="{{ $btnPrimary }}">Save changes</button>
                    </div>

                </div>

            </div>

        </div>

    @endif

</div>