<?php

namespace App\Services\Interfaces;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

interface BillingServiceInterface
{
    /**
     * Save the uploaded billing file and dispatch a job to process it.
     *
     * This method uploads the provided file to a designated storage location and
     * triggers a background job to process the CSV data. It ensures that large files
     * can be processed asynchronously.
     *
     * @param  UploadedFile  $file  The uploaded billing file containing debt data.
     */
    public function saveAndProcessFile(UploadedFile $file): void;

    /**
     * Process a collection of debts and insert them into the system.
     *
     * This method takes a collection of raw debt data, validates and transforms it into the platform's
     * debt model, and inserts it into the database. After inserting, it dispatches jobs to generate payment
     * slips and send notifications for each debt.
     *
     * @param  Collection  $debts  A collection of raw debt data to be processed and inserted into the system.
     */
    public function processDebts(Collection $debts): void;
}
