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
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_refund_id')->unique();           // Stripe refund ID (e.g., re_1Nxxx)
            $table->string('stripe_payment_intent_id')->nullable(); // Related Stripe PaymentIntent
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Link to local order
            $table->integer('amount');                              // Refunded amount in cents
            $table->string('currency', 10)->default('usd');
            $table->string('status')->nullable();                   // e.g., 'succeeded', 'failed'
            $table->string('charge')->nullable();
            $table->string('reason')->nullable();                   // e.g., 'requested_by_customer'
            $table->timestamp('refunded_at')->nullable();           // When the refund was issued
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
