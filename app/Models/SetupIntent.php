<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SetupIntent extends Model
{
    protected $fillable = [
        'stripe_setup_intent_id',
        'user_id',
        'status',
        'livemode',
        'client_secret',
        'payment_method',
        'setup_at',
        'metadata',
    ];

    protected $casts = [
        'livemode' => 'boolean',
        'setup_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Get the user associated with the setup intent.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the setup intent was successful.
     */
    public function isSucceeded(): bool
    {
        return $this->status === 'succeeded';
    }

    /**
     * Check if the setup intent is still awaiting a payment method.
     */
    public function requiresPaymentMethod(): bool
    {
        return $this->status === 'requires_payment_method';
    }
}
