<?php


use App\Enums\TableStatus;
use App\Models\DiningHall;
use App\Models\DiningTable;
use App\Models\TableSection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use App\Enums\FloorElementType;
use App\Enums\TableShape;
use App\Models\FloorElement;
use App\Enums\FloorElementPreset;


new class extends Component {
   public string $view = 'Floor Plan';
 
    public ?int $currentHallId = null;
 
    public ?int $selectedTable = null;
 
    public bool $editingLayout = false;
 
    // Add/Edit Table modal
    public bool $showAddTableModal = false;
 
    public ?int $editingTableId = null;
 
    public string $newTableName = '';
 
    public int $newTableSeats = 2;
 
    public ?int $newTableSectionId = null;
 
    public bool $newTableFeatured = false;
 
    public string $newTableShape = 'rectangle';
 
    // Add Element modal (barriers + labels)
    public bool $showAddElementModal = false;
 
    public string $newElementType = 'barrier';
 
    public string $newElementPreset = 'wall';
 
    public string $newElementName = '';
 
    public int $newElementWidth = 160;
 
    public int $newElementHeight = 24;
 
    // Tables list view (search + filter)
    public string $tableSearch = '';
 
    public string $tableSectionFilter = '';
 
    // Add/Edit Section modal
    public bool $showSectionModal = false;
 
    public ?int $editingSectionId = null;
 
    public string $newSectionName = '';
 
    public string $newSectionColor = '#5E8067';
 
    public array $sectionColorPalette = [
        '#5E8067', '#9A762B', '#47708F', '#B94A48',
        '#294936', '#8B5CF6', '#DB2777', '#0EA5E9',
    ];
 
    // Add/Edit Dining Hall modal
    public bool $showHallModal = false;
 
    public ?int $editingHallId = null;
 
    public string $newHallName = '';
 
    // Lets a link from the Reservations page (?table=5) jump straight to a table.
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
 
        if ($this->prefillTableId && DiningTable::whereKey($this->prefillTableId)->exists()) {
            $this->selectedTable = $this->prefillTableId;
            $this->view = 'Floor Plan';
        }
    }
 
    public function setView(string $view): void
    {
        $this->view = $view;
        $this->selectedTable = null;
    }
 
    public function selectTable(int $id): void
    {
        // Dragging owns clicks while the layout is being edited.
        if ($this->editingLayout) {
            return;
        }
 
        $this->selectedTable = $this->selectedTable === $id ? null : $id;
        $this->view = 'Floor Plan';
    }
 
    public function clearSelection(): void
    {
        $this->selectedTable = null;
    }
 
    public function toggleEditLayout(): void
    {
        $this->editingLayout = ! $this->editingLayout;
        $this->selectedTable = null;
    }
 
    // --- Dining Halls ------------------------------------------------------
 
    public function updatedCurrentHallId(): void
    {
        session(['servora_current_hall_id' => $this->currentHallId]);
        $this->selectedTable = null;
        $this->editingLayout = false;
        $this->view = 'Floor Plan';
    }
 
    public function openAddHallModal(): void
    {
        $this->editingHallId = null;
        $this->newHallName = '';
        $this->resetErrorBag();
        $this->showHallModal = true;
    }
 
    public function openEditHallModal(int $id): void
    {
        $hall = DiningHall::find($id);
 
        if (! $hall) {
            return;
        }
 
        $this->editingHallId = $hall->id;
        $this->newHallName = $hall->name;
        $this->resetErrorBag();
        $this->showHallModal = true;
    }
 
    public function closeHallModal(): void
    {
        $this->showHallModal = false;
        $this->editingHallId = null;
    }
 
    public function saveHall(): void
    {
        $validated = $this->validate([
            'newHallName' => ['required', 'string', 'max:50'],
        ]);
 
        if ($this->editingHallId) {
            DiningHall::whereKey($this->editingHallId)->update([
                'name' => $validated['newHallName'],
            ]);
        } else {
            $hall = DiningHall::create([
                'name' => $validated['newHallName'],
            ]);
 
            $this->currentHallId = $hall->id;
            $this->updatedCurrentHallId();
        }
 
        $this->showHallModal = false;
        $this->editingHallId = null;
    }
 
    public function deleteHall(int $id): void
    {
        // Always keep at least one hall to manage.
        if (DiningHall::count() <= 1) {
            return;
        }
 
        DiningHall::whereKey($id)->delete();
 
        if ($this->currentHallId === $id) {
            $this->currentHallId = DiningHall::query()->oldest('id')->value('id');
            $this->updatedCurrentHallId();
        }
 
        $this->showHallModal = false;
        $this->editingHallId = null;
    }
 
    // --- Add / Edit Table -----------------------------------------------
 
    public function openAddTableModal(): void
    {
        $this->editingTableId = null;
        $this->resetAddTableForm();
        $this->showAddTableModal = true;
    }
 
    public function openEditTableModal(int $id): void
    {
        $table = DiningTable::find($id);
 
        if (! $table) {
            return;
        }
 
        $this->editingTableId = $table->id;
        $this->newTableName = $table->name;
        $this->newTableSeats = $table->seats;
        $this->newTableSectionId = $table->table_section_id;
        $this->newTableFeatured = $table->is_featured;
        $this->newTableShape = $table->shape->value;
        $this->resetErrorBag();
        $this->showAddTableModal = true;
    }
 
    public function closeAddTableModal(): void
    {
        $this->showAddTableModal = false;
        $this->editingTableId = null;
        $this->resetAddTableForm();
    }
 
    protected function resetAddTableForm(): void
    {
        $this->reset(['newTableName', 'newTableSeats', 'newTableSectionId', 'newTableFeatured']);
        $this->newTableShape = TableShape::Rectangle->value;
        $this->newTableSeats = 2;
        $this->resetErrorBag();
    }
 
    public function saveTable(): void
    {
        $validated = $this->validate([
            'newTableName' => ['required', 'string', 'max:50'],
            'newTableSeats' => ['required', 'integer', 'min:1', 'max:20'],
            'newTableSectionId' => ['nullable', 'exists:table_sections,id'],
            'newTableShape' => ['required', 'in:rectangle,round'],
        ]);
 
        if ($this->editingTableId) {
            DiningTable::whereKey($this->editingTableId)->update([
                'table_section_id' => $validated['newTableSectionId'],
                'name' => $validated['newTableName'],
                'seats' => $validated['newTableSeats'],
                'shape' => $validated['newTableShape'],
                'is_featured' => $this->newTableFeatured,
            ]);
        } else {
            // Stagger new tables across the canvas in a simple grid so they don't
            // all land in the same spot (drag + overlap handling takes it from there).
            $count = DiningTable::where('dining_hall_id', $this->currentHallId)->count();
            $column = $count % 6;
            $row = intdiv($count, 6);
 
            DiningTable::create([
                'dining_hall_id' => $this->currentHallId,
                'table_section_id' => $validated['newTableSectionId'],
                'name' => $validated['newTableName'],
                'seats' => $validated['newTableSeats'],
                'status' => TableStatus::Available->value,
                'shape' => $validated['newTableShape'],
                'pos_x' => 60 + ($column * 150),
                'pos_y' => 40 + ($row * 120),
                'width' => 112,
                'height' => 80,
                'is_featured' => $this->newTableFeatured,
            ]);
        }
 
        $this->showAddTableModal = false;
        $this->editingTableId = null;
        $this->resetAddTableForm();
    }
 
    public function deleteTable(int $id): void
    {
        DiningTable::whereKey($id)->delete();
 
        if ($this->selectedTable === $id) {
            $this->selectedTable = null;
        }
    }
 
    public function duplicateTable(int $id): void
    {
        $table = DiningTable::find($id);
 
        if (! $table) {
            return;
        }
 
        $copy = DiningTable::create([
            'dining_hall_id' => $table->dining_hall_id,
            'table_section_id' => $table->table_section_id,
            'name' => $table->name.' Copy',
            'seats' => $table->seats,
            'status' => TableStatus::Available->value,
            'shape' => $table->shape->value,
            'rotation' => $table->rotation,
            'pos_x' => $table->pos_x + 24,
            'pos_y' => $table->pos_y + 24,
            'width' => $table->width,
            'height' => $table->height,
            'is_featured' => false,
        ]);
 
        $this->selectedTable = $copy->id;
        $this->view = 'Floor Plan';
    }
 
    public function cycleTableStatus(int $id): void
    {
        $table = DiningTable::find($id);
 
        if (! $table) {
            return;
        }
 
        $order = [TableStatus::Available, TableStatus::Reserved, TableStatus::Occupied];
        $currentIndex = array_search($table->status, $order, true);
        $next = $order[($currentIndex + 1) % count($order)];
 
        $table->update(['status' => $next->value]);
    }
 
    /**
     * Persist a table's new position on the floor-plan canvas.
     * Called from Alpine via $wire.updateTablePosition(id, x, y) on drag end.
     */
    public function updateTablePosition(int $id, int $x, int $y): void
    {
        $table = DiningTable::find($id);
 
        if (! $table) {
            return;
        }
 
        $table->update([
            'pos_x' => max(0, $x),
            'pos_y' => max(0, $y),
        ]);
    }
 
    /**
     * Persist a table's new size. Called from Alpine on resize-handle release.
     */
    public function updateTableSize(int $id, int $width, int $height): void
    {
        $table = DiningTable::find($id);
 
        if (! $table) {
            return;
        }
 
        $table->update([
            'width' => max(48, $width),
            'height' => max(32, $height),
        ]);
    }
 
    /**
     * Persist a table's new rotation. Called from Alpine on rotate-handle release.
     */
    public function updateTableRotation(int $id, int $degrees): void
    {
        $table = DiningTable::find($id);
 
        if (! $table) {
            return;
        }
 
        $table->update([
            'rotation' => (($degrees % 360) + 360) % 360,
        ]);
    }
 
    // --- Add Element (barriers + labels) ---------------------------------
 
    public function updatedNewElementType(string $value): void
    {
        if ($value === FloorElementType::Label->value) {
            $this->newElementWidth = 120;
            $this->newElementHeight = 32;
        } else {
            $this->newElementPreset = FloorElementPreset::Wall->value;
            $this->newElementWidth = FloorElementPreset::Wall->defaultWidth();
            $this->newElementHeight = FloorElementPreset::Wall->defaultHeight();
        }
    }
 
    public function updatedNewElementPreset(string $value): void
    {
        $preset = FloorElementPreset::from($value);
        $this->newElementWidth = $preset->defaultWidth();
        $this->newElementHeight = $preset->defaultHeight();
    }
 
    public function openAddElementModal(): void
    {
        $this->resetAddElementForm();
        $this->showAddElementModal = true;
    }
 
    public function closeAddElementModal(): void
    {
        $this->showAddElementModal = false;
        $this->resetAddElementForm();
    }
 
    protected function resetAddElementForm(): void
    {
        $this->reset(['newElementName']);
        $this->newElementType = FloorElementType::Barrier->value;
        $this->newElementPreset = FloorElementPreset::Wall->value;
        $this->newElementWidth = FloorElementPreset::Wall->defaultWidth();
        $this->newElementHeight = FloorElementPreset::Wall->defaultHeight();
        $this->resetErrorBag();
    }
 
    public function createElement(): void
    {
        $validated = $this->validate([
            'newElementName' => ['required', 'string', 'max:50'],
            'newElementWidth' => ['required', 'integer', 'min:24', 'max:800'],
            'newElementHeight' => ['required', 'integer', 'min:24', 'max:800'],
        ]);
 
        $count = FloorElement::where('dining_hall_id', $this->currentHallId)->count();
        $column = $count % 6;
        $row = intdiv($count, 6);
 
        $isBarrier = $this->newElementType === FloorElementType::Barrier->value;
 
        FloorElement::create([
            'dining_hall_id' => $this->currentHallId,
            'type' => $this->newElementType,
            'preset' => $isBarrier ? $this->newElementPreset : FloorElementPreset::Custom->value,
            'name' => $validated['newElementName'],
            'shape' => TableShape::Rectangle->value,
            'pos_x' => 60 + ($column * 150),
            'pos_y' => 560 - ($row * 120),
            'width' => $validated['newElementWidth'],
            'height' => $validated['newElementHeight'],
        ]);
 
        $this->showAddElementModal = false;
        $this->resetAddElementForm();
    }
 
    public function deleteElement(int $id): void
    {
        FloorElement::whereKey($id)->delete();
    }
 
    public function updateElementPosition(int $id, int $x, int $y): void
    {
        $element = FloorElement::find($id);
 
        if (! $element) {
            return;
        }
 
        $element->update([
            'pos_x' => max(0, $x),
            'pos_y' => max(0, $y),
        ]);
    }
 
    public function updateElementSize(int $id, int $width, int $height): void
    {
        $element = FloorElement::find($id);
 
        if (! $element) {
            return;
        }
 
        $element->update([
            'width' => max(24, $width),
            'height' => max(24, $height),
        ]);
    }
 
    public function updateElementRotation(int $id, int $degrees): void
    {
        $element = FloorElement::find($id);
 
        if (! $element) {
            return;
        }
 
        $element->update([
            'rotation' => (($degrees % 360) + 360) % 360,
        ]);
    }
 
    // --- Add / Edit Section ------------------------------------------------
 
    public function openAddSectionModal(): void
    {
        $this->editingSectionId = null;
        $this->newSectionName = '';
        $this->newSectionColor = $this->sectionColorPalette[0];
        $this->resetErrorBag();
        $this->showSectionModal = true;
    }
 
    public function openEditSectionModal(int $id): void
    {
        $section = TableSection::find($id);
 
        if (! $section) {
            return;
        }
 
        $this->editingSectionId = $section->id;
        $this->newSectionName = $section->name;
        $this->newSectionColor = $section->color;
        $this->resetErrorBag();
        $this->showSectionModal = true;
    }
 
    public function closeSectionModal(): void
    {
        $this->showSectionModal = false;
        $this->editingSectionId = null;
    }
 
    public function saveSection(): void
    {
        $validated = $this->validate([
            'newSectionName' => ['required', 'string', 'max:50'],
            'newSectionColor' => ['required', 'string', 'max:9'],
        ]);
 
        if ($this->editingSectionId) {
            TableSection::whereKey($this->editingSectionId)->update([
                'name' => $validated['newSectionName'],
                'color' => $validated['newSectionColor'],
            ]);
        } else {
            TableSection::create([
                'dining_hall_id' => $this->currentHallId,
                'name' => $validated['newSectionName'],
                'color' => $validated['newSectionColor'],
                'sort_order' => TableSection::where('dining_hall_id', $this->currentHallId)->count(),
            ]);
        }
 
        $this->showSectionModal = false;
        $this->editingSectionId = null;
    }
 
    public function deleteSection(int $id): void
    {
        // dining_tables.table_section_id is nullOnDelete, so affected tables
        // simply become unassigned rather than being deleted themselves.
        TableSection::whereKey($id)->delete();
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
    public function sections()
    {
        return TableSection::where('dining_hall_id', $this->currentHallId)
            ->ordered()
            ->withCount('tables')
            ->get();
    }
 
    #[Computed]
    public function tables()
    {
        return DiningTable::where('dining_hall_id', $this->currentHallId)
            ->with('section')
            ->orderBy('name')
            ->get();
    }
 
    #[Computed]
    public function filteredTables()
    {
        $query = DiningTable::where('dining_hall_id', $this->currentHallId)
            ->with('section')
            ->orderBy('name');
 
        if ($this->tableSearch !== '') {
            $query->where('name', 'like', '%'.$this->tableSearch.'%');
        }
 
        if ($this->tableSectionFilter === 'none') {
            $query->whereNull('table_section_id');
        } elseif ($this->tableSectionFilter !== '') {
            $query->where('table_section_id', (int) $this->tableSectionFilter);
        }
 
        return $query->get();
    }
 
    #[Computed]
    public function elements()
    {
        return FloorElement::where('dining_hall_id', $this->currentHallId)
            ->orderBy('id')
            ->get();
    }
 
    #[Computed]
    public function selectedTableModel(): ?DiningTable
    {
        return $this->selectedTable
            ? DiningTable::with('section')->find($this->selectedTable)
            : null;
    }
 
    #[Computed]
    public function stats(): array
    {
        $tables = $this->tables;
 
        return [
            'total' => $tables->count(),
            'available' => $tables->where('status', TableStatus::Available)->count(),
            'reserved' => $tables->where('status', TableStatus::Reserved)->count(),
            'occupied' => $tables->where('status', TableStatus::Occupied)->count(),
        ];
    }



};