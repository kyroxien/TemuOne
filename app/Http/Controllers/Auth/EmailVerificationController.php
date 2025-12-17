<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmailCodeMail;
use App\Models\User;

class EmailVerificationController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        if ($user->email_verified_at) {
            return $this->redirectToDashboard($user);
        }

        return view('livewire.auth.verify-email-challenge');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $user = $request->user();

        if ($user->email_verified_at) {
            return $this->redirectToDashboard($user);
        }

        if ($this->otpExpired($user)) {
            return back()->withErrors([
                'code' => __('Verification code has expired. Please request a new one.'),
            ]);
        }

        if (! Hash::check($request->code, $user->email_verification_code)) {
            return back()->withErrors([
                'code' => __('The verification code is invalid.'),
            ]);
        }

        $this->markEmailAsVerified($user);

        return $this->redirectToDashboard($user);
    }

    public function resend(Request $request)
    {
        $user = $request->user();

        if ($user->email_verified_at) {
            return $this->redirectToDashboard($user);
        }

        $this->sendNewOtp($user);

        return back()->with(
            'status',
            __('A new verification code has been sent to your email.')
        );
    }

    private function redirectToDashboard(User $user)
    {
        return match (true) {
            $user->hasRole('super-admin') => redirect('/super-admin/dashboard'),
            $user->hasRole('admin')       => redirect('/admin/dashboard'),
            default                       => redirect('/user/dashboard'),
        };
    }

    private function otpExpired(User $user): bool
    {
        return
            ! $user->email_verification_code ||
            ! $user->email_verification_expires_at ||
            now()->greaterThan($user->email_verification_expires_at);
    }

    private function markEmailAsVerified(User $user): void
    {
        $user->forceFill([
            'email_verified_at' => now(),
            'email_verification_code' => null,
            'email_verification_expires_at' => null,
        ])->save();
    }

    private function sendNewOtp(User $user): void
    {
        $code = random_int(100000, 999999);

        $user->update([
            'email_verification_code' => Hash::make($code),
            'email_verification_expires_at' => now()->addMinutes(15),
        ]);

        Mail::to($user->email)->send(
            new VerifyEmailCodeMail($code)
        );
    }
}
