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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // Уникальный числовой ID
            $table->uuid('transaction_id')->unique(); // Уникальный ID для API
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3);
            $table->string('status')->default('pending'); // pending, completed, failed
            $table->json('details')->nullable();
            $table->timestamps(); // created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
