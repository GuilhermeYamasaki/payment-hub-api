<?php

namespace App\Repositories\Interfaces;

interface DebtRepositoryInterface
{
    public function create(object $data): void;

    public function update(string $id, object $data): void;

    public function find(string $id): ?object;
}
