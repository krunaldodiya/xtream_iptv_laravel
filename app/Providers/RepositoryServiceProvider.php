<?php

namespace App\Providers;

use App\Repositories\PaymentTransactionRepository;
use App\Repositories\PaymentTransactionRepositoryInterface;

use App\Repositories\XtreamRepository;
use App\Repositories\XtreamRepositoryInterface;

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
        app()->bind(XtreamRepositoryInterface::class, XtreamRepository::class);
    }
}
