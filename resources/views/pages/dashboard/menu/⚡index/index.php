<?php

use App\Models\AvailabilitySchedule;
use App\Models\Ingredient;
use App\Models\Menu;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\ModifierGroup;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;

new class extends Component {
    /* =====================================================================
        Page state
    ===================================================================== */

    #[Url(as: 'view')]
    public string $view = 'Menus';

    #[Url(as: 'menu')]
    public ?int $selectedMenuId = null;

    public ?int $selectedCategoryId = null;   // section filter inside a menu

    public string $search = '';
    public string $statusFilter = 'all';      // all | available | attention
    public string $categoryFilter = '';       // Items tab

    public ?string $modal = null;             // item | menu | category | ingredient | modifier | schedule
    public ?string $notice = null;

    /* ---------- Item form ---------- */
    public ?int $itemId = null;
    public string $menu_category_id = '';
    public string $name = '';
    public string $description = '';
    public string $price = '';
    public string $icon = 'tools-kitchen-2';
    public bool $is_available = true;
    public array $menuIds = [];
    public array $modifierGroupIds = [];
    public array $recipe = [];                // [['ingredient_id' => '', 'quantity' => '']]

    /* ---------- Menu form ---------- */
    public ?int $menuId = null;
    public string $menuName = '';
    public string $menuDescription = '';
    public string $menuStatus = 'draft';

    /* ---------- Category form ---------- */
    public ?int $categoryId = null;
    public string $categoryName = '';

    /* ---------- Ingredient form ---------- */
    public ?int $ingredientId = null;
    public string $ingName = '';
    public string $ingUnit = 'kg';
    public string $ingStock = '0';
    public string $ingThreshold = '0';

    /* ---------- Modifier form ---------- */
    public ?int $groupId = null;
    public string $groupName = '';
    public string $groupType = 'single';
    public bool $groupRequired = false;
    public array $options = [];               // [['name' => '', 'price' => '0']]

    /* ---------- Schedule form ---------- */
    public ?int $scheduleId = null;
    public string $scheduleMenuId = '';
    public array $scheduleDays = [];
    public string $startsAt = '11:00';
    public string $endsAt = '22:00';
    public string $activeFrom = '';
    public string $activeUntil = '';

    public function mount(): void
    {
        $this->selectedMenuId ??= Menu::orderBy('id')->value('id');
    }

    /* =====================================================================
        Navigation
    ===================================================================== */

    public function setView(string $view): void
    {
        abort_unless(in_array($view, ['Menus', 'Categories', 'Items', 'Modifiers', 'Ingredients', 'Availability']), 404);

        $this->view = $view;
        $this->search = '';
        $this->statusFilter = 'all';
        $this->categoryFilter = '';
        $this->notice = null;
    }

    public function selectMenu(int $id): void
    {
        $this->selectedMenuId = $id;
        $this->selectedCategoryId = null;
        $this->search = '';
    }

    public function selectCategory(?int $id): void
    {
        $this->selectedCategoryId = $id;
    }

    public function viewCategoryItems(int $id): void
    {
        $this->setView('Items');
        $this->categoryFilter = (string) $id;
    }

    public function closeModal(): void
    {
        $this->modal = null;
        $this->resetValidation();
    }

    /* =====================================================================
        Menus
    ===================================================================== */

    public function createMenu(): void
    {
        $this->reset(['menuId', 'menuName', 'menuDescription', 'menuStatus']);
        $this->resetValidation();
        $this->modal = 'menu';
    }

    public function editMenu(int $id): void
    {
        $menu = Menu::findOrFail($id);

        $this->menuId = $menu->id;
        $this->menuName = $menu->name;
        $this->menuDescription = (string) $menu->description;
        $this->menuStatus = $menu->status;
        $this->resetValidation();
        $this->modal = 'menu';
    }

    public function saveMenu(): void
    {
        $this->validate([
            'menuName' => 'required|string|max:80',
            'menuDescription' => 'nullable|string|max:300',
            'menuStatus' => 'required|in:draft,published',
        ]);

        $data = [
            'name' => $this->menuName,
            'description' => $this->menuDescription ?: null,
            'status' => $this->menuStatus,
        ];

        if ($this->menuId) {
            Menu::findOrFail($this->menuId)->update($data);
        } else {
            $menu = Menu::create($data + ['slug' => $this->uniqueSlug(Menu::class, $this->menuName)]);
            $this->selectedMenuId = $menu->id;
            $this->selectedCategoryId = null;
        }

        $this->closeModal();
    }

    public function togglePublish(int $id): void
    {
        $menu = Menu::findOrFail($id);
        $menu->update(['status' => $menu->status === 'published' ? 'draft' : 'published']);
    }

    public function deleteMenu(int $id): void
    {
        Menu::findOrFail($id)->delete();

        if ($this->selectedMenuId === $id) {
            $this->selectedMenuId = Menu::orderBy('id')->value('id');
            $this->selectedCategoryId = null;
        }

        $this->closeModal();
    }

    public function removeFromMenu(int $itemId): void
    {
        if ($this->selectedMenuId) {
            Menu::findOrFail($this->selectedMenuId)->items()->detach($itemId);
        }
    }

    /* =====================================================================
        Categories
    ===================================================================== */

    public function createCategory(): void
    {
        $this->reset(['categoryId', 'categoryName']);
        $this->resetValidation();
        $this->modal = 'category';
    }

    public function editCategory(int $id): void
    {
        $category = MenuCategory::findOrFail($id);

        $this->categoryId = $category->id;
        $this->categoryName = $category->name;
        $this->resetValidation();
        $this->modal = 'category';
    }

    public function saveCategory(): void
    {
        $this->validate(['categoryName' => 'required|string|max:80']);

        if ($this->categoryId) {
            MenuCategory::findOrFail($this->categoryId)->update(['name' => $this->categoryName]);
        } else {
            MenuCategory::create([
                'name' => $this->categoryName,
                'slug' => $this->uniqueSlug(MenuCategory::class, $this->categoryName),
                'sort_order' => (MenuCategory::max('sort_order') ?? 0) + 1,
            ]);
        }

        $this->closeModal();
    }

    public function deleteCategory(int $id): void
    {
        $category = MenuCategory::withCount('items')->findOrFail($id);

        if ($category->items_count > 0) {
            $this->notice = "“{$category->name}” still has {$category->items_count} items. Move or delete them first.";
            $this->closeModal();
            return;
        }

        $category->delete();
        $this->selectedCategoryId = $this->selectedCategoryId === $id ? null : $this->selectedCategoryId;
        $this->closeModal();
    }

    /* =====================================================================
        Items
    ===================================================================== */

    public function createItem(): void
    {
        $this->resetItemForm();

        $this->menu_category_id = (string) ($this->selectedCategoryId ?? $this->categories->first()?->id);
        $this->menuIds = ($this->view === 'Menus' && $this->selectedMenuId)
            ? [(string) $this->selectedMenuId]
            : [];

        $this->modal = 'item';
    }

    public function editItem(int $id): void
    {
        $item = MenuItem::with(['menus', 'modifierGroups', 'ingredients'])->findOrFail($id);

        $this->resetItemForm();

        $this->itemId = $item->id;
        $this->menu_category_id = (string) $item->menu_category_id;
        $this->name = $item->name;
        $this->description = (string) $item->description;
        $this->price = (string) $item->price;
        $this->icon = $item->icon ?: 'tools-kitchen-2';
        $this->is_available = $item->is_available;
        $this->menuIds = $item->menus->pluck('id')->map(fn($v) => (string) $v)->all();
        $this->modifierGroupIds = $item->modifierGroups->pluck('id')->map(fn($v) => (string) $v)->all();
        $this->recipe = $item->ingredients->map(fn($i) => [
            'ingredient_id' => (string) $i->id,
            'quantity' => (string) (float) $i->pivot->quantity,
        ])->all();

        $this->modal = 'item';
    }

    public function addRecipeRow(): void
    {
        $this->recipe[] = ['ingredient_id' => '', 'quantity' => ''];
    }

    public function removeRecipeRow(int $index): void
    {
        unset($this->recipe[$index]);
        $this->recipe = array_values($this->recipe);
    }

    public function saveItem(): void
    {
        $this->validate([
            'menu_category_id' => ['required', Rule::exists(MenuCategory::class, 'id')],
            'name' => 'required|string|max:120',
            'description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'icon' => 'nullable|string|max:60',
            'recipe.*.ingredient_id' => ['required', Rule::exists(Ingredient::class, 'id')],
            'recipe.*.quantity' => 'required|numeric|gt:0',
        ]);

        $item = $this->itemId ? MenuItem::findOrFail($this->itemId) : new MenuItem();

        $item->fill([
            'menu_category_id' => $this->menu_category_id,
            'name' => $this->name,
            'description' => $this->description ?: null,
            'price' => $this->price,
            'icon' => $this->icon ?: null,
            'is_available' => $this->is_available,
        ]);

        if (!$item->exists) {
            $item->slug = $this->uniqueSlug(MenuItem::class, $this->name);
            $item->sort_order = (MenuItem::where('menu_category_id', $this->menu_category_id)->max('sort_order') ?? 0) + 1;
        }

        $item->save();

        $item->menus()->sync($this->menuIds);
        $item->modifierGroups()->sync($this->modifierGroupIds);
        $item->ingredients()->sync(
            collect($this->recipe)
                ->mapWithKeys(fn($row) => [$row['ingredient_id'] => ['quantity' => $row['quantity']]])
                ->all()
        );

        $this->closeModal();
        $this->resetItemForm();
    }

    public function toggleAvailability(int $id): void
    {
        $item = MenuItem::findOrFail($id);
        $item->update(['is_available' => !$item->is_available]);
    }

    public function deleteItem(int $id): void
    {
        $item = MenuItem::withCount('orderItems')->findOrFail($id);

        if ($item->order_items_count > 0) {
            // Past orders reference this dish, so keep the history intact.
            $item->update(['is_available' => false]);
            $this->notice = "“{$item->name}” has order history, so it was turned off instead of deleted.";
        } else {
            $item->delete();
        }

        $this->closeModal();
        $this->resetItemForm();
    }

    /* =====================================================================
        Ingredients
    ===================================================================== */

    public function createIngredient(): void
    {
        $this->reset(['ingredientId', 'ingName', 'ingUnit', 'ingStock', 'ingThreshold']);
        $this->resetValidation();
        $this->modal = 'ingredient';
    }

    public function editIngredient(int $id): void
    {
        $ingredient = Ingredient::findOrFail($id);

        $this->ingredientId = $ingredient->id;
        $this->ingName = $ingredient->name;
        $this->ingUnit = $ingredient->unit;
        $this->ingStock = (string) (float) $ingredient->stock;
        $this->ingThreshold = (string) (float) $ingredient->low_stock_threshold;
        $this->resetValidation();
        $this->modal = 'ingredient';
    }

    public function saveIngredient(): void
    {
        $this->validate([
            'ingName' => ['required', 'string', 'max:80', Rule::unique(Ingredient::class, 'name')->ignore($this->ingredientId)],
            'ingUnit' => 'required|in:kg,g,L,ml,pcs',
            'ingStock' => 'required|numeric|min:0',
            'ingThreshold' => 'required|numeric|min:0',
        ]);

        $data = [
            'name' => $this->ingName,
            'unit' => $this->ingUnit,
            'stock' => $this->ingStock,
            'low_stock_threshold' => $this->ingThreshold,
        ];

        $this->ingredientId
            ? Ingredient::findOrFail($this->ingredientId)->update($data)
            : Ingredient::create($data);

        $this->closeModal();
    }

    public function deleteIngredient(int $id): void
    {
        Ingredient::findOrFail($id)->delete();
        $this->closeModal();
    }

    /* =====================================================================
        Modifier groups
    ===================================================================== */

    public function createModifierGroup(): void
    {
        $this->reset(['groupId', 'groupName', 'groupType', 'groupRequired']);
        $this->options = [['name' => '', 'price' => '0']];
        $this->resetValidation();
        $this->modal = 'modifier';
    }

    public function editModifierGroup(int $id): void
    {
        $group = ModifierGroup::with('options')->findOrFail($id);

        $this->groupId = $group->id;
        $this->groupName = $group->name;
        $this->groupType = $group->type;
        $this->groupRequired = $group->is_required;
        $this->options = $group->options->map(fn($o) => [
            'name' => $o->name,
            'price' => (string) (float) $o->price_delta,
        ])->all();
        $this->resetValidation();
        $this->modal = 'modifier';
    }

    public function addOption(): void
    {
        $this->options[] = ['name' => '', 'price' => '0'];
    }

    public function removeOption(int $index): void
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    }

    public function saveModifierGroup(): void
    {
        $this->validate([
            'groupName' => 'required|string|max:80',
            'groupType' => 'required|in:single,multiple',
            'options' => 'required|array|min:1',
            'options.*.name' => 'required|string|max:60',
            'options.*.price' => 'nullable|numeric',
        ]);

        $group = $this->groupId ? ModifierGroup::findOrFail($this->groupId) : new ModifierGroup();

        $group->fill([
            'name' => $this->groupName,
            'type' => $this->groupType,
            'is_required' => $this->groupRequired,
        ])->save();

        $group->options()->delete();

        foreach (array_values($this->options) as $i => $option) {
            $group->options()->create([
                'name' => $option['name'],
                'price_delta' => (float) ($option['price'] ?: 0),
                'sort_order' => $i,
            ]);
        }

        $this->closeModal();
    }

    public function deleteModifierGroup(int $id): void
    {
        ModifierGroup::findOrFail($id)->delete();
        $this->closeModal();
    }

    /* =====================================================================
        Availability schedules
    ===================================================================== */

    public function createSchedule(): void
    {
        $this->reset(['scheduleId', 'scheduleDays', 'startsAt', 'endsAt', 'activeFrom', 'activeUntil']);
        $this->scheduleMenuId = (string) $this->selectedMenuId;
        $this->scheduleDays = ['1', '2', '3', '4', '5', '6', '7'];
        $this->resetValidation();
        $this->modal = 'schedule';
    }

    public function editSchedule(int $id): void
    {
        $schedule = AvailabilitySchedule::findOrFail($id);

        $this->scheduleId = $schedule->id;
        $this->scheduleMenuId = (string) $schedule->menu_id;
        $this->scheduleDays = array_map('strval', $schedule->days ?? []);
        $this->startsAt = substr($schedule->starts_at, 0, 5);
        $this->endsAt = substr($schedule->ends_at, 0, 5);
        $this->activeFrom = $schedule->active_from?->format('Y-m-d') ?? '';
        $this->activeUntil = $schedule->active_until?->format('Y-m-d') ?? '';
        $this->resetValidation();
        $this->modal = 'schedule';
    }

    public function saveSchedule(): void
    {
        $this->validate([
            'scheduleMenuId' => ['required', Rule::exists(Menu::class, 'id')],
            'scheduleDays' => 'required|array|min:1',
            'scheduleDays.*' => 'integer|between:1,7',
            'startsAt' => 'required|date_format:H:i',
            'endsAt' => 'required|date_format:H:i',
            'activeFrom' => 'nullable|date',
            'activeUntil' => ['nullable', 'date', ...($this->activeFrom ? ['after_or_equal:activeFrom'] : [])],
        ]);

        $data = [
            'menu_id' => $this->scheduleMenuId,
            'days' => collect($this->scheduleDays)->map(fn($d) => (int) $d)->unique()->sort()->values()->all(),
            'starts_at' => $this->startsAt,
            'ends_at' => $this->endsAt,
            'active_from' => $this->activeFrom ?: null,
            'active_until' => $this->activeUntil ?: null,
        ];

        $this->scheduleId
            ? AvailabilitySchedule::findOrFail($this->scheduleId)->update($data)
            : AvailabilitySchedule::create($data);

        $this->closeModal();
    }

    public function deleteSchedule(int $id): void
    {
        AvailabilitySchedule::findOrFail($id)->delete();
        $this->closeModal();
    }

    /* =====================================================================
        Data for the view
    ===================================================================== */

    #[Computed]
    public function menus()
    {
        return Menu::withCount('items')->with('schedules')->orderBy('id')->get();
    }

    #[Computed]
    public function selectedMenu(): ?Menu
    {
        return $this->menus->firstWhere('id', $this->selectedMenuId);
    }

    #[Computed]
    public function liveNow()
    {
        return $this->menus->filter(fn($menu) => $menu->isLiveNow())->values();
    }

    #[Computed]
    public function categories()
    {
        return MenuCategory::withCount('items')->orderBy('sort_order')->get();
    }

    /** Categories that appear inside the selected menu, with per-menu counts. */
    #[Computed]
    public function sections()
    {
        if (!$this->selectedMenuId) {
            return collect();
        }

        $menuId = $this->selectedMenuId;

        return MenuCategory::query()
            ->whereHas('items.menus', fn($q) => $q->where('menus.id', $menuId))
            ->withCount(['items' => fn($q) => $q->whereHas('menus', fn($m) => $m->where('menus.id', $menuId))])
            ->orderBy('sort_order')
            ->get();
    }

    #[Computed]
    public function items()
    {
        $menuId = $this->selectedMenuId;

        $items = MenuItem::with(['category', 'ingredients', 'menus'])
            ->withCount('orderItems')
            ->when($this->view === 'Menus', fn($q) => $q->whereHas('menus', fn($m) => $m->where('menus.id', $menuId)))
            ->when($this->view === 'Menus' && $this->selectedCategoryId, fn($q) => $q->where('menu_category_id', $this->selectedCategoryId))
            ->when($this->view === 'Items' && $this->categoryFilter !== '', fn($q) => $q->where('menu_category_id', $this->categoryFilter))
            ->when($this->search !== '', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return match ($this->statusFilter) {
            'available' => $items->filter(fn($i) => $i->availability_status === 'Available')->values(),
            'attention' => $items->filter(fn($i) => $i->availability_status !== 'Available')->values(),
            default => $items,
        };
    }

    #[Computed]
    public function stats(): array
    {
        $items = MenuItem::with('ingredients')->get();

        return [
            'live' => $this->liveNow->count(),
            'total' => $items->count(),
            'orderable' => $items->filter(fn($i) => $i->is_orderable)->count(),
            'attention' => $items->filter(fn($i) => $i->availability_status !== 'Available')->count(),
        ];
    }

    #[Computed]
    public function attentionItems()
    {
        return MenuItem::with(['ingredients', 'category'])
            ->orderBy('name')
            ->get()
            ->filter(fn($i) => $i->availability_status !== 'Available')
            ->values();
    }

    #[Computed]
    public function modifierGroups()
    {
        return ModifierGroup::with(['options', 'items'])->orderBy('name')->get();
    }

    #[Computed]
    public function ingredients()
    {
        return Ingredient::withCount('items')->orderBy('name')->get();
    }

    #[Computed]
    public function recipeItems()
    {
        return MenuItem::whereHas('ingredients')->with('ingredients')->orderBy('name')->take(10)->get();
    }

    #[Computed]
    public function schedules()
    {
        return AvailabilitySchedule::with('menu.schedules')->orderBy('menu_id')->orderBy('starts_at')->get();
    }

    /* =====================================================================
        Helpers
    ===================================================================== */

    private function resetItemForm(): void
    {
        $this->reset([
            'itemId',
            'menu_category_id',
            'name',
            'description',
            'price',
            'icon',
            'is_available',
            'menuIds',
            'modifierGroupIds',
            'recipe',
        ]);
        $this->resetValidation();
    }

    private function uniqueSlug(string $model, string $name): string
    {
        $slug = Str::slug($name) ?: Str::lower(Str::random(6));

        return $model::where('slug', $slug)->exists()
            ? $slug . '-' . Str::lower(Str::random(4))
            : $slug;
    }
};