<?php

namespace App\Http\Middleware;

use App\Mail\EmailNotify;
use App\Mail\UserEmailVerification;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class IsVerifyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if (getOption('email_verification_status', 0) == 1 && $user->email_verification_status != true && !(in_array($request->route()->getName(), ['email.verify']))) {
            try {

                if (!($user->otp_expiry >= now())) {
                    if (is_null($user->verify_token)) {
                        $user->verify_token = str_replace('-', '', Str::uuid()->toString());
                    }
                    $user->otp = rand(1000, 9999);
                    $user->otp_expiry = now()->addMinute(5);
                    $user->save();
                    $customData = (object)[
                        'otp' => $user->otp
                    ];

                    $templeate = 'email-verification';
                    Mail::to(auth()->user()->email)->send(new EmailNotify($customData, $user, $templeate));
                } else {
                    return redirect()->route('email.verify', $user->verify_token)->with('success', __('Already send an email. Please wait a minutes to try another'));
                }
                return redirect()->route('email.verify', $user->verify_token)->with('error', __('Verify Your Account'));
            } catch (Exception $e) {
                return redirect()->route('email.verify', $user->verify_token)->with('error', $e->getMessage());
            }
        }
        return $next($request);
    }
}
