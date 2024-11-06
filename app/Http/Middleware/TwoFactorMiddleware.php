<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->two_factor_enabled) {
            // Cek jika pengguna telah melewati proses 2FA
            if (!$request->session()->has('2fa_verified')) {
                return redirect()->route('2fa.verify'); // Ganti dengan rute yang sesuai
            }
        }

        return $next($request);
    }
}
