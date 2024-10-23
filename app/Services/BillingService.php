<?php

namespace App\Services;

use App\Jobs\GeneratePaymentSlipJob;
use App\Jobs\NotifySlipMailJob;
use App\Jobs\ProcessCsvBillingJob;
use App\Repositories\Interfaces\DebtRepositoryInterface;
use App\Services\Interfaces\BillingServiceInterface;
use App\Traits\FileTrait;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class BillingService implements BillingServiceInterface
{
    use FileTrait;

    public function __construct(
        private readonly DebtRepositoryInterface $debtRepository
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
    public function processDebts(Collection $data): void
    {
        $debts = $data->map(
            fn ($rawDebt) => $this->hydrateDebt($rawDebt)
        );

        $this->debtRepository->insert($debts->toArray());

        $debts->pluck('id')
            ->each(function (string $debtId) {
                NotifySlipMailJob::dispatchAfterResponse($debtId);
                GeneratePaymentSlipJob::dispatchAfterResponse($debtId);
            });
    }

    /**
     * Convert raw billing debt to debt model of plataform
     */
    private function hydrateDebt(array $data): array
    {
        $validador = validator($data, [
            'debtId' => 'required|string',
            'name' => 'required|string',
            'governmentId' => 'required|integer',
            'email' => 'required|email',
            'debtAmount' => 'required|numeric',
            'debtDueDate' => 'required|date',
        ]);

        throw_if(
            $validador->fails(),
            InvalidArgumentException::class,
            $validador->errors()->first()
        );

        return [
            'id' => data_get($data, 'debtId'),
            'name' => data_get($data, 'name'),
            'government_id' => (int) data_get($data, 'governmentId'),
            'email' => data_get($data, 'email'),
            'amount' => ((int) data_get($data, 'debtAmount')) * 100, // Remove cents to avoid float precision
            'due_date_at' => Carbon::parse(data_get($data, 'debtDueDate'))->endOfDay(),
        ];
    }
}
