<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ledger_kingdoms', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('ledger_factions', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('ledger_monsters', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('slug');
            $table->string('name');
            $table->string('classification')->nullable();
            $table->string('habitat')->nullable();
            $table->string('threat')->nullable();
            $table->unsignedTinyInteger('threat_level')->default(0);
            $table->string('status')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('ledger_kingdom_id')->nullable();
            $table->timestamps();
        });

        Schema::create('ledger_threat_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('slug');
            $table->string('report_number');
            $table->string('title');
            $table->string('type');
            $table->string('level');
            $table->unsignedTinyInteger('level_severity')->default(0);
            $table->string('status')->index();
            $table->unsignedInteger('sightings')->default(0);
            $table->text('description')->nullable();
            $table->string('region_name')->nullable();
            $table->unsignedBigInteger('ledger_kingdom_id')->nullable();
            $table->timestamps();
        });

        Schema::create('ledger_threat_report_monster', function (Blueprint $table) {
            $table->unsignedBigInteger('ledger_threat_report_id');
            $table->unsignedBigInteger('ledger_monster_id');
            $table->primary(['ledger_threat_report_id', 'ledger_monster_id']);
        });

        Schema::create('ledger_sync_states', function (Blueprint $table) {
            $table->string('resource')->primary();
            $table->timestamp('last_synced_at')->nullable();
            $table->text('last_error')->nullable();
        });

        Schema::create('supply_impacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ledger_threat_report_id')->index(); // plain column: ledger data is mirrored, no FK
            $table->foreignId('ingredient_id')->constrained()->cascadeOnDelete();
            $table->string('effect')->default('limited');                   // limited | unavailable
            $table->string('note')->nullable();
            $table->boolean('is_manual')->default(false);
            $table->timestamp('dismissed_at')->nullable();
            $table->timestamps();
            $table->unique(['ledger_threat_report_id', 'ingredient_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ([
            'ledger_sync_states',
            'ledger_threat_report_monster',
            'ledger_threat_reports',
            'ledger_monsters',
            'ledger_factions',
            'ledger_kingdoms',
            'supply_impacts'
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
