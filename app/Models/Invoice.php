<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Invoice extends Model
{
    protected $fillable = [
        'stripe_id',
        'user_id',
        'status',
        'currency',
        'amount_due',
        'amount_paid',
        'amount_remaining',
        'customer_email',
        'description',
        'invoice_pdf',
        'due_date',
        'paid_at',
        'voided_at',
        'finalized_at',
        'raw_data',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'paid_at' => 'datetime',
        'voided_at' => 'datetime',
        'finalized_at' => 'datetime',
        'raw_data' => 'array',
    ];

    /**
     * Get the user associated with the invoice.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the invoice is fully paid.
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    /**
     * Check if the invoice is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->due_date && now()->greaterThan($this->due_date) && $this->amount_remaining > 0;
    }

    /**
     * Check if the invoice is finalized.
     */
    public function isFinalized(): bool
    {
        return !is_null($this->finalized_at);
    }
}
