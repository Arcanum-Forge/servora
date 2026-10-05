<?php

// reservations/⚡index/index.php 

use App\Enums\ReservationStatus;
use App\Enums\TableStatus;
use App\Enums\WaitlistStatus;
use App\Models\DiningHall;
use App\Models\DiningTable;
use App\Models\FloorElement;
use App\Models\Guest;
use App\Models\Reservation;
use App\Models\WaitlistEntry;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;


new class extends Component {
    public ?int $currentHallId = null;

    public string $view = 'Reservations';

    public string $selectedDate = '';

    public string $search = '';

    // Add/Edit Reservation modal (also used for walk-ins)
    public bool $showReservationModal = false;

    public ?int $editingReservationId = null;

    public bool $isWalkIn = false;

    public ?int $fromWaitlistId = null;

    public string $newGuestName = '';

    public string $newGuestPhone = '';

    public int $newPartySize = 2;

    public string $newReservedDate = '';

    public string $newReservedTime = '18:00';

    public int $newDurationMinutes = 90;

    public ?int $newTableId = null;

    public string $newNotes = '';

    // Set when an existing guest is picked from search (keeps the booking linked to them).
    public ?int $selectedGuestId = null;

    // Dedicated "view full floor plan" modal, opened from the table field
    // in either the Reservation or Assign-Table modal.
    public bool $showFloorPickerModal = false;

    public string $floorPickerTarget = 'newTableId';

    // Add Waitlist modal
    public bool $showWaitlistModal = false;

    public string $newWaitlistGuestName = '';

    public string $newWaitlistPhone = '';

    public int $newWaitlistPartySize = 2;

    public ?int $selectedWaitlistGuestId = null;

    // Add/Edit Guest modal
    public bool $showGuestModal = false;

    public ?int $editingGuestId = null;

    public string $guestFormName = '';

    public string $guestFormPhone = '';

    public string $guestFormEmail = '';

    public string $guestFormNotes = '';

    // Quick "assign a table" prompt when seating a table-less reservation
    public bool $showSeatTableModal = false;

    public ?int $seatingReservationId = null;

    public ?int $seatTableId = null;

    // Calendar month view
    public string $calendarMonth = '';

    // Lets a link from the Floor Plan page (?table=5) open "New Reservation" pre-filled.
    #[Url(as: 'table')]
    public ?int $prefillTableId = null;

    public function mount(): void
    {
        $sessionHallId = session('servora_current_hall_id');
        $this->currentHallId = ($sessionHallId && DiningHall::whereKey($sessionHallId)->exists())
            ? $sessionHallId
            : DiningHall::query()->oldest('id')->value('id');

        if ($this->currentHallId) {
            session(['servora_current_hall_id' => $this->currentHallId]);
        }

        $this->selectedDate = now()->format('Y-m-d');
        $this->newReservedDate = $this->selectedDate;
        $this->calendarMonth = now()->format('Y-m');

        if ($this->prefillTableId && DiningTable::whereKey($this->prefillTableId)->exists()) {
            $this->openNewReservationModal(false);
            $this->newTableId = $this->prefillTableId;
        }

        if (!in_array($this->view, ['Reservations', 'Waitlist'], true)) {
            $this->view = 'Reservations';
        }
    }

    public function setView(string $view): void
    {
        $this->view = $view;
        $this->search = '';
    }

    public function updatedCurrentHallId(): void
    {
        session(['servora_current_hall_id' => $this->currentHallId]);
        $this->search = '';
    }

    // --- Date navigation ---------------------------------------------------

    public function prevDay(): void
    {
        $this->selectedDate = Carbon::parse($this->selectedDate)->subDay()->format('Y-m-d');
        $this->syncCalendarToSelectedDate();
    }

    public function nextDay(): void
    {
        $this->selectedDate = Carbon::parse($this->selectedDate)->addDay()->format('Y-m-d');
        $this->syncCalendarToSelectedDate();
    }

    public function goToToday(): void
    {
        $this->selectedDate = now()->format('Y-m-d');
        $this->syncCalendarToSelectedDate();
    }

    // --- Date picker (calendar popover) --------------------------------

    public function pickDate(string $date): void
    {
        $this->selectedDate = Carbon::parse($date)->format('Y-m-d');
        $this->syncCalendarToSelectedDate();
    }

    public function prevMonth(): void
    {
        $this->calendarMonth = Carbon::parse($this->calendarMonth . '-01')->subMonth()->format('Y-m');
    }

    public function nextMonth(): void
    {
        $this->calendarMonth = Carbon::parse($this->calendarMonth . '-01')->addMonth()->format('Y-m');
    }

    public function goToCurrentMonth(): void
    {
        $this->calendarMonth = now()->format('Y-m');
    }

    protected function syncCalendarToSelectedDate(): void
    {
        $this->calendarMonth = Carbon::parse($this->selectedDate)->format('Y-m');
    }

    // --- Add / Edit Reservation ----------------------------------------

    public function openNewReservationModal(bool $walkIn = false, ?int $fromWaitlistId = null): void
    {
        $this->resetReservationForm();
        $this->isWalkIn = $walkIn;
        $this->fromWaitlistId = $fromWaitlistId;

        if ($fromWaitlistId) {
            $entry = WaitlistEntry::with('guest')->find($fromWaitlistId);

            if ($entry) {
                $this->selectedGuestId = $entry->guest_id;
                $this->newGuestName = $entry->guest->name;
                $this->newGuestPhone = $entry->guest->phone ?? '';
                $this->newPartySize = $entry->party_size;
            }
        }

        $this->showReservationModal = true;
    }

    public function openEditReservationModal(int $id): void
    {
        $reservation = Reservation::with('guest')->find($id);

        if (!$reservation) {
            return;
        }

        $this->editingReservationId = $reservation->id;
        $this->isWalkIn = false;
        $this->fromWaitlistId = null;
        $this->selectedGuestId = $reservation->guest_id;
        $this->newGuestName = $reservation->guest->name;
        $this->newGuestPhone = $reservation->guest->phone ?? '';
        $this->newPartySize = $reservation->party_size;
        $this->newReservedDate = $reservation->reserved_for->format('Y-m-d');
        $this->newReservedTime = $reservation->reserved_for->format('H:i');
        $this->newDurationMinutes = $reservation->duration_minutes;
        $this->newTableId = $reservation->dining_table_id;
        $this->newNotes = $reservation->notes ?? '';
        $this->resetErrorBag();
        $this->showReservationModal = true;
    }

    public function closeReservationModal(): void
    {
        $this->showReservationModal = false;
        $this->fromWaitlistId = null;
        $this->resetReservationForm();
    }

    protected function resetReservationForm(): void
    {
        $this->editingReservationId = null;
        $this->isWalkIn = false;
        $this->selectedGuestId = null;
        $this->newGuestName = '';
        $this->newGuestPhone = '';
        $this->newPartySize = 2;
        $this->newReservedDate = $this->selectedDate;
        $this->newReservedTime = '18:00';
        $this->newDurationMinutes = 90;
        $this->newTableId = null;
        $this->newNotes = '';
        $this->resetErrorBag();
    }

    protected function findOrCreateGuest(string $name, ?string $phone): Guest
    {
        if ($phone) {
            return Guest::firstOrCreate(['phone' => $phone], ['name' => $name]);
        }

        return Guest::create(['name' => $name]);
    }

    /**
     * Prefer the guest picked from search; otherwise fall back to find-or-create.
     */
    protected function resolveGuest(?int $guestId, string $name, ?string $phone): Guest
    {
        if ($guestId && ($guest = Guest::find($guestId))) {
            if ($phone && !$guest->phone) {
                $guest->update(['phone' => $phone]);
            }

            return $guest;
        }

        return $this->findOrCreateGuest($name, $phone);
    }

    protected function searchGuests(string $term)
    {
        $term = trim($term);

        if ($term === '') {
            return collect();
        }

        return Guest::withCount('reservations')
            ->where(fn($q) => $q->where('name', 'like', '%' . $term . '%')->orWhere('phone', 'like', '%' . $term . '%'))
            ->orderBy('name')
            ->limit(5)
            ->get();
    }

    public function pickGuest(int $id, string $target = 'reservation'): void
    {
        $guest = Guest::find($id);

        if (!$guest) {
            return;
        }

        if ($target === 'waitlist') {
            $this->selectedWaitlistGuestId = $guest->id;
            $this->newWaitlistGuestName = $guest->name;
            $this->newWaitlistPhone = $guest->phone ?? '';

            return;
        }

        $this->selectedGuestId = $guest->id;
        $this->newGuestName = $guest->name;
        $this->newGuestPhone = $guest->phone ?? '';
    }

    public function clearGuest(string $target = 'reservation'): void
    {
        if ($target === 'waitlist') {
            $this->selectedWaitlistGuestId = null;
            $this->newWaitlistGuestName = '';
            $this->newWaitlistPhone = '';

            return;
        }

        $this->selectedGuestId = null;
        $this->newGuestName = '';
        $this->newGuestPhone = '';
    }

    // Typing a different name un-links the picked guest so a new one is created.
    public function updatedNewGuestName(): void
    {
        if ($this->selectedGuestId && Guest::whereKey($this->selectedGuestId)->value('name') !== $this->newGuestName) {
            $this->selectedGuestId = null;
        }
    }

    public function updatedNewWaitlistGuestName(): void
    {
        if ($this->selectedWaitlistGuestId && Guest::whereKey($this->selectedWaitlistGuestId)->value('name') !== $this->newWaitlistGuestName) {
            $this->selectedWaitlistGuestId = null;
        }
    }

    public function saveReservation(): void
    {
        $rules = [
            'newGuestName' => ['required', 'string', 'max:100'],
            'newGuestPhone' => ['nullable', 'string', 'max:30'],
            'newPartySize' => ['required', 'integer', 'min:1', 'max:30'],
            'newDurationMinutes' => ['required', 'integer', 'min:15', 'max:480'],
            'newTableId' => $this->isWalkIn
                ? ['required', 'exists:dining_tables,id']
                : ['nullable', 'exists:dining_tables,id'],
            'newNotes' => ['nullable', 'string', 'max:255'],
        ];

        if (!$this->isWalkIn) {
            $rules['newReservedDate'] = ['required', 'date'];
            $rules['newReservedTime'] = ['required'];
        }

        $validated = $this->validate($rules);

        $reservedFor = $this->isWalkIn
            ? now()
            : Carbon::parse($validated['newReservedDate'] . ' ' . $validated['newReservedTime']);

        $duration = $validated['newDurationMinutes'];
        $tableId = $validated['newTableId'] ?: null;

        if ($tableId && $this->tableHasConflict($tableId, $reservedFor, $reservedFor->copy()->addMinutes($duration), $this->editingReservationId)) {
            $this->addError('newTableId', 'That table is already booked over this time — pick another table or time.');

            return;
        }

        $guest = $this->resolveGuest($this->selectedGuestId, $validated['newGuestName'], $validated['newGuestPhone'] ?: null);

        $status = $this->isWalkIn ? ReservationStatus::Seated : ReservationStatus::Confirmed;

        if ($this->editingReservationId) {
            $reservation = Reservation::find($this->editingReservationId);
            $reservation->update([
                'guest_id' => $guest->id,
                'dining_table_id' => $tableId,
                'party_size' => $validated['newPartySize'],
                'reserved_for' => $reservedFor,
                'duration_minutes' => $duration,
                'notes' => $validated['newNotes'] ?: null,
            ]);
        } else {
            $reservation = Reservation::create([
                'dining_hall_id' => $this->currentHallId,
                'guest_id' => $guest->id,
                'dining_table_id' => $tableId,
                'party_size' => $validated['newPartySize'],
                'reserved_for' => $reservedFor,
                'duration_minutes' => $duration,
                'status' => $status->value,
                'seated_at' => $this->isWalkIn ? now() : null,
                'notes' => $validated['newNotes'] ?: null,
            ]);

            if ($this->isWalkIn) {
                $this->awardAndNotify($reservation);
            }

            if ($this->fromWaitlistId) {
                WaitlistEntry::whereKey($this->fromWaitlistId)->update([
                    'status' => WaitlistStatus::Seated->value,
                    'seated_at' => now(),
                ]);
            }
        }

        if ($reservation->dining_table_id) {
            DiningTable::whereKey($reservation->dining_table_id)->update([
                'status' => $status === ReservationStatus::Seated
                    ? TableStatus::Occupied->value
                    : TableStatus::Reserved->value,
            ]);
        }

        $this->showReservationModal = false;
        $this->fromWaitlistId = null;
        $this->resetReservationForm();
    }

    protected function freeTable(Reservation $reservation): void
    {
        if ($reservation->dining_table_id) {
            DiningTable::whereKey($reservation->dining_table_id)->update([
                'status' => TableStatus::Available->value,
            ]);
        }
    }

    public function seatReservation(int $id): void
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return;
        }

        if (!$reservation->dining_table_id) {
            // Can't seat a party with nowhere to sit them — ask which table first.
            $this->seatingReservationId = $id;
            $this->seatTableId = null;
            $this->resetErrorBag();
            $this->showSeatTableModal = true;

            return;
        }

        $this->finalizeSeating($reservation);
    }

    protected function finalizeSeating(Reservation $reservation): void
    {
        $reservation->update([
            'status' => ReservationStatus::Seated->value,
            'seated_at' => now(),
        ]);

        $this->awardAndNotify($reservation);

        if ($reservation->dining_table_id) {
            DiningTable::whereKey($reservation->dining_table_id)->update([
                'status' => TableStatus::Occupied->value,
            ]);
        }
    }

    protected function awardAndNotify(Reservation $reservation): void
    {
        $guest = $reservation->guest;
        $tierBefore = $guest->tier;

        $points = $guest->awardPointsFor($reservation);

        if ($points === 0) {
            return; // already paid out
        }

        $message = "+{$points} pts for {$guest->name}";

        if ($guest->tier !== $tierBefore) {
            $message .= " · now {$guest->tier}!";
        }

        $this->dispatch('points-awarded', message: $message);
    }

    public function closeSeatTableModal(): void
    {
        $this->showSeatTableModal = false;
        $this->seatingReservationId = null;
        $this->seatTableId = null;
    }

    // --- Dedicated floor-plan picker modal ------------------------------

    public function openFloorPicker(string $target): void
    {
        $this->floorPickerTarget = $target;
        $this->showFloorPickerModal = true;
    }

    public function closeFloorPicker(): void
    {
        $this->showFloorPickerModal = false;
    }

    public function updatedNewTableId(): void
    {
        // Picking a table in the dedicated picker closes it and returns to the form.
        $this->showFloorPickerModal = false;
    }

    public function updatedSeatTableId(): void
    {
        $this->showFloorPickerModal = false;
    }

    public function confirmSeatWithTable(): void
    {
        $validated = $this->validate([
            'seatTableId' => ['required', 'exists:dining_tables,id'],
        ]);

        $reservation = Reservation::find($this->seatingReservationId);

        if (!$reservation) {
            $this->closeSeatTableModal();

            return;
        }

        $now = now();
        $windowEnd = $now->copy()->addMinutes($reservation->duration_minutes);

        if ($this->tableHasConflict($validated['seatTableId'], $now, $windowEnd, $reservation->id)) {
            $this->addError('seatTableId', 'That table is already booked right now — pick another table.');

            return;
        }

        $reservation->update(['dining_table_id' => $validated['seatTableId']]);

        $reservation->refresh();

        $this->finalizeSeating($reservation);
        $this->closeSeatTableModal();
    }

    /**
     * Whether any other active (confirmed/seated) reservation on this table
     * overlaps the given [start, end) window. Only checks same-day bookings,
     * which is the only case that matters for a single service day.
     */
    protected function tableHasConflict(int $tableId, \Carbon\CarbonInterface $start, \Carbon\CarbonInterface $end, ?int $excludeReservationId = null): bool
    {
        return Reservation::where('dining_table_id', $tableId)
            ->whereIn('status', [ReservationStatus::Confirmed->value, ReservationStatus::Seated->value])
            ->when($excludeReservationId, fn($q) => $q->where('id', '!=', $excludeReservationId))
            ->whereDate('reserved_for', $start->toDateString())
            ->get()
            ->contains(fn(Reservation $existing) => $existing->overlaps($start, $end));
    }

    public function completeReservation(int $id): void
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return;
        }

        $reservation->update(['status' => ReservationStatus::Completed->value]);
        $this->freeTable($reservation);
    }

    public function cancelReservation(int $id): void
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return;
        }

        $reservation->update(['status' => ReservationStatus::Cancelled->value]);
        $this->freeTable($reservation);
    }

    public function markNoShow(int $id): void
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return;
        }

        $reservation->update(['status' => ReservationStatus::NoShow->value]);
        $this->freeTable($reservation);
    }

    // --- Waitlist ----------------------------------------------------------

    public function openAddWaitlistModal(): void
    {
        $this->resetWaitlistForm();
        $this->showWaitlistModal = true;
    }

    public function closeWaitlistModal(): void
    {
        $this->showWaitlistModal = false;
    }

    protected function resetWaitlistForm(): void
    {
        $this->selectedWaitlistGuestId = null;
        $this->newWaitlistGuestName = '';
        $this->newWaitlistPhone = '';
        $this->newWaitlistPartySize = 2;
        $this->resetErrorBag();
    }

    public function saveWaitlistEntry(): void
    {
        $validated = $this->validate([
            'newWaitlistGuestName' => ['required', 'string', 'max:100'],
            'newWaitlistPhone' => ['nullable', 'string', 'max:30'],
            'newWaitlistPartySize' => ['required', 'integer', 'min:1', 'max:30'],
        ]);

        $guest = $this->resolveGuest($this->selectedWaitlistGuestId, $validated['newWaitlistGuestName'], $validated['newWaitlistPhone'] ?: null);

        WaitlistEntry::create([
            'dining_hall_id' => $this->currentHallId,
            'guest_id' => $guest->id,
            'party_size' => $validated['newWaitlistPartySize'],
            'status' => WaitlistStatus::Waiting->value,
            'joined_at' => now(),
        ]);

        $this->showWaitlistModal = false;
        $this->resetWaitlistForm();
    }

    public function seatFromWaitlist(int $id): void
    {
        $this->openNewReservationModal(true, $id);
    }

    public function removeFromWaitlist(int $id): void
    {
        WaitlistEntry::whereKey($id)->update(['status' => WaitlistStatus::Left->value]);
    }

    // --- Guests --------------------------------------------------------

    public function openAddGuestModal(): void
    {
        $this->editingGuestId = null;
        $this->guestFormName = '';
        $this->guestFormPhone = '';
        $this->guestFormEmail = '';
        $this->guestFormNotes = '';
        $this->resetErrorBag();
        $this->showGuestModal = true;
    }

    public function openEditGuestModal(int $id): void
    {
        $guest = Guest::find($id);

        if (!$guest) {
            return;
        }

        $this->editingGuestId = $guest->id;
        $this->guestFormName = $guest->name;
        $this->guestFormPhone = $guest->phone ?? '';
        $this->guestFormEmail = $guest->email ?? '';
        $this->guestFormNotes = $guest->notes ?? '';
        $this->resetErrorBag();
        $this->showGuestModal = true;
    }

    public function closeGuestModal(): void
    {
        $this->showGuestModal = false;
        $this->editingGuestId = null;
    }

    public function saveGuest(): void
    {
        $validated = $this->validate([
            'guestFormName' => ['required', 'string', 'max:100'],
            'guestFormPhone' => ['nullable', 'string', 'max:30'],
            'guestFormEmail' => ['nullable', 'email', 'max:150'],
            'guestFormNotes' => ['nullable', 'string', 'max:500'],
        ]);

        $data = [
            'name' => $validated['guestFormName'],
            'phone' => $validated['guestFormPhone'] ?: null,
            'email' => $validated['guestFormEmail'] ?: null,
            'notes' => $validated['guestFormNotes'] ?: null,
        ];

        if ($this->editingGuestId) {
            Guest::whereKey($this->editingGuestId)->update($data);
        } else {
            Guest::create($data);
        }

        $this->showGuestModal = false;
        $this->editingGuestId = null;
    }

    public function deleteGuest(int $id): void
    {
        $guest = Guest::withCount(['reservations', 'waitlistEntries'])->find($id);

        if (!$guest || $guest->reservations_count > 0 || $guest->waitlist_entries_count > 0) {
            // Has history — the UI hides the delete action in this case, so this
            // is just a safety net against a stale button click.
            return;
        }

        $guest->delete();
    }

    // --- Computed --------------------------------------------------------

    #[Computed]
    public function halls()
    {
        return DiningHall::orderBy('name')->get();
    }

    #[Computed]
    public function currentHall(): ?DiningHall
    {
        return $this->currentHallId ? DiningHall::find($this->currentHallId) : null;
    }

    #[Computed]
    public function tables()
    {
        return DiningTable::where('dining_hall_id', $this->currentHallId)->orderBy('name')->get();
    }

    #[Computed]
    public function availableTables()
    {
        return $this->tables->where('status', TableStatus::Available);
    }

    #[Computed]
    public function floorElements()
    {
        return FloorElement::where('dining_hall_id', $this->currentHallId)->orderBy('id')->get();
    }

    #[Computed]
    public function reservationsForDate()
    {
        $query = Reservation::where('dining_hall_id', $this->currentHallId)
            ->whereDate('reserved_for', $this->selectedDate)
            ->where('status', '!=', ReservationStatus::Cancelled->value)
            ->with(['guest', 'table'])
            ->orderBy('reserved_for');

        if ($this->search !== '') {
            $term = '%' . $this->search . '%';
            $query->where(function ($q) use ($term) {
                $q->whereHas('guest', fn($g) => $g->where('name', 'like', $term))
                    ->orWhereHas('table', fn($t) => $t->where('name', 'like', $term));
            });
        }

        return $query->get();
    }

    #[Computed]
    public function waitlistEntries()
    {
        return WaitlistEntry::where('dining_hall_id', $this->currentHallId)
            ->where('status', WaitlistStatus::Waiting->value)
            ->with('guest')
            ->orderBy('joined_at')
            ->get();
    }

    #[Computed]
    public function guestSuggestions()
    {
        return $this->selectedGuestId ? collect() : $this->searchGuests($this->newGuestName);
    }

    #[Computed]
    public function selectedGuest(): ?Guest
    {
        return $this->selectedGuestId ? Guest::withCount('reservations')->find($this->selectedGuestId) : null;
    }

    #[Computed]
    public function waitlistGuestSuggestions()
    {
        return $this->selectedWaitlistGuestId ? collect() : $this->searchGuests($this->newWaitlistGuestName);
    }

    #[Computed]
    public function selectedWaitlistGuest(): ?Guest
    {
        return $this->selectedWaitlistGuestId ? Guest::withCount('reservations')->find($this->selectedWaitlistGuestId) : null;
    }

    #[Computed]
    public function guests()
    {
        $query = Guest::withCount(['reservations', 'waitlistEntries'])->orderBy('name');

        if ($this->search !== '') {
            $term = '%' . $this->search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                    ->orWhere('phone', 'like', $term)
                    ->orWhere('email', 'like', $term);
            });
        }

        return $query->get();
    }

    #[Computed]
    public function calendarWeeks(): array
    {
        $month = Carbon::parse($this->calendarMonth . '-01');
        $start = $month->copy()->startOfMonth()->startOfWeek(Carbon::SUNDAY);
        $end = $month->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        $counts = Reservation::where('dining_hall_id', $this->currentHallId)
            ->where('status', '!=', ReservationStatus::Cancelled->value)
            ->whereBetween('reserved_for', [$start->copy()->startOfDay(), $end->copy()->endOfDay()])
            ->get()
            ->groupBy(fn($r) => $r->reserved_for->format('Y-m-d'))
            ->map->count();

        $days = [];
        $cursor = $start->copy();

        while ($cursor->lte($end)) {
            $key = $cursor->format('Y-m-d');
            $days[] = [
                'date' => $key,
                'day' => $cursor->day,
                'inMonth' => $cursor->month === $month->month,
                'isToday' => $cursor->isToday(),
                'count' => $counts[$key] ?? 0,
            ];
            $cursor->addDay();
        }

        return array_chunk($days, 7);
    }

    #[Computed]
    public function stats(): array
    {
        $reservations = $this->reservationsForDate;

        return [
            'reservations' => $reservations->count(),
            'expected_guests' => $reservations->sum('party_size'),
            'seated' => $reservations->where('status', ReservationStatus::Seated)->count(),
            'waitlist' => $this->waitlistEntries->count(),
        ];
    }

    #[Computed]
    public function tableStats(): array
    {
        $tables = $this->tables;

        return [
            'total' => $tables->count(),
            'available' => $tables->where('status', TableStatus::Available)->count(),
            'occupied' => $tables->where('status', TableStatus::Occupied)->count(),
            'reserved' => $tables->where('status', TableStatus::Reserved)->count(),
        ];
    }




};