<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {

        $user = $request->user();

        // Generate secret key
        $google2fa = app('pragmarx.google2fa');
        // $user->google2fa_secret = $google2fa->generateSecretKey();
        // $user->save();
        $secret = $user->google2fa_secret ?? $google2fa->generateSecretKey();
        // Generate QR Code URL
        $QRCodeUrl = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            // $user->google2fa_secret
            $secret
        );

        return view('profile.edit', [
            'user' => $request->user(),
            "secret" => $secret,
            "QRCodeUrl" => $QRCodeUrl
        ]);;
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
