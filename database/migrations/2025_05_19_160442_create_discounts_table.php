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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_discount_id')->unique();   // Stripe discount ID, e.g. di_1M6...
            $table->string('stripe_customer_id')->nullable(); // Customer who got the discount
            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->onDelete('set null');
            $table->foreignId('promotion_code_id')->nullable()->constrained('promocodes')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('checkout_session_id')->nullable(); // Stripe Checkout Session
            $table->foreignId('invoice_id')->nullable()->constrained('invoices')->onDelete('set null');
            $table->string('invoice_item_id')->nullable();     // Stripe Invoice Item ID
            $table->string('subscription_id')->nullable();     // Stripe Subscription ID
            $table->timestamp('start_at')->nullable();         // When discount started
            $table->timestamp('end_at')->nullable();           // When discount ended
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
