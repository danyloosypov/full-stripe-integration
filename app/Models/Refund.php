<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Refund extends Model
{
    protected $fillable = [
        'stripe_refund_id',
        'stripe_payment_intent_id',
        'order_id',
        'amount',
        'currency',
        'status',
        'charge',
        'reason',
        'refunded_at',
    ];

    protected $casts = [
        'amount' => 'integer',
        'refunded_at' => 'datetime',
    ];

    /**
     * Get the order associated with the refund.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get formatted refunded amount (e.g., $12.34).
     */
    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount / 100, 2) . ' ' . strtoupper($this->currency);
    }

    /**
     * Check if the refund succeeded.
     */
    public function isSucceeded(): bool
    {
        return $this->status === 'succeeded';
    }
}
