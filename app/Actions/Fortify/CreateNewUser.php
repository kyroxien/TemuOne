<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use App\Mail\VerifyEmailCodeMail;


class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::where('email', $input['email'])->first();

        // 1. Jika email sudah ada & akun diblokir
        if ($user && $user->is_blocked) {
            throw ValidationException::withMessages([
                'email' => __('This account has been blocked.'),
            ]);
        }

        // 2. Reclaim akun pending (belum verify)
        if ($user && is_null($user->email_verified_at)) {
            $user->update([
                'name' => $input['name'],
                'password' => Hash::make($input['password']),
            ]);
        }

        // 3. Email sudah dipakai & aktif
        if ($user && ! is_null($user->email_verified_at)) {
            throw ValidationException::withMessages([
                'email' => __('Email already registered.'),
            ]);
        }

        // 4. User baru
        if (! $user) {
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);
        }

        // 5. Berikan role default
        $user->assignRole('user');

        // 6. Generate OTP Email
        $code = random_int(100000, 999999);
        $user->update([
            'email_verification_code' => Hash::make($code),
            'email_verification_expires_at' => now()->addMinutes(60),
        ]);

        // 6. Kirim email
        Mail::to($user->email)->send(
            new VerifyEmailCodeMail($code)
        );

        // 3. Return user
        return $user;
    }
}
