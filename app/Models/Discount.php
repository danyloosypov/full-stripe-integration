<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Discount extends Model
{
    protected $fillable = [
        'stripe_discount_id',
        'stripe_customer_id',
        'coupon_id',
        'promotion_code_id',
        'user_id',
        'checkout_session_id',
        'invoice_id',
        'invoice_item_id',
        'subscription_id',
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    /**
     * The user that owns the discount.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The coupon associated with the discount.
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * The promotion code used to apply the discount.
     */
    public function promotionCode(): BelongsTo
    {
        return $this->belongsTo(Promocode::class, 'promotion_code_id');
    }

    /**
     * The invoice associated with the discount.
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Check if the discount is currently active.
     */
    public function isActive(): bool
    {
        return is_null($this->end_at) || now()->lt($this->end_at);
    }
}
