<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && is_null($user->email_verified_at)) {

            // Izinkan halaman verifikasi & resend
            if (
                $request->routeIs('email.verify') ||
                $request->routeIs('email.verify.code') ||
                $request->routeIs('email.verify.resend')
            ) {
                return $next($request);
            }

            return redirect()->route('email.verify');
        }

        return $next($request);
    }
}