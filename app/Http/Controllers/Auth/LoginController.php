<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FAQRCode\Google2FA;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function redirectTo()
    {
        session()->flash('success', 'You are logged in!');
        return $this->redirectTo;
    }

    public function check_login(Request $request)
    {
        $secret = null;
        $QR_Image = null;

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->first();
        if ($user == null)
            return redirect()->back()->with('errorMessage', 'These credentials do not match our records.');
        if ($user && Hash::check($request->password, $user->password)) {
            $login_data = $request->all();
            if ($user['2fa_status'] == '0' && $user->google2fa_secret == null) {
                $google2fa = app('pragmarx.google2fa');
                $login_data["google2fa_secret"] = $google2fa->generateSecretKey();
                $twoFa = new Google2FA();
                $QR_Image = $twoFa->getQRCodeInline(
                    config('app.name'),
                    $login_data['email'],
                    $login_data['google2fa_secret']
                );
                $secret = $login_data['google2fa_secret'];
            } else {
                $login_data["google2fa_secret"] = $user->google2fa_secret;
            }
            $request->session()->flash('login_data', $login_data);
            return view('auth.google2fa', ['email' => $request->email, 'status' => $user['2fa_status'], 'QR_Image' => $QR_Image, 'secret' => $secret]);
        } else
            return redirect()->back()->with('errorMessage', 'These credentials do not match our records.');
    }

    public function validate_login(Request $request)
    {
        try {
            $userStoredSecretKey = null;
            $userEnteredCode = null;
            $userStoredSecretKey = session('login_data')['google2fa_secret'];
            if ($request->verify_2fa == '0') {
                $validator = Validator::make($request->all(), [
                    'verify_token' => ['required'],
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $userEnteredCode = $request->verify_token;
            } else {
                $userEnteredCode = $request->one . $request->two . $request->three . $request->four . $request->five . $request->six;
            }
            $google2fa = new Google2FA();
            $isValid = $google2fa->verifyKey($userStoredSecretKey, $userEnteredCode);
            if ($isValid) {
                if ($request->verify_2fa == '0') {
                    $user = User::where('email', session('login_data')['email'])->first();
                    $user->google2fa_secret = session('login_data')['google2fa_secret'];
                    $user['2fa_status'] = '1';
                    $user->save();
                }
                $request->merge(['email' => session('login_data')['email']]);
                $request->merge(['password' => session('login_data')['password']]);
                return $this->login($request);
            } else {
                return redirect()->route('login')->with('errorMessage', "The 'One Time Password' typed was wrong.");
            }
        } catch (\Throwable $th) {
            return redirect()->route('login')->with('errorMessage', "Something went wrong!");
        }
    }
}
