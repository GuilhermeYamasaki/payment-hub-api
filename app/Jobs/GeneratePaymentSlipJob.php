<?php

namespace App\Jobs;

use App\Services\Interfaces\PaymentSlipServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GeneratePaymentSlipJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly string $debtId
    ) {}

    /**
     * Execute the job.
     */
    public function handle(PaymentSlipServiceInterface $paymentSlipService): void
    {
        $paymentSlipService->generateSlip($this->debtId);
    }
}
