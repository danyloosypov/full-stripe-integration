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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_coupon_id')->unique(); // e.g., "25OFF"
            $table->string('name')->nullable();           // Optional label/name
            $table->integer('amount_off')->nullable();    // In cents (e.g., 500 = $5 off)
            $table->string('currency', 10)->nullable();   // e.g., "usd"
            $table->integer('percent_off')->nullable();   // e.g., 25 for 25%
            $table->boolean('duration_forever')->default(false);
            $table->integer('duration_in_months')->nullable(); // If not forever
            $table->integer('max_redemptions')->nullable();
            $table->timestamp('redeem_by')->nullable();   // Expiry
            $table->boolean('valid')->default(true);      // Stripe indicates if it's usable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
