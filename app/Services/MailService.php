<?php

namespace App\Services;

use App\Services\Interfaces\DebtServiceInterface;
use App\Services\Interfaces\MailServiceInterface;
use Illuminate\Support\Facades\Log;

class MailService implements MailServiceInterface
{
    public function __construct(
        private readonly DebtServiceInterface $debtService
    ) {}

    /**
     * {@inheritDoc}
     */
    public function notifyBilling(string $debtId): void
    {
        $debt = $this->debtService->find($debtId);
        if (data_get($debt, 'notify_at')) {
            return;
        }

        $this->sendEmail($debt);

        $this->debtService->recordNotify($debtId);
    }

    /**
     * Abstract method to send email notification.
     */
    private function sendEmail(object $debt): void
    {
        Log::debug('Notify user of billing');
    }
}
