<?php

namespace App\Services;

use App\Jobs\GeneratePaymentSlipJob;
use App\Jobs\NotifySlipMailJob;
use App\Jobs\ProcessCsvBillingJob;
use App\Jobs\ProcessDebtsJob;
use App\Repositories\Interfaces\DebtRepositoryInterface;
use App\Services\Interfaces\BillingServiceInterface;
use App\Traits\FileTrait;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use League\Csv\Reader;
use RuntimeException;

class BillingService implements BillingServiceInterface
{
    use FileTrait;

    private const MAX_BILLINGS_EACH_JOB = 1000;

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
    public function processCsvFile(string $csvPath): void
    {
        if (! $this->existsFile($csvPath)) {
            throw new RuntimeException(
                __('exception.file_not_found')
            );
        }

        $stream = $this->getFile($csvPath);

        $csv = Reader::createFromString($stream);
        $csv->setDelimiter(',');
        $csv->setHeaderOffset(0);

        $this->validCsvHeader($csv->getHeader());

        foreach ($csv->chunkBy(self::MAX_BILLINGS_EACH_JOB) as $billings) {
            ProcessDebtsJob::dispatchAfterResponse(
                collect($billings)
            );
        }
    }

    /**
     * Throw exception if csv header is invalid
     */
    private function validCsvHeader(array $headers): void
    {
        $expectedHeaders = [
            'name',
            'governmentId',
            'email',
            'debtAmount',
            'debtDueDate',
            'debtId',
        ];

        if (collect($headers)->diff($expectedHeaders)->isNotEmpty()) {
            throw new InvalidArgumentException(
                __('exception.invalid_csv_header')
            );
        }
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
