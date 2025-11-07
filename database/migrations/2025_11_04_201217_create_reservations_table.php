<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->nullable();
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->string('person_name');
            $table->string('person_phone_number');
            $table->longText('notes')->nullable();
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->date('confirmation_date')->nullable();
            $table->date('cancellation_date')->nullable();
            $table->integer('total_guests')->default(1);
            $table->decimal('total_price', 10, 2)->nullable();
            $table->integer('number_of_nights')->nullable();
            $table->enum('payment_method', ['cash', 'transfer', 'card'])->default('cash');
            $table->enum('status', ['pending', 'cancelled', 'checked_in', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Hapus tabel jika di-rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
