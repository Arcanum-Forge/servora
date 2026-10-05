<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    protected $fillable = [
        'name',
        'unit',
        'stock',
        'low_stock_threshold',
    ];

    protected $casts = [
        'stock' => 'decimal:2',
        'low_stock_threshold' => 'decimal:2',
    ];

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(MenuItem::class, 'menu_item_ingredient')
            ->withPivot('quantity');
    }

    /** Healthy | Low stock | Out of stock */
    public function getStatusLabelAttribute(): string
    {
        $stock = (float) $this->stock;

        if ($stock <= 0) {
            return 'Out of stock';
        }

        if ($stock <= (float) $this->low_stock_threshold) {
            return 'Low stock';
        }

        return 'Healthy';
    }

    /** 0-100, for the stock bar. Full bar = 3x the low-stock threshold. */
    public function getStockPercentAttribute(): int
    {
        $stock = max((float) $this->stock, 0);
        $threshold = (float) $this->low_stock_threshold;

        if ($threshold <= 0) {
            return $stock > 0 ? 100 : 0;
        }

        return (int) min(100, round($stock / ($threshold * 3) * 100));
    }
}