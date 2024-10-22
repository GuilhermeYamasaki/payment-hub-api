<?php

namespace App\Jobs;

use App\Services\Interfaces\BillingServiceInterface;
use App\Traits\FileTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use League\Csv\Reader;
use RuntimeException;

class ProcessCsvBillingJob implements ShouldQueue
{
    use FileTrait, Queueable;

    private const MAX_BILLINGS_EACH_JOB = 100;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly string $csvPath
    ) {}

    /**
     * Execute the job.
     */
    public function handle(BillingServiceInterface $billingService): void
    {
        if (! $this->existsFile($this->csvPath)) {
            throw new RuntimeException(
                __('exception.file_not_found')
            );
        }

        $stream = $this->getFile($this->csvPath);

        $csv = Reader::createFromString($stream);
        $csv->setDelimiter(',');
        $csv->setHeaderOffset(0);

        collect($csv->getRecords())
            ->chunk(self::MAX_BILLINGS_EACH_JOB)
            ->each(
                fn ($data) => ProcessBillingJob::dispatch($data)
            );
    }
}
