<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleFacebookCallback()
    {
        $remember_token = Str::random(64);

        $google2fa = app('pragmarx.google2fa');

        try {

            $user = Socialite::driver('facebook')->user();

            $finduser = User::where('google_id', $user->id)
                ->orWhere('email', $user->email)
                ->first();

            if ($finduser) {
                Auth::login($finduser);
                return redirect('login');

            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => USER_ROLE_CUSTOMER,
                    'tenant_id' => getTenantId(),
                    'facebook_id' => $user->id,
                    'password' => Hash::make($user->email . $user->id),
                    'remember_token' => $remember_token,
                    'google2fa_secret' => $google2fa->generateSecretKey(),
                    'ref_code' => random_strings(10),
                    'email_verification_status' => 1,
                ]);

                Auth::login($newUser);
                return redirect('login');
            }

        } catch (Exception $e) {
            Log::info("Google Login Error: " . $e->getMessage());
            return redirect(route('login'))->with('error', __(SOMETHING_WENT_WRONG));
        }
    }
}
