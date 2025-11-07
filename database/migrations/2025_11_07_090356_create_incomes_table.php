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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->decimal('amount', 10, 2);
            $table->string('description')->nullable();
            $table->enum('type', ['income', 'expense'])->default('income');
            $table->enum('payment_method', ['cash', 'transfer', 'card'])->default('cash');
            $table->date('date');
            $table->enum('category', ['rental', 'maintenance', 'food & beverage', 'other'])->nullable()->default('rental');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
