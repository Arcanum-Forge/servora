<?php
// {{-- guests/⚡index/index.php --}}
use App\Models\Guest;
use App\Models\MenuItem;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public const VIEWS = ['All Guests', 'Visit History', 'Preferences', 'Loyalty'];

    #[Url(as: 'view')]
    public string $view = 'All Guests';

    #[Url]
    public string $search = '';

    #[Url]
    public string $tier = '';

    #[Url]
    public string $diet = '';

    #[Url]
    public string $sort = 'recent';

    #[Url(as: 'guest')]
    public ?int $selectedGuestId = null;

    public bool $showForm = false;
    public ?int $editingId = null;
    public bool $confirmingDelete = false;

    // Form fields
    public string $name = '';
    public string $phone = '';
    public string $email = '';
    public string $notes = '';
    public ?string $birthday = null;
    public array $dietary = [];
    public string $seating_preference = '';
    public string $dining_style = '';
    public string $favorite_menu_item_id = '';

    #[Url(as: 'dish')]
    public ?int $favorite = null;

    public int $loyalty_points = 0;

    /* ------------------------------------------------------------------ */
    /* Navigation & filters                                                */
    /* ------------------------------------------------------------------ */

    public function setView(string $view): void
    {
        if (in_array($view, self::VIEWS, true)) {
            $this->view = $view;
            $this->resetPage('cursor');
        }
    }

    public function updatedSearch(): void
    {
        $this->resetPage('cursor');
    }
    public function updatedTier(): void
    {
        $this->resetPage('cursor');
    }
    public function updatedDiet(): void
    {
        $this->resetPage('cursor');
    }
    public function updatedSort(): void
    {
        $this->resetPage('cursor');
    }

    public function clearFilters(): void
    {
        $this->reset('search', 'tier', 'diet', 'favorite');
        $this->sort = 'recent';
        $this->resetPage('cursor');
    }

    public function selectGuest(int $id): void
    {
        $this->selectedGuestId = Guest::whereKey($id)->exists() ? $id : null;
        $this->confirmingDelete = false;
    }

    public function closeGuest(): void
    {
        $this->selectedGuestId = null;
        $this->confirmingDelete = false;
    }

    /* ------------------------------------------------------------------ */
    /* CRUD                                                                */
    /* ------------------------------------------------------------------ */

    public function openCreate(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $guest = Guest::findOrFail($id);

        $this->resetForm();
        $this->editingId = $guest->id;
        $this->name = $guest->name;
        $this->phone = (string) $guest->phone;
        $this->email = (string) $guest->email;
        $this->notes = (string) $guest->notes;
        $this->birthday = $guest->birthday?->format('Y-m-d');
        $this->dietary = $guest->dietary ?? [];
        $this->seating_preference = (string) $guest->seating_preference;
        $this->dining_style = (string) $guest->dining_style;
        $this->favorite_menu_item_id = (string) $guest->favorite_menu_item_id;
        $this->loyalty_points = $guest->loyalty_points;
        $this->showForm = true;
    }

    public function closeForm(): void
    {
        $this->showForm = false;
        $this->resetForm();
    }

    public function save(): void
    {
        $data = $this->validate([
            'name' => 'required|string|max:120',
            'phone' => 'nullable|string|max:40',
            'email' => 'nullable|email|max:160',
            'notes' => 'nullable|string|max:1000',
            'birthday' => 'nullable|date|before:today',
            'dietary' => 'array',
            'dietary.*' => 'in:' . implode(',', array_keys(Guest::DIETARY)),
            'seating_preference' => 'nullable|in:' . implode(',', array_keys(Guest::SEATING)),
            'dining_style' => 'nullable|in:' . implode(',', array_keys(Guest::STYLES)),
            'favorite_menu_item_id' => 'nullable|exists:menu_items,id',
            'loyalty_points' => 'required|integer|min:0|max:100000',
        ]);

        foreach (['phone', 'email', 'notes', 'birthday', 'seating_preference', 'dining_style', 'favorite_menu_item_id'] as $k) {
            $data[$k] = $data[$k] === '' ? null : $data[$k];
        }
        $data['dietary'] = $data['dietary'] ?: null;

        $guest = Guest::updateOrCreate(['id' => $this->editingId], $data);

        $this->closeForm();
        $this->selectedGuestId = $guest->id;
        unset($this->stats, $this->selectedGuest);
    }


    public function updatedFavorite(): void
    {
        $this->resetPage();
    }

    public function filterByFavorite(int $id): void
    {
        $this->reset('search', 'tier', 'diet');
        $this->favorite = $id;
        $this->setView('All Guests');
    }

    public function adjustPoints(int $id, int $delta): void
    {
        $guest = Guest::findOrFail($id);
        $guest->update(['loyalty_points' => max(0, $guest->loyalty_points + $delta)]);
        unset($this->stats, $this->selectedGuest);
    }

    public function delete(): void
    {
        $guest = Guest::withCount(['reservations', 'waitlistEntries'])->find($this->selectedGuestId);

        // Guests with history can't be deleted (the UI hides the button; this covers stale clicks).
        if ($guest && $guest->reservations_count === 0 && $guest->waitlist_entries_count === 0) {
            $guest->delete();
            $this->closeGuest();
            unset($this->stats);

            return;
        }

        $this->confirmingDelete = false;
    }

    public function export()
    {
        $guests = $this->baseQuery()->get();

        return response()->streamDownload(function () use ($guests) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Name', 'Email', 'Phone', 'Tier', 'Points', 'Visits', 'Last visit', 'Favorite', 'Seating', 'Dietary']);

            foreach ($guests as $g) {
                fputcsv($out, [
                    $g->name,
                    $g->email,
                    $g->phone,
                    $g->tier,
                    $g->loyalty_points,
                    $g->visits_count,
                    $g->last_visit_at ? \Carbon\Carbon::parse($g->last_visit_at)->toDateString() : '',
                    $g->favorite_item,
                    Guest::SEATING[$g->seating_preference] ?? '',
                    collect($g->dietary ?? [])->map(fn($d) => Guest::DIETARY[$d] ?? $d)->implode('; '),
                ]);
            }
            fclose($out);
        }, 'guests-' . now()->format('Y-m-d') . '.csv');
    }

    private function resetForm(): void
    {
        $this->reset(
            'editingId',
            'name',
            'phone',
            'email',
            'notes',
            'birthday',
            'dietary',
            'seating_preference',
            'dining_style',
            'favorite_menu_item_id',
            'loyalty_points',
        );
        $this->resetValidation();
    }

    /* ------------------------------------------------------------------ */
    /* Queries                                                             */
    /* ------------------------------------------------------------------ */

    /** A "visit" is a reservation that was actually seated. */
    private function baseQuery(): Builder
    {
        $seated = fn($q) => $q->whereNotNull('seated_at');

        return Guest::query()
            ->with('favoriteMenuItem')
            ->withCount(['reservations as visits_count' => $seated])
            ->withMax(['reservations as last_visit_at' => $seated], 'seated_at')
            ->withAvg(['reservations as avg_party' => $seated], 'party_size')
            ->when($this->search !== '', function (Builder $q) {
                $term = '%' . trim($this->search) . '%';
                $q->where(fn($w) => $w
                    ->where('name', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('phone', 'like', $term)
                    ->orWhereHas('favoriteMenuItem', fn($m) => $m->where('name', 'like', $term)));
            })
            ->when($this->favorite, fn(Builder $q) => $q->where('favorite_menu_item_id', $this->favorite))
            ->when($this->tier !== '', fn(Builder $q) => match ($this->tier) {
                'Gold' => $q->where('loyalty_points', '>=', Guest::GOLD_AT),
                'Silver' => $q->whereBetween('loyalty_points', [Guest::SILVER_AT, Guest::GOLD_AT - 1]),
                'Member' => $q->where('loyalty_points', '<', Guest::SILVER_AT),
                default => $q,
        })
            ->when($this->diet !== '', fn(Builder $q) => $q->whereJsonContains('dietary', $this->diet))
            ->when($this->sort === 'visits', fn($q) => $q->orderByDesc('visits_count'))
            ->when($this->sort === 'points', fn($q) => $q->orderByDesc('loyalty_points'))
            ->when($this->sort === 'name', fn($q) => $q->orderBy('name'))
            ->when($this->sort === 'recent', fn($q) => $q->orderByDesc('last_visit_at'))
            ->orderBy('name')
            ->orderBy('id');
    }


    public function mount(): void
    {
        if (!in_array($this->view, self::VIEWS, true)) {
            $this->view = 'All Guests';
        }
    }

    #[Computed]
    public function guests()
    {
        return $this->baseQuery()->cursorPaginate(12);
    }


    #[Computed]
    public function profiles(): Collection
    {
        return Guest::query()
            ->withCount(['reservations as visits_count' => fn($q) => $q->whereNotNull('seated_at')])
            ->withMax(['reservations as last_visit_at' => fn($q) => $q->whereNotNull('seated_at')], 'seated_at')
            ->withAvg(['reservations as avg_party' => fn($q) => $q->whereNotNull('seated_at')], 'party_size')
            ->orderByDesc('visits_count')
            ->limit(9)
            ->get();
    }

    #[Computed]
    public function selectedGuest(): ?Guest
    {
        if (!$this->selectedGuestId) {
            return null;
        }

        return Guest::query()
            ->withCount(['reservations', 'waitlistEntries'])
            ->withCount(['reservations as visits_count' => fn($q) => $q->whereNotNull('seated_at')])
            ->withMax(['reservations as last_visit_at' => fn($q) => $q->whereNotNull('seated_at')], 'seated_at')
            ->with(['reservations' => fn($q) => $q->with('table')->whereNotNull('seated_at')->latest('seated_at')->limit(5)])
            ->with('favoriteMenuItem')
            ->find($this->selectedGuestId);
    }

    #[Computed]
    public function stats(): array
    {
        $total = Guest::count();
        $visited = Guest::whereHas('reservations', fn($q) => $q->whereNotNull('seated_at'))->count();
        $returning = Guest::has('reservations', '>=', 2, 'and', fn($q) => $q->whereNotNull('seated_at'))->count();

        return [
            'total' => $total,
            'returning_pct' => $visited ? (int) round($returning / $visited * 100) : 0,
            'new_month' => Guest::where('created_at', '>=', now()->startOfMonth())->count(),
            'gold' => Guest::where('loyalty_points', '>=', Guest::GOLD_AT)->count(),
            'silver' => Guest::whereBetween('loyalty_points', [Guest::SILVER_AT, Guest::GOLD_AT - 1])->count(),
            'member' => Guest::where('loyalty_points', '<', Guest::SILVER_AT)->count(),
            'points' => (int) Guest::sum('loyalty_points'),
        ];
    }

    #[Computed]
    public function visits(): Collection
    {
        return Reservation::with(['guest.favoriteMenuItem', 'table'])
            ->whereNotNull('seated_at')
            ->latest('seated_at')
            ->limit(12)
            ->get();
    }

    #[Computed]
    public function visitSummary(): array
    {
        $start = now()->startOfMonth();
        $monthVisits = Reservation::whereNotNull('seated_at')->where('seated_at', '>=', $start);
        $count = (clone $monthVisits)->count();

        $guestIds = (clone $monthVisits)->distinct()->pluck('guest_id');
        $returning = $guestIds->isEmpty() ? 0 : Guest::whereIn('id', $guestIds)
            ->whereHas('reservations', fn($q) => $q->whereNotNull('seated_at')->where('seated_at', '<', $start))
            ->count();

        $hours = Reservation::whereNotNull('seated_at')
            ->where('seated_at', '>=', now()->subDays(90))
            ->pluck('seated_at')
            ->map(fn($d) => (int) $d->format('G'));

        $bucket = fn($h) => $h < 16 ? 'Lunch' : ($h < 21 ? 'Evening' : 'Late night');
        $groups = $hours->groupBy($bucket)->map->count();
        $sum = max(1, $groups->sum());

        return [
            'count' => $count,
            'returning_pct' => $guestIds->isEmpty() ? 0 : (int) round($returning / $guestIds->count() * 100),
            'times' => collect(['Evening', 'Lunch', 'Late night'])
                ->map(fn($l) => ['label' => $l, 'pct' => (int) round(($groups[$l] ?? 0) / $sum * 100)]),
        ];
    }

    #[Computed]
    public function preferences(): array
    {
        $guests = Guest::get(['seating_preference', 'dining_style', 'dietary']);

        $ratio = function (array $labels, string $col) use ($guests) {
            $counts = $guests->pluck($col)->filter()->countBy();
            $sum = max(1, $counts->sum());

            return collect($labels)->map(fn($label, $key) => [
                'label' => $label,
                'count' => $counts[$key] ?? 0,
                'pct' => (int) round(($counts[$key] ?? 0) / $sum * 100),
            ])->sortByDesc('count')->values();
        };

        $diet = $guests->pluck('dietary')->filter()->flatten()->countBy();

        return [
            'seating' => $ratio(Guest::SEATING, 'seating_preference'),
            'styles' => $ratio(Guest::STYLES, 'dining_style'),
            'diet' => collect(Guest::DIETARY)
                ->map(fn($l, $k) => ['label' => $l, 'count' => $diet[$k] ?? 0])
                ->values(),
            'favorites' => MenuItem::query()
                ->withCount('favoritedBy as guests_count')
                ->has('favoritedBy')
                ->orderByDesc('guests_count')
                ->limit(5)
                ->get(),
        ];
    }

    #[Computed]
    public function loyaltyMembers(): Collection
    {
        // Highest progress toward next reward first.
        return Guest::query()
            ->withCount(['reservations as visits_count' => fn($q) => $q->whereNotNull('seated_at')])
            ->with('favoriteMenuItem')
            ->where('loyalty_points', '>', 0)
            ->get()
            ->sortByDesc('tier_progress')
            ->take(8)
            ->values();
    }

    #[Computed]
    public function menuItems(): Collection
    {
        return MenuItem::available()->with('category')->orderBy('sort_order')->get()
            ->groupBy(fn($m) => $m->category?->name ?? 'Other');
    }

    #[Computed]
    public function favoriteFilter(): ?MenuItem
    {
        return $this->favorite ? MenuItem::find($this->favorite) : null;
    }



};