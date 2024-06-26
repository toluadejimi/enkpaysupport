<?php

namespace App\Http\Services;

use App\Http\Services\Sms\TwilioService;
use App\Models\FileManager;
use App\Models\User;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Stancl\Tenancy\Database\Models\Domain;

class UserService
{
    use ResponseTrait;

    public $smsService;

    public function __construct()
    {
        $this->smsService = new TwilioService();
    }

    public function userDetails($id)
    {
        return User::find($id);
    }
    public function userDomain($id)
    {
        return Domain::where('tenant_id',$id)->first();
    }



    public function userData()
    {
        return User::where('id', auth()->id())->first();
    }

    public function smsSend($request)
    {
        try {
            $user = User::where('id', auth()->id())->first();
            //check already send otp and this validate
            $currentDateTime = Carbon::now()->format('Y-m-d H:i:s');
            if ($user->otp_expiry && $currentDateTime < $user->otp_expiry) {
                return $this->error([], __("An otp has already been sent to your phone number."));
            }
            //send new otp
            $phoneNumber = trim($request->get('phone_no'));
            $otp = rand(111111, 999999);
            $smsText = __("Your") . " " . getOption('app_name') . " " . __("verification code is") . ": " . $otp;
            $sendSmsStatus = TwilioService::sendSms($phoneNumber, $otp, $smsText);
            if ($sendSmsStatus == true) {
                $dateTime = Carbon::now()->addMinute(5);
                $expiryTime = $dateTime->format('Y-m-d H:i:s');
                //save otp and expiry time in user table
                $user->otp = $otp;
                $user->otp_expiry = $expiryTime;
                $user->mobile = $phoneNumber;
                $user->save();
                return $this->success([], __("OTP has been sent to your phone number,please check"));
            } else {
                return $this->error([], __("Something went wrong,please check your credentials"));
            }

        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }

    }

    public function smsReSend()
    {

        try {
            $user = User::where('id', auth()->id())->first();
            //check already send otp and this validate
            $currentDateTime = Carbon::now()->format('Y-m-d H:i:s');
            if ($user->otp_expiry && $currentDateTime < $user->otp_expiry) {
                return $this->error([], __("An otp has already been sent to your phone number."));
            }
            //send new otp
            $phoneNumber = $user->mobile;
            $otp = rand(111111, 999999);
            $smsText = __("Your") . " " . getOption('app_name') . " " . __("verification code is") . ": " . $otp;
            $sendSmsStatus = TwilioService::sendSms($phoneNumber, $otp, $smsText);
            if ($sendSmsStatus == true) {
                $dateTime = Carbon::now()->addMinute(5);
                $expiryTime = $dateTime->format('Y-m-d H:i:s');
                //save otp and expiry time in user table
                $user->otp = $otp;
                $user->otp_expiry = $expiryTime;
                $user->save();
                return $this->success([], __("OTP has been re-sent to your phone number,please check"));

            } else {
                return $this->error([], __("Something went wrong,please check your phone number"));
            }


        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }

    }

    public function smsVerify($request)
    {

        $otp = $request->opt_field[0] . $request->opt_field[1] . $request->opt_field[2] . $request->opt_field[3] . $request->opt_field[4] . $request->opt_field[5];
        $user = User::where('id', auth()->id())->first();
        //check otp validity
        $currentDateTime = Carbon::now()->format('Y-m-d H:i:s');
        if ($user->otp_expiry && $currentDateTime < $user->otp_expiry) {
            if ($user->otp == $otp) {
                $user->phone_verification_status = 1;
                $user->save();
                return $this->success([], __("OTP verify successful"));
            } else {
                return $this->error([], __("OTP is Invalid!"));
            }
        } else {
            return $this->error([], __("OTP time expiry!"));
        }

    }
    public function profileUpdate(Request $request)
    {
        $authId = auth()->id();
        $request->validate([
            'name' => 'required|max:191',
            'mobile' => 'required|bail|numeric|digits_between:10,14' . $authId,
            'country' => 'required',
            'gender' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $user = User::find($authId);
            $user->name = $request->name;
            $user->mobile = $request->mobile;
            $user->gender = $request->gender;
            $user->city = $request->city;
            $user->state = $request->state;
            $user->dob = $request->dob;
            $user->zip = $request->zip;
            $user->country = $request->country;

            if ($request->hasFile('image')) {
                $uploadedImage = $request->file('image');
                $new_file = new FileManager();
                $uploaded = $new_file->upload('userImage', $uploadedImage, '', '');
                $user->image = $uploaded->id;
            }
            $user->save();
            DB::commit();
            return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }
    public function changePasswordUpdate(Request $request)
    {

        $request->validate([
            'current_password' => 'required',
            'password' => 'bail|required|min:6|confirmed',
        ]);

        try {
            $hashedPassword = Auth::user()->password;

            if (Hash::check($request->current_password, $hashedPassword)) {
                DB::beginTransaction();
                $user = User::find(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();
                DB::commit();
                return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
            } else {
                return $this->error([], "Current password dose not match!");
            }
        }catch (Exception $e){
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }

    }
}
