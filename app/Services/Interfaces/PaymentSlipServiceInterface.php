<?php

namespace App\Services\Interfaces;

interface PaymentSlipServiceInterface
{
    /**
     * Generate payment slip for user.
     */
    public function generateSlip(string $debtId): void;
}
