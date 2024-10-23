<?php

namespace App\Services;

use App\Services\Interfaces\DebtServiceInterface;
use App\Services\Interfaces\PaymentSlipServiceInterface;
use Illuminate\Support\Facades\Log;

class PaymentSlipService implements PaymentSlipServiceInterface
{
    public function __construct(
        private readonly DebtServiceInterface $debtService
    ) {}

    /**
     * {@inheritDoc}
     */
    public function generateSlip(string $debtId): void
    {
        $debt = $this->debtService->find($debtId);
        if (data_get($debt, 'generate_slip_at')) {
            return;
        }

        $this->buildDocument($debt);

        $this->debtService->recordGenerateSlip(
            data_get($debt, 'id')
        );
    }

    /**
     * Abstract method to build payment slip document.
     */
    private function buildDocument(object $debt): void
    {
        Log::debug('Generate payment slip for user');
    }
}
