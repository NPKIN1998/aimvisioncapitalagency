<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->decimal('initial_capital', 10, 2);
            $table->decimal('daily_income_percentage', 6, 2);
            $table->decimal('total_returns', 10, 2)->nullable();
            $table->unsignedInteger('days');
            $table->decimal('upline_bonus', 10, 2)->nullable();
            $table->unsignedInteger('daily_task')->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
