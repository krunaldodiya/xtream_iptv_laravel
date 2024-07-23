<?php

namespace App\Providers;

use App\Repositories\PaymentTransactionRepository;
use App\Repositories\PaymentTransactionRepositoryInterface;

use App\Repositories\ChannelRepository;
use App\Repositories\ChannelRepositoryInterface;

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
        app()->bind(ChannelRepositoryInterface::class, ChannelRepository::class);
    }
}
