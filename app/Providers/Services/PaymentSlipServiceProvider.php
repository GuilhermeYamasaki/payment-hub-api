<?php

namespace App\Providers\Services;

use App\Services\Interfaces\PaymentSlipServiceInterface;
use App\Services\PaymentSlipService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class PaymentSlipServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentSlipServiceInterface::class, PaymentSlipService::class);
    }

    /**
     * @return string[]
     */
    public function provides()
    {
        return [
            PaymentSlipServiceInterface::class,
        ];
    }
}
