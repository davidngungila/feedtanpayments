<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessagingTemplate extends Model
{
    protected $fillable = [
        'name',
        'type',
        'category',
        'subject',
        'content',
        'variables',
        'default_values',
        'is_active',
        'is_system',
        'usage_count',
        'last_used_at',
        'created_by',
        'description',
        'tags',
    ];

    protected $casts = [
        'variables' => 'array',
        'default_values' => 'array',
        'is_active' => 'boolean',
        'is_system' => 'boolean',
        'usage_count' => 'integer',
        'last_used_at' => 'datetime',
        'tags' => 'array',
    ];

    /**
     * Get the user that created the template.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get active templates only.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get templates by type.
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('type', strtoupper($type));
    }

    /**
     * Get templates by category.
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', strtoupper($category));
    }

    /**
     * Get system templates.
     */
    public function scopeSystem($query)
    {
        return $query->where('is_system', true);
    }

    /**
     * Get user templates (non-system).
     */
    public function scopeUser($query)
    {
        return $query->where('is_system', false);
    }

    /**
     * Get templates for SMS.
     */
    public function scopeForSms($query)
    {
        return $query->where('type', 'SMS');
    }

    /**
     * Get templates for Email.
     */
    public function scopeForEmail($query)
    {
        return $query->where('type', 'EMAIL');
    }

    /**
     * Get templates for WhatsApp.
     */
    public function scopeForWhatsapp($query)
    {
        return $query->where('type', 'WHATSAPP');
    }

    /**
     * Process template with variables.
     */
    public function process(array $variables = []): array
    {
        $mergedVariables = array_merge($this->default_values ?? [], $variables);
        $processedContent = $this->content;
        $processedSubject = $this->subject;

        // Replace placeholders in content
        foreach ($mergedVariables as $key => $value) {
            $placeholder = '{{' . $key . '}}';
            $processedContent = str_replace($placeholder, $value, $processedContent);
            if ($processedSubject) {
                $processedSubject = str_replace($placeholder, $value, $processedSubject);
            }
        }

        return [
            'content' => $processedContent,
            'subject' => $processedSubject,
        ];
    }

    /**
     * Increment usage count.
     */
    public function incrementUsage(): bool
    {
        return $this->increment('usage_count') && 
               $this->update(['last_used_at' => now()]);
    }

    /**
     * Get available variables.
     */
    public function getAvailableVariables(): array
    {
        return $this->variables ?? [];
    }

    /**
     * Check if template has subject (for emails).
     */
    public function hasSubject(): bool
    {
        return !empty($this->subject);
    }

    /**
     * Get template preview (first 100 characters).
     */
    public function getPreview(): string
    {
        return substr($this->content, 0, 100) . (strlen($this->content) > 100 ? '...' : '');
    }

    /**
     * Get type badge color.
     */
    public function getTypeBadgeColor(): string
    {
        return match($this->type) {
            'SMS' => 'primary',
            'EMAIL' => 'success',
            'WHATSAPP' => 'info',
            default => 'secondary'
        };
    }

    /**
     * Get category badge color.
     */
    public function getCategoryBadgeColor(): string
    {
        return match($this->category) {
            'TRANSACTIONAL' => 'primary',
            'MARKETING' => 'warning',
            'NOTIFICATION' => 'info',
            'ALERT' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Check if template can be edited.
     */
    public function canBeEdited(): bool
    {
        return !$this->is_system;
    }

    /**
     * Check if template can be deleted.
     */
    public function canBeDeleted(): bool
    {
        return !$this->is_system;
    }
}
