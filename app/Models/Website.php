<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Website extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain',
        'project_name',
        'path',
        'php_version',
        'ssl_enabled',
        'database_enabled',
        'database_name',
        'database_username',
        'database_password',
        'linux_username',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'ssl_enabled' => 'boolean',
        'database_enabled' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $hidden = [
        'database_password',
    ];

    /**
     * Get the user who created the website.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who updated the website.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the domains associated with this website.
     */
    public function domains(): HasMany
    {
        return $this->hasMany(Domain::class);
    }

    /**
     * Get the databases associated with this website.
     */
    public function databases(): HasMany
    {
        return $this->hasMany(Database::class);
    }

    /**
     * Scope a query to only include active websites.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include websites with SSL enabled.
     */
    public function scopeWithSsl($query)
    {
        return $query->where('ssl_enabled', true);
    }

    /**
     * Scope a query to only include websites with database enabled.
     */
    public function scopeWithDatabase($query)
    {
        return $query->where('database_enabled', true);
    }

    /**
     * Get the full URL of the website.
     */
    public function getFullUrlAttribute(): string
    {
        $protocol = $this->ssl_enabled ? 'https' : 'http';
        return "{$protocol}://{$this->domain}";
    }

    /**
     * Get the Nginx configuration file path.
     */
    public function getNginxConfigPathAttribute(): string
    {
        return "/etc/nginx/sites-available/{$this->domain}";
    }

    /**
     * Get the SSL certificate path.
     */
    public function getSslCertPathAttribute(): string
    {
        return $this->ssl_enabled ? "/etc/letsencrypt/live/{$this->domain}/fullchain.pem" : null;
    }

    /**
     * Get the SSL key path.
     */
    public function getSslKeyPathAttribute(): string
    {
        return $this->ssl_enabled ? "/etc/letsencrypt/live/{$this->domain}/privkey.pem" : null;
    }

    /**
     * Check if the website is currently active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if SSL is properly configured.
     */
    public function hasValidSsl(): bool
    {
        return $this->ssl_enabled && $this->ssl_cert_path && file_exists($this->ssl_cert_path);
    }

    /**
     * Get the database connection details (without password).
     */
    public function getDatabaseConnectionDetails(): array
    {
        if (!$this->database_enabled) {
            return [];
        }

        return [
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => $this->database_name,
            'username' => $this->database_username,
        ];
    }

    /**
     * Get website statistics.
     */
    public function getStatistics(): array
    {
        return [
            'domain' => $this->domain,
            'project_name' => $this->project_name,
            'php_version' => $this->php_version,
            'ssl_enabled' => $this->ssl_enabled,
            'database_enabled' => $this->database_enabled,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'days_active' => $this->created_at->diffInDays(now()),
        ];
    }
}
