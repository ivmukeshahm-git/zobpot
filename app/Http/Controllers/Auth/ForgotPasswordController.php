<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Helpers\SmsHelper;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function forget_password()
    {
        return view('website.auth.forget-password');
    }

    // Step 2: Send OTP
public function submitForgetPasswordForm(Request $request)
{
    $request->validate([
        'phone' => 'required|digits:10|exists:users,contact_no'
    ]);

    $user = User::where('contact_no', $request->phone)->first();

    $otp = rand(100000, 999999);

    Cache::put('forgot_otp_'.$user->id, $otp, now()->addMinutes(5));

    // SEND OTP WITH SAME SYSTEM LIKE REGISTRATION
    SmsHelper::sendOtp($user->contact_no, $otp, $user->name);

    return response()->json([
        'status' => 1,
        'message' => "OTP sent successfully",
        'user_id' => $user->id
    ]);
}



    // Step 3: Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'otp' => 'required|digits:6'
        ]);

        $cacheKey = 'forgot_otp_'.$request->user_id;
        $savedOtp = Cache::get($cacheKey);

        if(!$savedOtp){
            return response()->json([
                'status' => 0,
                'message' => "OTP expired or not found"
            ]);
        }

        if($savedOtp != $request->otp){
            return response()->json([
                'status' => 0,
                'message' => "Invalid OTP"
            ]);
        }

        return response()->json([
            'status' => 1,
            'message' => "OTP verified successfully"
        ]);
    }

    // Step 4: Reset Password
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'password' => 'required|min:6|confirmed'
        ]);

        User::where('id', $request->user_id)
            ->update(['password' => Hash::make($request->password)]);

        Cache::forget('forgot_otp_'.$request->user_id);

        return response()->json([
            'status' => 1,
            'message' => "Password reset successful"
        ]);
    }

    // Resend OTP
    public function resendOtp(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::find($request->user_id);

        $otp = rand(100000, 999999);

        Cache::put('forgot_otp_'.$user->id, $otp, now()->addMinutes(5));

        SmsHelper::sendOtp($user->contact_no, $otp, $user->name);


        return response()->json([
            'status' => 1,
            'message' => "OTP sent again"
        ]);
    }
}
