<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PragmaRX\Google2FAQRCode\Google2FA;
use App\Models\User;
use Illuminate\Routing\Controller as BaseController;

class TwoFactorController extends BaseController
{
    /**
     * The Google2FA service instance.
     *
     * @var Google2FA
     */
    protected Google2FA $google2fa;

    public function __construct()
    {
        // ✅ Proper middleware declaration
        $this->middleware('auth');

        $this->google2fa = new Google2FA();
    }

    public function showSetupForm()
    {
        /** @var User $user */
        $user   = Auth::user();
        $secret = $this->google2fa->generateSecretKey();
        Session::put('2fa_secret', $secret);

        $QR_Image = $this->google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $secret
        );

        return view('2fa.setup', compact('QR_Image', 'secret'));
    }

    public function enable2FA(Request $request)
    {
        $request->validate([
            'secret' => 'required|string',
            'otp'    => 'required|digits:6',
        ]);

        $valid = $this->google2fa->verifyKey($request->secret, $request->otp);

        if ($valid) {
            /** @var User $user */
            $user = Auth::user();
            $user->google2fa_secret = $request->secret;
            $user->save();

            return redirect('/')->with('success', '2FA enabled.');
        }

        return back()->withErrors(['otp' => 'Invalid OTP code.']);
    }

    public function showVerifyForm()
    {
        return view('2fa.verify');
    }

    public function verify2FA(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        /** @var User $user */
        $user  = Auth::user();
        $valid = $this->google2fa->verifyKey($user->google2fa_secret, $request->otp);

        if ($valid) {
            Session::put('2fa_verified', true);
            return redirect('/');
        }

        return back()->withErrors(['otp' => 'Invalid code.']);
    }
}
