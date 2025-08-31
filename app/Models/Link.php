<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'url',
        'type',
        'order',
        'is_active',
        'click_count',
        'embed_type',
        'embed_data',
        'show_as_embed',
        'image',
    ];

    protected $casts = [
        'metadata' => 'array',
        'embed_data' => 'array',
        'is_active' => 'boolean',
        'show_as_embed' => 'boolean',
        'last_clicked_at' => 'datetime',
    ];

    /**
     * Get the user that owns the link
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get analytics for this link
     */
    public function analytics(): HasMany
    {
        return $this->hasMany(Analytics::class, 'link_id');
    }

    /**
     * Get analytics for this link
     */
    public function getAnalytics()
    {
        return Analytics::where('user_id', $this->user_id)
            ->where('event_type', 'link_click')
            ->where('event_data', '"' . $this->id . '"')
            ->get();
    }

    /**
     * Get analytics count for this link
     */
    public function getAnalyticsCount(): int
    {
        return Analytics::where('user_id', $this->user_id)
            ->where('event_type', 'link_click')
            ->where('event_data', '"' . $this->id . '"')
            ->count();
    }

    /**
     * Scope for ordered links
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Format URL for Indonesian platforms
     */
    public function getFormattedUrlAttribute(): string
    {
        $url = $this->url;

        // Auto-format WhatsApp numbers
        if ($this->type === 'deeplink' && str_contains($url, 'whatsapp')) {
            return $this->formatWhatsAppUrl($url);
        }

        // Auto-format Shopee links
        if ($this->type === 'deeplink' && str_contains($url, 'shopee')) {
            return $this->formatShopeeUrl($url);
        }

        // Auto-format Tokopedia links
        if ($this->type === 'deeplink' && str_contains($url, 'tokopedia')) {
            return $this->formatTokopediaUrl($url);
        }

        return $url;
    }

    /**
     * Format WhatsApp URL
     */
    private function formatWhatsAppUrl(string $url): string
    {
        // Extract phone number and convert to wa.me format
        if (preg_match('/(\+?62\d{8,13})/', $url, $matches)) {
            $phone = $matches[1];
            $phone = preg_replace('/^\+?62/', '62', $phone);
            return "https://wa.me/{$phone}";
        }
        
        return $url;
    }

    /**
     * Format Shopee URL
     */
    private function formatShopeeUrl(string $url): string
    {
        // Ensure it's a proper Shopee Indonesia link
        if (!str_contains($url, 'shopee.co.id')) {
            return str_replace(['shopee.com', 'shopee.sg'], 'shopee.co.id', $url);
        }
        
        return $url;
    }

    /**
     * Format Tokopedia URL
     */
    private function formatTokopediaUrl(string $url): string
    {
        // Ensure it's a proper Tokopedia link
        if (!str_contains($url, 'tokopedia.com')) {
            return $url;
        }
        
        return $url;
    }

    /**
     * Increment click count
     */
    public function incrementClicks(): void
    {
        $this->increment('click_count');
        $this->update(['last_clicked_at' => now()]);
    }

    /**
     * Scope for active links
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for links by type
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Parse and extract embed data from URL
     */
    public static function parseEmbedData(string $url): ?array
    {
        // Spotify
        if (preg_match('/spotify\.com\/(track|album|playlist|artist)\/([a-zA-Z0-9]+)/', $url, $matches)) {
            return [
                'type' => 'spotify',
                'embed_type' => $matches[1],
                'id' => $matches[2],
                'embed_url' => "https://open.spotify.com/embed/{$matches[1]}/{$matches[2]}"
            ];
        }

        // YouTube
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return [
                'type' => 'youtube',
                'video_id' => $matches[1],
                'embed_url' => "https://www.youtube.com/embed/{$matches[1]}"
            ];
        }

        // Instagram
        if (preg_match('/instagram\.com\/(p|reel)\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return [
                'type' => 'instagram',
                'post_type' => $matches[1],
                'id' => $matches[2],
                'embed_url' => "{$url}embed/"
            ];
        }

        return null;
    }

    /**
     * Get embed HTML
     */
    public function getEmbedHtmlAttribute(): ?string
    {
        if (!$this->show_as_embed || !$this->embed_data) {
            return null;
        }

        // Ensure embed_data is an array
        $embedData = is_array($this->embed_data) ? $this->embed_data : json_decode($this->embed_data, true);
        
        if (!$embedData || !isset($embedData['embed_url'])) {
            return null;
        }

        switch ($this->embed_type) {
            case 'spotify':
                return $this->getSpotifyEmbed($embedData);
            case 'youtube':
                return $this->getYouTubeEmbed($embedData);
            case 'instagram':
                return $this->getInstagramEmbed($embedData);
            default:
                return null;
        }
    }

    /**
     * Get Spotify embed HTML
     */
    private function getSpotifyEmbed(array $embedData): string
    {
        $embedUrl = $embedData['embed_url'];
        return "<iframe style=\"border-radius:12px\" src=\"{$embedUrl}?utm_source=generator\" width=\"100%\" height=\"352\" frameBorder=\"0\" allowfullscreen=\"\" allow=\"autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture\" loading=\"lazy\"></iframe>";
    }

    /**
     * Get YouTube embed HTML
     */
    private function getYouTubeEmbed(array $embedData): string
    {
        $embedUrl = $embedData['embed_url'];
        return "<iframe width=\"100%\" height=\"315\" src=\"{$embedUrl}\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen loading=\"lazy\"></iframe>";
    }

    /**
     * Get Instagram embed HTML
     */
    private function getInstagramEmbed(array $embedData): string
    {
        return "<iframe src=\"{$embedData['embed_url']}\" width=\"100%\" height=\"500\" frameborder=\"0\" scrolling=\"no\" allowtransparency=\"true\" loading=\"lazy\"></iframe>";
    }
}
