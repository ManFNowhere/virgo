<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Without a webhook secret, do not register Cashier's default webhook route
        if (! env('STRIPE_WEBHOOK_SECRET')) {
            Cashier::ignoreRoutes();
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Cashier::useCustomerModel(User::class);
    }
}
