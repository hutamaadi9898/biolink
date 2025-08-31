<?php

namespace App\Http\Controllers;

use App\Models\Analytics;
use App\Models\Profile;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Jenssegers\Agent\Agent;

class ProfileController extends Controller
{
    /**
     * Display the public profile page
     */
    public function show(string $slug)
    {
        // First try to find user by slug
        $user = \App\Models\User::with([
            'links' => function ($query) {
                $query->where('is_active', true)->orderBy('order');
            },
            'portfolios' => function ($query) {
                $query->orderBy('order');
            },
            'activeTheme.theme',
            'profile',
        ])
            ->where('slug', $slug)
            ->firstOrFail();

        // Load embed HTML for links that should show as embeds
        $user->links->each(function ($link) {
            if ($link->show_as_embed && $link->embed_data) {
                try {
                    $link->embed_html = $link->getEmbedHtmlAttribute();
                } catch (\Exception $e) {
                    // If embed fails, don't crash the page
                    $link->embed_html = null;
                    $link->show_as_embed = false;
                }
            }
        });

        // Create profile if it doesn't exist
        if (! $user->profile) {
            $profile = Profile::create([
                'user_id' => $user->id,
                'slug' => $user->slug,
                'display_name' => $user->name,
                'bio' => $user->bio,
                'is_public' => true,
                'show_qr_code' => true,
                'view_count' => 0,
            ]);
            $user->load('profile');
        } else {
            $profile = $user->profile;
        }

        // Only show public profiles
        if (! $profile->is_public) {
            abort(404);
        }

        // Track profile view
        $this->trackAnalytics($user->id, 'profile_view', null, request());

        // Increment profile view count
        $profile->incrementViewCount();

        // Get theme configuration
        $themeConfig = $user->activeTheme?->merged_config ?? $this->getDefaultTheme();

        return Inertia::render('Profile/Show', [
            'profile' => $profile,
            'user' => $user,
            'links' => $user->links,
            'portfolios' => $user->portfolios,
            'theme' => $themeConfig,
            'qrCodeUrl' => $profile->qr_code_url,
        ]);
    }

    /**
     * Redirect to link and track click
     */
    public function redirectLink(Request $request, int $linkId)
    {
        $link = \App\Models\Link::with('user')->findOrFail($linkId);

        // Track link click
        $this->trackAnalytics($link->user_id, 'link_click', $linkId, $request);

        // Increment link click count
        $link->incrementClicks();

        return redirect($link->formatted_url);
    }

    /**
     * Track portfolio view
     */
    public function trackPortfolioView(Request $request, int $portfolioId)
    {
        $portfolio = \App\Models\Portfolio::with('user')->findOrFail($portfolioId);

        // Track portfolio view
        $this->trackAnalytics($portfolio->user_id, 'portfolio_view', $portfolioId, $request);

        // Increment portfolio view count
        $portfolio->incrementViews();

        return response()->json(['status' => 'tracked']);
    }

    /**
     * Generate QR Code for profile
     */
    public function generateQrCode(string $slug)
    {
        $profile = Profile::where('slug', $slug)->firstOrFail();

        if (! $profile->show_qr_code) {
            abort(404);
        }

        // Generate QR code using a QR code library
        $url = $profile->url;

        // For now, return a simple response - you can integrate with a QR code library
        return response()->json([
            'url' => $url,
            'qr_code' => 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data='.urlencode($url),
        ]);
    }

    /**
     * Track analytics event
     */
    private function trackAnalytics(int $userId, string $eventType, ?int $relatedId, Request $request): void
    {
        $agent = new Agent;

        $data = [
            'user_id' => $userId,
            'event_type' => $eventType,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referrer' => $request->header('referer'),
            'device_type' => $agent->isMobile() ? 'mobile' : ($agent->isTablet() ? 'tablet' : 'desktop'),
            'browser' => $agent->browser(),
            'os' => $agent->platform(),
        ];

        // Add link_id for link clicks, or store other related IDs in event_data
        if ($eventType === 'link_click' && $relatedId) {
            $data['link_id'] = $relatedId;
        } elseif ($relatedId) {
            $data['event_data'] = ['related_id' => $relatedId];
        }

        Analytics::trackEvent($data);
    }

    /**
     * Get default theme configuration
     */
    private function getDefaultTheme(): array
    {
        return [
            'colors' => [
                'primary' => '#000000',
                'secondary' => '#ffffff',
                'accent' => '#6366f1',
                'background' => '#ffffff',
                'text' => '#000000',
            ],
            'fonts' => [
                'heading' => 'Inter',
                'body' => 'Inter',
            ],
            'layout' => 'centered',
            'button_style' => 'rounded',
            'spacing' => 'normal',
        ];
    }
}
