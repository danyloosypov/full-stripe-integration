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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_id')->unique(); // e.g. 'in_1Mxxxxxxxxx'
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Customer reference
            $table->string('status'); // e.g. draft, open, paid, void, etc.
            $table->string('currency', 10)->default('usd');
            $table->integer('amount_due')->nullable(); // in cents
            $table->integer('amount_paid')->nullable(); // in cents
            $table->integer('amount_remaining')->nullable(); // in cents
            $table->string('customer_email')->nullable();
            $table->string('description')->nullable();
            $table->string('invoice_pdf')->nullable(); // URL to PDF invoice
            $table->timestamp('due_date')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('voided_at')->nullable();
            $table->timestamp('finalized_at')->nullable();
            $table->json('raw_data')->nullable(); // store entire raw Stripe invoice (optional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
