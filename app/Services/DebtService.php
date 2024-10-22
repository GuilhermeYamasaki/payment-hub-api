<?php

namespace App\Services;

use App\Repositories\Interfaces\DebtRepositoryInterface;
use App\Services\Interfaces\DebtServiceInterface;

class DebtService implements DebtServiceInterface
{
    public function __construct(
        private readonly DebtRepositoryInterface $debtRepository
    ) {}

    public function persist(object $data): void
    {
        $debtId = data_get($data, 'id');

        if (! $this->find($debtId)) {
            $this->debtRepository->create($data);
        }

        $this->debtRepository->update($debtId, $data);
    }

    public function find(string $id): ?object
    {
        return $this->debtRepository->find($id);
    }
}
