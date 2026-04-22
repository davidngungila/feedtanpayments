<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailMessage extends Model
{
    protected $fillable = [
        'messaging_service_id',
        'user_id',
        'message_id',
        'from_name',
        'from_email',
        'to_email',
        'to_name',
        'subject',
        'body_html',
        'body_text',
        'attachments',
        'cc',
        'bcc',
        'reply_to',
        'status_group_id',
        'status_group_name',
        'status_id',
        'status_name',
        'status_description',
        'sent_at',
        'delivered_at',
        'opened_at',
        'clicked_at',
        'failed_at',
        'bounced_at',
        'complained_at',
        'schedule_time',
        'custom_data',
        'error_message',
        'retry_count',
        'last_retry_at',
        'is_test',
        'notes',
    ];

    protected $casts = [
        'attachments' => 'array',
        'cc' => 'array',
        'bcc' => 'array',
        'reply_to' => 'array',
        'status_group_id' => 'integer',
        'status_id' => 'integer',
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'opened_at' => 'datetime',
        'clicked_at' => 'datetime',
        'failed_at' => 'datetime',
        'bounced_at' => 'datetime',
        'complained_at' => 'datetime',
        'custom_data' => 'array',
        'retry_count' => 'integer',
        'last_retry_at' => 'datetime',
        'is_test' => 'boolean',
    ];

    /**
     * Get the messaging service that owns the email message.
     */
    public function messagingService(): BelongsTo
    {
        return $this->belongsTo(MessagingService::class);
    }

    /**
     * Get the user that owns the email message.
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
     * Get opened messages.
     */
    public function scopeOpened($query)
    {
        return $query->whereNotNull('opened_at');
    }

    /**
     * Get clicked messages.
     */
    public function scopeClicked($query)
    {
        return $query->whereNotNull('clicked_at');
    }

    /**
     * Get bounced messages.
     */
    public function scopeBounced($query)
    {
        return $query->whereNotNull('bounced_at');
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
    public function scopeForRecipient($query, string $email)
    {
        return $query->where('to_email', $email);
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
     * Check if message was opened.
     */
    public function isOpened(): bool
    {
        return !is_null($this->opened_at);
    }

    /**
     * Check if message was clicked.
     */
    public function isClicked(): bool
    {
        return !is_null($this->clicked_at);
    }

    /**
     * Check if message bounced.
     */
    public function isBounced(): bool
    {
        return !is_null($this->bounced_at);
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
        if ($this->isBounced()) {
            return 'danger';
        }
        
        return match($this->status_group_name) {
            'PENDING' => 'warning',
            'DELIVERY' => $this->status_name === 'DELIVERED' ? 'success' : 'info',
            'FAILED' => 'danger',
            'REJECTED' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get engagement rate (opened/delivered).
     */
    public function getEngagementRate(): ?float
    {
        if (!$this->isDelivered() || !$this->isOpened()) {
            return null;
        }
        
        return 100.0; // If opened, engagement is 100%
    }

    /**
     * Get full recipient display.
     */
    public function getFullRecipient(): string
    {
        if ($this->to_name) {
            return "{$this->to_name} <{$this->to_email}>";
        }
        
        return $this->to_email;
    }

    /**
     * Get full sender display.
     */
    public function getFullSender(): string
    {
        if ($this->from_name) {
            return "{$this->from_name} <{$this->from_email}>";
        }
        
        return $this->from_email;
    }

    /**
     * Check if message has attachments.
     */
    public function hasAttachments(): bool
    {
        return !empty($this->attachments);
    }

    /**
     * Get attachment count.
     */
    public function getAttachmentCount(): int
    {
        return is_array($this->attachments) ? count($this->attachments) : 0;
    }
}
