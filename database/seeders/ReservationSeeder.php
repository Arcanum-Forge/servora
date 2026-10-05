<?php

namespace Database\Seeders;

use App\Enums\TableStatus;
use App\Models\DiningHall;
use App\Models\DiningTable;
use App\Models\Guest;
use App\Models\Reservation;
use App\Models\WaitlistEntry;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $hall = DiningHall::firstOrCreate(['name' => 'The Royal Dining Hall']);

        $tableByName = fn(string $name) => DiningTable::where('dining_hall_id', $hall->id)->where('name', $name)->first();

        $rowan = Guest::firstOrCreate(['name' => 'Rowan Hale']);
        $mira = Guest::firstOrCreate(['name' => 'Mira Solen']);
        $elira = Guest::firstOrCreate(['name' => 'Elira Vane']);
        $orin = Guest::firstOrCreate(['name' => 'Captain Orin']);

        // Arriving soon (within the 30-minute window the UI highlights).
        if ($table = $tableByName('T08')) {
            Reservation::create([
                'dining_hall_id' => $hall->id,
                'guest_id' => $rowan->id,
                'dining_table_id' => $table->id,
                'party_size' => 4,
                'reserved_for' => now()->addMinutes(20),
                'status' => 'confirmed',
                'notes' => 'Anniversary dinner',
            ]);
            $table->update(['status' => TableStatus::Reserved->value]);
        }

        // Confirmed, later today.
        if ($table = $tableByName('T03')) {
            Reservation::create([
                'dining_hall_id' => $hall->id,
                'guest_id' => $mira->id,
                'dining_table_id' => $table->id,
                'party_size' => 2,
                'reserved_for' => now()->addHours(2),
                'status' => 'confirmed',
            ]);
            $table->update(['status' => TableStatus::Reserved->value]);
        }

        if ($table = $tableByName('T09')) {
            Reservation::create([
                'dining_hall_id' => $hall->id,
                'guest_id' => $orin->id,
                'dining_table_id' => $table->id,
                'party_size' => 6,
                'reserved_for' => now()->addMinutes(45),
                'status' => 'confirmed',
            ]);
            $table->update(['status' => TableStatus::Reserved->value]);
        }

        // Already seated.
        if ($table = $tableByName('T06')) {
            Reservation::create([
                'dining_hall_id' => $hall->id,
                'guest_id' => $elira->id,
                'dining_table_id' => $table->id,
                'party_size' => 3,
                'reserved_for' => now()->subMinutes(20),
                'status' => 'seated',
                'seated_at' => now()->subMinutes(15),
            ]);
            $table->update(['status' => TableStatus::Occupied->value]);
        }

        // Waitlist.
        WaitlistEntry::create([
            'dining_hall_id' => $hall->id,
            'guest_id' => Guest::firstOrCreate(['name' => 'Sera Windmere'])->id,
            'party_size' => 2,
            'status' => 'waiting',
            'joined_at' => now()->subMinutes(18),
        ]);

        WaitlistEntry::create([
            'dining_hall_id' => $hall->id,
            'guest_id' => Guest::firstOrCreate(['name' => 'Aldric Vale'])->id,
            'party_size' => 4,
            'status' => 'waiting',
            'joined_at' => now()->subMinutes(11),
        ]);

        WaitlistEntry::create([
            'dining_hall_id' => $hall->id,
            'guest_id' => Guest::firstOrCreate(['name' => 'Lyra Moss'])->id,
            'party_size' => 2,
            'status' => 'waiting',
            'joined_at' => now()->subMinutes(5),
        ]);
    }
}