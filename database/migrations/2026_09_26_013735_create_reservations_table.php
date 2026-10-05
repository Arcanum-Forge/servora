<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dining_hall_id')->constrained()->cascadeOnDelete();
            $table->foreignId('guest_id')->constrained()->restrictOnDelete();
            $table->foreignId('dining_table_id')->nullable()->constrained('dining_tables')->nullOnDelete();
            $table->unsignedTinyInteger('party_size');
            $table->dateTime('reserved_for');
            $table->unsignedSmallInteger('duration_minutes')->default(90);
            $table->string('status')->default('confirmed'); // confirmed | seated | completed | cancelled | no_show
            $table->dateTime('seated_at')->nullable();
            $table->unsignedSmallInteger('points_awarded')->default(0);
            $table->string('notes')->nullable();
            $table->timestamps();

            $table->index(['dining_hall_id', 'reserved_for']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};