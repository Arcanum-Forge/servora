<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->nullable()->constrained()->nullOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('department')->default('Service');
            $table->string('status')->default('active'); // active, inactive, on_leave
            $table->string('avatar_color')->default('green'); // green, tan, amber, gray
            $table->date('joined_at')->nullable();
            $table->timestamps();

            $table->index(['department', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};