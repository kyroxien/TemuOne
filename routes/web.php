<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

use App\Http\Controllers\SuperAdminDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\Auth\EmailVerificationController;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::middleware(['auth'])->group(function () {
    Route::get('/verify-email', [EmailVerificationController::class, 'show'])
        ->name('email.verify');

    Route::post('/verify-email', [EmailVerificationController::class, 'verify'])
        ->name('email.verify.code');

    Route::post('/verify-email/resend', [EmailVerificationController::class, 'resend'])
        ->name('email.verify.resend');

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});


Route::middleware(['auth', 'email.verified.custom'])->group(function () {

    Route::middleware(['role:super-admin'])->group(function () {
        Route::get('/super-admin/dashboard', [SuperAdminDashboardController::class, 'index'])->name('superadmin.dashboard');
        // Managed blocked user
        Route::get('/super-admin/blocked-users', [SuperAdminDashboardController::class, 'blockedUsers'])
            ->name('superadmin.blocked-users');
        Route::post('/super-admin/unblock-user/{user}', [SuperAdminDashboardController::class, 'unblockUser'])
            ->middleware(['auth','role:super-admin'])
            ->name('superadmin.unblock-user');
        // Update role user
        Route::get('/super-admin/manage-roles', [SuperAdminDashboardController::class, 'manageRoles'])
            ->name('superadmin.manage-roles');
        Route::post('/super-admin/update-role/{user}', [SuperAdminDashboardController::class, 'updateRole'])
            ->name('superadmin.update-role');
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    });

    Route::middleware(['role:user'])->group(function () {
        Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    });

});
