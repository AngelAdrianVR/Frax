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
        Schema::create('community_events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date');
            $table->timestamp('time')->nullable();
            $table->string('participants')->nullable();
            $table->text('description')->nullable();
            $table->string('place')->nullable();
            $table->unsignedDouble('cost')->nullable();
            $table->unsignedInteger('capacity_event')->nullable();
            $table->unsignedInteger('capacity_per_resident')->nullable();
            $table->json('rules')->nullable();
            $table->foreignId('frax_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_events');
    }
};
