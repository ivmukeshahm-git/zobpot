<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ExpirePlans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plans:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire plan history rows and clear users active_plan_id / plan_service when needed (status=0 for inactive)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today()->toDateString();

        DB::beginTransaction();
        try {
            // 1) Mark any active plan_history entries that passed their expiry as inactive (status = 0)
            $updated = DB::table('tbl_plan_history')
                ->where('status', 1)
                ->whereDate('expire_date', '<', $today)
                ->update([
                    'status' => 0,
                    'updated_at' => now(),
                ]);

            $this->info("Expired plan_history rows updated: $updated");

            // 2) Clear users whose active_plan_id no longer has a valid active history
            $cleared = DB::table('users')
                ->where('active_plan_id', '<>', 0)
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('tbl_plan_history as ph')
                          ->whereColumn('ph.user_id', 'users.id')
                          ->whereColumn('ph.plan_id', 'users.active_plan_id')
                          ->where('ph.status', 1);
                })
                ->update([
                    'active_plan_id' => 0,
                    'plan_service' => null,
                    'plan_job_used' => 0,
                    'plan_internship_used' => 0,
                    'plan_job_limit' => null,
                    'plan_opportunity_limit' => null,
                    'updated_at' => now(),
                ]);

            $this->info("Users cleared (active_plan_id + plan_service + usage/limits reset): $cleared");

            DB::commit();
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error('Failed to expire plans: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
