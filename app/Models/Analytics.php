<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Redis;

class Analytics extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'link_id',
        'event_type',
        'event_data',
        'ip_address',
        'user_agent',
        'referrer',
        'country',
        'city',
        'device_type',
        'browser',
        'os',
        'metadata',
        'occurred_at',
    ];

    protected $casts = [
        'event_data' => 'array',
        'metadata' => 'array',
        'occurred_at' => 'datetime',
    ];

    /**
     * Get the user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the link
     */
    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }

    /**
     * Track an event in Redis for batch processing
     */
    public static function trackEvent(array $data): void
    {
        try {
            $eventData = array_merge($data, [
                'timestamp' => now()->timestamp,
                'id' => uniqid('analytics_', true),
            ]);

            Redis::lpush('analytics_queue', json_encode($eventData));
        } catch (\Exception $e) {
            // Fallback: Store directly in database if Redis is not available
            self::create([
                'user_id' => $data['user_id'],
                'link_id' => $data['link_id'] ?? null,
                'event_type' => $data['event_type'],
                'event_data' => $data['event_data'] ?? null,
                'ip_address' => $data['ip_address'] ?? null,
                'user_agent' => $data['user_agent'] ?? null,
                'referrer' => $data['referrer'] ?? null,
                'country' => $data['country'] ?? null,
                'city' => $data['city'] ?? null,
                'device_type' => $data['device_type'] ?? null,
                'browser' => $data['browser'] ?? null,
                'os' => $data['os'] ?? null,
                'metadata' => $data['metadata'] ?? null,
                'occurred_at' => now(),
            ]);
        }
    }

    /**
     * Batch insert analytics from Redis queue
     */
    public static function processBatchInsert(): int
    {
        try {
            $batchSize = 100;
            $processed = 0;

            $events = Redis::lrange('analytics_queue', 0, $batchSize - 1);

            if (empty($events)) {
                return 0;
            }

            $analyticsData = [];
            foreach ($events as $event) {
                $data = json_decode($event, true);

                $analyticsData[] = [
                    'user_id' => $data['user_id'],
                    'link_id' => $data['link_id'] ?? null,
                    'event_type' => $data['event_type'],
                    'event_data' => $data['event_data'] ?? null,
                    'ip_address' => $data['ip_address'] ?? null,
                    'user_agent' => $data['user_agent'] ?? null,
                    'referrer' => $data['referrer'] ?? null,
                    'country' => $data['country'] ?? null,
                    'city' => $data['city'] ?? null,
                    'device_type' => $data['device_type'] ?? null,
                    'browser' => $data['browser'] ?? null,
                    'os' => $data['os'] ?? null,
                    'metadata' => isset($data['metadata']) ? json_encode($data['metadata']) : null,
                    'occurred_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (! empty($analyticsData)) {
                self::insert($analyticsData);
                Redis::ltrim('analytics_queue', count($events), -1);
                $processed = count($events);
            }

            return $processed;
        } catch (\Exception $e) {
            // Redis not available
            return 0;
        }
    }

    /**
     * Get analytics summary for user
     */
    public static function getSummaryForUser(int $userId, string $period = 'week'): array
    {
        $startDate = match ($period) {
            'day' => now()->startOfDay(),
            'week' => now()->startOfWeek(),
            'month' => now()->startOfMonth(),
            'year' => now()->startOfYear(),
            default => now()->startOfWeek(),
        };

        $analytics = self::where('user_id', $userId)
            ->where('occurred_at', '>=', $startDate)
            ->get();

        return [
            'total_views' => $analytics->where('event_type', 'profile_view')->count(),
            'total_clicks' => $analytics->where('event_type', 'link_click')->count(),
            'portfolio_views' => $analytics->where('event_type', 'portfolio_view')->count(),
            'top_countries' => $analytics->groupBy('country')->map->count()->sortDesc()->take(5),
            'top_referrers' => $analytics->whereNotNull('referrer')->groupBy('referrer')->map->count()->sortDesc()->take(5),
            'device_breakdown' => $analytics->groupBy('device_type')->map->count(),
        ];
    }
}
