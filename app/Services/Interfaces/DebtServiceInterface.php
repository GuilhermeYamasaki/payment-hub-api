<?php

namespace App\Services\Interfaces;

interface DebtServiceInterface
{
    public function recordGenerateSlip(string $id): void;

    public function recordNotify(string $id): void;

    public function find(string $id): ?object;
}
