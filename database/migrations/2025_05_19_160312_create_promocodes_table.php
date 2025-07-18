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
        Schema::create('promocodes', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_promotion_code_id')->unique(); // Stripe's ID, e.g. promo_1N...
            $table->string('code')->unique();                     // Code customers enter
            $table->foreignId('coupon_id')->constrained('coupons')->onDelete('cascade'); // Link to coupon
            $table->integer('max_redemptions')->nullable();       // Optional usage limit
            $table->integer('times_redeemed')->default(0);        // Track redemptions
            $table->boolean('active')->default(true);             // Is it currently usable?
            $table->timestamp('expires_at')->nullable();          // Optional expiration
            $table->boolean('livemode')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promocodes');
    }
};
