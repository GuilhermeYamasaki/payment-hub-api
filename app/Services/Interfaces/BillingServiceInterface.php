<?php

namespace App\Services\Interfaces;

use Illuminate\Http\UploadedFile;

interface BillingServiceInterface
{
    /**
     * Save data file and dispatch job to process
     */
    public function saveAndProcessFile(UploadedFile $file): void;

    /**
     * Process debt.
     */
    public function processDebt(array $data): void;
}
