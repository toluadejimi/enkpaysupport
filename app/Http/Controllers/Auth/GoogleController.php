<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\UserService;
use App\Http\Services\UserWalletService;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        $remember_token = Str::random(64);

        $google2fa = app('pragmarx.google2fa');

        try {

            $user = Socialite::driver('google')->user();
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
                    'google_id' => $user->id,
                    'password' => Hash::make($user->email . $user->id),
                    'remember_token' => $remember_token,
                    'google2fa_secret' => $google2fa->generateSecretKey(),
                    'email_verification_status' => 1,
                ]);
                Auth::login($newUser);
                return redirect('login');
            }

        } catch (Exception $e) {
//           return redirect(route('login'))->with('error', $e->getMessage());
            Log::info("Google Login Error: " . $e->getMessage());
            return redirect(route('login'))->with('error', __(SOMETHING_WENT_WRONG));
        }
    }
}
