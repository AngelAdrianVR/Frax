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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('visit_date');
            $table->timestamp('time')->nullable();
            $table->boolean('identification')->default(false);
            $table->timestamp('arrived_at')->nullable();
            $table->timestamp('leaved_at')->nullable();
            $table->text('notes')->nullable();
            $table->string('qr_code')->nullable();
            $table->json('vehicle_details')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
