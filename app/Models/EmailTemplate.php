<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'category',
        'subject',
        'html_content',
        'text_content',
        'variables',
        'is_active',
        'is_default',
        'usage_count',
        'last_used_at',
        'created_by'
    ];

    protected $casts = [
        'variables' => 'array',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'last_used_at' => 'datetime'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function incrementUsage()
    {
        $this->increment('usage_count');
        $this->update(['last_used_at' => now()]);
    }

    public function processTemplate(array $data = [])
    {
        $htmlContent = $this->html_content;
        $textContent = $this->text_content;
        $subject = $this->subject;

        // Replace variables in HTML content
        foreach ($data as $key => $value) {
            $htmlContent = str_replace('{' . $key . '}', $value, $htmlContent);
            if ($textContent) {
                $textContent = str_replace('{' . $key . '}', $value, $textContent);
            }
            if ($subject) {
                $subject = str_replace('{' . $key . '}', $value, $subject);
            }
        }

        return [
            'html' => $htmlContent,
            'text' => $textContent,
            'subject' => $subject
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }
}