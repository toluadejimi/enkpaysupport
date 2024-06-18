<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Currency;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    use ResponseTrait;


    public function announcement(Request $request)
    {
        $data['pageTitle'] = __('Announcement');
        $data['navAnnouncementActiveClass'] = 'mm-active';
        $data['announcementData'] = Announcement::where('created_by', auth()->id())->first();
        return view('admin.setting.announcement', $data);
    }


    public function announcementStore(Request $request){
        try {
            DB::beginTransaction();
                if($request->id != null){
                    User::where('tenant_id', auth()->user()->tenant_id)->update(['announcement_seen' => 0]);
                    $data = Announcement::find($request->id);
                    $msg = 'Update Successfully';
                }else{
                    $data = new Announcement();
                    $msg = 'Create Successfully';
                }
            $data->customer_announcement =  $request->customer_announcement;
            $data->tenant_id =  auth()->user()->tenant_id;
            $data->created_by = auth()->id();
            $data->save();
            DB::commit();
            return $this->success([], __($msg));
        }catch (\Exception $exception){
            DB::rollBack();
            return $this->error([], SOMETHING_WENT_WRONG);
        }
    }
}
