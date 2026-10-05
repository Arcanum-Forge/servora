<?php

namespace App\Actions;

use App\Models\MenuItem;
use App\Models\ModifierOption;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AddItemToOrder
{
    /** Statuses the POS still lets staff add dishes to. */
    public const EDITABLE_STATUSES = ['open', 'sent', 'preparing', 'served'];

    /**
     * Add a dish to an order, enforcing availability, stock and modifier rules
     * on the server (the UI is never trusted).
     *
     * A line with the same dish, same modifier choices and same note is merged
     * (quantity increases). Different choices create a separate line.
     *
     * unit_price already includes modifier price changes, so subtotal logic
     * that sums line subtotals keeps working. Recalculate the order totals
     * after calling this.
     *
     * @param  array<int|string>  $optionIds  chosen modifier option ids
     *
     * @throws ValidationException
     */
    public function handle(
        Order $order,
        MenuItem $item,
        int $quantity = 1,
        array $optionIds = [],
        ?string $notes = null,
    ): OrderItem {
        if (!in_array($order->status, self::EDITABLE_STATUSES, true)) {
            throw ValidationException::withMessages(['order' => 'This order is already closed.']);
        }

        if ($quantity < 1) {
            throw ValidationException::withMessages(['quantity' => 'Quantity must be at least 1.']);
        }

        $notes = filled($notes) ? trim($notes) : null;

        // Re-check against the database, not the copy the UI was holding.
        $dish = MenuItem::orderable()
            ->with(['ingredients', 'modifierGroups.options'])
            ->find($item->id);

        if (!$dish) {
            throw ValidationException::withMessages([
                'item' => "{$item->name} is no longer available.",
            ]);
        }

        // Stock is only deducted when an order is paid, so count what this order already holds.
        $alreadyOnOrder = (int) $order->items()->where('menu_item_id', $dish->id)->sum('quantity');
        $servingsLeft = $dish->servings_left;

        if ($servingsLeft !== null && $servingsLeft < $alreadyOnOrder + $quantity) {
            throw ValidationException::withMessages([
                'quantity' => "Only {$servingsLeft} servings of {$dish->name} left.",
            ]);
        }

        // Modifier rules
        $optionIds = array_values(array_unique(array_map('intval', $optionIds)));
        $options = ModifierOption::whereIn('id', $optionIds)->get();

        if ($options->count() !== count($optionIds)) {
            throw ValidationException::withMessages(['modifiers' => 'One of the chosen options no longer exists.']);
        }

        $groups = $dish->modifierGroups;

        foreach ($options as $option) {
            if (!$groups->contains('id', $option->modifier_group_id)) {
                throw ValidationException::withMessages([
                    'modifiers' => "{$option->name} isn't offered with {$dish->name}.",
                ]);
            }
        }

        foreach ($groups as $group) {
            $picked = $options->where('modifier_group_id', $group->id)->count();

            if ($group->is_required && $picked === 0) {
                throw ValidationException::withMessages(['modifiers' => "Choose an option for {$group->name}."]);
            }

            if ($group->type === 'single' && $picked > 1) {
                throw ValidationException::withMessages(['modifiers' => "Pick only one option for {$group->name}."]);
            }
        }

        $unitPrice = round((float) $dish->price + (float) $options->sum('price_delta'), 2);

        return DB::transaction(function () use ($order, $dish, $quantity, $unitPrice, $notes, $options) {
            $signature = $options->pluck('id')->map(fn($id) => (int) $id)->sort()->values()->all();

            $existing = $order->items()
                ->where('menu_item_id', $dish->id)
                ->with('modifiers')
                ->get()
                ->first(function (OrderItem $line) use ($signature, $notes) {
                    $lineSignature = $line->modifiers
                        ->pluck('modifier_option_id')
                        ->map(fn($id) => (int) $id)
                        ->sort()
                        ->values()
                        ->all();

                    return $lineSignature === $signature && (filled($line->notes) ? $line->notes : null) === $notes;
                });

            if ($existing) {
                $newQuantity = $existing->quantity + $quantity;

                $existing->update([
                    'quantity' => $newQuantity,
                    'subtotal' => round((float) $existing->unit_price * $newQuantity, 2),
                ]);

                return $existing->load('modifiers');
            }

            $line = $order->items()->create([
                'menu_item_id' => $dish->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'subtotal' => round($unitPrice * $quantity, 2),
                'notes' => $notes,
            ]);

            foreach ($options as $option) {
                $line->modifiers()->create([
                    'modifier_option_id' => $option->id,
                    'name' => $option->name,
                    'price_delta' => $option->price_delta,
                ]);
            }

            return $line->load('modifiers');
        });
    }
}