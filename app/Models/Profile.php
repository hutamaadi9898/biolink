<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'slug',
        'display_name',
        'bio',
        'tagline',
        'avatar',
        'cover_image',
        'location',
        'social_links',
        'contact_info',
        'is_public',
        'show_qr_code',
        'view_count',
        'seo_data',
    ];

    protected $casts = [
        'social_links' => 'array',
        'contact_info' => 'array',
        'seo_data' => 'array',
        'is_public' => 'boolean',
        'show_qr_code' => 'boolean',
    ];

    /**
     * Get the user that owns the profile
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the profile URL
     */
    public function getUrlAttribute(): string
    {
        return url('/' . $this->slug);
    }

    /**
     * Get the QR code URL
     */
    public function getQrCodeUrlAttribute(): string
    {
        return route('qr.generate', ['slug' => $this->slug]);
    }

    /**
     * Increment view count
     */
    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }
}
