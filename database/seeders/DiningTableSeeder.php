<?php

namespace Database\Seeders;

use App\Models\DiningHall;
use App\Models\DiningTable;
use App\Models\FloorElement;
use App\Models\TableSection;
use Illuminate\Database\Seeder;

class DiningTableSeeder extends Seeder
{
    public function run(): void
    {
        // Reuses the hall the dining_hall_id migration backfills onto, so a fresh
        // migrate+seed doesn't end up with two "Royal Dining Hall" rows.
        $hall = DiningHall::firstOrCreate(['name' => 'The Royal Dining Hall']);

        $mainHall = TableSection::create(['dining_hall_id' => $hall->id, 'name' => 'Main Hall', 'color' => '#5E8067', 'sort_order' => 1]);
        $fireplace = TableSection::create(['dining_hall_id' => $hall->id, 'name' => 'Fireplace', 'color' => '#9A762B', 'sort_order' => 2]);
        $royalHall = TableSection::create(['dining_hall_id' => $hall->id, 'name' => 'Royal Hall', 'color' => '#47708F', 'sort_order' => 3]);

        // pos_x / pos_y are pixel coordinates on the 960x680 floor-plan canvas.
        $tables = [
            ['name' => 'T01', 'seats' => 2, 'status' => 'available', 'table_section_id' => $mainHall->id, 'pos_x' => 60, 'pos_y' => 40, 'width' => 112, 'height' => 80],
            ['name' => 'T02', 'seats' => 2, 'status' => 'reserved', 'table_section_id' => $mainHall->id, 'pos_x' => 220, 'pos_y' => 40, 'width' => 112, 'height' => 80],
            ['name' => 'T03', 'seats' => 4, 'status' => 'available', 'table_section_id' => $mainHall->id, 'pos_x' => 60, 'pos_y' => 160, 'width' => 144, 'height' => 96, 'shape' => 'round'],
            ['name' => 'T04', 'seats' => 4, 'status' => 'occupied', 'table_section_id' => $fireplace->id, 'pos_x' => 260, 'pos_y' => 160, 'width' => 144, 'height' => 96],
            ['name' => 'Royal Table', 'seats' => 8, 'status' => 'available', 'table_section_id' => $royalHall->id, 'is_featured' => true, 'pos_x' => 380, 'pos_y' => 300, 'width' => 320, 'height' => 112, 'shape' => 'round'],
            ['name' => 'T06', 'seats' => 4, 'status' => 'available', 'table_section_id' => $mainHall->id, 'pos_x' => 60, 'pos_y' => 460, 'width' => 128, 'height' => 64],
            ['name' => 'T07', 'seats' => 4, 'status' => 'available', 'table_section_id' => $mainHall->id, 'pos_x' => 220, 'pos_y' => 460, 'width' => 128, 'height' => 64],
            ['name' => 'T08', 'seats' => 2, 'status' => 'available', 'table_section_id' => $mainHall->id, 'pos_x' => 380, 'pos_y' => 460, 'width' => 128, 'height' => 64],
            ['name' => 'T09', 'seats' => 6, 'status' => 'available', 'table_section_id' => $fireplace->id, 'pos_x' => 540, 'pos_y' => 460, 'width' => 128, 'height' => 64],
            ['name' => 'T10', 'seats' => 4, 'status' => 'available', 'table_section_id' => $fireplace->id, 'pos_x' => 700, 'pos_y' => 460, 'width' => 128, 'height' => 64],
            ['name' => 'T11', 'seats' => 2, 'status' => 'available', 'table_section_id' => $mainHall->id, 'pos_x' => 820, 'pos_y' => 460, 'width' => 100, 'height' => 64],
        ];

        foreach ($tables as $table) {
            DiningTable::create($table + ['dining_hall_id' => $hall->id]);
        }

        // A few examples so the new floor elements (and their presets) are visible immediately.
        FloorElement::create([
            'dining_hall_id' => $hall->id,
            'type' => 'barrier',
            'preset' => 'wall',
            'name' => 'Kitchen Wall',
            'pos_x' => 60,
            'pos_y' => 580,
            'width' => 300,
            'height' => 24,
        ]);

        FloorElement::create([
            'dining_hall_id' => $hall->id,
            'type' => 'barrier',
            'preset' => 'bar_counter',
            'name' => 'Bar',
            'pos_x' => 700,
            'pos_y' => 580,
            'width' => 220,
            'height' => 48,
        ]);

        FloorElement::create([
            'dining_hall_id' => $hall->id,
            'type' => 'barrier',
            'preset' => 'restroom',
            'name' => 'Restrooms',
            'pos_x' => 60,
            'pos_y' => 632,
            'width' => 72,
            'height' => 72,
        ]);

        FloorElement::create([
            'dining_hall_id' => $hall->id,
            'type' => 'label',
            'name' => 'Entrance',
            'pos_x' => 780,
            'pos_y' => 40,
            'width' => 120,
            'height' => 32,
        ]);
    }
}