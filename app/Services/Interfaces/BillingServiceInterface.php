<?php

namespace App\Services\Interfaces;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

interface BillingServiceInterface
{
    /**
     * Save data file and dispatch job to process
     */
    public function saveAndProcessFile(UploadedFile $file): void;

    /**
     * Process debts
     */
    public function processDebts(Collection $debts): void;
}
