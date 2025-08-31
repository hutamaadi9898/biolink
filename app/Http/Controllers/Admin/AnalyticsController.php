<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Analytics;
use App\Models\Link;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AnalyticsController extends Controller
{
    /**
     * Display analytics overview
     */
    public function index(Request $request)
    {
        // Date range filter
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        // Total statistics
        $totalClicks = Analytics::where('event_type', 'link_click')->whereBetween('created_at', [$start, $end])->count();
        $totalUsers = User::whereBetween('created_at', [$start, $end])->count();
        $totalLinks = Link::whereBetween('created_at', [$start, $end])->count();
        $uniqueVisitors = Analytics::whereBetween('created_at', [$start, $end])->distinct('ip_address')->count();

        // Daily analytics
        $dailyAnalytics = Analytics::selectRaw('DATE(created_at) as date, COUNT(*) as total_clicks, COUNT(DISTINCT ip_address) as unique_visitors')
            ->where('event_type', 'link_click')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top performing links - simplified using existing click_count
        $topLinks = Link::with('user')
            ->where('click_count', '>', 0)
            ->orderBy('click_count', 'desc')
            ->take(10)
            ->get();

        // Top users by clicks - using links click_count sum
        $topUsers = User::with('profile')
            ->withSum('links', 'click_count')
            ->orderBy('links_sum_click_count', 'desc')
            ->take(10)
            ->get();

        // Browser statistics - simplified since we have browser column
        $browserStats = Analytics::select('browser')
            ->selectRaw('COUNT(*) as count')
            ->whereBetween('created_at', [$start, $end])
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderBy('count', 'desc')
            ->take(10)
            ->get()
            ->pluck('count', 'browser');

        // Device statistics (mobile vs desktop) - simplified since we have device_type column
        $deviceStats = Analytics::select('device_type')
            ->selectRaw('COUNT(*) as count')
            ->whereBetween('created_at', [$start, $end])
            ->whereNotNull('device_type')
            ->groupBy('device_type')
            ->get()
            ->pluck('count', 'device_type');

        // Referrer statistics
        $referrerStats = Analytics::selectRaw('referrer, COUNT(*) as count')
            ->whereBetween('created_at', [$start, $end])
            ->whereNotNull('referrer')
            ->where('referrer', '!=', '')
            ->groupBy('referrer')
            ->orderBy('count', 'desc')
            ->take(10)
            ->get();

        return Inertia::render('Admin/Analytics/Index', [
            'statistics' => [
                'total_clicks' => $totalClicks,
                'total_users' => $totalUsers,
                'total_links' => $totalLinks,
                'unique_visitors' => $uniqueVisitors,
            ],
            'daily_analytics' => $dailyAnalytics,
            'top_links' => $topLinks,
            'top_users' => $topUsers,
            'browser_stats' => $browserStats,
            'device_stats' => $deviceStats,
            'referrer_stats' => $referrerStats,
            'filters' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
        ]);
    }

    /**
     * Export analytics data
     */
    public function export(Request $request)
    {
        $validated = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'format' => ['required', 'in:csv,json'],
        ]);

        $start = Carbon::parse($validated['start_date'])->startOfDay();
        $end = Carbon::parse($validated['end_date'])->endOfDay();

        $analytics = Analytics::with('user')
            ->whereBetween('created_at', [$start, $end])
            ->get();

        if ($validated['format'] === 'csv') {
            $filename = 'analytics_'.$start->format('Y-m-d').'_to_'.$end->format('Y-m-d').'.csv';

            $headers = [
                'Content-type' => 'text/csv',
                'Content-Disposition' => "attachment; filename={$filename}",
            ];

            $callback = function () use ($analytics) {
                $file = fopen('php://output', 'w');

                // Header row
                fputcsv($file, [
                    'ID', 'Event Type', 'Event Data', 'User ID', 'IP Address', 'User Agent',
                    'Referrer', 'Country', 'City', 'Device Type', 'Browser', 'OS', 'Occurred At', 'Created At',
                ]);

                foreach ($analytics as $analytic) {
                    fputcsv($file, [
                        $analytic->id,
                        $analytic->event_type,
                        $analytic->event_data,
                        $analytic->user_id,
                        $analytic->ip_address,
                        $analytic->user_agent,
                        $analytic->referrer,
                        $analytic->country,
                        $analytic->city,
                        $analytic->device_type,
                        $analytic->browser,
                        $analytic->os,
                        $analytic->occurred_at,
                        $analytic->created_at,
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } else {
            // JSON format
            $filename = 'analytics_'.$start->format('Y-m-d').'_to_'.$end->format('Y-m-d').'.json';

            return response()->json($analytics, 200, [
                'Content-Disposition' => "attachment; filename={$filename}",
            ]);
        }
    }

    /**
     * Clear old analytics data
     */
    public function cleanup(Request $request)
    {
        $validated = $request->validate([
            'days' => ['required', 'integer', 'min:1', 'max:365'],
        ]);

        $cutoffDate = Carbon::now()->subDays($validated['days']);
        $deletedCount = Analytics::where('created_at', '<', $cutoffDate)->delete();

        return redirect()->back()->with('success', "Deleted {$deletedCount} analytics records older than {$validated['days']} days.");
    }
}
