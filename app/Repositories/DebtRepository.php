<?php

namespace App\Repositories;

use App\Models\Debt;
use App\Repositories\Interfaces\DebtRepositoryInterface;

class DebtRepository implements DebtRepositoryInterface
{
    public function __construct(
        private readonly Debt $model
    ) {}

    public function insert(array $debts): void
    {
        $this->model->insertOrIgnore($debts);
    }

    public function update(string $id, array $data): void
    {
        $this->model->where('id', $id)->update($data);
    }

    public function find(string $id): ?object
    {
        return $this->model->find($id);
    }
}
