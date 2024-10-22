<?php

namespace App\Services;

use App\Enums\DebtStatusEnum;
use App\Jobs\ProcessCsvBillingJob;
use App\Services\Interfaces\BillingServiceInterface;
use App\Services\Interfaces\DebtServiceInterface;
use App\Services\Interfaces\MailServiceInterface;
use App\Services\Interfaces\PaymentSlipServiceInterface;
use App\Traits\FileTrait;
use Illuminate\Http\UploadedFile;

class BillingService implements BillingServiceInterface
{
    use FileTrait;

    public function __construct(
        private readonly PaymentSlipServiceInterface $paymentSlipService,
        private readonly MailServiceInterface $mailService,
        private readonly DebtServiceInterface $debtService
    ) {}

    /**
     * {@inheritDoc}
     */
    public function saveAndProcessFile(UploadedFile $file): void
    {
        $path = $this->upload('billings', $file);

        ProcessCsvBillingJob::dispatch($path);
    }

    /**
     * {@inheritDoc}
     */
    public function processDebt(array $data): void
    {
        $debtId = data_get($data, 'debtID');

        $debt = $this->debtService->find($debtId);

        if (empty($debt)) {
            $debt = $this->hydrateDebt($data);
            $this->debtService->persist($debt);
        }

        if ($debt->status_enum === DebtStatusEnum::IMPORTED) {
            $this->paymentSlipService->generateSlip($debt);

            data_set($debt, 'status_enum', DebtStatusEnum::GENERATED);

            $this->debtService->persist($debt);
        }

        if ($debt->status_enum === DebtStatusEnum::GENERATED) {
            $this->mailService->notifyBilling($debt);

            data_set($debt, 'status_enum', DebtStatusEnum::SENDED);

            $this->debtService->persist($debt);
        }
    }

    private function hydrateDebt(array $data): object
    {
        return (object) [
            'id' => data_get($data, 'debtID'),
            'name' => data_get($data, 'name'),
            'government_id' => data_get($data, 'governmentId'),
            'email' => data_get($data, 'email'),
            'amount' => data_get($data, 'debtAmount') * 100,
            'due_date' => data_get($data, 'debtDueDate'),
            'status_enum' => DebtStatusEnum::IMPORTED,
        ];
    }
}
