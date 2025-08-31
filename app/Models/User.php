<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'bio',
        'slug',
        'role',
        'is_admin',
        'pro_expires_at',
        'provider',
        'provider_id',
        'provider_data',
        'google_id',
        'avatar',
        'google_token',
        'google_refresh_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google_token',
        'google_refresh_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'pro_expires_at' => 'datetime',
            'provider_data' => 'array',
        ];
    }

    /**
     * Check if user has pro subscription
     */
    public function isPro(): bool
    {
        return $this->role === 'pro' &&
               ($this->pro_expires_at === null || $this->pro_expires_at->isFuture());
    }

    /**
     * Get the user's profile
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Get all user links
     */
    public function links(): HasMany
    {
        return $this->hasMany(Link::class)->orderBy('order');
    }

    /**
     * Get all user portfolio items
     */
    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class)->orderBy('order');
    }

    /**
     * Get user analytics
     */
    public function analytics(): HasMany
    {
        return $this->hasMany(Analytics::class);
    }

    /**
     * Get user theme assignments
     */
    public function userThemes(): HasMany
    {
        return $this->hasMany(UserTheme::class);
    }

    /**
     * Get the active theme
     */
    public function activeTheme(): HasOne
    {
        return $this->hasOne(UserTheme::class)->where('is_active', true);
    }

    /**
     * Generate unique slug from name
     */
    public function generateSlug(): string
    {
        $baseSlug = \Str::slug($this->name);
        $slug = $baseSlug;
        $counter = 1;

        while (static::where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Check if theme is applied to user
     */
    public function hasTheme(int $themeId): bool
    {
        return $this->userThemes()->where('theme_id', $themeId)->exists();
    }

    /**
     * Check if user has any theme applied
     */
    public function hasThemeApplied(): bool
    {
        return $this->userThemes()->where('is_active', true)->exists();
    }

    /**
     * Boot the model
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->slug)) {
                $user->slug = $user->generateSlug();
            }
        });

        static::updating(function ($user) {
            if ($user->isDirty('name') && empty($user->slug)) {
                $user->slug = $user->generateSlug();
            }
        });
    }
}
