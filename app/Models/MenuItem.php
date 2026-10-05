<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    /** At or below this many servings left, an item shows as "Low stock". */
    public const LOW_SERVINGS = 15;

    protected $fillable = [
        'menu_category_id',
        'name',
        'slug',
        'description',
        'price',
        'icon',
        'is_available',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(MenuCategory::class, 'menu_category_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Dishes the POS can sell right now: switched on, and every recipe
     * ingredient has enough stock for at least one serving.
     * Dishes without a recipe are not stock-tracked and stay orderable.
     */
    public function scopeOrderable($query)
    {
        return $query->where('is_available', true)
            ->whereDoesntHave('ingredients', function ($q) {
                $q->where('menu_item_ingredient.quantity', '>', 0)
                    ->whereColumn('ingredients.stock', '<', 'menu_item_ingredient.quantity');
            });
    }

    public function favoritedBy(): HasMany
    {
        return $this->hasMany(Guest::class, 'favorite_menu_item_id');
    }

    /* ---------- Menu Studio ---------- */

    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class, 'menu_menu_item');
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'menu_item_ingredient')
            ->withPivot('quantity');
    }

    public function modifierGroups(): BelongsToMany
    {
        return $this->belongsToMany(ModifierGroup::class, 'menu_item_modifier_group');
    }

    /**
     * [servings, Ingredient] for the scarcest ingredient, or null when the
     * dish has no recipe (stock is then not tracked).
     */
    protected function scarcestIngredient(): ?array
    {
        $best = null;

        foreach ($this->ingredients as $ingredient) {
            $need = (float) $ingredient->pivot->quantity;

            if ($need <= 0) {
                continue;
            }

            $servings = (int) floor(max((float) $ingredient->stock, 0) / $need);

            if ($best === null || $servings < $best[0]) {
                $best = [$servings, $ingredient];
            }
        }

        return $best;
    }

    public function getServingsLeftAttribute(): ?int
    {
        return $this->scarcestIngredient()[0] ?? null;
    }

    /** Available | Low stock | Unavailable */
    public function getAvailabilityStatusAttribute(): string
    {
        if (!$this->is_available) {
            return 'Unavailable';
        }

        $servings = $this->servings_left;

        if ($servings === 0) {
            return 'Unavailable';
        }

        if ($servings !== null && $servings <= self::LOW_SERVINGS) {
            return 'Low stock';
        }

        return 'Available';
    }

    public function getAvailabilityReasonAttribute(): string
    {
        if (!$this->is_available) {
            return 'Turned off manually';
        }

        $scarcest = $this->scarcestIngredient();

        if ($scarcest && $scarcest[0] === 0) {
            return 'Out of ' . $scarcest[1]->name;
        }

        if ($scarcest && $scarcest[0] <= self::LOW_SERVINGS) {
            return "Low stock · about {$scarcest[0]} servings left ({$scarcest[1]->name})";
        }

        return 'Available';
    }

    public function getIsOrderableAttribute(): bool
    {
        return $this->availability_status !== 'Unavailable';
    }
}