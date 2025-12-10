<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

use Illuminate\Auth\Middleware\RedirectIfAuthenticated;

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
        Route::aliasMiddleware('role', RoleMiddleware::class);
        Route::aliasMiddleware('permission', PermissionMiddleware::class);
        Route::aliasMiddleware('role_or_permission', RoleOrPermissionMiddleware::class);

        RedirectIfAuthenticated::redirectUsing(function () {
            $user = auth()->user();

            if (!$user) {
                return '/'; // fallback untuk guest
            }

            if ($user->hasRole('super-admin')) {
                return route('superadmin.dashboard');
            }

            if ($user->hasRole('admin')) {
                return route('admin.dashboard');
            }

            return route('user.dashboard');
        });
    }
}
