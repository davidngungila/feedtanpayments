<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'address',
        'city',
        'country',
        'status',
        'balance',
        'credit_limit',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'credit_limit' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who created the client.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the client.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get all transactions for this client.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(ClientTransaction::class);
    }

    /**
     * Get all loans for this client.
     */
    public function loans(): HasMany
    {
        return $this->hasMany(ClientLoan::class);
    }

    /**
     * Get active clients only.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get inactive clients only.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Get suspended clients only.
     */
    public function scopeSuspended($query)
    {
        return $query->where('status', 'suspended');
    }

    /**
     * Get formatted balance.
     */
    public function getFormattedBalanceAttribute()
    {
        return 'TZS ' . number_format($this->balance, 2);
    }

    /**
     * Get formatted credit limit.
     */
    public function getFormattedCreditLimitAttribute()
    {
        return 'TZS ' . number_format($this->credit_limit, 2);
    }

    /**
     * Get status badge HTML.
     */
    public function getStatusBadgeAttribute()
    {
        $badgeClasses = [
            'active' => 'bg-success',
            'inactive' => 'bg-secondary',
            'suspended' => 'bg-danger',
        ];

        $badgeClass = $badgeClasses[$this->status] ?? 'bg-secondary';
        $statusText = ucfirst($this->status);

        return "<span class='badge {$badgeClass}'>{$statusText}</span>";
    }

    /**
     * Check if client has sufficient credit.
     */
    public function hasSufficientCredit($amount)
    {
        return ($this->credit_limit - $this->balance) >= $amount;
    }

    /**
     * Get available credit.
     */
    public function getAvailableCreditAttribute()
    {
        return $this->credit_limit - $this->balance;
    }

    /**
     * Get formatted available credit.
     */
    public function getFormattedAvailableCreditAttribute()
    {
        return 'TZS ' . number_format($this->available_credit, 2);
    }
}
