<?php

namespace App\Services\Interfaces;

interface PaymentSlipServiceInterface
{
    /**
     * Generate a payment slip for a specific debt.
     *
     * This method is responsible for creating a payment slip document for the specified debt
     * and recording its generation.
     *
     * @param  string  $debtId  The unique identifier of the debt for which the payment slip is to be generated.
     */
    public function generateSlip(string $debtId): void;
}
