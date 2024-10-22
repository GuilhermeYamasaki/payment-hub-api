<?php

namespace App\Services\Interfaces;

interface DebtServiceInterface
{
    public function persist(object $data): void;

    public function find(string $id): ?object;
}
