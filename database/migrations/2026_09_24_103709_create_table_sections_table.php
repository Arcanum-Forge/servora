<?php

use App\Models\DiningHall;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('table_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(DiningHall::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('color')->default('#5E8067'); // hex, drives floor-plan legend dot color
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('table_sections');
    }
};