<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MessagingService extends Model
{
    protected $fillable = [
        'name',
        'type',
        'provider',
        'base_url',
        'api_version',
        'api_key',
        'bearer_token',
        'username',
        'password',
        'sender_id',
        'config',
        'is_active',
        'test_mode',
        'rate_limit_per_hour',
        'cost_per_message',
        'currency',
        'webhook_url',
        'webhook_events',
        'last_sync_at',
        'notes',
    ];

    protected $casts = [
        'config' => 'array',
        'webhook_events' => 'array',
        'is_active' => 'boolean',
        'test_mode' => 'boolean',
        'rate_limit_per_hour' => 'integer',
        'cost_per_message' => 'decimal:4',
        'last_sync_at' => 'datetime',
    ];

    /**
     * Get the SMS messages for this service.
     */
    public function smsMessages(): HasMany
    {
        return $this->hasMany(SmsMessage::class);
    }

    /**
     * Get the email messages for this service.
     */
    public function emailMessages(): HasMany
    {
        return $this->hasMany(EmailMessage::class);
    }

    /**
     * Get active services only.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get services by type.
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('type', strtoupper($type));
    }

    /**
     * Get services in test mode.
     */
    public function scopeTestMode($query)
    {
        return $query->where('test_mode', true);
    }

    /**
     * Get API headers for requests.
     */
    public function getApiHeaders(): array
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        if ($this->bearer_token) {
            $headers['Authorization'] = 'Bearer ' . $this->bearer_token;
        } elseif ($this->username && $this->password) {
            $credentials = base64_encode($this->username . ':' . $this->password);
            $headers['Authorization'] = 'Basic ' . $credentials;
        }

        return $headers;
    }

    /**
     * Get API endpoint URL.
     */
    public function getApiEndpoint(string $endpoint): string
    {
        return rtrim($this->base_url, '/') . '/api/' . $this->api_version . '/' . ltrim($endpoint, '/');
    }

    /**
     * Check if service is ready for use.
     */
    public function isReady(): bool
    {
        return $this->is_active && 
               ($this->bearer_token || ($this->username && $this->password));
    }
}
