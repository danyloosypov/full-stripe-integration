<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'stripe_payment_intent_id',
        'stripe_checkout_session_id',
        'amount_total',
        'currency',
        'status',
    ];

    protected $casts = [
        'amount_total' => 'integer',
    ];

    /**
     * Get the user who placed the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order's products (line items).
     */
    public function products(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    /**
     * Check if the order has been paid.
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }
}
