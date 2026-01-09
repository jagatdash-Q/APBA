<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerPasswordReset;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
class CustomerAuthController extends Controller
{
    public function __construct()
    {
        Auth::setDefaultDriver('customer');
        config(['auth.defaults.passwords' => 'customers']);
    }


    public function logoutCustomer(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function validateCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $is_customer_exist = Customer::where('email',$request->email)->first();
        if($is_customer_exist==null){
            return redirect()->route('frontend.home')->with('errorMessage', 'Invalid email');
        }else{
            if ($is_customer_exist->is_verify_email=='0') {
                return redirect()->route('frontend.home')->with('errorMessage', 'Please verify your email first');
            }
            if ($is_customer_exist->password=='') {
                return redirect()->route('frontend.home')->with('errorMessage', 'Your password has been expired please reset your password');
            } elseif (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('customer.home');
            } else {
                return redirect()->route('frontend.home')->with('errorMessage', 'Incorrect credentials');
            }
        }
    }


    public function sendResetPasswordLink(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if customer exist to send password reset link
        $is_customer_exist = Customer::where('email',$request->email)->first();
        if($is_customer_exist==null){
            return redirect()->back()->with('errorMessage', 'Invalid email');
        }else{
            try {
                $token = Str::uuid()->toString();
                CustomerPasswordReset::create([
                    'customer_id' => $is_customer_exist->id,
                    'customer_email' => $is_customer_exist->email,
                    'password_reset_token' => $token,
                    'password_reset_link_sent_on' => now(),
                ]);

                $details = [
                    'name' => $is_customer_exist->first_name . ' ' . $is_customer_exist->last_name,
                    'mail' => $is_customer_exist->email,
                    'reset_link' =>  url('customer/account/reset/password?token=' . $token),
                ];
                Mail::to($request->email)->send(new \App\Mail\CustomerPasswordResetMail($details));
                return redirect('/')->with('doneMessage', 'Please check your mail for password reset link');
            } catch (Exception $e) {
                Log::info('Error in sending password reset email :-'.$e->getMessage());
                return redirect('/')->with('errorMessage', 'Unable to send password reset link,Please contact our technical team');
            }
        }

    }

    

}
