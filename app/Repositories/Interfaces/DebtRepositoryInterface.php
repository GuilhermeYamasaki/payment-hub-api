<?php

namespace App\Repositories\Interfaces;

interface DebtRepositoryInterface
{
    public function insert(array $debts): void;

    public function update(string $id, array $data): void;

    public function find(string $id): ?object;
}
