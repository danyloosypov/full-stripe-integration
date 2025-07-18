<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentIntent extends Model
{
    protected $fillable = [
        'stripe_payment_intent_id',
        'user_id',
        'order_id',
        'amount',
        'currency',
        'status',
        'livemode',
        'client_secret',
        'confirmed_at',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'integer',
        'livemode' => 'boolean',
        'confirmed_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Get the user associated with this payment intent.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the related order (if any).
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Return amount formatted as currency (e.g. $9.99).
     */
    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount / 100, 2) . ' ' . strtoupper($this->currency);
    }

    /**
     * Check if the intent is confirmed.
     */
    public function isConfirmed(): bool
    {
        return !is_null($this->confirmed_at);
    }

    /**
     * Check if the payment succeeded.
     */
    public function isSucceeded(): bool
    {
        return $this->status === 'succeeded';
    }
}
