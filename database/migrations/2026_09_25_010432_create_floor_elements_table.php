<?php

use App\Models\DiningHall;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('floor_elements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(DiningHall::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('type'); // barrier | label
            $table->string('preset')->default('wall');
            $table->string('name')->nullable(); // barrier caption or label text
            $table->string('shape')->default('rectangle'); // rectangle | round
            $table->unsignedSmallInteger('rotation')->default(0); // degrees, 0-359
            $table->integer('pos_x')->default(40);
            $table->integer('pos_y')->default(40);
            $table->unsignedInteger('width')->default(120);
            $table->unsignedInteger('height')->default(32);
            $table->string('color')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('floor_elements');
    }
};