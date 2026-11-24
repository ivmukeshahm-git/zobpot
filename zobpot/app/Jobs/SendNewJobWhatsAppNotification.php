<?php

namespace App\Jobs;

use App\Models\Job;
use App\Services\WhatsAppJobNotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendNewJobWhatsAppNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Retry temporary API failures via the queue.
     * Permanent failures (invalid phone, etc.) are handled inside the service
     * and will not throw, so they will not be retried endlessly.
     */
    public $tries = 3;

    public $backoff = [60, 120, 300];

    /** @var int */
    protected $jobId;

    public function __construct(int $jobId)
    {
        $this->jobId = $jobId;
    }

    public function handle(WhatsAppJobNotificationService $service): void
    {
        $job = Job::find($this->jobId);

        if (!$job) {
            Log::channel('whatsapp')->warning('[WHATSAPP] Queued job alert skipped — job not found', [
                'job_id' => $this->jobId,
            ]);
            return;
        }

        $service->sendNewJobAlert($job);
    }

    public function failed(\Throwable $exception): void
    {
        Log::channel('whatsapp')->error('[WHATSAPP] SendNewJobWhatsAppNotification failed permanently', [
            'job_id' => $this->jobId,
            'exception' => $exception->getMessage(),
        ]);
    }
}
