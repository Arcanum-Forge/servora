<?php

use App\Models\DiningHall;
use App\Models\TableSection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dining_tables', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(DiningHall::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(TableSection::class)->nullable()->constrained()->nullOnDelete();
            $table->string('name'); // e.g. "T01", "Royal Table"
            $table->unsignedTinyInteger('seats')->default(2);
            $table->string('status')->default('available'); // available | reserved | occupied
            $table->string('shape')->default('rectangle'); // rectangle | round
            $table->unsignedSmallInteger('rotation')->default(0); // degrees, 0-359
            $table->integer('pos_x')->nullable(); // optional free-form floor-plan coordinates
            $table->integer('pos_y')->nullable();
            $table->unsignedInteger('width')->default(112);
            $table->unsignedInteger('height')->default(80);
            $table->boolean('is_featured')->default(false); // e.g. the Royal Table styling
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dining_tables');
    }
};