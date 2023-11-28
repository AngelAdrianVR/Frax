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
        Schema::create('payment_tickets', function (Blueprint $table) {
            $table->id();
            $table->timestamp('acredited_at')->nullable();
            $table->boolean('is_acredited')->nullable();
            $table->string('payment_method');
            $table->foreignId('payment_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            // type calculated in resource
            // status calculated in Resource
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_tickets');
    }
};
