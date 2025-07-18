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
        Schema::create('setup_intents', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_setup_intent_id')->unique(); // e.g. si_1Mxxx...
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Associated user
            $table->string('status')->nullable(); // requires_payment_method, succeeded, etc.
            $table->boolean('livemode')->default(false);
            $table->string('client_secret')->nullable(); // Sent to frontend
            $table->string('payment_method')->nullable(); // Attached PM ID (e.g. pm_xxx)
            $table->timestamp('setup_at')->nullable(); // When setup succeeded
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setup_intents');
    }
};
