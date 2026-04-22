<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_key',
        'setting_value',
        'setting_type',
        'setting_group',
        'description',
        'is_public',
    ];

    protected $casts = [
        'setting_value' => 'string',
        'is_public' => 'boolean',
    ];

    /**
     * Get setting value by key
     */
    public static function getValue(string $key, $default = null)
    {
        $setting = static::where('setting_key', $key)->first();
        return $setting ? $setting->setting_value : $default;
    }

    /**
     * Set setting value by key
     */
    public static function setValue(string $key, $value, string $type = 'text', string $group = 'general', string $description = null, bool $isPublic = false)
    {
        return static::updateOrCreate(
            ['setting_key' => $key],
            [
                'setting_value' => $value,
                'setting_type' => $type,
                'setting_group' => $group,
                'description' => $description,
                'is_public' => $isPublic,
            ]
        );
    }

    /**
     * Get all settings by group
     */
    public static function getByGroup(string $group)
    {
        return static::where('setting_group', $group)->get();
    }
}
