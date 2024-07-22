<?php

namespace App\Providers;

use App\Listeners\SetInitialPlan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Registered;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(env('APP_ENV') != 'production');

        Event::listen(Registered::class, SetInitialPlan::class);
    }
}
