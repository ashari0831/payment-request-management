<?php

namespace App\Providers;

use App\Interfaces\BankRepositoryInterface;
use App\Interfaces\PaymentRequestRepositoryInterface;
use App\Repositories\BankRepository;
use App\Repositories\PaymentRequestRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentRequestRepositoryInterface::class, PaymentRequestRepository::class);
        $this->app->bind(BankRepositoryInterface::class, BankRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
