<?php

namespace App\Services\Interfaces;

interface DebtServiceInterface
{
    /**
     * Record the generation of a payment slip for a specific debt.
     *
     * This method updates the debt record with the timestamp of when the payment slip was generated.
     * It ensures that the slip generation time is stored and clears any related cache entries.
     *
     * @param  string  $id  The unique identifier of the debt.
     */
    public function recordGenerateSlip(string $id): void;

    /**
     * Record the notification of billing for a specific debt.
     *
     * This method updates the debt record with the timestamp of when the billing notification was sent.
     * It ensures that the notification time is stored and clears any related cache entries.
     *
     * @param  string  $id  The unique identifier of the debt.
     */
    public function recordNotify(string $id): void;

    /**
     * Retrieve a specific debt by its unique identifier.
     *
     * This method retrieves the debt from the repository and optionally throws an exception
     * if the debt is not found. The result is cached to optimize performance.
     *
     * @param  string  $id  The unique identifier of the debt.
     * @param  bool  $findOrFail  Optional. If true, the method will throw an exception if the debt is not found.
     * @return object|null The debt object if found, or null otherwise.
     */
    public function find(string $id): ?object;
}
