<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function googleAuth()
    {
        return Socialite::driver('google')->redirect();
    }
    public function googleAuthCallback()
    {
        $googleUser = Socialite::driver('google')->user();
        $user = User::where("id_google", $googleUser->getId())->orWhere("email", $googleUser->getEmail())->first();

        if (!$user) {
            $newUser =    User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
            ]);
            Auth::login($newUser);
        } else {
            Auth::login($user);
        }
        request()->session()->put('2fa_verified', true);

        return redirect()->intended("dashboard");
    }
    public function facebookAuth()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function facebookAuthCallback()
    {
        $facebookUser = Socialite::driver('facebook')->user();
        $user = User::where("id_facebook", $facebookUser->getId())->orWhere("email", $facebookUser->getEmail())->first();

        if (!$user) {
            $newUser =    User::create([
                'name' => $facebookUser->getName(),
                'email' => $facebookUser->getEmail(),
            ]);
            Auth::login($newUser);
        } else {
            Auth::login($user);
        }
        request()->session()->put('2fa_verified', true);

        return redirect()->intended("dashboard");
    }
}
