<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Coupon extends Model
{
    protected $fillable = [
        'stripe_coupon_id',
        'name',
        'amount_off',
        'currency',
        'percent_off',
        'duration_forever',
        'duration_in_months',
        'max_redemptions',
        'redeem_by',
        'valid',
    ];

    protected $casts = [
        'redeem_by' => 'datetime',
        'duration_forever' => 'boolean',
        'valid' => 'boolean',
    ];

    /**
     * Determine if the coupon is expired.
     */
    public function isExpired(): bool
    {
        return $this->redeem_by !== null && now()->greaterThan($this->redeem_by);
    }

    /**
     * Get the human-readable discount description.
     */
    public function getDescriptionAttribute(): string
    {
        if ($this->percent_off) {
            return "{$this->percent_off}% off";
        }

        if ($this->amount_off && $this->currency) {
            $amount = number_format($this->amount_off / 100, 2);
            return "{$amount} " . strtoupper($this->currency) . " off";
        }

        return 'Discount';
    }
}
