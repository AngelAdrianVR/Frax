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
        Schema::create('common_area_user', function (Blueprint $table) {
            $table->id();
            $table->string('time', 10);
            $table->date('date');
            $table->unsignedSmallInteger('people_quantity');
            $table->string('qr_code');
            $table->json('payment_data')->nullable(); //{type, amount, status, etc}
            $table->json('cancelation_data')->nullable(); //{reason, canceled_at}
            $table->foreignId('common_area_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('common_area_user');
    }
};
