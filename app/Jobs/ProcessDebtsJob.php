<?php

namespace App\Jobs;

use App\Services\Interfaces\BillingServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Collection;

class ProcessDebtsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly Collection $debts
    ) {}

    /**
     * Execute the job.
     */
    public function handle(BillingServiceInterface $billingService): void
    {
        $billingService->processDebts($this->debts);
    }
}
