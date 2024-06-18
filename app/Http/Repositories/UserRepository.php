<?php

namespace App\Http\Repositories;


use App\Models\User;
use App\Models\UserActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    /**
     * @param Request $request
     * @return User created using $request
     */
    public function create(Request $request)
    {
        $user = [
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'first_name' => $request->get('first_name') ? $request->get('first_name') : '',
            'last_name' => $request->get('last_name') ? $request->get('last_name') : '',
            'log_code' => Hash::make($request->get('email') . uniqid() . randomString(5)),
            'verification_code' => Hash::make($request->get('email') . uniqid() . randomString(5)),
            'mobile_verification_code' => mt_rand(100000, 999999),
            'role' => $request->get('role', 2),
            'level' => $request->get('level', 1),
        ];

        return User::create($user);
    }

    /**
     * @return User having role = 2
     */
    public function getUsers()
    {
        $data = User::where(['role' => 2,'is_admin'=>0]);
        return $data;
    }

    public function getAdmins()
    {
        $data = User::where(['is_admin'=>1])->get();
        return $data;
    }

    /**
     * @param $id
     * @return User having user_id = $id
     */
    public function find($id)
    {
        $data = User::find($id);
        return $data;
    }

    /**
     * @param $userId
     * @return UserActivityLog of $userId
     */
    public function getActivityLog($userId)
    {
        $query = UserActivityLog::where(['user_id' => $userId]);
        return $query;
    }

    /**
     * @param $data
     * @return UserSuspensionReason created with $data
     */
    public function userSuspensionReasonAdd($data)
    {
        return UserSuspensionReason::create($data);
    }

    /**
     * @param $user_id
     * Deletes suspension reasons for $user_id and
     * @return int 1
     */
    public function userSuspensionReasonDelete($user_id)
    {
        UserSuspensionReason::where(['user_id' => $user_id])->delete();
        return 1;
    }

    /**
     * @param $data
     * @return UserInformation by updating or creating it
     */
    public function updateAvatar($data){
        return UserInformation::updateOrCreate(['user_id'=>$data['user_id']],['user_id'=>$data['user_id'],'avatar'=>$data['avatar']]);
    }

    /**
     * @param $data
     * @return UserInformation updated according to $data
     */
    public function updateUserInfo($data)
    {
        return UserInformation::updateOrCreate(['user_id' => $data['user_id']], $data);
    }


    /**
     * @return User whose id verification is pending
     */
    public function getPendingIdVerificationUsers()
    {
        $data = User::where('passport_verification_status', 2)
            ->orWhere('national_id_verification_status', 2)
            ->orWhere('bank_statement_verification_status', 2)
            ->orWhere('phone_bill_verification_status', 2)
            ->orWhere('electricity_bill_verification_status', 2)
            ->orWhere('driving_license_verification_status', 2);
        return $data;
    }

    /**
     * @return User whose any one of the id is verified
     */
    public function getVerifiedUsers()
    {
        $data = User::where('total_verified_ids', '>', 0)
            ->orWhere('total_verified_utility_bills', '>', 0)
            ->orWhere('total_verified_banks', '>', 0);
        return $data;
    }
}
