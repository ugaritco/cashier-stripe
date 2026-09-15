<?php

namespace App\Providers;

use App\Models\User;
use Heritage\Support\ServiceProvider;
use Ugarit\Cashier\Cashier;

class WorkbenchServiceProvider extends ServiceProvider
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
        Cashier::useCustomerModel(User::class);
    }
}
