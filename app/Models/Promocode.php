<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Promocode extends Model
{
    protected $fillable = [
        'stripe_promotion_code_id',
        'code',
        'coupon_id',
        'max_redemptions',
        'times_redeemed',
        'active',
        'expires_at',
        'livemode',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'active' => 'boolean',
        'livemode' => 'boolean',
    ];

    /**
     * Get the coupon this promocode is associated with.
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Check if the promocode is expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at && now()->greaterThan($this->expires_at);
    }

    /**
     * Check if the promocode has reached its redemption limit.
     */
    public function isExhausted(): bool
    {
        return $this->max_redemptions !== null && $this->times_redeemed >= $this->max_redemptions;
    }

    /**
     * Check if the promocode is currently valid for use.
     */
    public function isUsable(): bool
    {
        return $this->active && ! $this->isExpired() && ! $this->isExhausted();
    }
}
