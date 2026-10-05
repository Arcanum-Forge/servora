{{-- tables/⚡index/index.blade.php --}}

<div>

    @php
        $crumb = $view;
    @endphp

    {{-- Page header --}}
    <div class="mb-6">
        <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-sm text-[#718076]">
            <span>Operations</span>
            <x-tabler-chevron-right class="h-4 w-4 text-[#C8D8C9]" />
            <span>Tables</span>
            <x-tabler-chevron-right class="h-4 w-4 text-[#C8D8C9]" />
            <span class="font-medium text-[#183524]">{{ $crumb }}</span>
        </nav>
        <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#183524]">Tables</h1>
        <p class="mt-1 text-sm text-[#718076]">Floor plans, seating and sections for your dining halls.</p>
    </div>

    @if ($this->halls->isEmpty())

        {{-- First-run empty state: no dining halls exist yet --}}
        <div class="flex min-h-[420px] flex-col items-center justify-center rounded-3xl border border-dashed border-[#DCE5DC] bg-white p-10 text-center">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F8FAF6]">
                <x-tabler-building-estate class="h-7 w-7 text-[#8FA58B]" />
            </div>
            <h2 class="mt-5 text-xl font-semibold text-[#183524]">Create your first dining hall</h2>
            <p class="mt-2 max-w-sm text-sm text-[#718076]">
                A dining hall holds its own floor plan, tables, and sections — add one to get started.
            </p>
            <button wire:click="openAddHallModal" type="button"
                class="mt-6 inline-flex items-center gap-2 rounded-full bg-[#294936] px-5 py-2.5 text-sm font-medium text-white transition hover:bg-[#183524]">
                <x-tabler-plus class="h-4 w-4" />
                Add Dining Hall
            </button>
        </div>

    @else

    {{-- Hero --}}
    <div class="rounded-3xl bg-[#294936] p-6 text-white sm:p-7">

        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/10">
                    <x-tabler-armchair class="h-6 w-6" />
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <div class="relative inline-flex items-center">
                            <select wire:model.live="currentHallId"
                                class="appearance-none border-0 bg-transparent py-0 pl-0 pr-6 text-2xl font-bold tracking-tight text-white focus:outline-none focus:ring-0 [&>option]:text-[#183524]">
                                @foreach ($this->halls as $hall)
                                    <option value="{{ $hall->id }}">{{ $hall->name }}</option>
                                @endforeach
                            </select>
                            <x-tabler-chevron-down class="pointer-events-none absolute right-0 h-4 w-4 text-white/60" />
                        </div>

                        <button wire:click="openEditHallModal({{ $currentHallId }})" type="button" title="Edit hall"
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/10 text-white/80 transition hover:bg-white/20">
                            <x-tabler-pencil class="h-4 w-4" />
                        </button>
                        <button wire:click="openAddHallModal" type="button" title="Add hall"
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/10 text-white/80 transition hover:bg-white/20">
                            <x-tabler-plus class="h-4 w-4" />
                        </button>
                    </div>
                    <p class="mt-0.5 text-sm text-white/60">Dining hall · {{ $this->stats['total'] }} {{ \Illuminate\Support\Str::plural('table', $this->stats['total']) }}</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                @if ($view === 'Floor Plan')
                    <button wire:click="openAddElementModal" type="button"
                        class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-white/20">
                        <x-tabler-square-plus class="h-4 w-4" />
                        Add Element
                    </button>
                @endif

                @if ($view === 'Floor Plan' || $view === 'Tables')
                    <button wire:click="openAddTableModal" type="button"
                        class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-2.5 text-sm font-semibold text-[#183524] transition hover:bg-[#E8F0E5]">
                        <x-tabler-plus class="h-4 w-4" />
                        Add Table
                    </button>
                @elseif ($view === 'Table Sections')
                    <button wire:click="openAddSectionModal" type="button"
                        class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-2.5 text-sm font-semibold text-[#183524] transition hover:bg-[#E8F0E5]">
                        <x-tabler-plus class="h-4 w-4" />
                        Add Section
                    </button>
                @endif
            </div>

        </div>

        @php
            $tiles = [
                ['Tables', $this->stats['total'], 'layout-grid'],
                ['Available', $this->stats['available'], 'circle-check'],
                ['Reserved', $this->stats['reserved'], 'bookmark'],
                ['Occupied', $this->stats['occupied'], 'armchair'],
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

    {{-- Segmented tabs --}}
    <div class="mt-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <div class="inline-flex self-start rounded-full bg-[#F0F3EF] p-1">
            @foreach (['Floor Plan', 'Tables', 'Table Sections'] as $item)
                <button wire:click="setView('{{ $item }}')" type="button"
                    class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-medium transition
                            {{ $view === $item ? 'bg-white text-[#183524] shadow-sm' : 'text-[#718076] hover:text-[#294936]' }}">

                    @if ($item === 'Floor Plan')
                        <x-tabler-layout-grid class="h-4 w-4" />
                    @elseif ($item === 'Tables')
                        <x-tabler-table class="h-4 w-4" />
                    @else
                        <x-tabler-map-2 class="h-4 w-4" />
                    @endif

                    {{ $item }}
                </button>
            @endforeach
        </div>

        @if ($view === 'Floor Plan')
            <button wire:click="toggleEditLayout" type="button"
                class="inline-flex items-center gap-2 self-start rounded-full px-4 py-2.5 text-sm font-medium transition lg:self-auto
                        {{ $editingLayout
                            ? 'bg-[#294936] text-white shadow-sm hover:bg-[#183524]'
                            : 'border border-[#DCE5DC] bg-white text-[#294936] shadow-sm hover:bg-[#F8FAF6]' }}">
                @if ($editingLayout)
                    <x-tabler-check class="h-4 w-4" />
                    Done editing
                @else
                    <x-tabler-arrows-move class="h-4 w-4" />
                    Edit Layout
                @endif
            </button>
        @endif

    </div>

    @if ($view === 'Floor Plan')

    {{-- Workspace --}}
    <div class="mt-6 grid gap-6 xl:grid-cols-[1fr_300px]">

        {{-- Floor plan --}}
        <section class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-[#E6EDE6]">

            <div class="flex flex-col gap-3 border-b border-[#F0F3EF] p-5 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h2 class="text-lg font-bold text-[#183524]">Floor plan</h2>
                    <p class="mt-0.5 text-xs text-[#718076]">
                        @if ($editingLayout)
                            Drag to move, corner handle to resize, top handle to rotate.
                        @else
                            {{ $this->currentHall?->name }} · tap a table to see details.
                        @endif
                    </p>
                </div>

                @unless ($editingLayout)
                    <div class="flex flex-wrap items-center gap-2">
                        @foreach (\App\Enums\TableStatus::cases() as $status)
                            <span class="inline-flex items-center gap-2 rounded-full bg-[#F8FAF6] px-3 py-1.5">
                                <span class="h-2 w-2 rounded-full {{ $status->dotColor() }}"></span>
                                <span class="text-[11px] font-semibold text-[#718076]">{{ $status->label() }}</span>
                            </span>
                        @endforeach
                    </div>
                @endunless

            </div>

            {{-- Canvas: fixed-size, draggable coordinate space. Scrolls on small screens. --}}
            <div class="overflow-x-auto bg-[#F8FAF6] p-4">

                <div class="relative mx-auto" style="width: 960px; min-height: 680px;" x-data="floorPlan()" wire:key="canvas-{{ $currentHallId }}">

                    <div class="pointer-events-none absolute inset-6 rounded-3xl border border-[#DCE5DC]"></div>

                    {{-- Tables --}}
                    @foreach ($this->tables as $table)

                        <div wire:key="table-{{ $table->id }}" data-floor-item data-item-type="table" data-item-id="{{ $table->id }}"
                            @if ($editingLayout)
                                x-on:pointerdown="startDrag($event, 'table', {{ $table->id }}, {{ $table->pos_x ?? 40 }}, {{ $table->pos_y ?? 40 }})"
                                x-on:pointermove.window="onDrag($event, $el, 'table', {{ $table->id }})"
                                x-on:pointerup.window="endDrag($el, 'table', {{ $table->id }})"
                            @endif
                            style="position: absolute; left: {{ $table->pos_x ?? 40 }}px; top: {{ $table->pos_y ?? 40 }}px; width: {{ $table->width }}px; height: {{ $table->height }}px; touch-action: none;"
                            class="select-none {{ $editingLayout ? 'cursor-grab active:cursor-grabbing' : '' }}">

                            <button type="button" data-shape
                                @unless ($editingLayout) wire:click="selectTable({{ $table->id }})" @endunless
                                style="transform: rotate({{ $table->rotation }}deg);"
                                class="group relative flex h-full w-full origin-center flex-col items-center justify-center border-2 bg-white shadow-sm transition {{ $table->shape->radiusClass() }} {{ $table->is_featured ? 'border-[#294936] bg-[#E8F0E5]' : $table->status->borderColor() }} {{ $editingLayout ? 'border-dashed' : 'hover:-translate-y-1 hover:shadow-md' }} {{ $this->selectedTableModel?->id === $table->id ? 'ring-4 ring-[#294936]/15' : '' }}">

                                @if ($table->section && ! $table->is_featured)
                                    <span class="absolute inset-x-2 top-1 h-1 rounded-full" style="background-color: {{ $table->section->color }}"></span>
                                @endif

                                @if ($table->is_featured)
                                    <div class="flex items-center gap-2">
                                        <x-tabler-crown class="h-4 w-4 text-[#9A762B]" stroke-width="1.5" />
                                        <span class="text-sm font-semibold uppercase tracking-[0.12em] text-[#294936]">
                                            {{ $table->name }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-sm font-bold text-[#183524]">{{ $table->name }}</span>
                                @endif

                                <span class="mt-1 text-[10px] uppercase tracking-wider {{ $table->is_featured ? 'text-[#5E8067]' : 'text-[#8FA58B]' }}">
                                    {{ $table->seatsLabel }}
                                </span>

                                <span class="absolute -right-1.5 -top-1.5 h-3 w-3 rounded-full {{ $table->status->dotColor() }} ring-2 ring-white"></span>

                            </button>

                            @if ($editingLayout)

                                <button type="button" wire:click="deleteTable({{ $table->id }})"
                                    wire:confirm="Remove {{ $table->name }}?"
                                    class="absolute -left-1.5 -top-1.5 flex h-5 w-5 items-center justify-center rounded-full bg-[#B94A48] text-white shadow ring-2 ring-white">
                                    <x-tabler-x class="h-3 w-3" />
                                </button>

                                <span
                                    x-on:pointerdown="startResize($event, 'table', {{ $table->id }}, {{ $table->width }}, {{ $table->height }})"
                                    x-on:pointermove.window="onResize($event, $el.parentElement, 'table', {{ $table->id }})"
                                    x-on:pointerup.window="endResize($el.parentElement, 'table', {{ $table->id }})"
                                    style="touch-action: none;"
                                    class="absolute -bottom-1.5 -right-1.5 h-4 w-4 cursor-se-resize rounded-full border-2 border-white bg-[#294936]"></span>

                                <span
                                    x-on:pointerdown="startRotate($event, 'table', {{ $table->id }}, $el.parentElement)"
                                    x-on:pointermove.window="onRotate($event, $el.parentElement.querySelector('[data-shape]'), 'table', {{ $table->id }})"
                                    x-on:pointerup.window="endRotate($el.parentElement.querySelector('[data-shape]'), 'table', {{ $table->id }})"
                                    style="touch-action: none;"
                                    class="absolute -top-6 left-1/2 h-4 w-4 -translate-x-1/2 cursor-alias rounded-full border-2 border-white bg-[#47708F]"></span>

                            @endif

                        </div>

                    @endforeach

                    {{-- Barriers --}}
                    @foreach ($this->elements->where('type', \App\Enums\FloorElementType::Barrier) as $element)

                        @php
                            $preset = $element->preset ?? \App\Enums\FloorElementPreset::Wall;
                            $icon = $preset->icon();
                            $accent = $preset->accentColor();
                        @endphp

                        <div wire:key="barrier-{{ $element->id }}" data-floor-item data-item-type="barrier" data-item-id="{{ $element->id }}"
                            @if ($editingLayout)
                                x-on:pointerdown="startDrag($event, 'barrier', {{ $element->id }}, {{ $element->pos_x }}, {{ $element->pos_y }})"
                                x-on:pointermove.window="onDrag($event, $el, 'barrier', {{ $element->id }})"
                                x-on:pointerup.window="endDrag($el, 'barrier', {{ $element->id }})"
                            @endif
                            style="position: absolute; left: {{ $element->pos_x }}px; top: {{ $element->pos_y }}px; width: {{ $element->width }}px; height: {{ $element->height }}px; touch-action: none;"
                            class="select-none {{ $editingLayout ? 'cursor-grab active:cursor-grabbing' : '' }}">

                            <div data-shape
                                style="transform: rotate({{ $element->rotation }}deg); {{ $icon ? 'border-color: '.$accent.'; background-color: '.$accent.'1A; color: '.$accent.';' : '' }}"
                                class="flex h-full w-full origin-center flex-col items-center justify-center gap-1 overflow-hidden border-2 px-2 text-center text-[10px] font-medium uppercase tracking-wide {{ $icon ? '' : 'border-dashed border-[#718076]/50 bg-[#718076]/15 text-[#718076]' }} {{ $element->shape->radiusClass() }}">
                                @if ($icon)
                                    <x-dynamic-component :component="'tabler-'.$icon" class="h-4 w-4 shrink-0" />
                                @endif
                                <span class="truncate leading-tight">{{ $element->name ?: $preset->label() }}</span>
                            </div>

                            @if ($editingLayout)

                                <button type="button" wire:click="deleteElement({{ $element->id }})"
                                    wire:confirm="Remove this barrier?"
                                    class="absolute -left-1.5 -top-1.5 flex h-5 w-5 items-center justify-center rounded-full bg-[#B94A48] text-white shadow ring-2 ring-white">
                                    <x-tabler-x class="h-3 w-3" />
                                </button>

                                <span
                                    x-on:pointerdown="startResize($event, 'barrier', {{ $element->id }}, {{ $element->width }}, {{ $element->height }})"
                                    x-on:pointermove.window="onResize($event, $el.parentElement, 'barrier', {{ $element->id }})"
                                    x-on:pointerup.window="endResize($el.parentElement, 'barrier', {{ $element->id }})"
                                    style="touch-action: none;"
                                    class="absolute -bottom-1.5 -right-1.5 h-4 w-4 cursor-se-resize rounded-full border-2 border-white bg-[#294936]"></span>

                                <span
                                    x-on:pointerdown="startRotate($event, 'barrier', {{ $element->id }}, $el.parentElement)"
                                    x-on:pointermove.window="onRotate($event, $el.parentElement.querySelector('[data-shape]'), 'barrier', {{ $element->id }})"
                                    x-on:pointerup.window="endRotate($el.parentElement.querySelector('[data-shape]'), 'barrier', {{ $element->id }})"
                                    style="touch-action: none;"
                                    class="absolute -top-6 left-1/2 h-4 w-4 -translate-x-1/2 cursor-alias rounded-full border-2 border-white bg-[#47708F]"></span>

                            @endif

                        </div>

                    @endforeach

                    {{-- Labels (purely informational; don't block table placement) --}}
                    @foreach ($this->elements->where('type', \App\Enums\FloorElementType::Label) as $element)

                        <div wire:key="label-{{ $element->id }}" data-floor-item data-item-type="label" data-item-id="{{ $element->id }}"
                            @if ($editingLayout)
                                x-on:pointerdown="startDrag($event, 'label', {{ $element->id }}, {{ $element->pos_x }}, {{ $element->pos_y }})"
                                x-on:pointermove.window="onDrag($event, $el, 'label', {{ $element->id }})"
                                x-on:pointerup.window="endDrag($el, 'label', {{ $element->id }})"
                            @endif
                            style="position: absolute; left: {{ $element->pos_x }}px; top: {{ $element->pos_y }}px; width: {{ $element->width }}px; height: {{ $element->height }}px; touch-action: none;"
                            class="select-none {{ $editingLayout ? 'cursor-grab active:cursor-grabbing' : '' }}">

                            <div data-shape style="transform: rotate({{ $element->rotation }}deg);"
                                class="flex h-full w-full origin-center items-center justify-center rounded-lg px-2 text-xs font-semibold uppercase tracking-wide text-[#294936] {{ $editingLayout ? 'border border-dashed border-[#8FA58B] bg-white/60' : '' }}">
                                {{ $element->name }}
                            </div>

                            @if ($editingLayout)

                                <button type="button" wire:click="deleteElement({{ $element->id }})"
                                    wire:confirm="Remove this label?"
                                    class="absolute -left-1.5 -top-1.5 flex h-5 w-5 items-center justify-center rounded-full bg-[#B94A48] text-white shadow ring-2 ring-white">
                                    <x-tabler-x class="h-3 w-3" />
                                </button>

                                <span
                                    x-on:pointerdown="startResize($event, 'label', {{ $element->id }}, {{ $element->width }}, {{ $element->height }})"
                                    x-on:pointermove.window="onResize($event, $el.parentElement, 'label', {{ $element->id }})"
                                    x-on:pointerup.window="endResize($el.parentElement, 'label', {{ $element->id }})"
                                    style="touch-action: none;"
                                    class="absolute -bottom-1.5 -right-1.5 h-4 w-4 cursor-se-resize rounded-full border-2 border-white bg-[#294936]"></span>

                                <span
                                    x-on:pointerdown="startRotate($event, 'label', {{ $element->id }}, $el.parentElement)"
                                    x-on:pointermove.window="onRotate($event, $el.parentElement.querySelector('[data-shape]'), 'label', {{ $element->id }})"
                                    x-on:pointerup.window="endRotate($el.parentElement.querySelector('[data-shape]'), 'label', {{ $element->id }})"
                                    style="touch-action: none;"
                                    class="absolute -top-6 left-1/2 h-4 w-4 -translate-x-1/2 cursor-alias rounded-full border-2 border-white bg-[#47708F]"></span>

                            @endif

                        </div>

                    @endforeach

                </div>

            </div>

        </section>

        {{-- Right panel --}}
        <aside class="space-y-5">

            @if ($this->selectedTableModel)

                @php
                   $table = $this->selectedTableModel
                @endphp

                <section class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[#E6EDE6]">

                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#E8F0E5] text-[#294936]">
                                @if ($table->is_featured)
                                    <x-tabler-crown class="h-5 w-5 text-[#9A762B]" />
                                @else
                                    <x-tabler-armchair class="h-5 w-5" />
                                @endif
                            </div>
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-[#8FA58B]">Selected table</p>
                                <h2 class="text-lg font-bold leading-tight text-[#183524]">{{ $table->name }}</h2>
                            </div>
                        </div>

                        <button wire:click="clearSelection" type="button"
                            class="flex h-8 w-8 items-center justify-center rounded-full text-[#8FA58B] hover:bg-[#F8FAF6]">
                            <x-tabler-x class="h-4 w-4" />
                        </button>
                    </div>

                    <div class="mt-5 space-y-3 rounded-2xl bg-[#F8FAF6] p-4">

                        <div class="flex items-center justify-between">
                            <span class="text-xs text-[#718076]">Status</span>
                            <span class="inline-flex items-center gap-2 text-xs font-bold {{ $table->status->textColor() }}">
                                <span class="h-2 w-2 rounded-full {{ $table->status->dotColor() }}"></span>
                                {{ $table->status->label() }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-xs text-[#718076]">Capacity</span>
                            <span class="text-sm font-semibold text-[#183524]">{{ $table->seatsLabel }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-xs text-[#718076]">Shape</span>
                            <span class="text-sm font-semibold text-[#183524]">{{ $table->shape->label() }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-xs text-[#718076]">Section</span>
                            <span class="inline-flex items-center gap-2 text-sm font-semibold text-[#183524]">
                                @if ($table->section)
                                    <span class="h-2 w-2 rounded-full" style="background-color: {{ $table->section->color }}"></span>
                                @endif
                                {{ $table->section?->name ?? '—' }}
                            </span>
                        </div>

                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-2">
                        <button type="button" wire:click="duplicateTable({{ $table->id }})"
                            class="rounded-full border border-[#DCE5DC] px-3 py-2.5 text-xs font-semibold text-[#294936] transition hover:bg-[#F8FAF6]">
                            Duplicate
                        </button>
                        <button type="button" wire:click="openEditTableModal({{ $table->id }})"
                            class="rounded-full border border-[#DCE5DC] px-3 py-2.5 text-xs font-semibold text-[#294936] transition hover:bg-[#F8FAF6]">
                            Edit Table
                        </button>
                        <a href="/dashboard/reservations?table={{ $table->id }}" wire:navigate
                            class="col-span-2 flex items-center justify-center gap-2 rounded-full border border-[#DCE5DC] px-3 py-2.5 text-xs font-semibold text-[#294936] transition hover:bg-[#F8FAF6]">
                            <x-tabler-calendar-plus class="h-4 w-4" />
                            New Reservation
                        </a>
                        <button type="button" wire:click="cycleTableStatus({{ $table->id }})"
                            class="col-span-2 inline-flex items-center justify-center gap-2 rounded-full bg-[#294936] px-3 py-2.5 text-xs font-semibold text-white transition hover:bg-[#183524]">
                            <x-tabler-refresh class="h-4 w-4" />
                            Cycle Status
                        </button>
                    </div>

                </section>

            @else

                {{-- Overview --}}
                @php
                    $tableTotal = $this->stats['total'];
                    $safeTotal = max($tableTotal, 1);
                    $availPct = ($this->stats['available'] / $safeTotal) * 100;
                    $resPct = ($this->stats['reserved'] / $safeTotal) * 100;
                    $occPct = ($this->stats['occupied'] / $safeTotal) * 100;
                    $donut = $tableTotal === 0
                        ? '#F0F3EF'
                        : 'conic-gradient(#5E8067 0 '.$availPct.'%, #9A762B '.$availPct.'% '.($availPct + $resPct).'%, #294936 '.($availPct + $resPct).'% 100%)';
                @endphp

                <section class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[#E6EDE6]">

                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wide text-[#8FA58B]">Floor pulse</p>
                        <span class="text-[11px] text-[#718076]">{{ $tableTotal }} tables</span>
                    </div>

                    <div class="mt-4 flex items-center gap-5">
                        <div class="relative h-24 w-24 shrink-0 rounded-full" style="background: {{ $donut }}">
                            <div class="absolute inset-3 flex flex-col items-center justify-center rounded-full bg-white">
                                <span class="text-lg font-bold leading-none text-[#183524]">{{ (int) round($occPct) }}%</span>
                                <span class="mt-0.5 text-[8px] font-semibold uppercase tracking-wide text-[#8FA58B]">occupied</span>
                            </div>
                        </div>
                        <div class="space-y-2 text-xs">
                            <p class="flex items-center gap-2 text-[#718076]"><span class="h-2 w-2 rounded-full bg-[#5E8067]"></span><span class="font-semibold text-[#183524]">{{ $this->stats['available'] }}</span> free</p>
                            <p class="flex items-center gap-2 text-[#718076]"><span class="h-2 w-2 rounded-full bg-[#9A762B]"></span><span class="font-semibold text-[#183524]">{{ $this->stats['reserved'] }}</span> reserved</p>
                            <p class="flex items-center gap-2 text-[#718076]"><span class="h-2 w-2 rounded-full bg-[#294936]"></span><span class="font-semibold text-[#183524]">{{ $this->stats['occupied'] }}</span> occupied</p>
                        </div>
                    </div>

                    <p class="mt-5 rounded-2xl bg-[#F8FAF6] px-3 py-3 text-xs text-[#8FA58B]">
                        Select a table on the floor plan to see its details and quick actions.
                    </p>

                </section>

            @endif

        </aside>

    </div>

    @elseif ($view === 'Tables')

    {{-- Tables list view --}}
    <div class="mt-6">

        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-lg font-bold text-[#183524]">All tables</h2>
                <p class="text-xs text-[#718076]">{{ $this->filteredTables->count() }} of {{ $this->stats['total'] }} tables</p>
            </div>

            <div class="flex flex-wrap items-center gap-2">

                <div class="relative">
                    <x-tabler-search class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8FA58B]" />
                    <input type="search" wire:model.live.debounce.300ms="tableSearch" placeholder="Search tables…"
                        class="w-full rounded-full border border-[#DCE5DC] bg-white py-2.5 pl-10 pr-4 text-sm text-[#26342A] outline-none placeholder:text-[#9AA79D] focus:border-[#8FA58B] focus:ring-2 focus:ring-[#E8F0E5] sm:w-64" />
                </div>

                <div class="relative">
                    <select wire:model.live="tableSectionFilter"
                        class="appearance-none rounded-full border border-[#DCE5DC] bg-white py-2.5 pl-4 pr-9 text-sm text-[#294936] outline-none focus:border-[#8FA58B] focus:ring-2 focus:ring-[#E8F0E5]">
                        <option value="">All sections</option>
                        <option value="none">No section</option>
                        @foreach ($this->sections as $section)
                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                        @endforeach
                    </select>
                    <x-tabler-chevron-down class="pointer-events-none absolute right-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8FA58B]" />
                </div>

            </div>
        </div>

        <section class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-[#E6EDE6]">

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-[#F8FAF6] text-[11px] uppercase tracking-wide text-[#8FA58B]">
                            <th class="px-5 py-3.5 font-semibold">Table</th>
                            <th class="px-5 py-3.5 font-semibold">Section</th>
                            <th class="px-5 py-3.5 font-semibold">Seats</th>
                            <th class="px-5 py-3.5 font-semibold">Shape</th>
                            <th class="px-5 py-3.5 font-semibold">Status</th>
                            <th class="px-5 py-3.5 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->filteredTables as $table)
                            <tr wire:key="row-table-{{ $table->id }}" class="border-t border-[#F0F3EF] transition hover:bg-[#F8FAF6]">
                                <td class="px-5 py-3.5 font-bold text-[#183524]">
                                    <span class="inline-flex items-center gap-3">
                                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl {{ $table->is_featured ? 'bg-[#FFF4DD] text-[#9A762B]' : 'bg-[#E8F0E5] text-[#5E8067]' }}">
                                            @if ($table->is_featured)
                                                <x-tabler-crown class="h-4 w-4" />
                                            @else
                                                <x-tabler-armchair class="h-4 w-4" />
                                            @endif
                                        </span>
                                        {{ $table->name }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-[#718076]">
                                    @if ($table->section)
                                        <span class="inline-flex items-center gap-2 rounded-full bg-[#F8FAF6] px-2.5 py-1 text-xs font-semibold text-[#294936]">
                                            <span class="h-2 w-2 rounded-full" style="background-color: {{ $table->section->color }}"></span>
                                            {{ $table->section->name }}
                                        </span>
                                    @else
                                        <span class="text-[#C8D8C9]">—</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-[#718076]">{{ $table->seatsLabel }}</td>
                                <td class="px-5 py-3.5 text-[#718076]">{{ $table->shape->label() }}</td>
                                <td class="px-5 py-3.5">
                                    <button wire:click="cycleTableStatus({{ $table->id }})" type="button" title="Click to change status"
                                        class="inline-flex items-center gap-2 rounded-full bg-[#F8FAF6] px-3 py-1.5 text-xs font-bold {{ $table->status->textColor() }} transition hover:bg-[#E8F0E5]">
                                        <span class="h-2 w-2 rounded-full {{ $table->status->dotColor() }}"></span>
                                        {{ $table->status->label() }}
                                    </button>
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center justify-end gap-1">
                                        <button wire:click="selectTable({{ $table->id }})" type="button"
                                            class="rounded-full px-3 py-1.5 text-xs font-medium text-[#294936] transition hover:bg-[#F0F3EF]">
                                            Locate
                                        </button>
                                        <button wire:click="openEditTableModal({{ $table->id }})" type="button"
                                            class="rounded-full px-3 py-1.5 text-xs font-medium text-[#294936] transition hover:bg-[#F0F3EF]">
                                            Edit
                                        </button>
                                        <button wire:click="duplicateTable({{ $table->id }})" type="button"
                                            class="rounded-full px-3 py-1.5 text-xs font-medium text-[#294936] transition hover:bg-[#F0F3EF]">
                                            Duplicate
                                        </button>
                                        <button wire:click="deleteTable({{ $table->id }})" wire:confirm="Remove {{ $table->name }}?" type="button"
                                            class="rounded-full px-3 py-1.5 text-xs font-medium text-[#B94A48] transition hover:bg-[#FBEAEA]">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-14 text-center">
                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-[#F8FAF6]">
                                        <x-tabler-table class="h-6 w-6 text-[#8FA58B]" />
                                    </div>
                                    <p class="mt-3 text-sm font-medium text-[#294936]">No tables match your search</p>
                                    <p class="mt-1 text-xs text-[#8FA58B]">Try a different name or section filter.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </section>

    </div>

    @elseif ($view === 'Table Sections')

    {{-- Table Sections management view --}}
    <div class="mt-6">

        <div class="mb-4">
            <h2 class="text-lg font-bold text-[#183524]">Table sections</h2>
            <p class="text-xs text-[#718076]">Organize tables into areas of {{ $this->currentHall?->name }}.</p>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
            @forelse ($this->sections as $section)
                <div wire:key="row-section-{{ $section->id }}"
                    class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-[#E6EDE6] transition hover:shadow-md">

                    <div class="h-1.5" style="background-color: {{ $section->color }}"></div>

                    <div class="p-4">
                        <div class="flex items-center gap-3">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl"
                                style="background-color: {{ $section->color }}22; color: {{ $section->color }}">
                                <x-tabler-map-2 class="h-5 w-5" />
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-bold text-[#183524]">{{ $section->name }}</p>
                                <p class="text-xs text-[#8FA58B]">{{ $section->tables_count }} {{ \Illuminate\Support\Str::plural('table', $section->tables_count) }}</p>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-end gap-1 border-t border-[#F0F3EF] pt-3">
                            <button wire:click="openEditSectionModal({{ $section->id }})" type="button"
                                class="rounded-full px-3 py-1 text-xs font-medium text-[#294936] transition hover:bg-[#F8FAF6]">
                                Edit
                            </button>
                            <button wire:click="deleteSection({{ $section->id }})" type="button"
                                wire:confirm="Delete {{ $section->name }}? Its tables will become unassigned, not deleted."
                                class="rounded-full px-3 py-1 text-xs font-medium text-[#B94A48] transition hover:bg-[#FBEAEA]">
                                Delete
                            </button>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-full rounded-3xl border border-dashed border-[#DCE5DC] bg-white p-12 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-[#F8FAF6]">
                        <x-tabler-map-2 class="h-6 w-6 text-[#8FA58B]" />
                    </div>
                    <p class="mt-3 text-sm font-medium text-[#294936]">No sections yet</p>
                    <p class="mt-1 text-xs text-[#8FA58B]">Add one to start organizing tables.</p>
                </div>
            @endforelse
        </div>

    </div>

    @endif

    {{-- Add/Edit Table modal --}}
    @if ($showAddTableModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
            wire:click.self="closeAddTableModal">

            <div class="max-h-[90vh] w-full max-w-md overflow-y-auto rounded-3xl bg-white p-6 shadow-xl">

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                            <x-tabler-armchair class="h-5 w-5" />
                        </div>
                        <h2 class="text-lg font-bold text-[#183524]">{{ $editingTableId ? 'Edit Table' : 'Add Table' }}</h2>
                    </div>
                    <button wire:click="closeAddTableModal" type="button"
                        class="flex h-8 w-8 items-center justify-center rounded-full text-[#8FA58B] hover:bg-[#F8FAF6]">
                        <x-tabler-x class="h-4 w-4" />
                    </button>
                </div>

                <form wire:submit="saveTable" class="mt-5 space-y-4">

                    <div>
                        <label class="text-xs font-medium text-[#718076]">Table name</label>
                        <input type="text" wire:model="newTableName" placeholder="e.g. T12" autofocus
                            class="mt-1 w-full rounded-xl border border-[#DCE5DC] px-3 py-2.5 text-sm text-[#294936] focus:border-[#5E8067] focus:outline-none focus:ring-1 focus:ring-[#5E8067]">
                        @error('newTableName')
                            <p class="mt-1 text-xs text-[#B94A48]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-xs font-medium text-[#718076]">Seats</label>
                        <input type="number" min="1" max="20" wire:model="newTableSeats"
                            class="mt-1 w-full rounded-xl border border-[#DCE5DC] px-3 py-2.5 text-sm text-[#294936] focus:border-[#5E8067] focus:outline-none focus:ring-1 focus:ring-[#5E8067]">
                        @error('newTableSeats')
                            <p class="mt-1 text-xs text-[#B94A48]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-xs font-medium text-[#718076]">Shape</label>
                        <div class="mt-1 inline-flex w-full rounded-full bg-[#F0F3EF] p-1">
                            @foreach (\App\Enums\TableShape::cases() as $shape)
                                <button type="button" wire:click="$set('newTableShape', '{{ $shape->value }}')"
                                    class="flex-1 rounded-full px-3 py-2 text-sm font-medium transition
                                            {{ $newTableShape === $shape->value
                                                ? 'bg-white text-[#183524] shadow-sm'
                                                : 'text-[#718076] hover:text-[#294936]' }}">
                                    {{ $shape->label() }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-medium text-[#718076]">Section</label>
                        <select wire:model="newTableSectionId"
                            class="mt-1 w-full rounded-xl border border-[#DCE5DC] px-3 py-2.5 text-sm text-[#294936] focus:border-[#5E8067] focus:outline-none focus:ring-1 focus:ring-[#5E8067]">
                            <option value="">No section</option>
                            @foreach ($this->sections as $section)
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                            @endforeach
                        </select>
                        @error('newTableSectionId')
                            <p class="mt-1 text-xs text-[#B94A48]">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="flex items-center gap-2 rounded-2xl bg-[#F8FAF6] px-3 py-3 text-sm text-[#294936]">
                        <input type="checkbox" wire:model="newTableFeatured"
                            class="rounded border-[#DCE5DC] text-[#294936] focus:ring-[#5E8067]">
                        Feature this table (e.g. a Royal Table)
                    </label>

                    <div class="mt-2 flex items-center justify-end gap-2 pt-2">
                        <button type="button" wire:click="closeAddTableModal"
                            class="rounded-full border border-[#DCE5DC] px-5 py-2.5 text-sm font-medium text-[#294936] hover:bg-[#F8FAF6]">
                            Cancel
                        </button>
                        <button type="submit" wire:loading.attr="disabled" wire:target="saveTable"
                            class="inline-flex items-center gap-2 rounded-full bg-[#294936] px-5 py-2.5 text-sm font-medium text-white hover:bg-[#183524] disabled:opacity-60">
                            <span wire:loading.remove wire:target="saveTable">{{ $editingTableId ? 'Save Changes' : 'Add Table' }}</span>
                            <span wire:loading wire:target="saveTable">Saving…</span>
                        </button>
                    </div>

                </form>

            </div>

        </div>
    @endif

    {{-- Add Element modal (barriers + labels) --}}
    @if ($showAddElementModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
            wire:click.self="closeAddElementModal">

            <div class="max-h-[90vh] w-full max-w-md overflow-y-auto rounded-3xl bg-white p-6 shadow-xl">

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                            <x-tabler-square-plus class="h-5 w-5" />
                        </div>
                        <h2 class="text-lg font-bold text-[#183524]">Add Floor Element</h2>
                    </div>
                    <button wire:click="closeAddElementModal" type="button"
                        class="flex h-8 w-8 items-center justify-center rounded-full text-[#8FA58B] hover:bg-[#F8FAF6]">
                        <x-tabler-x class="h-4 w-4" />
                    </button>
                </div>

                <form wire:submit="createElement" class="mt-5 space-y-4">

                    <div class="inline-flex w-full rounded-full bg-[#F0F3EF] p-1">
                        @foreach (\App\Enums\FloorElementType::cases() as $type)
                            <button type="button" wire:click="$set('newElementType', '{{ $type->value }}')"
                                class="flex-1 rounded-full px-3 py-2 text-sm font-medium transition
                                        {{ $newElementType === $type->value
                                            ? 'bg-white text-[#183524] shadow-sm'
                                            : 'text-[#718076] hover:text-[#294936]' }}">
                                {{ $type->label() }}
                            </button>
                        @endforeach
                    </div>

                    @if ($newElementType === 'barrier')
                        <div>
                            <label class="text-xs font-medium text-[#718076]">Fixture type</label>
                            <div class="mt-1 grid grid-cols-4 gap-2">
                                @foreach (\App\Enums\FloorElementPreset::cases() as $preset)
                                    @continue($preset === \App\Enums\FloorElementPreset::Custom)
                                    <button type="button" wire:click="$set('newElementPreset', '{{ $preset->value }}')"
                                        class="flex flex-col items-center gap-1 rounded-2xl border px-2 py-3 text-[10px] font-medium transition
                                                {{ $newElementPreset === $preset->value
                                                    ? 'border-[#294936] bg-[#294936] text-white'
                                                    : 'border-[#DCE5DC] bg-white text-[#294936] hover:bg-[#F8FAF6]' }}">
                                        @if ($icon = $preset->icon())
                                            <x-dynamic-component :component="'tabler-'.$icon" class="h-4 w-4" />
                                        @else
                                            <x-tabler-square class="h-4 w-4" />
                                        @endif
                                        {{ $preset->label() }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div>
                        <label class="text-xs font-medium text-[#718076]">
                            {{ $newElementType === 'label' ? 'Label text' : 'Barrier name' }}
                        </label>
                        <input type="text" wire:model="newElementName" autofocus
                            placeholder="{{ $newElementType === 'label' ? 'e.g. Entrance' : 'e.g. Kitchen Wall' }}"
                            class="mt-1 w-full rounded-xl border border-[#DCE5DC] px-3 py-2.5 text-sm text-[#294936] focus:border-[#5E8067] focus:outline-none focus:ring-1 focus:ring-[#5E8067]">
                        @error('newElementName')
                            <p class="mt-1 text-xs text-[#B94A48]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs font-medium text-[#718076]">Width (px)</label>
                            <input type="number" min="24" max="800" wire:model="newElementWidth"
                                class="mt-1 w-full rounded-xl border border-[#DCE5DC] px-3 py-2.5 text-sm text-[#294936] focus:border-[#5E8067] focus:outline-none focus:ring-1 focus:ring-[#5E8067]">
                        </div>
                        <div>
                            <label class="text-xs font-medium text-[#718076]">Height (px)</label>
                            <input type="number" min="24" max="800" wire:model="newElementHeight"
                                class="mt-1 w-full rounded-xl border border-[#DCE5DC] px-3 py-2.5 text-sm text-[#294936] focus:border-[#5E8067] focus:outline-none focus:ring-1 focus:ring-[#5E8067]">
                        </div>
                    </div>

                    <div class="mt-2 flex items-center justify-end gap-2 pt-2">
                        <button type="button" wire:click="closeAddElementModal"
                            class="rounded-full border border-[#DCE5DC] px-5 py-2.5 text-sm font-medium text-[#294936] hover:bg-[#F8FAF6]">
                            Cancel
                        </button>
                        <button type="submit" wire:loading.attr="disabled" wire:target="createElement"
                            class="inline-flex items-center gap-2 rounded-full bg-[#294936] px-5 py-2.5 text-sm font-medium text-white hover:bg-[#183524] disabled:opacity-60">
                            <span wire:loading.remove wire:target="createElement">Add</span>
                            <span wire:loading wire:target="createElement">Adding…</span>
                        </button>
                    </div>

                </form>

            </div>

        </div>
    @endif

    {{-- Add/Edit Section modal --}}
    @if ($showSectionModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
            wire:click.self="closeSectionModal">

            <div class="max-h-[90vh] w-full max-w-md overflow-y-auto rounded-3xl bg-white p-6 shadow-xl">

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                            <x-tabler-map-2 class="h-5 w-5" />
                        </div>
                        <h2 class="text-lg font-bold text-[#183524]">{{ $editingSectionId ? 'Edit Section' : 'Add Section' }}</h2>
                    </div>
                    <button wire:click="closeSectionModal" type="button"
                        class="flex h-8 w-8 items-center justify-center rounded-full text-[#8FA58B] hover:bg-[#F8FAF6]">
                        <x-tabler-x class="h-4 w-4" />
                    </button>
                </div>

                <form wire:submit="saveSection" class="mt-5 space-y-4">

                    <div>
                        <label class="text-xs font-medium text-[#718076]">Section name</label>
                        <input type="text" wire:model="newSectionName" placeholder="e.g. Patio" autofocus
                            class="mt-1 w-full rounded-xl border border-[#DCE5DC] px-3 py-2.5 text-sm text-[#294936] focus:border-[#5E8067] focus:outline-none focus:ring-1 focus:ring-[#5E8067]">
                        @error('newSectionName')
                            <p class="mt-1 text-xs text-[#B94A48]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-xs font-medium text-[#718076]">Color</label>
                        <div class="mt-1 flex flex-wrap gap-2">
                            @foreach ($sectionColorPalette as $color)
                                <button type="button" wire:click="$set('newSectionColor', '{{ $color }}')"
                                    class="h-8 w-8 rounded-full border-2 transition {{ $newSectionColor === $color ? 'border-[#294936] ring-2 ring-[#E8F0E5]' : 'border-transparent' }}"
                                    style="background-color: {{ $color }}"></button>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-2 flex items-center justify-end gap-2 pt-2">
                        <button type="button" wire:click="closeSectionModal"
                            class="rounded-full border border-[#DCE5DC] px-5 py-2.5 text-sm font-medium text-[#294936] hover:bg-[#F8FAF6]">
                            Cancel
                        </button>
                        <button type="submit" wire:loading.attr="disabled" wire:target="saveSection"
                            class="inline-flex items-center gap-2 rounded-full bg-[#294936] px-5 py-2.5 text-sm font-medium text-white hover:bg-[#183524] disabled:opacity-60">
                            <span wire:loading.remove wire:target="saveSection">{{ $editingSectionId ? 'Save Changes' : 'Add Section' }}</span>
                            <span wire:loading wire:target="saveSection">Saving…</span>
                        </button>
                    </div>

                </form>

            </div>

        </div>
    @endif

    {{-- Add/Edit Dining Hall modal --}}
    @if ($showHallModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
            wire:click.self="closeHallModal">

            <div class="max-h-[90vh] w-full max-w-md overflow-y-auto rounded-3xl bg-white p-6 shadow-xl">

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                            <x-tabler-building-estate class="h-5 w-5" />
                        </div>
                        <h2 class="text-lg font-bold text-[#183524]">{{ $editingHallId ? 'Edit Dining Hall' : 'Add Dining Hall' }}</h2>
                    </div>
                    <button wire:click="closeHallModal" type="button"
                        class="flex h-8 w-8 items-center justify-center rounded-full text-[#8FA58B] hover:bg-[#F8FAF6]">
                        <x-tabler-x class="h-4 w-4" />
                    </button>
                </div>

                <form wire:submit="saveHall" class="mt-5 space-y-4">

                    <div>
                        <label class="text-xs font-medium text-[#718076]">Hall name</label>
                        <input type="text" wire:model="newHallName" placeholder="e.g. Patio" autofocus
                            class="mt-1 w-full rounded-xl border border-[#DCE5DC] px-3 py-2.5 text-sm text-[#294936] focus:border-[#5E8067] focus:outline-none focus:ring-1 focus:ring-[#5E8067]">
                        @error('newHallName')
                            <p class="mt-1 text-xs text-[#B94A48]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-2 flex items-center justify-between gap-2 pt-2">

                        @if ($editingHallId && $this->halls->count() > 1)
                            <button type="button" wire:click="deleteHall({{ $editingHallId }})"
                                wire:confirm="Delete this dining hall? Its tables, sections, and floor elements will be deleted too."
                                class="rounded-full px-4 py-2.5 text-xs font-medium text-[#B94A48] hover:bg-[#FBEAEA]">
                                Delete Hall
                            </button>
                        @else
                            <span></span>
                        @endif

                        <div class="flex items-center gap-2">
                            <button type="button" wire:click="closeHallModal"
                                class="rounded-full border border-[#DCE5DC] px-5 py-2.5 text-sm font-medium text-[#294936] hover:bg-[#F8FAF6]">
                                Cancel
                            </button>
                            <button type="submit" wire:loading.attr="disabled" wire:target="saveHall"
                                class="inline-flex items-center gap-2 rounded-full bg-[#294936] px-5 py-2.5 text-sm font-medium text-white hover:bg-[#183524] disabled:opacity-60">
                                <span wire:loading.remove wire:target="saveHall">{{ $editingHallId ? 'Save Changes' : 'Add Hall' }}</span>
                                <span wire:loading wire:target="saveHall">Saving…</span>
                            </button>
                        </div>

                    </div>

                </form>

            </div>

        </div>
    @endif

    @endif

</div>