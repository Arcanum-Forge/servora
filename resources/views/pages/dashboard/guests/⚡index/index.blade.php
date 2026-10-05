{{-- guests/⚡index/index.blade.php --}}
<div>

    @php
        use App\Models\Guest;
        use Carbon\Carbon;
        use Illuminate\Support\Str;

        $stats = $this->stats;

        $tierBadge = [
            'Gold' => 'bg-[#FFF4DD] text-[#9A762B]',
            'Silver' => 'bg-[#E8F0E5] text-[#5E8067]',
            'Member' => 'bg-[#F0F3EF] text-[#718076]',
        ];
        $tierBar = ['Gold' => 'bg-[#D8B95F]', 'Silver' => 'bg-[#5E8067]', 'Member' => 'bg-[#8FA58B]'];
        $avatars = [
            'bg-[#294936] text-white',
            'bg-[#F1ECE5] text-[#806A49]',
            'bg-[#E8F0E5] text-[#294936]',
            'bg-[#FDEFE7] text-[#A06B48]',
            'bg-[#EEF2F0] text-[#5E8067]',
        ];
        $seatIcon = ['fireplace' => 'flame', 'window' => 'sun', 'quiet_corner' => 'moon', 'bar' => 'beer'];
        $lastVisit = fn ($v) => $v ? Carbon::parse($v)->format('M j') : 'None yet';
        $tabIcons = [
            'All Guests' => 'users', 'Visit History' => 'history',
            'Preferences' => 'heart', 'Loyalty' => 'crown',
        ];

        // Shared class strings (same look as POS / Reservations)
        $panel = 'overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-[#E6EDE6]';
        $card = 'rounded-2xl bg-white p-5 shadow-sm ring-1 ring-[#E6EDE6]';
        $select = 'rounded-full border border-[#DCE5DC] bg-white px-4 py-2.5 text-sm text-[#294936] outline-none focus:border-[#8FA58B] focus:ring-2 focus:ring-[#E8F0E5]';
        $tile = 'rounded-xl bg-[#F8FAF6] p-3';
        $tileLabel = 'mt-1 text-[9px] font-semibold uppercase tracking-wider text-[#8FA58B]';
    @endphp

    {{-- Page header --}}
    <div class="mb-6">
        <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-sm text-[#718076]">
            <span>Manage</span>
            <x-tabler-chevron-right class="h-4 w-4 text-[#C8D8C9]" />
            <span>Guests</span>
            <x-tabler-chevron-right class="h-4 w-4 text-[#C8D8C9]" />
            <span class="font-medium text-[#183524]">{{ $view }}</span>
        </nav>
        <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#183524]">Guests</h1>
        <p class="mt-1 text-sm text-[#718076]">Visit history, preferences and loyalty for everyone who dines with you.</p>
    </div>

    {{-- Hero --}}
    <div class="rounded-3xl bg-[#294936] p-6 text-white sm:p-7">

        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/10">
                    <x-tabler-users class="h-6 w-6" />
                </div>
                <div>
                    <h2 class="text-2xl font-bold tracking-tight">Your guests</h2>
                    <p class="mt-0.5 text-sm text-white/60">Know who walks through your doors and what they love.</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <button type="button" wire:click="export" wire:loading.attr="disabled" wire:target="export"
                    class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-white/20 disabled:opacity-60">
                    <x-tabler-download class="h-4 w-4" />
                    Export
                </button>
                <button type="button" wire:click="openCreate"
                    class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-2.5 text-sm font-semibold text-[#183524] transition hover:bg-[#E8F0E5]">
                    <x-tabler-user-plus class="h-4 w-4" />
                    Add guest
                </button>
            </div>

        </div>

        @php
            $tiles = [
                ['Total guests', number_format($stats['total']), 'users'],
                ['Returning', $stats['returning_pct'] . '%', 'repeat'],
                ['New this month', number_format($stats['new_month']), 'sparkles'],
                ['Gold members', number_format($stats['gold']), 'crown'],
            ];
        @endphp
        <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-4">
            @foreach ($tiles as [$heroLabel, $heroValue, $heroIcon])
                <div class="rounded-2xl bg-white/10 px-4 py-3">
                    <div class="flex items-center justify-between">
                        <p class="text-[11px] font-medium uppercase tracking-wide text-white/60">{{ $heroLabel }}</p>
                        <x-dynamic-component :component="'tabler-' . $heroIcon" class="h-4 w-4 text-white/40" />
                    </div>
                    <p class="mt-1 text-3xl font-bold leading-none">{{ $heroValue }}</p>
                </div>
            @endforeach
        </div>

    </div>

    {{-- Tabs + filters --}}
    <div class="mt-6">

        <div class="inline-flex max-w-full self-start overflow-x-auto rounded-full bg-[#F0F3EF] p-1 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
            @foreach (['All Guests', 'Visit History', 'Preferences', 'Loyalty'] as $item)
                <button type="button" wire:click="setView('{{ $item }}')" wire:key="tab-{{ $item }}"
                    class="inline-flex shrink-0 items-center gap-2 rounded-full px-4 py-2 text-sm font-medium transition
                        {{ $view === $item ? 'bg-white text-[#183524] shadow-sm' : 'text-[#718076] hover:text-[#294936]' }}">
                    <x-dynamic-component :component="'tabler-' . $tabIcons[$item]" class="h-4 w-4" />
                    {{ $item }}
                </button>
            @endforeach
        </div>

    </div>

    {{-- ========================= WORKSPACE ========================= --}}
    <div class="mt-6">

    @if ($view === 'All Guests')

        @php $list = $this->guests; @endphp

        <section class="{{ $panel }}">

            <div class="flex flex-col gap-1 border-b border-[#F0F3EF] p-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-bold text-[#183524]">Guest directory</h2>
                    <p class="mt-0.5 text-xs text-[#718076]">Tap a guest to open their profile.</p>
                </div>
                @php $filtering = $search !== '' || $tier !== '' || $diet !== '' || $favorite; @endphp
                <span class="text-xs text-[#8FA58B]">
                    @if ($filtering)
                        Showing {{ $list->count() }}{{ $list->hasMorePages() ? '+' : '' }} {{ Str::plural('guest', $list->count()) }}
                    @else
                        {{ number_format($stats['total']) }} {{ Str::plural('guest', $stats['total']) }}
                    @endif
                </span>
            </div>

            {{-- Filters --}}
            <div class="flex flex-col gap-3 border-b border-[#F0F3EF] p-4 sm:px-5 lg:flex-row lg:items-center">
                <div class="relative flex-1">
                    <x-tabler-search class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8FA58B]" />
                    <input type="search" wire:model.live.debounce.300ms="search" placeholder="Search name, email, phone or favorite dish…"
                        class="w-full rounded-full border border-[#DCE5DC] bg-white py-2.5 pl-10 pr-4 text-sm text-[#26342A] outline-none placeholder:text-[#9AA79D] focus:border-[#8FA58B] focus:ring-2 focus:ring-[#E8F0E5]">
                </div>

                <div class="grid grid-cols-2 gap-2 sm:flex sm:flex-wrap sm:items-center">
                    <select wire:model.live="tier" class="{{ $select }}">
                        <option value="">All tiers</option>
                        <option>Gold</option>
                        <option>Silver</option>
                        <option>Member</option>
                    </select>

                    <select wire:model.live="diet" class="{{ $select }}">
                        <option value="">Any diet</option>
                        @foreach (Guest::DIETARY as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>

                    <select wire:model.live="sort" class="{{ $select }}">
                        <option value="recent">Recent visit</option>
                        <option value="visits">Most visits</option>
                        <option value="points">Most points</option>
                        <option value="name">Name A–Z</option>
                    </select>

                    @if ($favorite && $this->favoriteFilter)
                        <button type="button" wire:click="$set('favorite', null)"
                            class="inline-flex items-center justify-center gap-1.5 rounded-full bg-[#E8F0E5] px-3.5 py-2.5 text-sm font-medium text-[#294936] transition hover:bg-[#DCE5DC]">
                            ♥ {{ $this->favoriteFilter->name }}
                            <x-tabler-x class="h-3.5 w-3.5" />
                        </button>
                    @endif

                    @if ($search !== '' || $tier !== '' || $diet !== '' || $favorite)
                        <button type="button" wire:click="clearFilters"
                            class="inline-flex items-center justify-center gap-1.5 rounded-full px-3 py-2.5 text-sm font-medium text-[#718076] transition hover:bg-[#F0F3EF] hover:text-[#294936]">
                            <x-tabler-x class="h-4 w-4" /> Clear
                        </button>
                    @endif
                </div>
            </div>

            <div class="bg-[#F8FAF6] p-4 sm:p-5">

                @if ($list->isEmpty())
                    <div class="flex min-h-[260px] items-center justify-center">
                        <div class="max-w-sm text-center">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white ring-1 ring-[#E6EDE6]">
                                <x-tabler-users class="h-6 w-6 text-[#8FA58B]" />
                            </div>
                            <p class="mt-3 text-sm font-medium text-[#294936]">No guests found</p>
                            <p class="mt-1 text-xs text-[#8FA58B]">Try a different search, or add a new guest.</p>
                            @if ($search !== '' || $tier !== '' || $diet !== '' || $favorite)
                                <button type="button" wire:click="clearFilters"
                                    class="mt-4 rounded-full border border-[#DCE5DC] bg-white px-4 py-2 text-xs font-semibold text-[#294936] transition hover:bg-[#F8FAF6]">
                                    Clear filters
                                </button>
                            @endif
                        </div>
                    </div>
                @else
                    <div wire:loading.class="opacity-60" wire:target="search,tier,diet,sort,gotoPage,nextPage,previousPage"
                        class="grid grid-cols-1 gap-4 transition-opacity sm:grid-cols-2 2xl:grid-cols-3">

                        @foreach ($list as $g)
                            <button type="button" wire:click="selectGuest({{ $g->id }})" wire:key="guest-{{ $g->id }}"
                                class="group {{ $card }} text-left transition hover:shadow-md">

                                <div class="flex items-start justify-between">
                                    <div class="flex h-11 w-11 items-center justify-center rounded-xl text-sm font-bold {{ $avatars[$g->id % count($avatars)] }}">
                                        {{ $g->initials }}
                                    </div>
                                    <span class="rounded-full px-2.5 py-1 text-[10px] font-bold {{ $tierBadge[$g->tier] }}">{{ $g->tier }}</span>
                                </div>

                                <div class="mt-4">
                                    <div class="flex items-center gap-2">
                                        <h3 class="truncate font-bold text-[#183524]">{{ $g->name }}</h3>
                                        @if ($g->tier === 'Gold')
                                            <x-tabler-rosette-discount-check class="h-4 w-4 shrink-0 text-[#9A762B]" />
                                        @endif
                                    </div>
                                    <p class="mt-0.5 truncate text-xs text-[#718076]">{{ $g->email ?: ($g->phone ?: 'No contact on file') }}</p>
                                </div>

                                <div class="mt-4 grid grid-cols-3 gap-2">
                                    <div class="{{ $tile }}">
                                        <p class="text-sm font-bold text-[#183524]">{{ $g->visits_count }}</p>
                                        <p class="{{ $tileLabel }}">Visits</p>
                                    </div>
                                    <div class="{{ $tile }}">
                                        <p class="text-sm font-bold text-[#183524]">{{ $g->avg_party ? round($g->avg_party) : '–' }}</p>
                                        <p class="{{ $tileLabel }}">Avg party</p>
                                    </div>
                                    <div class="{{ $tile }}">
                                        <p class="text-sm font-bold text-[#183524]">{{ $lastVisit($g->last_visit_at) }}</p>
                                        <p class="{{ $tileLabel }}">Last visit</p>
                                    </div>
                                </div>

                                <div class="mt-4 flex items-center gap-2 text-xs text-[#718076]">
                                    <x-dynamic-component :component="'tabler-' . ($seatIcon[$g->seating_preference] ?? 'sparkles')" class="h-4 w-4 shrink-0 text-[#5E8067]" />
                                    <span class="truncate">{{ $g->favorite_item ?: (Guest::SEATING[$g->seating_preference] ?? 'No preferences noted') }}</span>
                                </div>
                            </button>
                        @endforeach
                    </div>

                    @if ($list->hasPages())
                        <div class="mt-5 flex items-center justify-between gap-3 border-t border-[#E6EDE6] pt-4">
                            <button type="button" @disabled($list->onFirstPage())
                                wire:click="setPage('{{ $list->previousCursor()?->encode() }}', 'cursor')"
                                x-on:click="$el.closest('section').scrollIntoView({ behavior: 'smooth', block: 'start' })"
                                class="inline-flex items-center gap-2 rounded-full border border-[#DCE5DC] bg-white px-4 py-2 text-sm font-medium text-[#294936] transition hover:bg-[#F8FAF6] disabled:pointer-events-none disabled:opacity-40">
                                <x-tabler-chevron-left class="h-4 w-4" />
                                Previous
                            </button>

                            <span class="text-xs text-[#8FA58B]">{{ $list->count() }} on this page</span>

                            <button type="button" @disabled(! $list->hasMorePages())
                                wire:click="setPage('{{ $list->nextCursor()?->encode() }}', 'cursor')"
                                x-on:click="$el.closest('section').scrollIntoView({ behavior: 'smooth', block: 'start' })"
                                class="inline-flex items-center gap-2 rounded-full bg-[#294936] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#183524] disabled:pointer-events-none disabled:opacity-40">
                                Next
                                <x-tabler-chevron-right class="h-4 w-4" />
                            </button>
                        </div>
                    @endif
                @endif

            </div>
        </section>

    @elseif ($view === 'Visit History')

        @php $summary = $this->visitSummary; @endphp

        <div class="grid gap-6 xl:grid-cols-[1fr_320px]">

            <section class="{{ $panel }}">
                <div class="border-b border-[#F0F3EF] p-5">
                    <h2 class="text-lg font-bold text-[#183524]">Recent visits</h2>
                    <p class="mt-0.5 text-xs text-[#718076]">A timeline of recent guest activity.</p>
                </div>

                <div class="divide-y divide-[#F0F3EF]">
                    @forelse ($this->visits as $visit)
                        <button type="button" wire:click="selectGuest({{ $visit->guest_id }})" wire:key="visit-{{ $visit->id }}"
                            class="flex w-full gap-4 p-5 text-left transition hover:bg-[#F8FAF6]">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-xs font-bold {{ $avatars[$visit->guest_id % count($avatars)] }}">
                                {{ $visit->guest?->initials }}
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-col justify-between gap-1 sm:flex-row">
                                    <div>
                                        <p class="text-sm font-bold text-[#183524]">{{ $visit->guest?->name ?? 'Removed guest' }}</p>
                                        <p class="mt-0.5 text-xs text-[#718076]">
                                            {{ $visit->table?->name ?? 'No table' }} · Party of {{ $visit->party_size }} · {{ $visit->duration_minutes }} min
                                        </p>
                                    </div>
                                    <p class="text-xs text-[#8FA58B]">{{ $visit->seated_at->format('M j · g:i A') }}</p>
                                </div>

                                @if ($visit->notes || $visit->guest?->favorite_item)
                                    <div class="mt-3 flex flex-wrap gap-1.5">
                                        @if ($visit->guest?->favorite_item)
                                            <span class="rounded-lg bg-[#F8FAF6] px-2 py-1 text-[11px] font-semibold text-[#718076]">♥ {{ $visit->guest->favorite_item }}</span>
                                        @endif
                                        @if ($visit->notes)
                                            <span class="rounded-lg bg-[#FFF4DD] px-2 py-1 text-[11px] font-semibold text-[#9A762B]">{{ $visit->notes }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </button>
                    @empty
                        <div class="flex min-h-[260px] flex-col items-center justify-center p-8 text-center">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#F8FAF6]">
                                <x-tabler-history class="h-6 w-6 text-[#8FA58B]" />
                            </div>
                            <p class="mt-3 text-sm font-medium text-[#294936]">No seated visits yet</p>
                            <p class="mt-1 text-xs text-[#8FA58B]">Seat a reservation and it will show up here.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <aside class="space-y-4 self-start">
                <div class="rounded-3xl bg-[#294936] p-5 text-white">
                    <p class="text-[11px] font-medium uppercase tracking-wide text-white/60">This month</p>
                    <p class="mt-2 text-3xl font-bold leading-none">{{ number_format($summary['count']) }}</p>
                    <p class="mt-1 text-xs text-white/60">recorded guest visits</p>
                    <div class="mt-5 h-1.5 overflow-hidden rounded-full bg-white/10">
                        <div class="h-full rounded-full bg-[#D8C78A]" style="width: {{ $summary['returning_pct'] }}%"></div>
                    </div>
                    <p class="mt-2 text-[11px] text-white/60">{{ $summary['returning_pct'] }}% from returning guests</p>
                </div>

                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[#E6EDE6]">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wide text-[#8FA58B]">Popular visit times</p>
                        <span class="text-[11px] text-[#718076]">last 90 days</span>
                    </div>
                    <div class="mt-4 space-y-4">
                        @foreach ($summary['times'] as $i => $t)
                            <div>
                                <div class="flex justify-between text-xs">
                                    <span class="text-[#718076]">{{ $t['label'] }}</span>
                                    <span class="font-bold text-[#183524]">{{ $t['pct'] }}%</span>
                                </div>
                                <div class="mt-2 h-2 rounded-full bg-[#F0F3EF]">
                                    <div class="h-full rounded-full {{ ['bg-[#294936]', 'bg-[#8FA58B]', 'bg-[#D8C78A]'][$i] }}" style="width: {{ $t['pct'] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>

    @elseif ($view === 'Preferences')

        @php $prefs = $this->preferences; @endphp

        <div class="grid gap-6 lg:grid-cols-2">

            {{-- Seating --}}
            <section class="{{ $panel }}">
                <div class="flex items-center gap-3 border-b border-[#F0F3EF] p-5">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#5E8067]">
                        <x-tabler-armchair class="h-5 w-5" />
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-[#183524]">Seating</h2>
                        <p class="text-xs text-[#718076]">Where your guests like to sit</p>
                    </div>
                </div>
                <div class="space-y-4 p-5">
                    @foreach ($prefs['seating'] as $i => $row)
                        <div>
                            <div class="flex justify-between text-xs">
                                <span class="text-[#718076]">{{ $row['label'] }}</span>
                                <span class="font-bold text-[#183524]">{{ $row['pct'] }}%</span>
                            </div>
                            <div class="mt-2 h-2 rounded-full bg-[#F0F3EF]">
                                <div class="h-full rounded-full {{ ['bg-[#294936]', 'bg-[#5E8067]', 'bg-[#8FA58B]', 'bg-[#D8C78A]'][$i % 4] }}" style="width: {{ $row['pct'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- Dietary --}}
            <section class="{{ $panel }}">
                <div class="flex items-center gap-3 border-b border-[#F0F3EF] p-5">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#5E8067]">
                        <x-tabler-leaf class="h-5 w-5" />
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-[#183524]">Dietary</h2>
                        <p class="text-xs text-[#718076]">Tap one to filter the guest list</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3 p-5">
                    @foreach ($prefs['diet'] as $row)
                        <button type="button" wire:click="$set('diet', '{{ array_search($row['label'], Guest::DIETARY) }}'); setView('All Guests')"
                            class="rounded-2xl bg-[#F8FAF6] p-4 text-left transition hover:bg-[#E8F0E5]">
                            <p class="text-xl font-bold text-[#183524]">{{ $row['count'] }}</p>
                            <p class="mt-1 text-xs text-[#718076]">{{ $row['label'] }}</p>
                        </button>
                    @endforeach
                </div>
            </section>

            {{-- Dining style --}}
            <section class="{{ $panel }}">
                <div class="flex items-center gap-3 border-b border-[#F0F3EF] p-5">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#FFF4DD] text-[#9A762B]">
                        <x-tabler-mood-smile class="h-5 w-5" />
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-[#183524]">Dining style</h2>
                        <p class="text-xs text-[#718076]">How guests prefer their experience</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2 p-5">
                    @foreach ($prefs['styles'] as $row)
                        <div class="flex items-center gap-2 rounded-full bg-[#F8FAF6] px-3.5 py-2 ring-1 ring-[#E6EDE6]">
                            <span class="text-xs text-[#718076]">{{ $row['label'] }}</span>
                            <span class="text-xs font-bold text-[#183524]">{{ $row['count'] }}</span>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- Favorites --}}
            <section class="{{ $panel }}">
                <div class="flex items-center gap-3 border-b border-[#F0F3EF] p-5">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#5E8067]">
                        <x-tabler-heart class="h-5 w-5" />
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-[#183524]">Favorites</h2>
                        <p class="text-xs text-[#718076]">Tap a dish to see who loves it</p>
                    </div>
                </div>
                <div class="space-y-2 p-5">
                    @forelse ($prefs['favorites'] as $dish)
                        <button type="button" wire:key="fav-{{ $dish->id }}" wire:click="filterByFavorite({{ $dish->id }})"
                            class="flex w-full items-center gap-3 rounded-2xl bg-[#F8FAF6] p-3 text-left transition hover:bg-[#E8F0E5]">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-white text-[#5E8067] shadow-sm">
                                <x-tabler-flame class="h-4 w-4" />
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-bold text-[#183524]">{{ $dish->name }}</p>
                                <p class="text-[11px] text-[#8FA58B]">{{ $dish->guests_count }} {{ Str::plural('guest', $dish->guests_count) }} · {{ number_format($dish->price, 2) }} silver</p>
                            </div>
                            <span class="rounded-full bg-white px-2.5 py-1 text-xs font-bold text-[#294936] shadow-sm">{{ $dish->guests_count }}</span>
                        </button>
                    @empty
                        <p class="py-6 text-center text-xs text-[#8FA58B]">No favorites recorded yet.</p>
                    @endforelse
                </div>
            </section>
        </div>

    @elseif ($view === 'Loyalty')

        @php $total = max(1, $stats['total']); @endphp

        <div class="space-y-6">

            <section class="rounded-3xl bg-[#294936] p-6 text-white sm:p-7">
                <div class="grid gap-6 lg:grid-cols-[1fr_auto] lg:items-center">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/10">
                            <x-tabler-crown class="h-6 w-6 text-[#D8C78A]" />
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold tracking-tight">
                                {{ number_format($stats['gold']) }} {{ Str::plural('guest', $stats['gold']) }} {{ $stats['gold'] === 1 ? 'has' : 'have' }} reached Gold
                            </h2>
                            <p class="mt-0.5 text-sm text-white/60">Your most frequent guests are building a long-term relationship with the house.</p>
                        </div>
                    </div>
                    <div class="rounded-2xl bg-white/10 px-5 py-3 lg:text-right">
                        <p class="text-3xl font-bold leading-none">{{ number_format($stats['total']) }}</p>
                        <p class="mt-1 text-xs text-white/60">enrolled · {{ number_format($stats['points']) }} pts issued</p>
                    </div>
                </div>
            </section>

            <div class="grid gap-4 md:grid-cols-3">
                @foreach ([
                    ['Member', $stats['member'], 'Guests who have joined the loyalty circle.', 'user', 'bg-[#F0F3EF] text-[#718076]', 'bg-[#8FA58B]'],
                    ['Silver', $stats['silver'], 'Guests with regular dining activity.', 'star', 'bg-[#E8F0E5] text-[#5E8067]', 'bg-[#5E8067]'],
                    ['Gold', $stats['gold'], 'Your most frequent returning guests.', 'crown', 'bg-[#FFF4DD] text-[#9A762B]', 'bg-[#D8B95F]'],
                ] as [$label, $count, $desc, $icon, $iconCls, $bar])
                    <button type="button" wire:click="$set('tier', '{{ $label }}'); setView('All Guests')"
                        class="{{ $card }} text-left transition hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl {{ $iconCls }}">
                                <x-dynamic-component :component="'tabler-' . $icon" class="h-5 w-5" />
                            </div>
                            <span class="text-2xl font-bold leading-none text-[#183524]">{{ $count }}</span>
                        </div>
                        <p class="mt-4 text-sm font-bold text-[#183524]">{{ $label }}</p>
                        <p class="mt-1 text-xs leading-5 text-[#718076]">{{ $desc }}</p>
                        <div class="mt-4 h-2 rounded-full bg-[#F0F3EF]">
                            <div class="h-full rounded-full {{ $bar }}" style="width: {{ round($count / $total * 100) }}%"></div>
                        </div>
                    </button>
                @endforeach
            </div>

            <section class="{{ $panel }}">
                <div class="border-b border-[#F0F3EF] p-5">
                    <h2 class="text-lg font-bold text-[#183524]">Loyalty members</h2>
                    <p class="mt-0.5 text-xs text-[#718076]">Guests closest to their next reward tier.</p>
                </div>

                <div class="divide-y divide-[#F0F3EF]">
                    @forelse ($this->loyaltyMembers as $g)
                        <div wire:key="loyal-{{ $g->id }}" class="flex flex-col gap-4 p-5 sm:flex-row sm:items-center">
                            <button type="button" wire:click="selectGuest({{ $g->id }})"
                                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl text-sm font-bold {{ $avatars[$g->id % count($avatars)] }}">
                                {{ $g->initials }}
                            </button>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2">
                                    <p class="truncate text-sm font-bold text-[#183524]">{{ $g->name }}</p>
                                    <span class="rounded-full px-2 py-0.5 text-[10px] font-bold {{ $tierBadge[$g->tier] }}">{{ $g->tier }}</span>
                                </div>
                                <p class="mt-0.5 text-xs text-[#718076]">{{ $g->visits_count }} visits · {{ number_format($g->loyalty_points) }} points</p>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="w-full sm:w-44">
                                    <div class="flex justify-between text-[11px]">
                                        <span class="text-[#8FA58B]">{{ $g->tier === 'Gold' ? 'Next reward' : 'Next tier' }}</span>
                                        <span class="font-bold text-[#183524]">{{ $g->tier_progress }}%</span>
                                    </div>
                                    <div class="mt-1.5 h-2 rounded-full bg-[#F0F3EF]">
                                        <div class="h-full rounded-full {{ $tierBar[$g->tier] }}" style="width: {{ $g->tier_progress }}%"></div>
                                    </div>
                                </div>

                                <button type="button" wire:click="adjustPoints({{ $g->id }}, 50)" title="Award 50 points"
                                    class="shrink-0 rounded-full border border-[#DCE5DC] px-3.5 py-2 text-xs font-semibold text-[#294936] transition hover:bg-[#F8FAF6]">
                                    +50
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="flex min-h-[200px] flex-col items-center justify-center p-8 text-center">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#F8FAF6]">
                                <x-tabler-crown class="h-6 w-6 text-[#8FA58B]" />
                            </div>
                            <p class="mt-3 text-sm font-medium text-[#294936]">No points earned yet</p>
                            <p class="mt-1 text-xs text-[#8FA58B]">Award points from a guest profile to start the program.</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>

    @endif

    </div>


    {{-- ========================= GUEST DETAIL DRAWER ========================= --}}
    @if ($g = $this->selectedGuest)
        <div class="fixed inset-0 z-40 flex justify-end bg-black/40" wire:key="drawer-{{ $g->id }}">
            <div class="absolute inset-0" wire:click="closeGuest"></div>

            <aside class="relative flex h-full w-full max-w-md flex-col overflow-y-auto bg-white shadow-xl sm:rounded-l-3xl">

                <div class="flex items-start justify-between border-b border-[#F0F3EF] p-6">
                    <div class="flex items-center gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl text-base font-bold {{ $avatars[$g->id % count($avatars)] }}">
                            {{ $g->initials }}
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-[#183524]">{{ $g->name }}</h3>
                            <span class="mt-1 inline-block rounded-full px-2.5 py-1 text-[10px] font-bold {{ $tierBadge[$g->tier] }}">{{ $g->tier }}</span>
                        </div>
                    </div>
                    <button type="button" wire:click="closeGuest" class="flex h-8 w-8 items-center justify-center rounded-full text-[#8FA58B] hover:bg-[#F8FAF6]">
                        <x-tabler-x class="h-4 w-4" />
                    </button>
                </div>

                <div class="space-y-6 p-6">

                    <div class="grid grid-cols-3 gap-2">
                        <div class="{{ $tile }}">
                            <p class="text-sm font-bold text-[#183524]">{{ $g->visits_count }}</p>
                            <p class="{{ $tileLabel }}">Visits</p>
                        </div>
                        <div class="{{ $tile }}">
                            <p class="text-sm font-bold text-[#183524]">{{ number_format($g->loyalty_points) }}</p>
                            <p class="{{ $tileLabel }}">Points</p>
                        </div>
                        <div class="{{ $tile }}">
                            <p class="text-sm font-bold text-[#183524]">{{ $lastVisit($g->last_visit_at) }}</p>
                            <p class="{{ $tileLabel }}">Last visit</p>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs">
                            <span class="text-[#8FA58B]">{{ $g->tier === 'Gold' ? 'Next reward' : 'Progress to next tier' }}</span>
                            <span class="font-bold text-[#183524]">{{ $g->tier_progress }}%</span>
                        </div>
                        <div class="mt-2 h-2 rounded-full bg-[#F0F3EF]">
                            <div class="h-full rounded-full {{ $tierBar[$g->tier] }}" style="width: {{ $g->tier_progress }}%"></div>
                        </div>
                        <div class="mt-3 flex gap-2">
                            @foreach ([50, 100] as $pts)
                                <button type="button" wire:click="adjustPoints({{ $g->id }}, {{ $pts }})"
                                    class="rounded-full border border-[#DCE5DC] px-3.5 py-1.5 text-xs font-semibold text-[#294936] transition hover:bg-[#F8FAF6]">+{{ $pts }} pts</button>
                            @endforeach
                        </div>
                    </div>

                    <dl class="space-y-3 text-sm">
                        @foreach ([
                            ['mail', $g->email], ['phone', $g->phone],
                            ['cake', $g->birthday?->format('F j')],
                            ['armchair', Guest::SEATING[$g->seating_preference] ?? null],
                            ['mood-smile', Guest::STYLES[$g->dining_style] ?? null],
                            ['heart', $g->favorite_item],
                        ] as [$icon, $value])
                            @if ($value)
                                <div class="flex items-center gap-3 text-[#294936]">
                                    <x-dynamic-component :component="'tabler-' . $icon" class="h-4 w-4 shrink-0 text-[#5E8067]" />
                                    <span class="truncate">{{ $value }}</span>
                                </div>
                            @endif
                        @endforeach
                    </dl>

                    @if ($g->dietary)
                        <div class="flex flex-wrap gap-1.5">
                            @foreach ($g->dietary as $d)
                                @if ($d === 'nut_allergy')
                                    <span class="inline-flex items-center gap-1 rounded-lg bg-[#FBEAEA] px-2 py-1 text-[11px] font-bold text-[#B94A48]">
                                        <x-tabler-alert-triangle class="h-3.5 w-3.5" />
                                        {{ Guest::DIETARY[$d] ?? $d }}
                                    </span>
                                @else
                                    <span class="rounded-lg bg-[#E8F0E5] px-2 py-1 text-[11px] font-semibold text-[#5E8067]">{{ Guest::DIETARY[$d] ?? $d }}</span>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    @if ($g->notes)
                        <div class="rounded-2xl bg-[#FBF7EE] p-4 text-sm leading-6 text-[#5E4A2F]">{{ $g->notes }}</div>
                    @endif

                    <div>
                        <h4 class="text-xs font-semibold uppercase tracking-wide text-[#8FA58B]">Recent visits</h4>
                        <div class="mt-3 space-y-2">
                            @forelse ($g->reservations as $r)
                                <div class="flex items-center justify-between rounded-2xl bg-[#F8FAF6] px-4 py-3 text-xs">
                                    <span class="font-semibold text-[#294936]">{{ $r->table?->name ?? 'No table' }} · Party of {{ $r->party_size }}</span>
                                    <span class="text-[#8FA58B]">{{ $r->seated_at->format('M j, Y') }}</span>
                                </div>
                            @empty
                                <p class="text-xs text-[#8FA58B]">No visits yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="mt-auto border-t border-[#F0F3EF] p-5">
                    @if ($confirmingDelete)
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-xs font-medium text-[#B94A48]">Delete this guest for good?</p>
                            <div class="flex gap-2">
                                <button type="button" wire:click="$set('confirmingDelete', false)"
                                    class="rounded-full border border-[#DCE5DC] px-4 py-2 text-xs font-medium text-[#294936] hover:bg-[#F8FAF6]">Cancel</button>
                                <button type="button" wire:click="delete"
                                    class="rounded-full bg-[#B94A48] px-4 py-2 text-xs font-semibold text-white hover:bg-[#9E3E3C]">Delete</button>
                            </div>
                        </div>
                    @else
                        <div class="flex gap-3">
                            <button type="button" wire:click="edit({{ $g->id }})"
                                class="flex-1 rounded-full bg-[#294936] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#183524]">Edit guest</button>
                            @if ($g->reservations_count === 0 && $g->waitlist_entries_count === 0)
                                <button type="button" wire:click="$set('confirmingDelete', true)" title="Delete"
                                    class="flex h-10 w-10 items-center justify-center rounded-full border border-[#DCE5DC] text-[#B94A48] transition hover:bg-[#FBEAEA]">
                                    <x-tabler-trash class="h-4 w-4" />
                                </button>
                            @else
                                <span title="Guests with booking history can't be deleted"
                                    class="flex h-10 w-10 items-center justify-center rounded-full border border-[#F0F3EF] text-[#C8D8C9]">
                                    <x-tabler-lock class="h-4 w-4" />
                                </span>
                            @endif
                        </div>
                    @endif
                </div>
            </aside>
        </div>
    @endif


    {{-- ========================= ADD / EDIT MODAL ========================= --}}
    @if ($showForm)
        @php
            $input = 'mt-1 w-full rounded-xl border border-[#DCE5DC] px-3 py-2.5 text-sm text-[#294936] focus:border-[#5E8067] focus:outline-none focus:ring-1 focus:ring-[#5E8067]';
            $labelCls = 'text-xs font-medium text-[#718076]';
        @endphp

        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4" wire:click.self="closeForm">
            <div class="max-h-[90vh] w-full max-w-lg overflow-y-auto rounded-3xl bg-white p-6 shadow-xl">

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                            <x-tabler-user class="h-5 w-5" />
                        </div>
                        <h2 class="text-lg font-bold text-[#183524]">{{ $editingId ? 'Edit guest' : 'Add guest' }}</h2>
                    </div>
                    <button type="button" wire:click="closeForm" class="flex h-8 w-8 items-center justify-center rounded-full text-[#8FA58B] hover:bg-[#F8FAF6]">
                        <x-tabler-x class="h-4 w-4" />
                    </button>
                </div>

                <form wire:submit="save" class="mt-5 space-y-4">

                    <div>
                        <label class="{{ $labelCls }}">Name</label>
                        <input type="text" wire:model="name" class="{{ $input }}" autofocus>
                        @error('name') <p class="mt-1 text-xs text-[#B94A48]">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="{{ $labelCls }}">Email</label>
                            <input type="email" wire:model="email" class="{{ $input }}">
                            @error('email') <p class="mt-1 text-xs text-[#B94A48]">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="{{ $labelCls }}">Phone</label>
                            <input type="text" wire:model="phone" class="{{ $input }}">
                            @error('phone') <p class="mt-1 text-xs text-[#B94A48]">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="{{ $labelCls }}">Birthday</label>
                            <input type="date" wire:model="birthday" class="{{ $input }}">
                            @error('birthday') <p class="mt-1 text-xs text-[#B94A48]">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="{{ $labelCls }}">Loyalty points</label>
                            <input type="number" min="0" wire:model="loyalty_points" class="{{ $input }}">
                            @error('loyalty_points') <p class="mt-1 text-xs text-[#B94A48]">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="{{ $labelCls }}">Seating preference</label>
                            <select wire:model="seating_preference" class="{{ $input }}">
                                <option value="">No preference</option>
                                @foreach (Guest::SEATING as $k => $l) <option value="{{ $k }}">{{ $l }}</option> @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="{{ $labelCls }}">Dining style</label>
                            <select wire:model="dining_style" class="{{ $input }}">
                                <option value="">Not set</option>
                                @foreach (Guest::STYLES as $k => $l) <option value="{{ $k }}">{{ $l }}</option> @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="{{ $labelCls }}">Favorite dish or drink</label>

                        <div class="relative mt-1"
                            x-data="{
                                open: false,
                                query: '',
                                items: @js($this->menuItems->flatten(1)->map(fn ($m) => ['id' => $m->id, 'name' => $m->name, 'category' => $m->category?->name ?? 'Other'])->values()),
                                get selected() { return this.items.find(i => String(i.id) === String($wire.favorite_menu_item_id)) },
                                get filtered() {
                                    const q = this.query.trim().toLowerCase();
                                    return q ? this.items.filter(i => i.name.toLowerCase().includes(q) || i.category.toLowerCase().includes(q)) : this.items;
                                },
                                pick(id) { $wire.favorite_menu_item_id = id === null ? '' : String(id); this.open = false; this.query = ''; },
                            }"
                            x-on:click.outside="open = false" x-on:keydown.escape.stop="open = false">

                            <x-tabler-search class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8FA58B]" />

                            <input type="text" autocomplete="off"
                                :value="open ? query : (selected ? selected.name : '')"
                                :placeholder="selected ? selected.name : 'Search the menu…'"
                                x-on:focus="open = true; query = ''"
                                x-on:input="query = $event.target.value; open = true"
                                x-on:keydown.enter.prevent="filtered[0] && pick(filtered[0].id)"
                                class="w-full rounded-xl border border-[#DCE5DC] py-2.5 pl-9 pr-9 text-sm text-[#294936] placeholder:text-[#9AA79D] focus:border-[#5E8067] focus:outline-none focus:ring-1 focus:ring-[#5E8067]">

                            <button type="button" x-show="selected" x-cloak x-on:click="pick(null)" title="Clear"
                                class="absolute right-2.5 top-1/2 flex h-6 w-6 -translate-y-1/2 items-center justify-center rounded-full text-[#8FA58B] hover:bg-[#F8FAF6]">
                                <x-tabler-x class="h-3.5 w-3.5" />
                            </button>

                            <div x-show="open" x-cloak x-transition.opacity.duration.100ms
                                class="absolute z-20 mt-1 max-h-56 w-full overflow-y-auto rounded-2xl border border-[#DCE5DC] bg-white py-1 shadow-lg">
                                <template x-for="item in filtered" :key="item.id">
                                    <button type="button" x-on:click="pick(item.id)"
                                        :class="selected && selected.id === item.id ? 'bg-[#E8F0E5] font-semibold' : ''"
                                        class="flex w-full items-center justify-between gap-3 px-3.5 py-2 text-left text-sm hover:bg-[#F8FAF6]">
                                        <span class="truncate text-[#183524]" x-text="item.name"></span>
                                        <span class="shrink-0 text-[11px] text-[#8FA58B]" x-text="item.category"></span>
                                    </button>
                                </template>
                                <p x-show="filtered.length === 0" class="px-3.5 py-3 text-xs text-[#8FA58B]">No dishes match.</p>
                            </div>
                        </div>

                        @error('favorite_menu_item_id') <p class="mt-1 text-xs text-[#B94A48]">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <p class="{{ $labelCls }}">Dietary</p>
                        <div class="mt-2 flex flex-wrap gap-2">
                            @foreach (Guest::DIETARY as $k => $l)
                                <label class="cursor-pointer">
                                    <input type="checkbox" value="{{ $k }}" wire:model="dietary" class="peer sr-only">
                                    <span class="inline-block rounded-full border border-[#DCE5DC] px-3.5 py-1.5 text-xs font-medium text-[#718076] transition peer-checked:border-[#294936] peer-checked:bg-[#294936] peer-checked:text-white">{{ $l }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="{{ $labelCls }}">Notes</label>
                        <textarea wire:model="notes" rows="3" placeholder="Allergies, preferences, etc." class="{{ $input }}"></textarea>
                        @error('notes') <p class="mt-1 text-xs text-[#B94A48]">{{ $message }}</p> @enderror
                    </div>

                    <div class="mt-2 flex items-center justify-end gap-2 pt-2">
                        <button type="button" wire:click="closeForm"
                            class="rounded-full border border-[#DCE5DC] px-5 py-2.5 text-sm font-medium text-[#294936] hover:bg-[#F8FAF6]">
                            Cancel
                        </button>
                        <button type="submit" wire:loading.attr="disabled" wire:target="save"
                            class="inline-flex items-center gap-2 rounded-full bg-[#294936] px-5 py-2.5 text-sm font-medium text-white hover:bg-[#183524] disabled:opacity-60">
                            <span wire:loading.remove wire:target="save">{{ $editingId ? 'Save changes' : 'Add guest' }}</span>
                            <span wire:loading wire:target="save">Saving…</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    @endif

</div>