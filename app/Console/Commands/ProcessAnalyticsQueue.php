<?php

namespace App\Console\Commands;

use App\Models\Analytics;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class ProcessAnalyticsQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analytics:process-queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process analytics events from Redis queue and store them in database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $processed = 0;

        // Process up to 1000 items at a time
        while ($processed < 1000) {
            $item = Redis::rpop('analytics_queue');

            if (! $item) {
                break; // Queue is empty
            }

            try {
                $data = json_decode($item, true);

                // Valid event types from database constraint
                $validEventTypes = ['profile_view', 'link_click', 'portfolio_view'];

                if ($data && in_array($data['event_type'], $validEventTypes)) {
                    Analytics::create([
                        'user_id' => $data['user_id'] ?? null,
                        'link_id' => $data['link_id'] ?? null,
                        'event_type' => $data['event_type'],
                        'event_data' => $data['event_data'] ?? null,
                        'ip_address' => $data['ip_address'] ?? null,
                        'user_agent' => $data['user_agent'] ?? null,
                        'referrer' => $data['referrer'] ?? null,
                        'device_type' => $data['device_type'] ?? null,
                        'browser' => $data['browser'] ?? null,
                        'os' => $data['os'] ?? null,
                        'occurred_at' => isset($data['timestamp']) ?
                            \Carbon\Carbon::createFromTimestamp($data['timestamp']) : now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $processed++;
                } else {
                    // Skip invalid event types
                    $this->warn('Skipped invalid event type: '.($data['event_type'] ?? 'unknown'));
                }
            } catch (\Exception $e) {
                $this->error('Failed to process analytics item: '.$e->getMessage());
                // Put the item back in the queue for retry
                Redis::lpush('analytics_queue', $item);
                break;
            }
        }

        if ($processed > 0) {
            $this->info("Processed {$processed} analytics events.");
        } else {
            $this->info('No analytics events to process.');
        }

        return 0;
    }
}
