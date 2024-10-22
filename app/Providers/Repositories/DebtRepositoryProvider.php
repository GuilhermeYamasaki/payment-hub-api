<?php

namespace App\Providers\Repositories;

use App\Repositories\DebtRepository;
use App\Repositories\Interfaces\DebtRepositoryInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class DebtRepositoryProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DebtRepositoryInterface::class, DebtRepository::class);
    }

    /**
     * @return string[]
     */
    public function provides()
    {
        return [
            DebtRepositoryInterface::class,
        ];
    }
}
