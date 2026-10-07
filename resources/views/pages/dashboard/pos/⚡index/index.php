<?php

// pos/⚡index/index.php

use Livewire\Component;
use Livewire\Attributes\Url;

use App\Actions\AddItemToOrder;
use App\Models\DiningHall;
use App\Models\DiningTable;
use App\Models\FloorElement;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\ModifierOption;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\SupplyImpact;

new class extends Component {
    /*
     * Kept in sync with the ?table= query string, so the picker,
     * deep links from the floor plan, and page refreshes all agree.
     */
    #[Url(as: 'table', except: null)]
    public ?int $diningTableId = null;

    public string $search = '';

    public string $activeCategory = 'All';

    public int $guestCount = 4;

    public string $paymentMethod = 'cash';

    /*
    |--------------------------------------------------------------------------
    | Table picker
    |--------------------------------------------------------------------------
    */

    public bool $showTablePicker = false;

    public ?int $pickerHallId = null;

    /*
    |--------------------------------------------------------------------------
    | Modifier picker (dish customization)
    |--------------------------------------------------------------------------
    */

    public ?int $pickingItemId = null;

    public int $pickQuantity = 1;

    /** Keyed by modifier group id. single: '12', multiple: ['3', '5'] */
    public array $pickSelected = [];

    public string $pickNotes = '';

    /*
    |--------------------------------------------------------------------------
    | Messages
    |--------------------------------------------------------------------------
    */

    public ?string $notice = null;

    /*
    |--------------------------------------------------------------------------
    | Restaurant charges
    |--------------------------------------------------------------------------
    |
    | 10% service charge
    | 10% tax
    |
    | These can later be moved into restaurant settings.
    |
    */

    public float $serviceChargeRate = 0.10;

    public float $taxRate = 0.10;

    public function mount(): void
    {
        $this->syncGuestCount();
    }

    public function render()
    {
        // Only dishes that are switched on AND have stock for at least one serving.
        $categories = MenuCategory::query()
            ->where('is_active', true)
            ->withCount([
                'items' => fn($query) => $query->orderable(),
            ])
            ->orderBy('sort_order')
            ->get();

        $menuItems = MenuItem::query()
            ->orderable()
            ->with(['category', 'modifierGroups'])
            ->withAvailability()      
            ->when(
                $this->activeCategory !== 'All',
                fn($query) => $query->whereHas(
                    'category',
                    fn($category) => $category->where('name', $this->activeCategory)
                )
            )
            ->when(
                filled($this->search),
                fn($query) => $query->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                })
            )
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $supplyNotices = SupplyImpact::active()
            ->with(['ingredient', 'threatReport'])
            ->get();

        $order = $this->currentOrder();

        if ($order) {
            $order->load([
                'diningTable',
                'items.menuItem.category',
                'items.modifiers',
            ]);
        }

        // Dish being customized (if the modal is open).
        $picking = $this->pickingItemId
            ? MenuItem::with(['modifierGroups.options', 'ingredients'])->find($this->pickingItemId)
            : null;

        $pickUnitPrice = $picking
            ? round(
                (float) $picking->price
                + (float) ModifierOption::whereIn('id', $this->pickedOptionIds())->sum('price_delta'),
                2
            )
            : 0;

        // Only query the floor plan while the picker is open.
        $halls = collect();
        $pickerTables = collect();
        $pickerElements = collect();

        if ($this->showTablePicker) {
            $halls = DiningHall::query()->orderBy('id')->get();

            $pickerTables = DiningTable::query()
                ->where('dining_hall_id', $this->pickerHallId)
                ->orderBy('name')
                ->get();

            $pickerElements = FloorElement::query()
                ->where('dining_hall_id', $this->pickerHallId)
                ->get();
        }

        return $this->view([
            'categories' => $categories,
            'menuItems' => $menuItems,
            'order' => $order,
            'picking' => $picking,
            'pickUnitPrice' => $pickUnitPrice,
            'halls' => $halls,
            'pickerTables' => $pickerTables,
            'pickerElements' => $pickerElements,
            'supplyNotices' => $supplyNotices,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Table selection
    |--------------------------------------------------------------------------
    */

    public function openTablePicker(): void
    {
        $this->pickerHallId = $this->hallForCurrentTable()
            ?? session('current_hall_id')
            ?? DiningHall::query()->orderBy('id')->value('id');

        $this->showTablePicker = true;
    }

    public function closeTablePicker(): void
    {
        $this->showTablePicker = false;
    }

    /**
     * Runs when the floor-table-picker does
     * wire:click="$set('diningTableId', id)".
     */
    public function updatedDiningTableId($value): void
    {
        if ($value && !DiningTable::whereKey($value)->exists()) {
            $this->diningTableId = null;

            return;
        }

        $this->showTablePicker = false;

        $this->closePicker();

        $this->syncGuestCount();
    }

    protected function hallForCurrentTable(): ?int
    {
        if (!$this->diningTableId) {
            return null;
        }

        return DiningTable::whereKey($this->diningTableId)->value('dining_hall_id');
    }

    /**
     * Pull the guest count from the table's active order,
     * or fall back to the default for a fresh table.
     */
    protected function syncGuestCount(): void
    {
        $order = $this->currentOrder();

        $this->guestCount = $order?->guest_count ?? 4;
    }

    /*
    |--------------------------------------------------------------------------
    | Order
    |--------------------------------------------------------------------------
    */

    protected function currentOrder(): ?Order
    {
        if (!$this->diningTableId) {
            return null;
        }

        return Order::query()
            ->where('dining_table_id', $this->diningTableId)
            ->whereIn('status', [
                'open',
                'sent',
                'preparing',
                'served',
            ])
            ->latest()
            ->first();
    }

    protected function getOrCreateOrder(): Order
    {
        if (!$this->diningTableId) {
            abort(404, 'No dining table selected.');
        }

        $order = $this->currentOrder();

        if ($order) {
            return $order;
        }

        return DB::transaction(function () {
            $table = DiningTable::lockForUpdate()
                ->findOrFail($this->diningTableId);

            $order = Order::create([
                'dining_table_id' => $table->id,
                'order_number' => $this->generateOrderNumber(),
                'type' => 'dine_in',
                'status' => 'open',
                'guest_count' => $this->guestCount,
                'subtotal' => 0,
                'service_charge' => 0,
                'tax' => 0,
                'discount' => 0,
                'total' => 0,
            ]);

            $table->update([
                'status' => 'occupied',
            ]);

            return $order;
        });
    }

    protected function generateOrderNumber(): string
    {
        do {
            $number = 'ORD-' . now()->format('ymd') . '-' . strtoupper(
                Str::random(5)
            );
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }

    /*
    |--------------------------------------------------------------------------
    | Menu
    |--------------------------------------------------------------------------
    */

    /**
     * Tile tap. Dishes with modifiers open the customization modal;
     * everything else is added straight away.
     */
    public function addToOrder(int $menuItemId): void
    {
        if (!$this->diningTableId) {
            return;
        }

        $menuItem = MenuItem::orderable()
            ->with('modifierGroups')
            ->find($menuItemId);

        if (!$menuItem) {
            $this->notice = 'That dish is no longer available.';

            return;
        }

        if ($menuItem->modifierGroups->isNotEmpty()) {
            $this->openPicker($menuItem);

            return;
        }

        $this->addLine($menuItem->id, 1, [], null);
    }

    /**
     * Validates (stock, modifier rules) and adds the line, then recalculates.
     * If validation fails nothing is written, not even the new order.
     */
    protected function addLine(int $menuItemId, int $quantity, array $optionIds, ?string $notes): bool
    {
        if (!MenuItem::orderable()->whereKey($menuItemId)->exists()) {
            $this->notice = 'That dish is no longer available.';
            $this->closePicker();

            return false;
        }
        try {
            DB::transaction(function () use ($menuItemId, $quantity, $optionIds, $notes) {
                $order = $this->getOrCreateOrder();

                app(AddItemToOrder::class)->handle(
                    $order,
                    MenuItem::findOrFail($menuItemId),
                    $quantity,
                    $optionIds,
                    $notes,
                );

                $this->recalculateOrder($order);
            });
        } catch (ValidationException $e) {
            $this->notice = collect($e->errors())->flatten()->first();

            return false;
        }

        $this->notice = null;

        return true;
    }

    /* ---------- Modifier picker ---------- */

    protected function openPicker(MenuItem $menuItem): void
    {
        $this->reset(['pickQuantity', 'pickSelected', 'pickNotes']);

        foreach ($menuItem->modifierGroups as $group) {
            $this->pickSelected[$group->id] = $group->type === 'multiple' ? [] : '';
        }

        $this->notice = null;
        $this->pickingItemId = $menuItem->id;
    }

    public function confirmPick(): void
    {
        if (!$this->pickingItemId) {
            return;
        }

        $added = $this->addLine(
            $this->pickingItemId,
            $this->pickQuantity,
            $this->pickedOptionIds(),
            $this->pickNotes ?: null,
        );

        if ($added) {
            $this->closePicker();
        }
    }

    public function closePicker(): void
    {
        $this->reset(['pickingItemId', 'pickQuantity', 'pickSelected', 'pickNotes']);
    }

    /** @return array<int> */
    protected function pickedOptionIds(): array
    {
        return collect($this->pickSelected)
            ->flatten()
            ->filter(fn($id) => $id !== '' && $id !== null)
            ->map(fn($id) => (int) $id)
            ->values()
            ->all();
    }

    public function dismissNotice(): void
    {
        $this->notice = null;
    }

    /* ---------- Quantities ---------- */

    public function increaseQuantity(int $orderItemId): void
    {
        $order = $this->currentOrder();

        if (!$order) {
            return;
        }

        $item = OrderItem::query()
            ->with('menuItem.ingredients')
            ->where('order_id', $order->id)
            ->findOrFail($orderItemId);

        if (!$this->canServeMore($order, $item->menuItem)) {
            $this->notice = "No more {$item->menuItem->name} available.";

            return;
        }

        $newQuantity = $item->quantity + 1;

        $item->update([
            'quantity' => $newQuantity,
            'subtotal' => $newQuantity * (float) $item->unit_price,
        ]);

        $this->recalculateOrder($order);
    }

    public function decreaseQuantity(int $orderItemId): void
    {
        $order = $this->currentOrder();

        if (!$order) {
            return;
        }

        $item = OrderItem::query()
            ->where('order_id', $order->id)
            ->findOrFail($orderItemId);

        if ($item->quantity <= 1) {
            $item->delete();
        } else {
            $newQuantity = $item->quantity - 1;

            $item->update([
                'quantity' => $newQuantity,
                'subtotal' => $newQuantity * (float) $item->unit_price,
            ]);
        }

        $this->recalculateOrder($order);
    }

    public function removeFromOrder(int $orderItemId): void
    {
        $order = $this->currentOrder();

        if (!$order) {
            return;
        }

        OrderItem::query()
            ->where('order_id', $order->id)
            ->findOrFail($orderItemId)
            ->delete();

        $this->recalculateOrder($order);
    }

    /**
     * Stock is deducted when the order is paid, so compare the servings left
     * with everything of this dish already on the order (across all its lines).
     */
    protected function canServeMore(Order $order, MenuItem $menuItem): bool
    {
        if (!MenuItem::orderable()->whereKey($menuItem->id)->exists()) {
            return false;
        }
        
        $servingsLeft = $menuItem->servings_left;

        if ($servingsLeft === null) {
            return true;
        }

        $onOrder = (int) $order->items()
            ->where('menu_item_id', $menuItem->id)
            ->sum('quantity');

        return $servingsLeft >= $onOrder + 1;
    }

    public function clearOrder(): void
    {
        $order = $this->currentOrder();

        if (!$order) {
            return;
        }

        /*
         * Only an open order can be cleared.
         * Sent/preparing/served orders should not be destroyed.
         */
        if ($order->status !== 'open') {
            return;
        }

        DB::transaction(function () use ($order) {
            $order->items()->delete();
            $order->delete();

            if ($this->diningTableId) {
                DiningTable::whereKey($this->diningTableId)
                    ->update([
                        'status' => 'available',
                    ]);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Guest count
    |--------------------------------------------------------------------------
    */

    public function increaseGuests(): void
    {
        $this->guestCount = min(99, $this->guestCount + 1);

        $this->updateOrderGuestCount();
    }

    public function decreaseGuests(): void
    {
        $this->guestCount = max(1, $this->guestCount - 1);

        $this->updateOrderGuestCount();
    }

    protected function updateOrderGuestCount(): void
    {
        $order = $this->currentOrder();

        if ($order) {
            $order->update([
                'guest_count' => $this->guestCount,
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Totals
    |--------------------------------------------------------------------------
    */

    protected function recalculateOrder(Order $order): void
    {
        $order->load('items');

        $subtotal = $order->items->sum(function ($item) {
            return (float) $item->subtotal;
        });

        $serviceCharge = round(
            $subtotal * $this->serviceChargeRate,
            2
        );

        $tax = round(
            ($subtotal + $serviceCharge) * $this->taxRate,
            2
        );

        $total = round(
            $subtotal +
            $serviceCharge +
            $tax -
            (float) $order->discount,
            2
        );

        $order->update([
            'subtotal' => $subtotal,
            'service_charge' => $serviceCharge,
            'tax' => $tax,
            'total' => max(0, $total),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Payment
    |--------------------------------------------------------------------------
    */

    public function selectPaymentMethod(string $method): void
    {
        if (!in_array($method, ['cash', 'card'], true)) {
            return;
        }

        $this->paymentMethod = $method;
    }

    public function charge(): void
    {
        $order = $this->currentOrder();

        if (!$order || $order->items()->count() === 0) {
            return;
        }

        if ($order->status !== 'open') {
            return;
        }

        DB::transaction(function () use ($order) {
            $this->recalculateOrder($order);

            app(\App\Actions\DeductIngredientStock::class)->handle($order);

            $order->refresh();

            $order->payments()->create([
                'method' => $this->paymentMethod,
                'amount' => $order->total,
                'status' => 'completed',
                'reference' => $order->order_number,
            ]);

            $order->update([
                'status' => 'paid',
            ]);

            if ($this->diningTableId) {
                DiningTable::whereKey($this->diningTableId)
                    ->update([
                        'status' => 'available',
                    ]);
            }
        });

        session()->flash(
            'success',
            "Order {$order->order_number} has been paid."
        );
    }

};