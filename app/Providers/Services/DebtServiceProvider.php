<?php

namespace App\Providers\Services;

use App\Services\DebtService;
use App\Services\Interfaces\DebtServiceInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class DebtServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DebtServiceInterface::class, DebtService::class);
    }

    /**
     * @return string[]
     */
    public function provides()
    {
        return [
            DebtServiceInterface::class,
        ];
    }
}
