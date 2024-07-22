<?php

namespace App\Providers;

use App\Repositories\GithubRepository;
use App\Repositories\GithubRepositoryInterface;
use App\Repositories\PaymentTransactionRepository;
use App\Repositories\PaymentTransactionRepositoryInterface;
use App\Repositories\TradingCalendarRepository;
use App\Repositories\TradingCalendarRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        app()->bind(PaymentTransactionRepositoryInterface::class, PaymentTransactionRepository::class);
        app()->bind(TradingCalendarRepositoryInterface::class, TradingCalendarRepository::class);
        app()->bind(GithubRepositoryInterface::class, GithubRepository::class);
    }
}
