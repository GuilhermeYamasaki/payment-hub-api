<?php

namespace App\Services;

use App\Repositories\Interfaces\DebtRepositoryInterface;
use App\Services\Interfaces\DebtServiceInterface;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class DebtService implements DebtServiceInterface
{
    public function __construct(
        private readonly DebtRepositoryInterface $debtRepository
    ) {}

    /**
     * {@inheritDoc}
     */
    public function recordGenerateSlip(string $id): void
    {
        $this->find($id, true);

        $this->debtRepository->update($id, [
            'generate_slip_at' => now(),
        ]);

        cache()->forget(
            __('cache.debt.id', ['id' => $id])
        );
    }

    /**
     * {@inheritDoc}
     */
    public function recordNotify(string $id): void
    {
        $debt = $this->find($id, true);

        $this->debtRepository->update($id, [
            'notify_at' => now(),
        ]);

        cache()->forget(
            __('cache.debt.id', ['id' => $id])
        );
    }

    /**
     * {@inheritDoc}
     */
    public function find(string $id, bool $findOrFail = false): ?object
    {
        return cache()->remember(
            __('cache.debt.id', ['id' => $id]),
            now()->addDay(),
            function () use ($id, $findOrFail) {
                $debt = $this->debtRepository->find($id);

                throw_if(
                    empty($debt) && $findOrFail,
                    NotFoundResourceException::class,
                );

                return $debt;
            }
        );
    }
}
