<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PDF;
use PragmaRX\Google2FAQRCode\Google2FA;

class GoogleAuthController extends Controller
{
    use ResponseTrait;

    public function verifyView()
    {
        return view('google2fa.index');
    }

    public function verify(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $status = (new Google2FA)->verifyKey($user->google2fa_secret, $request->one_time_password);
        if ($status == true) {
            Session::put('2fa_status', true);
            return redirect()->route('frontend')->with('success', __('Login Successfully'));
        } else {
            return redirect()->back()->with('error', __('Code dose not match'));
        }
    }

    public function enable(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $status = (new Google2FA)->verifyKey($user->google2fa_secret, $request->one_time_password);
        if ($status == true) {
            $user->google_auth_status = 1;
            $user->save();
            return $this->success([], __("Enabled Successfully"));
        } else {
            return $this->error([], __("Code dose not match!"));
        }
    }

    public function disable(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $status = (new Google2FA)->verifyKey($user->google2fa_secret, $request->one_time_password);
        if ($status == true) {
            $user->google_auth_status = 0;
            $user->save();
            return $this->success([], __("Disabled Successfully"));
        } else {
            return $this->error([], __("Code dose not match!"));
        }
    }

}
