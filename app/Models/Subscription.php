<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'stripe_id',
        'stripe_status',
        'stripe_price',
        'quantity',
        'trial_ends_at',
        'ends_at',
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    /**
     * Get the user that owns the subscription.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(SubscriptionItem::class);
    }

    /**
     * Check if subscription is active.
     */
    public function isActive(): bool
    {
        return $this->stripe_status === 'active' &&
            (! $this->ends_at || $this->ends_at->isFuture());
    }

    /**
     * Check if the subscription is within a trial period.
     */
    public function onTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    /**
     * Check if the subscription is canceled.
     */
    public function isCanceled(): bool
    {
        return $this->stripe_status === 'canceled';
    }

    /**
     * Check if the subscription is incomplete.
     */
    public function isIncomplete(): bool
    {
        return $this->stripe_status === 'incomplete';
    }

    /**
     * Check if the subscription is in grace period (after cancellation but before ends_at).
     */
    public function onGracePeriod(): bool
    {
        return $this->ends_at && $this->ends_at->isFuture() && $this->stripe_status === 'canceled';
    }
}
