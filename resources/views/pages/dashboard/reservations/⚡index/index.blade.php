{{-- reservations/⚡index/index.blade.php --}}

<div>

    <div x-data="{ show: false, message: '', timer: null }"
        x-on:points-awarded.window="message = $event.detail.message; show = true; clearTimeout(timer); timer = setTimeout(() => show = false, 3500)"
        x-show="show" x-cloak
        x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="translate-y-2 opacity-0"
        x-transition:leave="transition duration-150 ease-in" x-transition:leave-end="opacity-0"
        class="fixed bottom-6 right-6 z-[70] flex items-center gap-2.5 rounded-full bg-[#294936] py-3 pl-4 pr-5 text-sm font-semibold text-white shadow-xl">
        <x-tabler-sparkles class="h-4 w-4 text-[#D8C78A]" />
        <span x-text="message"></span>
    </div>


    @php
        $crumb = ['Reservations' => 'Board', 'Waitlist' => 'Waitlist'][$view] ?? $view;
    @endphp

    {{-- Page header --}}
    <div class="mb-6">
        <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-sm text-[#718076]">
            <span>Operations</span>
            <x-tabler-chevron-right class="h-4 w-4 text-[#C8D8C9]" />
            <span>Reservations</span>
            <x-tabler-chevron-right class="h-4 w-4 text-[#C8D8C9]" />
            <span class="font-medium text-[#183524]">{{ $crumb }}</span>
        </nav>
        <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#183524]">Reservations</h1>
        <p class="mt-1 text-sm text-[#718076]">Bookings, walk-ins and the waitlist for your dining halls.</p>
    </div>

    @if ($this->halls->isEmpty())

        <div class="flex min-h-[420px] flex-col items-center justify-center rounded-3xl border border-dashed border-[#DCE5DC] bg-white p-10 text-center">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F8FAF6]">
                <x-tabler-building-estate class="h-7 w-7 text-[#8FA58B]" />
            </div>
            <h2 class="mt-5 text-xl font-semibold text-[#183524]">No dining halls yet</h2>
            <p class="mt-2 max-w-sm text-sm text-[#718076]">
                Create a dining hall from the Tables page before taking reservations.
            </p>
        </div>

    @else

    @php
        $sel = \Carbon\Carbon::parse($selectedDate);
        $isToday = $sel->isToday();
    @endphp

    {{-- Hero --}}
    <div class="rounded-3xl bg-[#294936] p-6 text-white sm:p-7">

        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/10">
                    <x-tabler-bookmark class="h-6 w-6" />
                </div>
                <div>
                    <div class="relative inline-flex items-center">
                        <select wire:model.live="currentHallId"
                            class="appearance-none border-0 bg-transparent py-0 pl-0 pr-6 text-2xl font-bold tracking-tight text-white focus:outline-none focus:ring-0 [&>option]:text-[#183524]">
                            @foreach ($this->halls as $hall)
                                <option value="{{ $hall->id }}">{{ $hall->name }}</option>
                            @endforeach
                        </select>
                        <x-tabler-chevron-down class="pointer-events-none absolute right-0 h-4 w-4 text-white/60" />
                    </div>
                    <p class="mt-0.5 text-sm text-white/60">Service board · {{ $sel->format('l, F j') }}</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                @if ($view === 'Reservations')
                    <button wire:click="openNewReservationModal(false)" type="button"
                        class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-white/20">
                        <x-tabler-calendar-plus class="h-4 w-4" />
                        New Reservation
                    </button>
                    <button wire:click="openNewReservationModal(true)" type="button"
                        class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-2.5 text-sm font-semibold text-[#183524] transition hover:bg-[#E8F0E5]">
                        <x-tabler-walk class="h-4 w-4" />
                        Seat Walk-in
                    </button>
                @elseif ($view === 'Waitlist')
                    <button wire:click="openAddWaitlistModal" type="button"
                        class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-2.5 text-sm font-semibold text-[#183524] transition hover:bg-[#E8F0E5]">
                        <x-tabler-plus class="h-4 w-4" />
                        Add to Waitlist
                    </button>
                @elseif ($view === 'Guests')
                    <button wire:click="openAddGuestModal" type="button"
                        class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-2.5 text-sm font-semibold text-[#183524] transition hover:bg-[#E8F0E5]">
                        <x-tabler-plus class="h-4 w-4" />
                        Add Guest
                    </button>
                @endif
            </div>

        </div>

        @if ($view === 'Reservations')
            @php
                $tiles = [
                    ['Bookings', $this->stats['reservations'], 'bookmark'],
                    ['Expected guests', $this->stats['expected_guests'], 'users'],
                    ['Seated', $this->stats['seated'], 'armchair'],
                    ['Waiting', $this->stats['waitlist'], 'hourglass'],
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
        @endif

    </div>

    {{-- Tabs + date picker --}}
    <div class="mt-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <div class="inline-flex self-start rounded-full bg-[#F0F3EF] p-1">
            @foreach (['Reservations', 'Waitlist'] as $item)
                <button wire:click="setView('{{ $item }}')" type="button"
                    class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-medium transition
                            {{ $view === $item ? 'bg-white text-[#183524] shadow-sm' : 'text-[#718076] hover:text-[#294936]' }}">

                    @if ($item === 'Reservations')
                        <x-tabler-layout-columns class="h-4 w-4" />
                    @else
                        <x-tabler-hourglass class="h-4 w-4" />
                    @endif

                    {{ $item }}

                    @if ($item === 'Waitlist' && $this->stats['waitlist'] > 0)
                        <span class="rounded-full bg-[#FFF4DD] px-1.5 text-[10px] font-semibold text-[#9A762B]">{{ $this->stats['waitlist'] }}</span>
                    @endif
                </button>
            @endforeach
        </div>

        @if ($view === 'Reservations')
            <div class="flex items-center gap-2" x-data="{ open: false }">

                @unless ($isToday)
                    <button wire:click="goToToday" type="button"
                        class="rounded-full border border-[#DCE5DC] bg-white px-3.5 py-2 text-xs font-semibold text-[#5E8067] shadow-sm transition hover:bg-[#F8FAF6]">
                        Back to today
                    </button>
                @endunless

                <div class="relative">
                    <div class="inline-flex items-center rounded-full border border-[#DCE5DC] bg-white p-1 shadow-sm">
                        <button wire:click="prevDay" type="button"
                            class="flex h-9 w-9 items-center justify-center rounded-full text-[#718076] transition hover:bg-[#F8FAF6]">
                            <x-tabler-chevron-left class="h-4 w-4" />
                        </button>

                        <button type="button" x-on:click="open = ! open"
                            class="flex items-center gap-2.5 rounded-full px-3 py-1.5 transition hover:bg-[#F8FAF6]">
                            <x-tabler-calendar-event class="h-4 w-4 text-[#5E8067]" />
                            <span class="text-left leading-tight">
                                <span class="block text-[10px] font-semibold uppercase tracking-[0.16em] text-[#8FA58B]">{{ $isToday ? 'Today' : $sel->format('l') }}</span>
                                <span class="block text-sm font-bold text-[#183524]">{{ $sel->format('F j, Y') }}</span>
                            </span>
                            <x-tabler-chevron-down class="h-3.5 w-3.5 text-[#8FA58B]" />
                        </button>

                        <button wire:click="nextDay" type="button"
                            class="flex h-9 w-9 items-center justify-center rounded-full text-[#718076] transition hover:bg-[#F8FAF6]">
                            <x-tabler-chevron-right class="h-4 w-4" />
                        </button>
                    </div>

                    {{-- Calendar popover --}}
                    <div x-show="open" x-cloak x-transition.opacity.duration.150ms
                        x-on:click.outside="open = false" x-on:keydown.escape.window="open = false"
                        class="absolute right-0 z-30 mt-2 w-[320px] rounded-3xl border border-[#DCE5DC] bg-white p-4 shadow-xl">

                        <div class="flex items-center justify-between">
                            <button wire:click="prevMonth" type="button"
                                class="flex h-8 w-8 items-center justify-center rounded-full text-[#718076] transition hover:bg-[#F8FAF6]">
                                <x-tabler-chevron-left class="h-4 w-4" />
                            </button>
                            <p class="text-sm font-bold text-[#183524]">{{ \Carbon\Carbon::parse($calendarMonth.'-01')->format('F Y') }}</p>
                            <button wire:click="nextMonth" type="button"
                                class="flex h-8 w-8 items-center justify-center rounded-full text-[#718076] transition hover:bg-[#F8FAF6]">
                                <x-tabler-chevron-right class="h-4 w-4" />
                            </button>
                        </div>

                        <div class="mt-3 grid grid-cols-7 text-center text-[10px] font-semibold uppercase tracking-wide text-[#8FA58B]">
                            @foreach (['S', 'M', 'T', 'W', 'T', 'F', 'S'] as $dayName)
                                <div class="py-1.5">{{ $dayName }}</div>
                            @endforeach
                        </div>

                        <div class="space-y-1">
                            @foreach ($this->calendarWeeks as $week)
                                <div class="grid grid-cols-7 gap-1">
                                    @foreach ($week as $day)
                                        <button wire:key="pick-{{ $day['date'] }}" wire:click="pickDate('{{ $day['date'] }}')" x-on:click="open = false" type="button"
                                            class="relative flex h-10 flex-col items-center justify-center rounded-xl text-sm transition
                                                    {{ $day['date'] === $selectedDate ? 'bg-[#294936] font-bold text-white' : ($day['inMonth'] ? 'text-[#183524] hover:bg-[#F8FAF6]' : 'text-[#C8D8C9] hover:bg-[#F8FAF6]') }}
                                                    {{ $day['isToday'] && $day['date'] !== $selectedDate ? 'ring-1 ring-[#294936]' : '' }}">
                                            <span class="leading-none">{{ $day['day'] }}</span>
                                            @if ($day['count'] > 0)
                                                <span class="mt-0.5 flex items-center gap-0.5">
                                                    <span class="h-1 w-1 rounded-full {{ $day['date'] === $selectedDate ? 'bg-white' : 'bg-[#5E8067]' }}"></span>
                                                    @if ($day['count'] > 3)
                                                        <span class="h-1 w-1 rounded-full {{ $day['date'] === $selectedDate ? 'bg-white' : 'bg-[#5E8067]' }}"></span>
                                                    @endif
                                                </span>
                                            @endif
                                        </button>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-3 flex items-center justify-between border-t border-[#F0F3EF] pt-3">
                            <p class="flex items-center gap-1.5 text-[11px] text-[#8FA58B]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#5E8067]"></span> has bookings
                            </p>
                            <button wire:click="goToToday" x-on:click="open = false" type="button" class="text-xs font-semibold text-[#5E8067] hover:text-[#294936]">
                                Jump to today
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        @endif

    </div>

    @if ($view === 'Reservations')

        {{-- Insights --}}
        @php
            $all = $this->reservationsForDate;

            // Floor donut
            $tableTotal = $this->tableStats['total'];
            $safeTotal = max($tableTotal, 1);
            $availPct = ($this->tableStats['available'] / $safeTotal) * 100;
            $resPct = ($this->tableStats['reserved'] / $safeTotal) * 100;
            $occPct = ($this->tableStats['occupied'] / $safeTotal) * 100;
            $donut = $tableTotal === 0
                ? '#F0F3EF'
                : 'conic-gradient(#5E8067 0 '.$availPct.'%, #9A762B '.$availPct.'% '.($availPct + $resPct).'%, #294936 '.($availPct + $resPct).'% 100%)';

            // Service load by hour
            $byHour = $all->filter(fn ($r) => $r->status->value !== 'no_show')
                ->groupBy(fn ($r) => (int) $r->reserved_for->format('G'));
            $startHour = min(11, $byHour->keys()->min() ?? 11);
            $endHour = max(22, $byHour->keys()->max() ?? 22);
            $maxCovers = max(1, $byHour->map(fn ($g) => $g->sum('party_size'))->max() ?? 1);
            $nowHour = $isToday ? (int) now()->format('G') : null;
            $waiting = $this->waitlistEntries;
        @endphp

        <div class="mt-6 grid gap-4 lg:grid-cols-3">

            {{-- Service load --}}
            <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[#E6EDE6]">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-wide text-[#8FA58B]">Service load</p>
                    <span class="text-[11px] text-[#718076]">guests per hour</span>
                </div>
                <div class="mt-4 flex h-20 items-end gap-1">
                    @foreach (range($startHour, $endHour) as $h)
                        @php
                            $covers = ($byHour[$h] ?? collect())->sum('party_size');
                            $barPx = $covers ? 10 + (int) round(($covers / $maxCovers) * 70) : 4;
                            $barColor = $h === $nowHour ? 'bg-[#9A762B]' : ($covers ? 'bg-[#5E8067]' : 'bg-[#E8F0E5]');
                        @endphp
                        <div class="flex flex-1 items-end justify-center" title="{{ $covers }} guests at {{ sprintf('%02d', $h) }}:00">
                            <div class="w-full rounded-t-md {{ $barColor }}" style="height: {{ $barPx }}px"></div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-1.5 flex gap-1">
                    @foreach (range($startHour, $endHour) as $h)
                        <p class="flex-1 text-center text-[9px] {{ $h === $nowHour ? 'font-bold text-[#9A762B]' : 'text-[#8FA58B]' }}">{{ $h }}</p>
                    @endforeach
                </div>
            </div>

            {{-- Floor pulse --}}
            <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[#E6EDE6]">
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
                        <p class="flex items-center gap-2 text-[#718076]"><span class="h-2 w-2 rounded-full bg-[#5E8067]"></span><span class="font-semibold text-[#183524]">{{ $this->tableStats['available'] }}</span> free</p>
                        <p class="flex items-center gap-2 text-[#718076]"><span class="h-2 w-2 rounded-full bg-[#9A762B]"></span><span class="font-semibold text-[#183524]">{{ $this->tableStats['reserved'] }}</span> reserved</p>
                        <p class="flex items-center gap-2 text-[#718076]"><span class="h-2 w-2 rounded-full bg-[#294936]"></span><span class="font-semibold text-[#183524]">{{ $this->tableStats['occupied'] }}</span> occupied</p>
                    </div>
                </div>
            </div>

            {{-- Waitlist peek --}}
            <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[#E6EDE6]">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-wide text-[#8FA58B]">Next on the waitlist</p>
                    <button wire:click="setView('Waitlist')" type="button" class="inline-flex items-center gap-1 text-xs font-medium text-[#5E8067] hover:text-[#294936]">
                        View all <x-tabler-arrow-right class="h-3.5 w-3.5" />
                    </button>
                </div>
                <div class="mt-3 space-y-2">
                    @forelse ($waiting->take(3) as $entry)
                        <button wire:key="peek-{{ $entry->id }}" wire:click="seatFromWaitlist({{ $entry->id }})" type="button"
                            class="flex w-full items-center justify-between rounded-2xl bg-[#F8FAF6] px-3 py-2 text-left transition hover:bg-[#F0F3EF]">
                            <span>
                                <span class="block text-sm font-semibold text-[#183524]">{{ $entry->guest->name }}</span>
                                <span class="block text-[11px] text-[#8FA58B]">{{ $entry->party_size }} {{ \Illuminate\Support\Str::plural('guest', $entry->party_size) }}</span>
                            </span>
                            <span class="rounded-full bg-[#FFF4DD] px-2 py-1 text-[10px] font-bold text-[#9A762B]">{{ $entry->waitedMinutes() }} min</span>
                        </button>
                    @empty
                        <div class="flex items-center gap-2 rounded-2xl bg-[#F8FAF6] px-3 py-4 text-xs text-[#8FA58B]">
                            <x-tabler-check class="h-4 w-4 text-[#5E8067]" />
                            No one's waiting right now.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- Board --}}
        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-lg font-bold text-[#183524]">{{ $isToday ? "Today's board" : $sel->format('l').'’s board' }}</h2>
                <p class="text-xs text-[#718076]">Seat and complete guests to move them across the board.</p>
            </div>
            <div class="relative">
                <x-tabler-search class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8FA58B]" />
                <input wire:model.live.debounce.300ms="search" type="search" placeholder="Search guest or table…"
                    class="w-full rounded-full border border-[#DCE5DC] bg-white py-2.5 pl-10 pr-4 text-sm text-[#26342A] outline-none placeholder:text-[#9AA79D] focus:border-[#8FA58B] focus:ring-2 focus:ring-[#E8F0E5] sm:w-72" />
            </div>
        </div>

        @php
            $columns = [
                [
                    'label' => 'Upcoming', 'icon' => 'clock', 'tint' => 'bg-[#E8F0E5] text-[#5E8067]',
                    'empty' => 'No upcoming bookings',
                    'items' => $all->filter(fn ($r) => $r->status->value === 'confirmed' && ! $r->isArrivingSoon()),
                ],
                [
                    'label' => 'Arriving soon', 'icon' => 'bell', 'tint' => 'bg-[#FFF4DD] text-[#9A762B]',
                    'empty' => 'No one arriving soon',
                    'items' => $all->filter(fn ($r) => $r->isArrivingSoon()),
                ],
                [
                    'label' => 'Seated', 'icon' => 'armchair', 'tint' => 'bg-[#294936] text-white',
                    'empty' => 'No tables seated',
                    'items' => $all->filter(fn ($r) => $r->status->value === 'seated'),
                ],
                [
                    'label' => 'Wrapped', 'icon' => 'flag', 'tint' => 'bg-[#E4E9E4] text-[#718076]',
                    'empty' => 'Nothing wrapped yet',
                    'items' => $all->filter(fn ($r) => in_array($r->status->value, ['completed', 'no_show'])),
                ],
            ];
            $avatarPalette = ['#5E8067', '#9A762B', '#47708F', '#B94A48', '#294936'];
        @endphp

        <div class="mt-4 flex snap-x snap-mandatory gap-4 overflow-x-auto pb-3 xl:snap-none">
            @foreach ($columns as $column)
                <section wire:key="column-{{ $column['label'] }}"
                    class="flex max-h-[68vh] min-h-[260px] w-[300px] shrink-0 snap-start flex-col rounded-3xl bg-[#F8FAF6] p-3 ring-1 ring-[#EDF2ED] xl:w-auto xl:min-w-[250px] xl:flex-1">

                    <div class="flex shrink-0 items-center justify-between px-1 pb-3">
                        <div class="flex items-center gap-2.5">
                            <span class="flex h-8 w-8 items-center justify-center rounded-xl {{ $column['tint'] }}">
                                <x-dynamic-component :component="'tabler-'.$column['icon']" class="h-4 w-4" />
                            </span>
                            <div class="leading-tight">
                                <h3 class="text-sm font-bold text-[#183524]">{{ $column['label'] }}</h3>
                                <p class="text-[10px] text-[#8FA58B]">{{ $column['items']->sum('party_size') }} guests</p>
                            </div>
                        </div>
                        <span class="rounded-full bg-white px-2.5 py-1 text-xs font-bold text-[#294936] shadow-sm">{{ $column['items']->count() }}</span>
                    </div>

                    <div class="min-h-0 flex-1 space-y-3 overflow-y-auto overscroll-contain pb-14 pr-1 [scrollbar-width:thin] [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-[#DCE5DC] [&::-webkit-scrollbar]:w-1.5">
                        @forelse ($column['items'] as $reservation)
                            @php
                                $status = $reservation->status->value;
                                $soon = $reservation->isArrivingSoon();
                                $late = $reservation->isLate();
                                $avatar = $avatarPalette[crc32($reservation->guest->name) % count($avatarPalette)];
                                $accent = match (true) {
                                    $soon => 'border-l-[#9A762B]',
                                    $late => 'border-l-[#B94A48]',
                                    $status === 'seated' => 'border-l-[#294936]',
                                    in_array($status, ['completed', 'no_show']) => 'border-l-[#718076]',
                                    default => 'border-l-[#C8D8C9]',
                                };
                                $faded = in_array($status, ['completed', 'no_show']) ? 'opacity-60' : '';
                            @endphp

                            <article wire:key="reservation-card-{{ $reservation->id }}"
                                class="group rounded-2xl border border-l-4 border-[#E6EDE6] {{ $accent }} {{ $faded }} bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">

                                <div class="flex items-start gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-sm font-bold text-white" style="background-color: {{ $avatar }}">
                                        {{ strtoupper(mb_substr($reservation->guest->name, 0, 1)) }}
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <a href="/dashboard/guests?guest={{ $reservation->guest_id }}" wire:navigate
                                            class="block truncate text-sm font-bold text-[#183524] hover:text-[#5E8067] hover:underline">
                                            {{ $reservation->guest->name }}
                                        </a>
                                        <p class="mt-0.5 flex items-center gap-1 text-xs text-[#718076]">
                                            <x-tabler-clock class="h-3.5 w-3.5" />
                                            {{ $reservation->reserved_for->format('H:i') }}–{{ $reservation->endsAt()->format('H:i') }}
                                        </p>
                                    </div>

                                    @if (in_array($status, ['confirmed', 'seated']))
                                        <div class="relative shrink-0" x-data="{ open: false }">
                                            <button type="button" x-on:click="open = ! open"
                                                class="flex h-7 w-7 items-center justify-center rounded-lg text-[#8FA58B] hover:bg-[#F8FAF6]">
                                                <x-tabler-dots class="h-4 w-4" />
                                            </button>
                                            <div x-show="open" x-on:click.away="open = false" x-cloak
                                                class="absolute right-0 z-10 mt-1 w-36 overflow-hidden rounded-xl border border-[#DCE5DC] bg-white shadow-lg">
                                                @if ($status === 'confirmed')
                                                    <button type="button" wire:click="openEditReservationModal({{ $reservation->id }})" x-on:click="open = false"
                                                        class="block w-full px-3 py-2 text-left text-xs font-medium text-[#294936] hover:bg-[#F8FAF6]">
                                                        Edit
                                                    </button>
                                                    <button type="button" wire:click="markNoShow({{ $reservation->id }})" x-on:click="open = false"
                                                        class="block w-full px-3 py-2 text-left text-xs font-medium text-[#B94A48] hover:bg-[#FBEAEA]">
                                                        Mark No-show
                                                    </button>
                                                @endif
                                                <button type="button" wire:click="cancelReservation({{ $reservation->id }})" x-on:click="open = false"
                                                    class="block w-full px-3 py-2 text-left text-xs font-medium text-[#B94A48] hover:bg-[#FBEAEA]">
                                                    Cancel
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-3 flex flex-wrap items-center gap-1.5">
                                    <span class="inline-flex items-center gap-1 rounded-lg bg-[#F8FAF6] px-2 py-1 text-[11px] font-semibold text-[#294936]">
                                        <x-tabler-users class="h-3.5 w-3.5 text-[#8FA58B]" />
                                        {{ $reservation->party_size }}
                                    </span>

                                    @if ($reservation->table)
                                        <a href="/dashboard/tables?table={{ $reservation->table->id }}" wire:navigate
                                            class="inline-flex items-center gap-1 rounded-lg bg-[#F8FAF6] px-2 py-1 text-[11px] font-semibold text-[#294936] transition hover:bg-[#E8F0E5]">
                                            <x-tabler-armchair class="h-3.5 w-3.5 text-[#8FA58B]" />
                                            {{ $reservation->table->name }}
                                        </a>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-lg border border-dashed border-[#DCE5DC] px-2 py-1 text-[11px] text-[#8FA58B]">
                                            <x-tabler-armchair class="h-3.5 w-3.5" />
                                            No table
                                        </span>
                                    @endif

                                    @if ($soon)
                                        <span class="rounded-lg bg-[#FFF4DD] px-2 py-1 text-[11px] font-bold text-[#9A762B]">
                                            in {{ max(1, abs((int) now()->diffInMinutes($reservation->reserved_for))) }} min
                                        </span>
                                    @elseif ($late)
                                        <span class="rounded-lg bg-[#FBEAEA] px-2 py-1 text-[11px] font-bold text-[#B94A48]">Running late</span>
                                    @elseif ($status === 'seated' && $reservation->seated_at)
                                        <span class="rounded-lg bg-[#E8F0E5] px-2 py-1 text-[11px] font-bold text-[#5E8067]">Seated {{ $reservation->seated_at->format('H:i') }}</span>
                                    @elseif (in_array($status, ['completed', 'no_show']))
                                        <span class="rounded-lg {{ $reservation->status->bgColor() }} px-2 py-1 text-[11px] font-bold {{ $reservation->status->textColor() }}">{{ $reservation->status->label() }}</span>
                                    @endif

                                    @if ($reservation->points_awarded > 0)
                                        <span class="inline-flex items-center gap-1 rounded-lg bg-[#FFF4DD] px-2 py-1 text-[11px] font-bold text-[#9A762B]">
                                            <x-tabler-sparkles class="h-3.5 w-3.5" />
                                            +{{ $reservation->points_awarded }} pts
                                        </span>
                                    @endif
                                </div>

                                @if ($reservation->notes)
                                    <p class="mt-2.5 truncate text-xs italic text-[#8FA58B]">“{{ $reservation->notes }}”</p>
                                @endif

                                @php
                                    $diet = $reservation->guest->dietary ?? [];
                                    $hasAllergy = in_array('nut_allergy', $diet);
                                    $tier = $reservation->guest->tier;
                                    $fav = $reservation->guest->favorite_item;
                                @endphp
                                
                                @if ($hasAllergy || $tier !== 'Member' || count($diet) || $fav)
                                    <div class="mt-2.5 flex flex-wrap items-center gap-1.5">
                                        @if ($hasAllergy)
                                            <span class="inline-flex items-center gap-1 rounded-lg bg-[#FBEAEA] px-2 py-1 text-[11px] font-bold text-[#B94A48]">
                                                <x-tabler-alert-triangle class="h-3.5 w-3.5" />
                                                Nut allergy
                                            </span>
                                        @endif
                                
                                        @foreach (array_diff($diet, ['nut_allergy']) as $d)
                                            <span class="rounded-lg bg-[#E8F0E5] px-2 py-1 text-[11px] font-semibold text-[#5E8067]">
                                                {{ \App\Models\Guest::DIETARY[$d] ?? $d }}
                                            </span>
                                        @endforeach
                                
                                        @if ($tier !== 'Member')
                                            <span class="inline-flex items-center gap-1 rounded-lg px-2 py-1 text-[11px] font-bold
                                                {{ $tier === 'Gold' ? 'bg-[#FFF4DD] text-[#9A762B]' : 'bg-[#F0F3EF] text-[#718076]' }}">
                                                <x-tabler-crown class="h-3.5 w-3.5" />
                                                {{ $tier }}
                                            </span>
                                        @endif
                                
                                        @if ($fav)
                                            <span class="truncate text-[11px] text-[#8FA58B]">♥ {{ $fav }}</span>
                                        @endif
                                    </div>
                                @endif

                                @if ($status === 'confirmed')
                                    <button wire:click="seatReservation({{ $reservation->id }})" type="button"
                                        class="mt-3 flex w-full items-center justify-center gap-2 rounded-xl bg-[#294936] px-3 py-2 text-xs font-semibold text-white transition hover:bg-[#183524]">
                                        <x-tabler-armchair class="h-4 w-4" />
                                        Seat
                                    </button>
                                @elseif ($status === 'seated')
                                    <button wire:click="completeReservation({{ $reservation->id }})" type="button"
                                        class="mt-3 flex w-full items-center justify-center gap-2 rounded-xl border border-[#DCE5DC] px-3 py-2 text-xs font-semibold text-[#294936] transition hover:bg-[#F8FAF6]">
                                        <x-tabler-flag class="h-4 w-4" />
                                        Complete
                                    </button>
                                @endif

                            </article>
                        @empty
                            <div class="flex flex-col items-center gap-2 rounded-2xl border border-dashed border-[#DCE5DC] px-3 py-8 text-center">
                                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white text-[#C8D8C9]">
                                    <x-dynamic-component :component="'tabler-'.$column['icon']" class="h-5 w-5" />
                                </span>
                                <p class="text-xs text-[#8FA58B]">{{ $column['empty'] }}</p>
                            </div>
                        @endforelse
                    </div>

                </section>
            @endforeach
        </div>

    @elseif ($view === 'Waitlist')

        @php
            $entries = $this->waitlistEntries;
            $waits = $entries->map(fn ($e) => $e->waitedMinutes());
            $avgWait = $entries->count() ? (int) round($waits->avg()) : 0;
            $longest = $waits->max() ?? 0;
        @endphp

        <div class="mt-6 grid grid-cols-3 gap-3">
            <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-[#E6EDE6]">
                <p class="text-[11px] font-medium uppercase tracking-wide text-[#8FA58B]">In line</p>
                <p class="mt-1 text-2xl font-bold text-[#183524]">{{ $entries->count() }}</p>
            </div>
            <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-[#E6EDE6]">
                <p class="text-[11px] font-medium uppercase tracking-wide text-[#8FA58B]">Avg wait</p>
                <p class="mt-1 text-2xl font-bold text-[#183524]">{{ $avgWait }}<span class="ml-1 text-sm font-medium text-[#8FA58B]">min</span></p>
            </div>
            <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-[#E6EDE6]">
                <p class="text-[11px] font-medium uppercase tracking-wide text-[#8FA58B]">Longest</p>
                <p class="mt-1 text-2xl font-bold {{ $longest >= 20 ? 'text-[#B94A48]' : 'text-[#183524]' }}">{{ $longest }}<span class="ml-1 text-sm font-medium text-[#8FA58B]">min</span></p>
            </div>
        </div>

        <div class="mt-4 space-y-3">

            @forelse ($entries as $index => $entry)
                @php
                    $mins = $entry->waitedMinutes();
                    $urgency = $mins >= 20
                        ? 'bg-[#FBEAEA] text-[#B94A48]'
                        : ($mins >= 10 ? 'bg-[#FFF4DD] text-[#9A762B]' : 'bg-[#E8F0E5] text-[#5E8067]');
                @endphp

                <div wire:key="waitlist-{{ $entry->id }}" class="flex items-center gap-4 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-[#E6EDE6]">

                    <div class="flex h-16 w-16 shrink-0 flex-col items-center justify-center rounded-2xl {{ $urgency }}">
                        <span class="text-2xl font-bold leading-none">{{ $mins }}</span>
                        <span class="mt-1 text-[9px] font-semibold uppercase tracking-wide">min</span>
                    </div>

                    <div class="min-w-0 flex-1">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-[#8FA58B]">#{{ $index + 1 }} in line</p>
                        <p class="truncate text-base font-bold text-[#183524]">{{ $entry->guest->name }}</p>
                        <p class="text-xs text-[#718076]">{{ $entry->party_size }} {{ \Illuminate\Support\Str::plural('guest', $entry->party_size) }}</p>
                    </div>

                    <div class="flex shrink-0 items-center gap-2">
                        <button wire:click="seatFromWaitlist({{ $entry->id }})" type="button"
                            class="inline-flex items-center gap-2 rounded-full bg-[#294936] px-4 py-2 text-xs font-semibold text-white transition hover:bg-[#183524]">
                            <x-tabler-armchair class="h-4 w-4" />
                            Seat
                        </button>
                        <button wire:click="removeFromWaitlist({{ $entry->id }})" wire:confirm="Remove {{ $entry->guest->name }} from the waitlist?" type="button"
                            class="rounded-full px-3 py-2 text-xs font-medium text-[#B94A48] transition hover:bg-[#FBEAEA]">
                            Remove
                        </button>
                    </div>

                </div>
            @empty
                <div class="rounded-3xl border border-dashed border-[#DCE5DC] bg-white p-12 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-[#F8FAF6]">
                        <x-tabler-hourglass class="h-6 w-6 text-[#8FA58B]" />
                    </div>
                    <p class="mt-3 text-sm font-medium text-[#294936]">No one's waiting right now</p>
                    <p class="mt-1 text-xs text-[#8FA58B]">Walk-ins who can't be seated straight away will queue up here.</p>
                </div>
            @endforelse

        </div>

    @elseif ($view === 'Guests')

        @php
            $guestList = $this->guests;
            $returning = $guestList->where('reservations_count', '>', 1)->count();
            $avatarPalette = ['#5E8067', '#9A762B', '#47708F', '#B94A48', '#294936'];
        @endphp

        <div class="mt-6 grid grid-cols-3 gap-3">
            <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-[#E6EDE6]">
                <p class="text-[11px] font-medium uppercase tracking-wide text-[#8FA58B]">Guests</p>
                <p class="mt-1 text-2xl font-bold text-[#183524]">{{ $guestList->count() }}</p>
            </div>
            <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-[#E6EDE6]">
                <p class="text-[11px] font-medium uppercase tracking-wide text-[#8FA58B]">Returning</p>
                <p class="mt-1 text-2xl font-bold text-[#5E8067]">{{ $returning }}</p>
            </div>
            <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-[#E6EDE6]">
                <p class="text-[11px] font-medium uppercase tracking-wide text-[#8FA58B]">First-timers</p>
                <p class="mt-1 text-2xl font-bold text-[#183524]">{{ $guestList->count() - $returning }}</p>
            </div>
        </div>

        <div class="mt-4">

            <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-lg font-bold text-[#183524]">Guest directory</h2>
                <div class="relative">
                    <x-tabler-search class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8FA58B]" />
                    <input wire:model.live.debounce.300ms="search" type="search" placeholder="Search name, phone, email…"
                        class="w-full rounded-full border border-[#DCE5DC] bg-white py-2.5 pl-10 pr-4 text-sm text-[#26342A] outline-none placeholder:text-[#9AA79D] focus:border-[#8FA58B] focus:ring-2 focus:ring-[#E8F0E5] sm:w-72" />
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
                @forelse ($guestList as $guest)
                    @php $avatar = $avatarPalette[crc32($guest->name) % count($avatarPalette)]; @endphp

                    <div wire:key="guest-{{ $guest->id }}" class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-[#E6EDE6] transition hover:shadow-md">
                        <div class="flex items-start gap-3">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full text-sm font-bold text-white" style="background-color: {{ $avatar }}">
                                {{ strtoupper(mb_substr($guest->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-bold text-[#183524]">{{ $guest->name }}</p>
                                <p class="truncate text-xs text-[#718076]">{{ $guest->phone ?? $guest->email ?? 'No contact info' }}</p>
                            </div>
                            <span class="shrink-0 rounded-full bg-[#F0F3EF] px-2 py-0.5 text-[10px] font-semibold text-[#718076]">
                                {{ $guest->reservations_count }} {{ $guest->reservations_count === 1 ? 'visit' : 'visits' }}
                            </span>
                        </div>

                        @if ($guest->notes)
                            <p class="mt-3 line-clamp-2 text-xs italic text-[#8FA58B]">{{ $guest->notes }}</p>
                        @endif

                        <div class="mt-3 flex items-center justify-end gap-1 border-t border-[#F0F3EF] pt-3">
                            <button wire:click="openEditGuestModal({{ $guest->id }})" type="button"
                                class="rounded-full px-3 py-1 text-xs font-medium text-[#294936] transition hover:bg-[#F8FAF6]">
                                Edit
                            </button>
                            @if ($guest->reservations_count === 0 && $guest->waitlist_entries_count === 0)
                                <button wire:click="deleteGuest({{ $guest->id }})" wire:confirm="Remove {{ $guest->name }}?" type="button"
                                    class="rounded-full px-3 py-1 text-xs font-medium text-[#B94A48] transition hover:bg-[#FBEAEA]">
                                    Delete
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full rounded-3xl border border-dashed border-[#DCE5DC] bg-white p-12 text-center text-sm text-[#8FA58B]">
                        No guests match your search.
                    </div>
                @endforelse
            </div>

        </div>

    @endif

    {{-- Add/Edit Reservation modal --}}
    @if ($showReservationModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4" wire:click.self="closeReservationModal">
            <div class="max-h-[90vh] w-full max-w-lg overflow-y-auto rounded-3xl bg-white p-6 shadow-xl">

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                            @if ($isWalkIn)
                                <x-tabler-walk class="h-5 w-5" />
                            @else
                                <x-tabler-calendar-plus class="h-5 w-5" />
                            @endif
                        </div>
                        <h2 class="text-lg font-bold text-[#183524]">
                            @if ($editingReservationId)
                                Edit Reservation
                            @elseif ($isWalkIn)
                                Seat Walk-in
                            @else
                                New Reservation
                            @endif
                        </h2>
                    </div>
                    <button wire:click="closeReservationModal" class="flex h-8 w-8 items-center justify-center rounded-full text-[#8FA58B] hover:bg-[#F8FAF6]">
                        <x-tabler-x class="h-4 w-4" />
                    </button>
                </div>

                <form wire:submit="saveReservation" class="mt-5 space-y-4">

                    <div>
                        <x-guest-combobox
                            model="newGuestName"
                            target="reservation"
                            :value="$newGuestName"
                            :suggestions="$this->guestSuggestions"
                            :selected="$this->selectedGuest" />
                        @error('newGuestName') <p class="mt-1 text-xs text-[#B94A48]">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs font-medium text-[#718076]">Phone (optional)</label>
                            <input type="text" wire:model="newGuestPhone" placeholder="Phone"
                                class="mt-1 w-full rounded-xl border border-[#DCE5DC] px-3 py-2.5 text-sm text-[#294936] focus:border-[#5E8067] focus:outline-none focus:ring-1 focus:ring-[#5E8067]">
                        </div>
                        <div>
                            <label class="text-xs font-medium text-[#718076]">Party size</label>
                            <input type="number" min="1" max="30" wire:model="newPartySize"
                                class="mt-1 w-full rounded-xl border border-[#DCE5DC] px-3 py-2.5 text-sm text-[#294936] focus:border-[#5E8067] focus:outline-none focus:ring-1 focus:ring-[#5E8067]">
                            @error('newPartySize') <p class="mt-1 text-xs text-[#B94A48]">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-medium text-[#718076]">
                                {{ $isWalkIn ? 'Table' : 'Table (optional)' }}
                            </label>
                            @if ($newTableId && ! $isWalkIn)
                                <button type="button" wire:click="$set('newTableId', null)" class="text-xs text-[#8FA58B] underline hover:text-[#294936]">
                                    Clear selection
                                </button>
                            @endif
                        </div>
                        <button type="button" wire:click="openFloorPicker('newTableId')"
                            class="mt-1 flex w-full items-center justify-between rounded-xl border border-[#DCE5DC] px-3 py-2.5 text-left text-sm text-[#294936] hover:bg-[#F8FAF6]">
                            <span>
                                @if ($newTableId && ($picked = $this->tables->firstWhere('id', $newTableId)))
                                    <span class="font-semibold">{{ $picked->name }}</span>
                                    <span class="text-[#8FA58B]">· {{ $picked->seatsLabel }}</span>
                                @else
                                    <span class="text-[#8FA58B]">{{ $isWalkIn ? 'Choose a table…' : 'No table selected' }}</span>
                                @endif
                            </span>
                            <span class="inline-flex shrink-0 items-center gap-1.5 text-xs font-medium text-[#5E8067]">
                                <x-tabler-layout-grid class="h-4 w-4" />
                                View Floor Plan
                            </span>
                        </button>
                        @error('newTableId') <p class="mt-1 text-xs text-[#B94A48]">{{ $message }}</p> @enderror
                    </div>

                    @unless ($isWalkIn)
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-xs font-medium text-[#718076]">Date</label>
                                <input type="date" wire:model="newReservedDate"
                                    class="mt-1 w-full rounded-xl border border-[#DCE5DC] px-3 py-2.5 text-sm text-[#294936] focus:border-[#5E8067] focus:outline-none focus:ring-1 focus:ring-[#5E8067]">
                                @error('newReservedDate') <p class="mt-1 text-xs text-[#B94A48]">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="text-xs font-medium text-[#718076]">Time</label>
                                <input type="time" wire:model="newReservedTime"
                                    class="mt-1 w-full rounded-xl border border-[#DCE5DC] px-3 py-2.5 text-sm text-[#294936] focus:border-[#5E8067] focus:outline-none focus:ring-1 focus:ring-[#5E8067]">
                                @error('newReservedTime') <p class="mt-1 text-xs text-[#B94A48]">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    @endunless

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs font-medium text-[#718076]">Duration</label>
                            <select wire:model="newDurationMinutes"
                                class="mt-1 w-full rounded-xl border border-[#DCE5DC] px-3 py-2.5 text-sm text-[#294936] focus:border-[#5E8067] focus:outline-none focus:ring-1 focus:ring-[#5E8067]">
                                <option value="30">30 min</option>
                                <option value="45">45 min</option>
                                <option value="60">1 hr</option>
                                <option value="90">1.5 hr</option>
                                <option value="120">2 hr</option>
                                <option value="150">2.5 hr</option>
                                <option value="180">3 hr</option>
                            </select>
                            @error('newDurationMinutes') <p class="mt-1 text-xs text-[#B94A48]">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-xs font-medium text-[#718076]">Notes (optional)</label>
                            <input type="text" wire:model="newNotes" placeholder="e.g. Anniversary"
                                class="mt-1 w-full rounded-xl border border-[#DCE5DC] px-3 py-2.5 text-sm text-[#294936] focus:border-[#5E8067] focus:outline-none focus:ring-1 focus:ring-[#5E8067]">
                        </div>
                    </div>

                    <div class="mt-2 flex items-center justify-end gap-2 pt-2">
                        <button type="button" wire:click="closeReservationModal"
                            class="rounded-full border border-[#DCE5DC] px-5 py-2.5 text-sm font-medium text-[#294936] hover:bg-[#F8FAF6]">
                            Cancel
                        </button>
                        <button type="submit" wire:loading.attr="disabled" wire:target="saveReservation"
                            class="inline-flex items-center gap-2 rounded-full bg-[#294936] px-5 py-2.5 text-sm font-medium text-white hover:bg-[#183524] disabled:opacity-60">
                            <span wire:loading.remove wire:target="saveReservation">
                                {{ $editingReservationId ? 'Save Changes' : ($isWalkIn ? 'Seat Now' : 'Book Reservation') }}
                            </span>
                            <span wire:loading wire:target="saveReservation">Saving…</span>
                        </button>
                    </div>

                </form>

            </div>
        </div>
    @endif

    {{-- Quick "assign a table" prompt when seating an unassigned reservation --}}
    @if ($showSeatTableModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4" wire:click.self="closeSeatTableModal">
            <div class="max-h-[90vh] w-full max-w-sm overflow-y-auto rounded-3xl bg-white p-6 shadow-xl">

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                            <x-tabler-armchair class="h-5 w-5" />
                        </div>
                        <h2 class="text-lg font-bold text-[#183524]">Assign a Table</h2>
                    </div>
                    <button wire:click="closeSeatTableModal" class="flex h-8 w-8 items-center justify-center rounded-full text-[#8FA58B] hover:bg-[#F8FAF6]">
                        <x-tabler-x class="h-4 w-4" />
                    </button>
                </div>

                <p class="mt-3 text-xs text-[#718076]">This reservation doesn't have a table yet — pick one to seat them.</p>

                <form wire:submit="confirmSeatWithTable" class="mt-5 space-y-4">

                    <div>
                        <label class="text-xs font-medium text-[#718076]">Table</label>
                        <button type="button" wire:click="openFloorPicker('seatTableId')"
                            class="mt-1 flex w-full items-center justify-between rounded-xl border border-[#DCE5DC] px-3 py-2.5 text-left text-sm text-[#294936] hover:bg-[#F8FAF6]">
                            <span>
                                @if ($seatTableId && ($picked = $this->tables->firstWhere('id', $seatTableId)))
                                    <span class="font-semibold">{{ $picked->name }}</span>
                                    <span class="text-[#8FA58B]">· {{ $picked->seatsLabel }}</span>
                                @else
                                    <span class="text-[#8FA58B]">Choose a table…</span>
                                @endif
                            </span>
                            <span class="inline-flex shrink-0 items-center gap-1.5 text-xs font-medium text-[#5E8067]">
                                <x-tabler-layout-grid class="h-4 w-4" />
                                View Floor Plan
                            </span>
                        </button>
                        @error('seatTableId') <p class="mt-1 text-xs text-[#B94A48]">{{ $message }}</p> @enderror
                    </div>

                    <div class="mt-2 flex items-center justify-end gap-2 pt-2">
                        <button type="button" wire:click="closeSeatTableModal"
                            class="rounded-full border border-[#DCE5DC] px-5 py-2.5 text-sm font-medium text-[#294936] hover:bg-[#F8FAF6]">
                            Cancel
                        </button>
                        <button type="submit" wire:loading.attr="disabled" wire:target="confirmSeatWithTable"
                            class="inline-flex items-center gap-2 rounded-full bg-[#294936] px-5 py-2.5 text-sm font-medium text-white hover:bg-[#183524] disabled:opacity-60">
                            <span wire:loading.remove wire:target="confirmSeatWithTable">Seat Now</span>
                            <span wire:loading wire:target="confirmSeatWithTable">Seating…</span>
                        </button>
                    </div>

                </form>

            </div>
        </div>
    @endif

    {{-- Dedicated floor-plan picker, opened from either table field above --}}
    @if ($showFloorPickerModal)
        <div class="fixed inset-0 z-[60] flex items-center justify-center bg-black/50 p-4" wire:click.self="closeFloorPicker">
            <div class="max-h-[90vh] w-full max-w-5xl overflow-y-auto rounded-3xl bg-white p-6 shadow-xl">

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                            <x-tabler-layout-grid class="h-5 w-5" />
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-[#183524]">Choose a Table</h2>
                            <p class="text-xs text-[#718076]">Tap a table to select it.</p>
                        </div>
                    </div>
                    <button wire:click="closeFloorPicker" class="flex h-8 w-8 items-center justify-center rounded-full text-[#8FA58B] hover:bg-[#F8FAF6]">
                        <x-tabler-x class="h-4 w-4" />
                    </button>
                </div>

                <div class="mt-5">
                    <x-floor-table-picker
                        :tables="$this->tables"
                        :elements="$this->floorElements"
                        :selected="$floorPickerTarget === 'seatTableId' ? $seatTableId : $newTableId"
                        :model="$floorPickerTarget"
                        :disable-unavailable="$floorPickerTarget === 'seatTableId' || $isWalkIn" />
                </div>

            </div>
        </div>
    @endif

    {{-- Add Waitlist modal --}}
    @if ($showWaitlistModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4" wire:click.self="closeWaitlistModal">
            <div class="max-h-[90vh] w-full max-w-md overflow-y-auto rounded-3xl bg-white p-6 shadow-xl">

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#FFF4DD] text-[#9A762B]">
                            <x-tabler-hourglass class="h-5 w-5" />
                        </div>
                        <h2 class="text-lg font-bold text-[#183524]">Add to Waitlist</h2>
                    </div>
                    <button wire:click="closeWaitlistModal" class="flex h-8 w-8 items-center justify-center rounded-full text-[#8FA58B] hover:bg-[#F8FAF6]">
                        <x-tabler-x class="h-4 w-4" />
                    </button>
                </div>

                <form wire:submit="saveWaitlistEntry" class="mt-5 space-y-4">

                    <div>
                        <x-guest-combobox
                            model="newWaitlistGuestName"
                            target="waitlist"
                            :value="$newWaitlistGuestName"
                            :suggestions="$this->waitlistGuestSuggestions"
                            :selected="$this->selectedWaitlistGuest" />
                        @error('newWaitlistGuestName') <p class="mt-1 text-xs text-[#B94A48]">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs font-medium text-[#718076]">Phone (optional)</label>
                            <input type="text" wire:model="newWaitlistPhone" placeholder="Phone"
                                class="mt-1 w-full rounded-xl border border-[#DCE5DC] px-3 py-2.5 text-sm text-[#294936] focus:border-[#5E8067] focus:outline-none focus:ring-1 focus:ring-[#5E8067]">
                        </div>
                        <div>
                            <label class="text-xs font-medium text-[#718076]">Party size</label>
                            <input type="number" min="1" max="30" wire:model="newWaitlistPartySize"
                                class="mt-1 w-full rounded-xl border border-[#DCE5DC] px-3 py-2.5 text-sm text-[#294936] focus:border-[#5E8067] focus:outline-none focus:ring-1 focus:ring-[#5E8067]">
                            @error('newWaitlistPartySize') <p class="mt-1 text-xs text-[#B94A48]">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-2 flex items-center justify-end gap-2 pt-2">
                        <button type="button" wire:click="closeWaitlistModal"
                            class="rounded-full border border-[#DCE5DC] px-5 py-2.5 text-sm font-medium text-[#294936] hover:bg-[#F8FAF6]">
                            Cancel
                        </button>
                        <button type="submit" wire:loading.attr="disabled" wire:target="saveWaitlistEntry"
                            class="inline-flex items-center gap-2 rounded-full bg-[#294936] px-5 py-2.5 text-sm font-medium text-white hover:bg-[#183524] disabled:opacity-60">
                            <span wire:loading.remove wire:target="saveWaitlistEntry">Add to Waitlist</span>
                            <span wire:loading wire:target="saveWaitlistEntry">Adding…</span>
                        </button>
                    </div>

                </form>

            </div>
        </div>
    @endif

    {{-- Add/Edit Guest modal --}}
    @if ($showGuestModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4" wire:click.self="closeGuestModal">
            <div class="max-h-[90vh] w-full max-w-md overflow-y-auto rounded-3xl bg-white p-6 shadow-xl">

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                            <x-tabler-user class="h-5 w-5" />
                        </div>
                        <h2 class="text-lg font-bold text-[#183524]">{{ $editingGuestId ? 'Edit Guest' : 'Add Guest' }}</h2>
                    </div>
                    <button wire:click="closeGuestModal" class="flex h-8 w-8 items-center justify-center rounded-full text-[#8FA58B] hover:bg-[#F8FAF6]">
                        <x-tabler-x class="h-4 w-4" />
                    </button>
                </div>

                <form wire:submit="saveGuest" class="mt-5 space-y-4">

                    <div>
                        <label class="text-xs font-medium text-[#718076]">Name</label>
                        <input type="text" wire:model="guestFormName" autofocus
                            class="mt-1 w-full rounded-xl border border-[#DCE5DC] px-3 py-2.5 text-sm text-[#294936] focus:border-[#5E8067] focus:outline-none focus:ring-1 focus:ring-[#5E8067]">
                        @error('guestFormName') <p class="mt-1 text-xs text-[#B94A48]">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs font-medium text-[#718076]">Phone</label>
                            <input type="text" wire:model="guestFormPhone"
                                class="mt-1 w-full rounded-xl border border-[#DCE5DC] px-3 py-2.5 text-sm text-[#294936] focus:border-[#5E8067] focus:outline-none focus:ring-1 focus:ring-[#5E8067]">
                        </div>
                        <div>
                            <label class="text-xs font-medium text-[#718076]">Email</label>
                            <input type="email" wire:model="guestFormEmail"
                                class="mt-1 w-full rounded-xl border border-[#DCE5DC] px-3 py-2.5 text-sm text-[#294936] focus:border-[#5E8067] focus:outline-none focus:ring-1 focus:ring-[#5E8067]">
                            @error('guestFormEmail') <p class="mt-1 text-xs text-[#B94A48]">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-medium text-[#718076]">Notes</label>
                        <textarea wire:model="guestFormNotes" rows="3" placeholder="Allergies, preferences, etc."
                            class="mt-1 w-full rounded-xl border border-[#DCE5DC] px-3 py-2.5 text-sm text-[#294936] focus:border-[#5E8067] focus:outline-none focus:ring-1 focus:ring-[#5E8067]"></textarea>
                    </div>

                    <div class="mt-2 flex items-center justify-end gap-2 pt-2">
                        <button type="button" wire:click="closeGuestModal"
                            class="rounded-full border border-[#DCE5DC] px-5 py-2.5 text-sm font-medium text-[#294936] hover:bg-[#F8FAF6]">
                            Cancel
                        </button>
                        <button type="submit" wire:loading.attr="disabled" wire:target="saveGuest"
                            class="inline-flex items-center gap-2 rounded-full bg-[#294936] px-5 py-2.5 text-sm font-medium text-white hover:bg-[#183524] disabled:opacity-60">
                            <span wire:loading.remove wire:target="saveGuest">{{ $editingGuestId ? 'Save Changes' : 'Add Guest' }}</span>
                            <span wire:loading wire:target="saveGuest">Saving…</span>
                        </button>
                    </div>

                </form>

            </div>
        </div>
    @endif

    @endif

</div>