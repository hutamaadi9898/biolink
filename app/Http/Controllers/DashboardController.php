<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Analytics;
use App\Models\Profile;
use App\Models\Theme;
use App\Http\Requests\StorePortfolioRequest;
use App\Http\Requests\UpdatePortfolioRequest;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Show the dashboard
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Get or create profile with unique slug handling
        $profile = $user->profile;
        
        if (!$profile) {
            $baseSlug = $user->username ?? 'user-' . $user->id;
            $slug = $baseSlug;
            $counter = 1;
            
            // Ensure slug is unique
            while (Profile::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            
            $profile = $user->profile()->create([
                'slug' => $slug,
                'display_name' => $user->name,
            ]);
        }

        // Get analytics summary
        $analytics = Analytics::getSummaryForUser($user->id, 'week');

        // Get quick stats
        $stats = [
            'total_links' => $user->links()->count(),
            'active_links' => $user->links()->active()->count(),
            'total_portfolios' => $user->portfolios()->count(),
            'profile_views' => $analytics['total_views'],
            'total_clicks' => $analytics['total_clicks'],
        ];

        // Get recent links (last 5)
        $recentLinks = $user->links()
            ->latest()
            ->limit(5)
            ->get();

        // Get recent analytics data (last 5 entries)
        $recentAnalytics = Analytics::where('user_id', $user->id)
            ->latest('occurred_at')
            ->limit(5)
            ->get();

        return Inertia::render('Dashboard/Index', [
            'user' => $user,
            'profile' => $profile,
            'stats' => $stats,
            'analytics' => $analytics,
            'recentLinks' => $recentLinks,
            'recentAnalytics' => $recentAnalytics,
            'profileUrl' => $profile->url,
            'isPro' => $user->isPro(),
        ]);
    }

    /**
     * Show profile settings
     */
    public function profileSettings(Request $request)
    {
        $user = $request->user();
        $profile = $user->profile;

        return Inertia::render('Dashboard/Profile', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    /**
     * Update profile settings
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();
        
        $validated = $request->validate([
            'display_name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'tagline' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'social_links' => 'nullable|array',
            'contact_info' => 'nullable|array',
            'is_public' => 'boolean',
            'show_qr_code' => 'boolean',
        ]);

        $profile = $user->profile;
        
        if (!$profile) {
            $baseSlug = $user->username ?? 'user-' . $user->id;
            $slug = $baseSlug;
            $counter = 1;
            
            // Ensure slug is unique
            while (Profile::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            
            $validated['slug'] = $slug;
            $profile = $user->profile()->create($validated);
        } else {
            $profile->update($validated);
        }

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Show portfolio management
     */
    public function portfolio(Request $request)
    {
        $user = $request->user();
        $portfolios = $user->portfolios()->orderBy('order')->get();

        return Inertia::render('Dashboard/Portfolio', [
            'portfolios' => $portfolios,
        ]);
    }

    /**
     * Store new portfolio item
     */
    public function storePortfolio(StorePortfolioRequest $request)
    {
        $validated = $request->validated();
        $user = $request->user();

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('portfolio', 'public');
            $validated['image'] = $path;
        }

        // Set order if not provided
        if (!isset($validated['order'])) {
            $validated['order'] = $user->portfolios()->max('order') + 1;
        }

        $portfolio = $user->portfolios()->create($validated);

        return back()->with('success', 'Portfolio item berhasil ditambahkan!');
    }

    /**
     * Update portfolio item
     */
    public function updatePortfolio(UpdatePortfolioRequest $request, $portfolioId)
    {
        $user = $request->user();
        $portfolio = $user->portfolios()->findOrFail($portfolioId);

        // Authorization is handled by the findOrFail method above
        // Since we're only finding portfolios that belong to the user

        $validated = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($portfolio->image) {
                Storage::disk('public')->delete($portfolio->image);
            }
            
            $path = $request->file('image')->store('portfolio', 'public');
            $validated['image'] = $path;
        }

        $portfolio->update($validated);

        return back()->with('success', 'Portfolio item berhasil diperbarui!');
    }

    /**
     * Delete portfolio item
     */
    public function destroyPortfolio(Request $request, $portfolioId)
    {
        $user = $request->user();
        $portfolio = $user->portfolios()->findOrFail($portfolioId);

        // Authorization is handled by the findOrFail method above
        // Since we're only finding portfolios that belong to the user

        // Delete image file
        if ($portfolio->image) {
            Storage::disk('public')->delete($portfolio->image);
        }

        $portfolio->delete();

        return back()->with('success', 'Portfolio item berhasil dihapus!');
    }

    /**
     * Show themes
     */
    public function themes(Request $request)
    {
        $user = $request->user();
        
        $freeThemes = Theme::active()->free()->orderBy('sort_order')->get();
        $premiumThemes = Theme::active()->premium()->orderBy('sort_order')->get();
        
        $currentTheme = $user->activeTheme?->theme;

        return Inertia::render('Dashboard/Themes', [
            'freeThemes' => $freeThemes,
            'premiumThemes' => $premiumThemes,
            'currentTheme' => $currentTheme,
            'isPro' => $user->isPro(),
        ]);
    }

    /**
     * Apply theme to user
     */
    public function applyTheme(Request $request, Theme $theme)
    {
        $user = $request->user();

        // Check if theme is available for user
        if (!$theme->isAvailableForUser($user)) {
            return back()->with('error', 'Tema ini hanya tersedia untuk pengguna Pro.');
        }

        // Deactivate current theme
        $user->userThemes()->update(['is_active' => false]);

        // Activate new theme
        $user->userThemes()->updateOrCreate(
            ['theme_id' => $theme->id],
            ['is_active' => true]
        );

        return back()->with('success', 'Tema berhasil diterapkan!');
    }

    /**
     * Customize theme
     */
    public function customizeTheme(Request $request)
    {
        $user = $request->user();
        
        if (!$user->isPro()) {
            return back()->with('error', 'Kustomisasi tema hanya tersedia untuk pengguna Pro.');
        }

        $validated = $request->validate([
            'custom_config' => 'required|array',
        ]);

        $activeTheme = $user->activeTheme;
        
        if (!$activeTheme) {
            return back()->with('error', 'Tidak ada tema yang aktif.');
        }

        $activeTheme->update($validated);

        return back()->with('success', 'Kustomisasi tema berhasil disimpan!');
    }
}
