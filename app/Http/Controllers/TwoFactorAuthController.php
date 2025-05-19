<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorAuthController extends Controller
{
    public function verify2FA(Request $request)
    {
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');

        $isValid = $google2fa->verifyKey($user->google2fa_secret, $request->input('otp'));

        if ($isValid) {
            session(['2fa_verified' => true]);
            return redirect('/redirect-user');
        } else {
            return back()->withErrors(['otp' => 'Invalid authentication code']);
        }
    }

    public function show2FAForm()
    {
        return view('auth.2fa');
    }
}

