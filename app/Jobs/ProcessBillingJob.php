<?php

namespace App\Jobs;

use App\Services\Interfaces\BillingServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Spatie\Async\Pool;

class ProcessBillingJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly array $billings
    ) {}

    /**
     * Execute the job.
     */
    public function handle(BillingServiceInterface $billingService): void
    {
        $pool = Pool::create();

        foreach ($this->billings as $billing) {
            $pool->add(fn () => $billingService->processDebt($billing), 1024 * 10000)
                ->catch(function ($exception) use ($billing) {
                    Log::error(self::class, [
                        'exception' => $exception,
                        'billing' => $billing,
                    ]);
                });
        }

        $pool->wait();
    }
}
