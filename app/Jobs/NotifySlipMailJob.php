<?php

namespace App\Jobs;

use App\Services\Interfaces\MailServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class NotifySlipMailJob implements ShouldQueue
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
    public function handle(MailServiceInterface $mailService): void
    {
        $mailService->notifyBilling($this->debtId);
    }
}
