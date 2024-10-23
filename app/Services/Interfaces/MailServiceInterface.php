<?php

namespace App\Services\Interfaces;

interface MailServiceInterface
{
    /**
     * Notify user of billing.
     */
    public function notifyBilling(string $debtId): void;
}
