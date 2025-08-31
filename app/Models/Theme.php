<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'preview_image',
        'config',
        'is_premium',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'config' => 'array',
        'is_premium' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get user theme assignments
     */
    public function userThemes(): HasMany
    {
        return $this->hasMany(UserTheme::class);
    }

    /**
     * Scope for active themes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for free themes
     */
    public function scopeFree($query)
    {
        return $query->where('is_premium', false);
    }

    /**
     * Scope for premium themes
     */
    public function scopePremium($query)
    {
        return $query->where('is_premium', true);
    }

    /**
     * Check if theme is available for user
     */
    public function isAvailableForUser(User $user): bool
    {
        if (!$this->is_premium) {
            return true;
        }

        return $user->isPro();
    }
}
