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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamp('limit_date');
            $table->timestamp('paid_at')->nullable();
            $table->json('bills')->nullable();
            // $table->unsignedFloat('total')->nullable(); //calculated in PaymentResource
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('frax_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
