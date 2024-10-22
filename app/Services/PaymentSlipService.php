<?php

namespace App\Services;

use App\Services\Interfaces\PaymentSlipServiceInterface;
use Illuminate\Support\Facades\Log;

class PaymentSlipService implements PaymentSlipServiceInterface
{
    /**
     * {@inheritDoc}
     */
    public function generateSlip(object $debt): void
    {
        Log::debug('Generate payment slip for user', [
            'debt' => $debt,
        ]);
    }
}
