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
        Schema::create('payment_intents', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_payment_intent_id')->unique(); // e.g., pi_1NXyz...
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Optional user
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete(); // Optional related order

            $table->integer('amount'); // In cents
            $table->string('currency', 10)->default('usd');
            $table->string('status')->nullable(); // e.g., requires_payment_method, succeeded
            $table->boolean('livemode')->default(false);
            $table->string('client_secret')->nullable(); // For frontend
            $table->timestamp('confirmed_at')->nullable(); // When the payment was confirmed
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_intents');
    }
};
