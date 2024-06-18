<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileRequest;
use App\Models\FileManager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class   ProfileController extends Controller
{
    public function myProfile()
    {
        $data['pageTitle'] = 'Profile';
        $data['navAccountSettingActiveClass'] = 'mm-active';
        $data['subNavProfileActiveClass'] = 'mm-active';
        $data['timezones'] = getTimeZone();
        return view('customer.profile.index', $data);
    }

    public function changePassword()
    {
        $data['pageTitle'] = 'Change Password';
        $data['navAccountSettingActiveClass'] = 'mm-active';
        $data['subNavChangePasswordActiveClass'] = 'mm-active';
        return view('admin.profile.change-password', $data);
    }

    public function changePasswordUpdate(Request $request)
    {

        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = Auth::user();
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->back()->with('success', 'Updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Old and new password dose not match!');
        }
    }

    public function update(ProfileRequest $request)
    {

        $user = User::find(Auth::user()->id);
        /*File Manager Call upload*/
        if ($request->profile_image) {
            $new_file = FileManager::where('id', $user->image)->first();
            if ($new_file) {
                $new_file->removeFile();
                $upload = $new_file->upload('User', $request->profile_image, '', $new_file->id);
                $user->image = $upload->id;
            } else {
                $new_file = new FileManager();
                $upload = $new_file->upload('User', $request->profile_image);
                $user->image = $upload->id;
            }
        }
        /*End*/
        $user->name = $request->name;
//        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->username = $request->username;
        $user->app_timezone = $request->app_timezone;
        $user->save();
        return redirect()->back()->with('success', 'Profile has been updated');
    }
}
