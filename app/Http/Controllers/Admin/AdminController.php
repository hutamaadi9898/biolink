<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Analytics;
use App\Models\Link;
use App\Models\Portfolio;
use App\Models\User;
use Carbon\Carbon;
use Inertia\Inertia;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index()
    {
        // Get key statistics
        $totalUsers = User::count();
        $totalLinks = Link::count();
        $totalPortfolios = Portfolio::count();
        $totalClicks = Analytics::where('event_type', 'link_click')->count();

        // Get recent statistics (last 30 days)
        $thirtyDaysAgo = Carbon::now()->subDays(30);
        $newUsersThisMonth = User::where('created_at', '>=', $thirtyDaysAgo)->count();
        $newLinksThisMonth = Link::where('created_at', '>=', $thirtyDaysAgo)->count();
        $clicksThisMonth = Analytics::where('event_type', 'link_click')
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->count();

        // Get recent users
        $recentUsers = User::with('profile')
            ->latest()
            ->take(5)
            ->get();

        // Get top performing links (simplified)
        $topLinks = Link::with(['user'])
            ->orderBy('click_count', 'desc')
            ->take(5)
            ->get()
            ->map(function ($link) {
                return [
                    'id' => $link->id,
                    'title' => $link->title,
                    'user' => ['name' => $link->user->name],
                    'analytics_sum_clicks' => $link->click_count ?? 0,
                ];
            });

        // Get daily analytics for the last 30 days
        $dailyAnalytics = Analytics::selectRaw('DATE(created_at) as date, COUNT(*) as total_clicks')
            ->where('event_type', 'link_click')
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Get user growth data
        $userGrowth = User::selectRaw('DATE(created_at) as date, COUNT(*) as total_users')
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'statistics' => [
                'total_users' => $totalUsers,
                'total_links' => $totalLinks,
                'total_portfolios' => $totalPortfolios,
                'total_clicks' => $totalClicks,
                'new_users_this_month' => $newUsersThisMonth,
                'new_links_this_month' => $newLinksThisMonth,
                'clicks_this_month' => $clicksThisMonth,
            ],
            'recent_users' => $recentUsers,
            'top_links' => $topLinks,
            'daily_analytics' => $dailyAnalytics,
            'user_growth' => $userGrowth,
        ]);
    }

    /**
     * Display system information
     */
    public function system()
    {
        $systemInfo = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'database_type' => config('database.default'),
            'cache_driver' => config('cache.default'),
            'session_driver' => config('session.driver'),
            'queue_driver' => config('queue.default'),
            'mail_driver' => config('mail.default'),
            'timezone' => config('app.timezone'),
            'environment' => app()->environment(),
            'debug_mode' => config('app.debug'),
        ];

        // Get database statistics
        $databaseStats = [
            'users_table_size' => User::count(),
            'links_table_size' => Link::count(),
            'portfolios_table_size' => Portfolio::count(),
            'analytics_table_size' => Analytics::count(),
        ];

        return Inertia::render('Admin/System', [
            'system_info' => $systemInfo,
            'database_stats' => $databaseStats,
        ]);
    }
}
