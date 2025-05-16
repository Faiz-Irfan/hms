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
            $table->string('invoice_id', 255)->unique();
            $table->date('payment_date')->nullable();
            $table->enum('payment_method', ['Cash', 'Transfer', 'QR']);
            $table->enum('payment_status', ['paid', 'unpaid', 'partially_paid']);
            $table->float('rental_amount',  8, 2);
            $table->string('proof')->nullable();
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
