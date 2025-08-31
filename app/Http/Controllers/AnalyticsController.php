<?php

namespace App\Http\Controllers;

use App\Models\Analytics;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AnalyticsController extends Controller
{
    /**
     * Show analytics dashboard
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $period = $request->get('period', '7days');

        // Get date range based on period
        $dateRange = $this->getDateRange($period);

        // Get analytics data for user
        $analytics = Analytics::where('user_id', $user->id)
            ->whereBetween('occurred_at', $dateRange)
            ->get();

        // Calculate stats
        $total_views = $analytics->where('event_type', 'profile_view')->count();
        $total_clicks = $analytics->where('event_type', 'link_click')->count();
        $total_countries = $analytics->whereNotNull('country')->pluck('country')->unique()->count();

        // Get daily breakdown
        $daily_breakdown = $analytics->groupBy(function ($item) {
            return $item->occurred_at->format('Y-m-d');
        })->map(function ($items, $date) {
            return [
                'date' => $date,
                'views' => $items->where('event_type', 'profile_view')->count(),
                'clicks' => $items->where('event_type', 'link_click')->count(),
            ];
        })->values();

        // Get top countries
        $top_countries = $analytics->whereNotNull('country')
            ->pluck('country')
            ->countBy()
            ->map(function ($count, $country) {
                return [
                    'country' => $country,
                    'count' => $count,
                ];
            })
            ->sortByDesc('count')
            ->take(10)
            ->values();

        // Get top devices
        $top_devices = $analytics->whereNotNull('device_type')
            ->pluck('device_type')
            ->countBy()
            ->map(function ($count, $device) {
                return [
                    'device' => $device,
                    'count' => $count,
                ];
            })
            ->sortByDesc('count')
            ->take(10)
            ->values();

        // Get top browsers
        $top_browsers = $analytics->whereNotNull('browser')
            ->pluck('browser')
            ->countBy()
            ->map(function ($count, $browser) {
                return [
                    'browser' => $browser,
                    'count' => $count,
                ];
            })
            ->sortByDesc('count')
            ->take(10)
            ->values();

        // Get top links with click data
        $topLinks = $analytics->where('event_type', 'link_click')
            ->groupBy('event_data')
            ->map(function ($items) use ($user) {
                $linkId = str_replace('"', '', $items->first()->event_data ?? '');

                // Only process if linkId is numeric (valid ID)
                if (! is_numeric($linkId)) {
                    return null;
                }

                $link = $user->links()->find($linkId);

                // Skip if link not found
                if (! $link) {
                    return null;
                }

                return [
                    'id' => $linkId,
                    'title' => $link->title ?? 'Unknown Link',
                    'clicks' => $items->count(),
                ];
            })
            ->filter() // Remove null values
            ->sortByDesc('clicks')
            ->take(10)
            ->values();

        // Get portfolio views count
        $portfolio_views = $analytics->where('event_type', 'portfolio_view')->count();
        $unique_visitors = $analytics->whereNotNull('ip_address')->pluck('ip_address')->unique()->count();

        return Inertia::render('Dashboard/Analytics', [
            'stats' => [
                'total_views' => $total_views,
                'total_clicks' => $total_clicks,
                'portfolio_views' => $portfolio_views,
                'unique_visitors' => $unique_visitors,
            ],
            'dailyBreakdown' => $daily_breakdown,
            'topLinks' => $topLinks,
            'topCountries' => $top_countries->pluck('country', 'count')->toArray(),
            'deviceBreakdown' => $top_devices->pluck('device', 'count')->toArray(),
            'browserBreakdown' => $top_browsers->pluck('browser', 'count')->toArray(),
            'period' => $period,
        ]);
    }

    /**
     * Get analytics data via API
     */
    public function getData(Request $request)
    {
        $user = $request->user();
        $period = $request->get('period', '7days');

        $dateRange = $this->getDateRange($period);

        $analytics = Analytics::where('user_id', $user->id)
            ->whereBetween('occurred_at', $dateRange)
            ->get();

        // Calculate stats
        $total_views = $analytics->where('event_type', 'profile_view')->count();
        $total_clicks = $analytics->where('event_type', 'link_click')->count();
        $total_countries = $analytics->whereNotNull('country')->pluck('country')->unique()->count();

        // Get daily breakdown
        $daily_breakdown = $analytics->groupBy(function ($item) {
            return $item->occurred_at->format('Y-m-d');
        })->map(function ($items, $date) {
            return [
                'date' => $date,
                'views' => $items->where('event_type', 'profile_view')->count(),
                'clicks' => $items->where('event_type', 'link_click')->count(),
            ];
        })->values();

        // Get top countries
        $top_countries = $analytics->whereNotNull('country')
            ->pluck('country')
            ->countBy()
            ->map(function ($count, $country) {
                return [
                    'country' => $country,
                    'count' => $count,
                ];
            })
            ->sortByDesc('count')
            ->take(10)
            ->values();

        return response()->json([
            'total_views' => $total_views,
            'total_clicks' => $total_clicks,
            'total_countries' => $total_countries,
            'daily_breakdown' => $daily_breakdown,
            'top_countries' => $top_countries,
        ]);
    }

    /**
     * Get date range based on period
     */
    private function getDateRange($period)
    {
        switch ($period) {
            case 'today':
                return [Carbon::today(), Carbon::tomorrow()];
            case '7days':
                return [Carbon::now()->subDays(7), Carbon::now()];
            case '30days':
                return [Carbon::now()->subDays(30), Carbon::now()];
            case '90days':
                return [Carbon::now()->subDays(90), Carbon::now()];
            default:
                return [Carbon::now()->subDays(7), Carbon::now()];
        }
    }
}
