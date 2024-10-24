<?php

namespace App\Jobs;

use App\Services\Interfaces\BillingServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessCsvBillingJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly string $csvPath
    ) {}

    /**
     * Execute the job.
     */
    public function handle(BillingServiceInterface $billingService): void
    {
        $billingService->processCsvFile($this->csvPath);
    }
}
