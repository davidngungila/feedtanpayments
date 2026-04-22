<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SmsMessage extends Model
{
    protected $fillable = [
        'messaging_service_id',
        'user_id',
        'message_id',
        'from',
        'to',
        'message',
        'message_type',
        'sms_count',
        'price',
        'currency',
        'status_group_id',
        'status_group_name',
        'status_id',
        'status_name',
        'status_description',
        'sent_at',
        'delivered_at',
        'read_at',
        'failed_at',
        'schedule_time',
        'custom_data',
        'error_message',
        'retry_count',
        'last_retry_at',
        'is_test',
        'notes',
    ];

    protected $casts = [
        'price' => 'decimal:4',
        'sms_count' => 'integer',
        'status_group_id' => 'integer',
        'status_id' => 'integer',
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'read_at' => 'datetime',
        'failed_at' => 'datetime',
        'custom_data' => 'array',
        'retry_count' => 'integer',
        'last_retry_at' => 'datetime',
        'is_test' => 'boolean',
    ];

    /**
     * Get the messaging service that owns the SMS message.
     */
    public function messagingService(): BelongsTo
    {
        return $this->belongsTo(MessagingService::class);
    }

    /**
     * Get the user that owns the SMS message.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get pending messages.
     */
    public function scopePending($query)
    {
        return $query->where('status_group_name', 'PENDING');
    }

    /**
     * Get delivered messages.
     */
    public function scopeDelivered($query)
    {
        return $query->where('status_group_name', 'DELIVERY')
                    ->where('status_name', 'DELIVERED');
    }

    /**
     * Get failed messages.
     */
    public function scopeFailed($query)
    {
        return $query->where('status_group_name', 'FAILED');
    }

    /**
     * Get messages by status group.
     */
    public function scopeByStatusGroup($query, string $groupName)
    {
        return $query->where('status_group_name', $groupName);
    }

    /**
     * Get messages for a specific recipient.
     */
    public function scopeForRecipient($query, string $phoneNumber)
    {
        return $query->where('to', $phoneNumber);
    }

    /**
     * Get messages sent in a date range.
     */
    public function scopeSentBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('sent_at', [$startDate, $endDate]);
    }

    /**
     * Check if message is delivered successfully.
     */
    public function isDelivered(): bool
    {
        return $this->status_group_name === 'DELIVERY' && 
               $this->status_name === 'DELIVERED';
    }

    /**
     * Check if message failed.
     */
    public function isFailed(): bool
    {
        return $this->status_group_name === 'FAILED' || 
               in_array($this->status_name, ['EXPIRED', 'UNDELIVERABLE', 'REJECTED']);
    }

    /**
     * Check if message is still pending.
     */
    public function isPending(): bool
    {
        return $this->status_group_name === 'PENDING';
    }

    /**
     * Get status badge color.
     */
    public function getStatusBadgeColor(): string
    {
        return match($this->status_group_name) {
            'PENDING' => 'warning',
            'DELIVERY' => $this->status_name === 'DELIVERED' ? 'success' : 'info',
            'FAILED' => 'danger',
            'REJECTED' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Format the recipient phone number.
     */
    public function getFormattedRecipient(): string
    {
        $phone = $this->to;
        
        // Add country code if missing
        if (strlen($phone) === 9 && str_starts_with($phone, '7')) {
            $phone = '255' . $phone;
        }
        
        return $phone;
    }

    /**
     * Get delivery time in minutes.
     */
    public function getDeliveryTimeInMinutes(): ?int
    {
        if (!$this->sent_at || !$this->delivered_at) {
            return null;
        }
        
        return $this->sent_at->diffInMinutes($this->delivered_at);
    }
}
