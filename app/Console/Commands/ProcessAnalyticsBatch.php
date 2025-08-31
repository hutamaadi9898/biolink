<?php

namespace App\Console\Commands;

use App\Models\Analytics;
use Illuminate\Console\Command;

class ProcessAnalyticsBatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analytics:process-batch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process analytics events from Redis queue and batch insert to database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Processing analytics batch...');

        $processed = Analytics::processBatchInsert();

        if ($processed > 0) {
            $this->info("Successfully processed {$processed} analytics events.");
        } else {
            $this->info('No analytics events to process.');
        }

        return Command::SUCCESS;
    }
}
