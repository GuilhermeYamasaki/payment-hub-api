<?php

namespace App\Services\Interfaces;

interface MailServiceInterface
{
    /**
     * Notify the user of an billing.
     *
     * This method is responsible for triggering an email notification to the user
     * regarding their debt. It interacts with the debt service to verify if a notification
     * has already been sent by checking the 'notify_at' field. If not, it will proceed to send the email
     * and record the notification event.
     *
     * @param  string  $debtId  The unique identifier of the debt for which the notification will be sent.
     */
    public function notifyBilling(string $debtId): void;
}
