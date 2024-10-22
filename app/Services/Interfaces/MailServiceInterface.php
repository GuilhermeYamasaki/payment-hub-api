<?php

namespace App\Services\Interfaces;

interface MailServiceInterface
{
    /**
     * Notify user of billing.
     */
    public function notifyBilling(object $debt): void;
}
