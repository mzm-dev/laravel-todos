<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
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

        // Abaikan semua permission jika dalam mod penyenggaraan
        Gate::before(function ($user, $ability) {

            return true;

            // Contoh lain: jika user adalah super admin
            if ($user->hasRole('Super Admin')) {
                return true;
            }
        });
    }
}
