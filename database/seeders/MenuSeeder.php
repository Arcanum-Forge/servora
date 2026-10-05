<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Menu;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\ModifierGroup;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        /* ---------- Categories (adjust columns to match menu_categories) ---------- */
        $categories = [];
        foreach (['Starters', 'Soups & Stews', 'Salads', 'Main Courses', 'Sides', 'Desserts', 'Beverages'] as $i => $name) {
            $categories[$name] = MenuCategory::firstOrCreate(
                ['name' => $name],
                ['slug' => Str::slug($name), 'sort_order' => $i + 1]
            );
        }

        /* ---------- Ingredients: name => [unit, stock, low threshold] ---------- */
        $ingredients = [];
        foreach ([
            'Ember-drake Ribs' => ['kg', 18, 5],
            'Venison' => ['kg', 10, 3],
            'Moonroot' => ['kg', 4, 5],
            'Fireberries' => ['kg', 7, 3],
            'Wild Mushrooms' => ['kg', 2.5, 3],
            'Mountain Carrots' => ['kg', 12, 4],
            'Hearth Potatoes' => ['kg', 24, 6],
            'Dragon Salt' => ['kg', 1.2, 0.5],
            'Royal Cream' => ['L', 3, 1],
        ] as $name => [$unit, $stock, $threshold]) {
            $ingredients[$name] = Ingredient::firstOrCreate(
                ['name' => $name],
                ['unit' => $unit, 'stock' => $stock, 'low_stock_threshold' => $threshold]
            );
        }

        /* ---------- Items: name => [category, price, icon, available, description, recipe] ---------- */
        $items = [];
        foreach ([
            'Dragonfire Roast' => [
                'Main Courses',
                18,
                'meat',
                true,
                'Ember-drake ribs, charred root vegetables, and fireberry glaze.',
                ['Ember-drake Ribs' => 0.4, 'Fireberries' => 0.05, 'Dragon Salt' => 0.005, 'Hearth Potatoes' => 0.2]
            ],
            "Hunter's Feast" => [
                'Main Courses',
                14,
                'tools-kitchen-2',
                true,
                "Roasted venison, wild mushrooms, buttered potatoes and hunter's gravy.",
                ['Venison' => 0.35, 'Wild Mushrooms' => 0.1, 'Hearth Potatoes' => 0.2]
            ],
            'Royal Venison Platter' => [
                'Main Courses',
                24,
                'meat',
                false,
                'A shareable platter of venison cuts for the table.',
                ['Venison' => 0.8, 'Dragon Salt' => 0.005]
            ],
            'Moonroot Stew' => [
                'Soups & Stews',
                9,
                'bowl-spoon',
                true,
                'Moonroot, mountain carrots, onions and slow-cooked beef.',
                ['Moonroot' => 0.3, 'Mountain Carrots' => 0.15, 'Dragon Salt' => 0.003]
            ],
            'Charred Root Vegetables' => [
                'Sides',
                6,
                'carrot',
                true,
                'Seasonal roots roasted over the hearth with herb butter.',
                ['Mountain Carrots' => 0.15, 'Hearth Potatoes' => 0.1]
            ],
            'Fireberry Tart' => [
                'Desserts',
                8,
                'cake',
                true,
                'Flaky pastry, fireberry compote and royal cream.',
                ['Fireberries' => 0.08, 'Royal Cream' => 0.05]
            ],
            'Moon Tea' => [
                'Beverages',
                4,
                'glass',
                true,
                'Silver-leaf tea served hot or chilled.',
                []
            ],
        ] as $name => [$category, $price, $icon, $available, $description, $recipe]) {
            $item = MenuItem::firstOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'menu_category_id' => $categories[$category]->id,
                    'name' => $name,
                    'description' => $description,
                    'price' => $price,
                    'icon' => $icon,
                    'is_available' => $available,
                    'sort_order' => 0,
                ]
            );

            if ($item->ingredients()->doesntExist()) {
                $item->ingredients()->sync(
                    collect($recipe)->mapWithKeys(fn($qty, $ing) => [
                        $ingredients[$ing]->id => ['quantity' => $qty],
                    ])->all()
                );
            }

            $items[$name] = $item;
        }

        /* ---------- Modifiers ---------- */
        foreach ([
            [
                'Cooking Preference',
                'single',
                true,
                [['Rare', 0], ['Medium', 0], ['Well Done', 0]],
                ['Dragonfire Roast', "Hunter's Feast"]
            ],
            [
                'Choose Your Side',
                'single',
                false,
                [['Charred Roots', 0], ['Buttered Potatoes', 0], ['Wild Rice', 1]],
                ["Hunter's Feast"]
            ],
            [
                'Extra Toppings',
                'multiple',
                false,
                [['Fireberry Glaze', 1], ['Wild Mushrooms', 2], ['Herb Butter', 1]],
                ['Dragonfire Roast', "Hunter's Feast", 'Royal Venison Platter']
            ],
            [
                'Drink Size',
                'single',
                false,
                [['Small', -1], ['Regular', 0], ['Large', 2]],
                ['Moon Tea']
            ],
        ] as [$name, $type, $required, $options, $usedBy]) {
            $group = ModifierGroup::firstOrCreate(
                ['name' => $name],
                ['type' => $type, 'is_required' => $required]
            );

            if ($group->options()->doesntExist()) {
                foreach ($options as $i => [$optionName, $delta]) {
                    $group->options()->create([
                        'name' => $optionName,
                        'price_delta' => $delta,
                        'sort_order' => $i,
                    ]);
                }
            }

            $group->items()->syncWithoutDetaching(
                collect($usedBy)->map(fn($n) => $items[$n]->id)->all()
            );
        }

        /* ---------- Menus + schedules ---------- */
        $allDays = [1, 2, 3, 4, 5, 6, 7];

        $menus = [
            [
                'Tavern Menu',
                'Everyday dining across the hall during regular service.',
                'published',
                null, // null = every item
                [[$allDays, '11:00', '22:00', null, null]]
            ],
            [
                'Royal Banquet Menu',
                'Formal dining for banquet evenings.',
                'published',
                ['Main Courses', 'Desserts', 'Beverages'],
                [[[5, 6, 7], '17:00', '23:00', null, null]]
            ],
            [
                "Adventurer's Menu",
                'Hearty expedition meals.',
                'draft',
                ['Soups & Stews', 'Sides'],
                [[$allDays, '07:00', '23:00', null, null]]
            ],
            [
                'Festival Menu',
                'Seasonal dishes for the winter festival.',
                'published',
                ['Desserts', 'Beverages'],
                [
                    [
                        $allDays,
                        '12:00',
                        '00:00',
                        Carbon::create(now()->year, 12, 20),
                        Carbon::create(now()->year + 1, 1, 5)
                    ]
                ]
            ],
        ];

        foreach ($menus as [$name, $description, $status, $onlyCategories, $schedules]) {
            $menu = Menu::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'description' => $description, 'status' => $status]
            );

            $ids = MenuItem::query()
                ->when($onlyCategories, fn($q) => $q->whereHas(
                    'category',
                    fn($c) => $c->whereIn('name', $onlyCategories)
                ))
                ->pluck('id');

            $menu->items()->syncWithoutDetaching($ids->all());

            if ($menu->schedules()->doesntExist()) {
                foreach ($schedules as [$days, $start, $end, $from, $until]) {
                    $menu->schedules()->create([
                        'days' => $days,
                        'starts_at' => $start,
                        'ends_at' => $end,
                        'active_from' => $from,
                        'active_until' => $until,
                    ]);
                }
            }
        }
    }
}