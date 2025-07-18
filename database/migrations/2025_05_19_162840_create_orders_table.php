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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to users
            $table->string('stripe_payment_intent_id')->nullable(); // Stripe PaymentIntent
            $table->string('stripe_checkout_session_id')->nullable(); // Stripe Checkout Session

            // Order details
            $table->integer('amount_total'); // in cents (e.g., 999 for $9.99)
            $table->string('currency', 10)->default('usd');
            $table->enum('status', ['pending', 'paid', 'failed', 'canceled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
