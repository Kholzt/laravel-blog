<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TwoFaktorController extends Controller
{
    public function twoFaktor(Request $request)
    {

        return view("auth.2FA");
    }
    public function enableTwoFactorAuthentication(Request $request)
    {
        $user = $request->user();
        $twoFaktorEnabled = !!$request->enabled;
        $google2fa_secret = $request->google2fa_secret;

        // Generate secret key
        $user->two_factor_enabled = $twoFaktorEnabled;
        $user->google2fa_secret = $google2fa_secret;
        $user->save();


        return Redirect::route('profile.edit')->with('status', 'Two-Faktor Updated');
    }


    public function verifyTwoFactorAuthentication(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required',
        ]);

        $user = $request->user();
        $google2fa = app('pragmarx.google2fa');

        if ($google2fa->verifyKey($user->google2fa_secret, $request->one_time_password)) {
            // Simpan status 2FA telah diverifikasi di session
            $request->session()->put('2fa_verified', true);
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['one_time_password' => 'Invalid verification code.']);
    }
}
