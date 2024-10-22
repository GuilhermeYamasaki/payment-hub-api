<?php

namespace App\Providers\Services;

use App\Services\BillingService;
use App\Services\Interfaces\BillingServiceInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class BillingServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BillingServiceInterface::class, BillingService::class);
    }

    /**
     * @return string[]
     */
    public function provides()
    {
        return [
            BillingServiceInterface::class,
        ];
    }
}
