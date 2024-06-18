<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileRequest;
use App\Models\Category;
use App\Models\FileManager;
use App\Models\Notification;
use App\Models\NotificationSeen;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class   NotificationController extends Controller
{
    public function notificationView($id)
    {
        $data['pageTitle'] = 'Notification View';
        $data['singleNotification'] = Notification::find($id);

        if($data['singleNotification'] !=null){
            $dataArray = [
                'user_id'=> $data['singleNotification']->user_id,
                'notification_id'=> $data['singleNotification']->id,
            ];
            NotificationSeen::firstOrCreate($dataArray);
        }

        return view('customer.notification.view', $data);
    }
    public function notificationDelete($id)
    {
        DB::beginTransaction();
        try {
            $data= Notification::where('id', $id)->firstOrFail();
            if (!$data && $data == null) {
                return $this->error([], SOMETHING_WENT_WRONG);
            }
            $data->delete();
            DB::commit();
            return redirect()->back()->with('success', DELETED_SUCCESSFULLY);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', SOMETHING_WENT_WRONG);
        }
    }

    public function allNotification(){
        $data['pageTitle'] = 'All Notification';
        return view('customer.notification.all', $data);
    }
    public function notificationMarkAsRead(){
        DB::beginTransaction();
        try {
            foreach (userNotification('unseen') as $item){
                $dataArray = [
                    'user_id'=> $item->user_id,
                    'notification_id'=> $item->id,
                ];
                NotificationSeen::firstOrCreate($dataArray);
            }
            DB::commit();
            return redirect()->back()->with('success', UPDATED_SUCCESSFULLY);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('error', SOMETHING_WENT_WRONG);

        }

    }
}
