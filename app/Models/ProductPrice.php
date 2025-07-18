<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPrice extends Model
{
    protected $fillable = [
        'stripe_price_id',
        'stripe_product_id',
        'active',
        'billing_scheme',
        'stripe_created_at',
        'currency',
        'livemode',
        'lookup_key',
        'nickname',
        'tax_behavior',
        'type',
        'unit_amount',
        'unit_amount_decimal',
        'recurring_interval',
        'recurring_interval_count',
        'recurring_trial_period_days',
        'recurring_usage_type',
        'product_id',
    ];

    protected $casts = [
        'active' => 'boolean',
        'livemode' => 'boolean',
        'stripe_created_at' => 'datetime',
    ];

    /**
     * The local product this price belongs to.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get formatted price (e.g. $10.00).
     */
    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->unit_amount / 100, 2) . ' ' . strtoupper($this->currency);
    }

    /**
     * Check if this price is recurring.
     */
    public function isRecurring(): bool
    {
        return $this->type === 'recurring';
    }
}
