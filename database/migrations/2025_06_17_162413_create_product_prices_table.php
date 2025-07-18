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
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_price_id')->unique(); // e.g., price_1MoBy5LkdIwHu7ixZhnattbh
            $table->string('stripe_product_id'); // e.g., prod_NZKdYqrwEYx6iK
            $table->boolean('active')->default(true);
            $table->string('billing_scheme')->nullable(); // e.g., per_unit
            $table->timestamp('stripe_created_at')->nullable(); // UNIX timestamp from Stripe
            $table->string('currency', 10)->default('usd');
            $table->boolean('livemode')->default(false);
            $table->string('lookup_key')->nullable();
            $table->string('nickname')->nullable();
            $table->string('tax_behavior')->nullable(); // e.g., 'inclusive', 'exclusive', 'unspecified'
            $table->string('type')->nullable(); // e.g., 'recurring', 'one_time'
            $table->integer('unit_amount')->nullable(); // in cents (e.g., 1000 = $10.00)
            $table->string('unit_amount_decimal')->nullable();

            // Recurring details
            $table->string('recurring_interval')->nullable(); // e.g., month
            $table->integer('recurring_interval_count')->nullable(); // e.g., 1
            $table->integer('recurring_trial_period_days')->nullable();
            $table->string('recurring_usage_type')->nullable(); // e.g., licensed
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_prices');
    }
};
