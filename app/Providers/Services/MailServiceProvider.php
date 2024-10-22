<?php

namespace App\Providers\Services;

use App\Services\Interfaces\MailServiceInterface;
use App\Services\MailService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MailServiceInterface::class, MailService::class);
    }

    /**
     * @return string[]
     */
    public function provides()
    {
        return [
            MailServiceInterface::class,
        ];
    }
}
