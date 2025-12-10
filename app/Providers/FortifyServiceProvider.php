<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse; 
use Laravel\Fortify\Contracts\RegisterResponse; 
use Laravel\Fortify\Contracts\TwoFactorLoginResponse;


class FortifyServiceProvider extends ServiceProvider
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
        $this->configureActions();
        $this->configureViews();
        $this->configureRateLimiting();

        Fortify::authenticateUsing(function (Request $request) {
            $user = \App\Models\User::where('email', $request->email)->first();

            // Jika user tidak ditemukan → salah login seperti biasa
            if (! $user) {
                return null;
            }

            // Jika user sudah diblokir
            if ($user->is_blocked) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    Fortify::username() => 'Akun Anda diblokir karena terlalu banyak percobaan login.',
                ]);
            }

            // Jika password benar → reset failed_attempts
            if (\Hash::check($request->password, $user->password)) {
                $user->failed_attempts = 0;
                $user->save();
                return $user;
            }

            // Jika password salah → increment failed attempts
            $user->failed_attempts += 1;

            // Jika gagal 4 kali → blokir
            if ($user->failed_attempts >= 4) {
                $user->is_blocked = true;
            }

            $user->save();

            return null; // tetap gagal login
        });

        $this->app->singleton(LoginResponse::class, function () {
            return new class implements LoginResponse {
                public function toResponse($request)
                {
                    $user = $request->user();

                    if ($user->hasRole('super-admin')) {
                        return redirect('/super-admin/dashboard');
                    }

                    if ($user->hasRole('admin')) {
                        return redirect('/admin/dashboard');
                    }

                    return redirect('/user/dashboard');
                }
            };
        });

        $this->app->singleton(RegisterResponse::class, function () {
            return new class implements RegisterResponse {
                public function toResponse($request)
                {
                    $user = $request->user();

                    if ($user->hasRole('super-admin')) {
                        return redirect('/super-admin/dashboard');
                    }

                    if ($user->hasRole('admin')) {
                        return redirect('/admin/dashboard');
                    }

                    return redirect('/user/dashboard');
                }
            };
        });

        $this->app->singleton(TwoFactorLoginResponse::class, function () {
            return new class implements TwoFactorLoginResponse {
                public function toResponse($request)
                {
                    $user = $request->user();

                    if ($user->hasRole('super-admin')) {
                        return redirect('/super-admin/dashboard');
                    }

                    if ($user->hasRole('admin')) {
                        return redirect('/admin/dashboard');
                    }

                    return redirect('/user/dashboard');
                }
            };
        });
    }

    /**
     * Configure Fortify actions.
     */
    private function configureActions(): void
    {
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::createUsersUsing(CreateNewUser::class);
    }

    /**
     * Configure Fortify views.
     */
    private function configureViews(): void
    {
        Fortify::loginView(fn () => view('livewire.auth.login'));
        Fortify::verifyEmailView(fn () => view('livewire.auth.verify-email'));
        Fortify::twoFactorChallengeView(fn () => view('livewire.auth.two-factor-challenge'));
        Fortify::confirmPasswordView(fn () => view('livewire.auth.confirm-password'));
        Fortify::registerView(fn () => view('livewire.auth.register'));
        Fortify::resetPasswordView(fn () => view('livewire.auth.reset-password'));
        Fortify::requestPasswordResetLinkView(fn () => view('livewire.auth.forgot-password'));
    }

    /**
     * Configure rate limiting.
     */
    private function configureRateLimiting(): void
    {
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });
    }
}
