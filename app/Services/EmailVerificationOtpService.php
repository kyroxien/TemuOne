<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmailCodeMail;

class EmailVerificationOtpService
{
    public const EXPIRATION_MINUTES = 60;

    public function send(User $user): int
    {
        $code = random_int(100000, 999999);

        $user->forceFill([
            'email_verification_code' => Hash::make($code),
            'email_verification_expires_at' => now()->addMinutes(self::EXPIRATION_MINUTES),
        ])->save();

        Mail::to($user->email)->send(
            new VerifyEmailCodeMail($code, self::EXPIRATION_MINUTES)
        );

        return $code;
    }
}
