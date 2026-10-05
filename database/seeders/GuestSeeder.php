<?php

namespace Database\Seeders;

use App\Enums\ReservationStatus;
use App\Models\DiningTable;
use App\Models\Guest;
use App\Models\Reservation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\MenuItem;

class GuestSeeder extends Seeder
{
    // Adjust to whichever case your "Wrapped" lane uses.
    private const FINISHED = 'Completed';
    private array $tags = [
        'Loves candlelit tables',
        'Always tips the bard',
        'Celebrates every harvest festival',
        'Arrives early, orders slowly',
        'Prefers the same server',
        'Usually brings a large party',
    ];

    public function run(): void
    {

        $menuItemIds = MenuItem::pluck('id');
        if ($menuItemIds->isEmpty()) {
            $this->command?->warn('No menu items found — seeding guests without a favorite dish.');
        }



        $names = [
            'Sir Aldric',
            'Mira Vane',
            'Elira Windmere',
            'Captain Solen',
            'Lady Wren',
            'Brannoch Ironfist',
            'Thessaly Rook',
            'Old Man Hobb',
            'Selene Ashgrove',
            'Torvin Deepdelver',
            'Isolde Marsh',
            'Pip Thistledown',
            'Gareth Coldwater',
            'Nyra Duskwhisper',
            'Bram Oakenshield',
            'Lysa Emberly',
            'Cedric Stormvale',
            'Odessa Fenn',
            'Halric Stonebrook',
            'Yara Brightwater',
            'Dorin Copperkettle',
            'Mabel Quickfoot',
            'Kestrel Hollow',
            'Rowan Elmsworth',
            'Talia Nightbloom',
            'Fenwick Alebrew',
            'Ysolde Graymantle',
            'Corwin Ashby',
            'Petra Lightfoot',
            'Gwendolyn Thorne',
            'Ulric Redmane',
            'Sable Windrider',
            'Merrin Oakes',
            'Hollis Barrow',
            'Anwen Silverbrook',
            'Dagan Frost',
            'Ilse Moonvale',
            'Rurik Steelhand',
            'Calla Wildmoor',
            'Osric Vale',
        ];

        $tableIds = DiningTable::pluck('id');
        if ($tableIds->isEmpty()) {
            $this->command?->warn('No dining tables found — seeding guests without visit history.');
        }

        foreach ($names as $i => $name) {
            $visits = $tableIds->isEmpty() ? 0 : $this->visitCount();

            $guest = Guest::create([
                'name' => $name,
                'email' => Str::slug($name, '.') . '@example.test',
                'phone' => '+62 8' . fake()->numerify('##-####-####'),
                'notes' => fake()->boolean(40) ? fake()->randomElement($this->tags) : null,
                'birthday' => fake()->boolean(70) ? fake()->dateTimeBetween('-65 years', '-19 years') : null,
                'dietary' => $this->dietary(),
                'seating_preference' => fake()->randomElement(array_keys(Guest::SEATING)),
                'dining_style' => fake()->randomElement(array_keys(Guest::STYLES)),
                'favorite_menu_item_id' => $menuItemIds->isNotEmpty() && fake()->boolean(85)
                    ? $menuItemIds->random()
                    : null,
                'loyalty_points' => $visits * fake()->numberBetween(55, 95),
                'created_at' => now()->subDays(fake()->numberBetween(1, 200)),
            ]);

            for ($v = 0; $v < $visits; $v++) {
                $table = DiningTable::find($tableIds->random());
                $seated = now()
                    ->subDays(fake()->numberBetween(0, 90))
                    ->setTime($this->hour(), fake()->randomElement([0, 15, 30, 45]));

                Reservation::create([
                    'dining_hall_id' => $table->dining_hall_id,
                    'guest_id' => $guest->id,
                    'dining_table_id' => $table->id,
                    'party_size' => fake()->numberBetween(1, 6),
                    'reserved_for' => $seated,
                    'duration_minutes' => fake()->randomElement([60, 90, 120]),
                    'status' => constant(ReservationStatus::class . '::' . self::FINISHED),
                    'seated_at' => $seated,
                    'notes' => null,
                ]);
            }

            // Guests are back-dated, so keep created_at earlier than the first visit is not enforced — fine for demo data.
        }
    }

    private function visitCount(): int
    {
        // Skewed: many guests with a few visits, a handful of regulars.
        return fake()->randomElement([0, 1, 1, 2, 2, 3, 4, 5, 7, 9, 12, 16, 20]);
    }

    private function hour(): int
    {
        // Weighted toward evening service.
        return fake()->randomElement([12, 13, 13, 18, 19, 19, 20, 20, 21, 22]);
    }

    private function dietary(): ?array
    {
        if (fake()->boolean(60)) {
            return null;
        }

        return fake()->randomElements(array_keys(Guest::DIETARY), fake()->numberBetween(1, 2));
    }
}