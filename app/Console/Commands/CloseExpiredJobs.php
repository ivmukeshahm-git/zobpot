<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CloseExpiredJobs extends Command
{
    protected $signature = 'jobs:close-expired';

    protected $description = 'Automatically close jobs after 30 days';

    public function handle()
    {
        Log::info('Cron Running: '.now());

        DB::table('tbl_job')
            ->where('status', 1)
            // ->where('created_at', '<=', Carbon::now()->subSeconds(10))
            ->where('created_at', '<=', Carbon::now()->subDays(30))
            ->update([
                'status' => 2,
                'updated_at' => now(),
            ]);

        Log::info('Expired jobs closed');
    }
}