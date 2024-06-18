<?php

namespace App\Http\Controllers;

use App\Http\Services\UserEmailVerifyService;
use App\Mail\UserEmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserEmailVerifyController extends Controller
{
    public $userEmailVerifyService;

    public function __construct()
    {
        $this->userEmailVerifyService = new UserEmailVerifyService;
    }

    public function emailVerified(Request $request, $token)
    {
        $otp = $request->otp__field__1 . $request->otp__field__2 . $request->otp__field__3 . $request->otp__field__4;
        $verified =  $this->userEmailVerifyService->emailVerified($otp, $token);
        if ($verified == true) {
            return redirect()->route('login')->with('success', __('Congratulations! Successfully verified your email.'));
        } else {
            return redirect()->route('email.verify', $token)->with('error', __('Your otp doesn`t match or expired'));
        }
    }

    public function emailVerify($token)
    {
        $user = auth()->user();
        $now = now();
        $expiry_date = $user->otp_expiry;
        $interval = $now->diff($expiry_date);
        $minutes_difference = $interval->format('%i');
        return view('auth.verify', compact('token', 'user', 'minutes_difference'));
    }

    public function emailVerifyResend($token)
    {
        $user = $this->userEmailVerifyService->getUserByToken($token);

        if (getOption('email_verification_status', 0) == 1) {
            if ($user) {
                emailVerifyEmailNotify($user);
                return redirect()->route('login')->with('success', __(SENT_SUCCESSFULLY));
            }
        } else {
            return redirect()->route('login')->with('error', __(SOMETHING_WENT_WRONG));
        }
    }
}
