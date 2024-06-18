<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use http\Env\Request;

class NotificationController extends Controller
{
    public function details($id)
    {
        $data = Notification::where('id', $id)->first();
        $data->update(['view_status' => STATUS_ACTIVE]);
        return view('user.notification', compact('data'));
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())->update(['view_status' => STATUS_ACTIVE]);
        return back()->with('success', __('Successfully read all the notification'));
    }

    public function notificationSeen(Request $request)
    {
        return redirect()->back()->with('success', __('Login Successfully'));
    }
}
