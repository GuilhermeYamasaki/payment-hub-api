<?php

namespace App\Repositories;

use App\Models\Debt;
use App\Repositories\Interfaces\DebtRepositoryInterface;

class DebtRepository implements DebtRepositoryInterface
{
    public function __construct(
        private readonly Debt $model
    ) {}

    /**
     * {@inheritDoc}
     */
    public function insert(array $debts): void
    {
        $this->model->insertOrIgnore($debts);
    }

    /**
     * {@inheritDoc}
     */
    public function update(string $id, array $data): void
    {
        $this->model->where('id', $id)->update($data);
    }

    /**
     * {@inheritDoc}
     */
    public function find(string $id): ?object
    {
        return $this->model->find($id);
    }
}
