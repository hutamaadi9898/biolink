<?php

namespace App\Services;

use App\Models\Link;

class EmbedService
{
    /**
     * Create a social media embed link for a user
     */
    public static function createEmbedLink(int $userId, string $url, array $options = []): ?Link
    {
        $embedData = Link::parseEmbedData($url);
        
        if (!$embedData) {
            return null;
        }

        $title = $options['title'] ?? self::getDefaultTitle($embedData['type']);
        $description = $options['description'] ?? self::getDefaultDescription($embedData['type']);

        return Link::create([
            'user_id' => $userId,
            'type' => 'social',
            'title' => $title,
            'url' => $url,
            'link_type' => 'embed',
            'embed_type' => $embedData['type'],
            'embed_data' => $embedData,
            'show_as_embed' => true,
            'description' => $description,
            'order' => $options['order'] ?? 99,
            'is_active' => true,
        ]);
    }

    /**
     * Get default title for embed type
     */
    private static function getDefaultTitle(string $type): string
    {
        return match($type) {
            'spotify' => 'Musik Favorit Saya',
            'youtube' => 'Video Terbaru',
            'instagram' => 'Post Instagram',
            'tiktok' => 'Video TikTok',
            default => 'Media Social'
        };
    }

    /**
     * Get default description for embed type
     */
    private static function getDefaultDescription(string $type): string
    {
        return match($type) {
            'spotify' => 'Dengarkan playlist favorit saya',
            'youtube' => 'Tonton video terbaru saya',
            'instagram' => 'Lihat post terbaru di Instagram',
            'tiktok' => 'Video viral di TikTok',
            default => 'Konten media social'
        };
    }

    /**
     * Update embed data for existing link
     */
    public static function updateEmbedData(Link $link): bool
    {
        $embedData = Link::parseEmbedData($link->url);
        
        if (!$embedData) {
            return false;
        }

        $link->update([
            'embed_type' => $embedData['type'],
            'embed_data' => $embedData,
            'link_type' => 'embed',
            'show_as_embed' => true,
        ]);

        return true;
    }

    /**
     * Get supported social media platforms
     */
    public static function getSupportedPlatforms(): array
    {
        return [
            'spotify' => [
                'name' => 'Spotify',
                'pattern' => 'spotify.com/(track|album|playlist|artist)/',
                'description' => 'Share music, playlists, and artists'
            ],
            'youtube' => [
                'name' => 'YouTube',
                'pattern' => '(youtube.com/watch|youtu.be/)',
                'description' => 'Embed videos directly'
            ],
            'instagram' => [
                'name' => 'Instagram',
                'pattern' => 'instagram.com/(p|reel)/',
                'description' => 'Show posts and reels'
            ],
        ];
    }

    /**
     * Parse embed data from URL
     */
    public static function parseEmbedData(string $url): ?array
    {
        // Spotify
        if (preg_match('/spotify\.com\/(track|album|playlist|artist)\/([a-zA-Z0-9]+)/', $url, $matches)) {
            return [
                'platform' => 'spotify',
                'type' => $matches[1],
                'id' => $matches[2],
                'url' => $url
            ];
        }

        // YouTube
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return [
                'platform' => 'youtube',
                'type' => 'video',
                'id' => $matches[1],
                'url' => $url
            ];
        }

        // Instagram
        if (preg_match('/instagram\.com\/(p|reel)\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return [
                'platform' => 'instagram',
                'type' => 'post',
                'id' => $matches[2],
                'url' => $url
            ];
        }

        return null;
    }

    /**
     * Generate embed HTML
     */
    public static function generateEmbedHtml(array $embedData): string
    {
        switch ($embedData['platform']) {
            case 'spotify':
                return self::generateSpotifyEmbed($embedData);
            case 'youtube':
                return self::generateYouTubeEmbed($embedData);
            case 'instagram':
                return self::generateInstagramEmbed($embedData);
            default:
                return '';
        }
    }

    /**
     * Generate Spotify embed HTML
     */
    private static function generateSpotifyEmbed(array $embedData): string
    {
        $embedUrl = "https://open.spotify.com/embed/{$embedData['type']}/{$embedData['id']}";
        return '<iframe src="' . $embedUrl . '" width="100%" height="352" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>';
    }

    /**
     * Generate YouTube embed HTML
     */
    private static function generateYouTubeEmbed(array $embedData): string
    {
        $embedUrl = "https://www.youtube.com/embed/{$embedData['id']}";
        return '<iframe src="' . $embedUrl . '" width="100%" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    }

    /**
     * Generate Instagram embed HTML
     */
    private static function generateInstagramEmbed(array $embedData): string
    {
        $postUrl = "https://www.instagram.com/p/{$embedData['id']}/embed";
        return '<iframe src="' . $postUrl . '" width="100%" height="500" frameborder="0" scrolling="no" allowtransparency="true"></iframe>';
    }
}
