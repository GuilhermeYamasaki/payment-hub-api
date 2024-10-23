<?php

namespace App\Repositories\Interfaces;

interface DebtRepositoryInterface
{
    /**
     * Insert a list of debts into the database.
     *
     * This method inserts multiple debt records into the database in a single operation.
     * If a debt record already exists, it is ignored to prevent duplication.
     *
     * @param  array  $debts  An array of debt data to be inserted.
     */
    public function insert(array $debts): void;

    /**
     * Update an existing debt record in the database.
     *
     * This method updates a specific debt record identified by its unique ID with the provided data.
     *
     * @param  string  $id  The unique identifier of the debt to be updated.
     * @param  array  $data  The data to update in the debt record.
     */
    public function update(string $id, array $data): void;

    /**
     * Find a debt by its unique identifier.
     *
     * This method retrieves a debt record from the database based on its ID.
     * If the debt is not found, it returns null.
     *
     * @param  string  $id  The unique identifier of the debt.
     * @return object|null The debt object if found, or null if not found.
     */
    public function find(string $id): ?object;
}
