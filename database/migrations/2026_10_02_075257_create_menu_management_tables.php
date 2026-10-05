<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Menus (Tavern, Royal Banquet, Festival...) -----------------------
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('status')->default('draft'); // draft | published
            $table->timestamps();
        });

        Schema::create('menu_menu_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained()->cascadeOnDelete();
            $table->foreignId('menu_item_id')->constrained()->cascadeOnDelete();
            $table->unique(['menu_id', 'menu_item_id']);
        });

        // Ingredients + recipe pivot ---------------------------------------
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('unit')->default('kg'); // kg, g, L, ml, pcs
            $table->decimal('stock', 10, 2)->default(0);
            $table->decimal('low_stock_threshold', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('menu_item_ingredient', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ingredient_id')->constrained()->cascadeOnDelete();
            $table->decimal('quantity', 10, 3)->default(0); // per serving, in the ingredient's unit
            $table->unique(['menu_item_id', 'ingredient_id']);
        });

        // Modifiers ----------------------------------------------------------
        Schema::create('modifier_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('single'); // single | multiple
            $table->boolean('is_required')->default(false);
            $table->timestamps();
        });

        Schema::create('modifier_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modifier_group_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->decimal('price_delta', 8, 2)->default(0);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('menu_item_modifier_group', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('modifier_group_id')->constrained()->cascadeOnDelete();
            $table->unique(['menu_item_id', 'modifier_group_id']);
        });

        // Availability schedules ---------------------------------------------
        Schema::create('availability_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained()->cascadeOnDelete();
            $table->json('days');                 // ISO weekdays: 1 = Mon ... 7 = Sun
            $table->time('starts_at');
            $table->time('ends_at');              // ends_at <= starts_at means "past midnight"
            $table->date('active_from')->nullable();
            $table->date('active_until')->nullable();
            $table->timestamps();
        });



        // Snapshot of what the guest picked. Name and price are copied so past
        // orders stay correct even if the modifier is renamed, repriced or deleted.
        Schema::create('order_item_modifiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('modifier_option_id')->nullable()->constrained('modifier_options')->nullOnDelete();
            $table->string('name');
            $table->decimal('price_delta', 8, 2)->default(0);
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('availability_schedules');
        Schema::dropIfExists('menu_item_modifier_group');
        Schema::dropIfExists('modifier_options');
        Schema::dropIfExists('modifier_groups');
        Schema::dropIfExists('menu_item_ingredient');
        Schema::dropIfExists('ingredients');
        Schema::dropIfExists('menu_menu_item');
        Schema::dropIfExists('menus');
        Schema::dropIfExists('order_item_modifiers');
    }
};