<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTheme extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'theme_id',
        'custom_config',
        'is_active',
    ];

    protected $casts = [
        'custom_config' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the theme
     */
    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    /**
     * Get merged theme configuration
     */
    public function getMergedConfigAttribute(): array
    {
        $baseConfig = $this->theme->config ?? [];
        $customConfig = $this->custom_config ?? [];

        return array_merge($baseConfig, $customConfig);
    }
}
