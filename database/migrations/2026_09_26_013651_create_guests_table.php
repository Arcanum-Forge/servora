<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('notes')->nullable();

            $table->unsignedInteger('loyalty_points')->default(0);
            $table->date('birthday')->nullable();
            $table->json('dietary')->nullable();            // ['vegetarian', 'nut_allergy', ...]
            $table->string('seating_preference')->nullable(); // fireplace|window|quiet_corner|bar
            $table->string('dining_style')->nullable(); // quiet|celebrations|family|business|romantic|solo
            $table->foreignId('favorite_menu_item_id')->nullable()->constrained('menu_items')->nullOnDelete();
            $table->index('loyalty_points');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};