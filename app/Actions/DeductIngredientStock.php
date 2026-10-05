<?php

namespace App\Actions;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DeductIngredientStock
{
    /**
     * Subtract the recipe quantities for every line of the order.
     * Call this exactly once per order, at the moment it becomes paid.
     */
    public function handle(Order $order): void
    {
        DB::transaction(function () use ($order) {
            $order->loadMissing('items.menuItem.ingredients');

            foreach ($order->items as $line) {
                foreach ($line->menuItem?->ingredients ?? [] as $ingredient) {
                    $ingredient->decrement(
                        'stock',
                        (float) $ingredient->pivot->quantity * $line->quantity
                    );
                }
            }
        });
    }
}