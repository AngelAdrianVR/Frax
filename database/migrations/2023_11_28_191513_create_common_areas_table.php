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
        Schema::create('common_areas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedFloat('preparation_hours')->default(0);
            $table->unsignedFloat('hours_anticipation_booking')->default(0);
            $table->boolean('is_multiple_reserved')->default(false);
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->text('rules')->nullable();
            $table->text('policy')->nullable();
            $table->text('terms')->nullable();
            $table->json('features')->nullable(); //{icon, label, value}
            $table->json('schedule')->nullable(); //{0: null, 1: {open: 10:00AM, close: 8:00PM, duration: 4}}
            $table->foreignId('frax_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('common_areas');
    }
};
