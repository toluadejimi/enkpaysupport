<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;
use App\Models\FileManager;
use App\Models\InstantMessage;
use App\Models\Setting;
use App\Models\User;
use App\Models\Ticket;
use App\Traits\ResponseTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Admin\InstantMessageRequest;
use App\Http\Services\ConversationService;

class InstantMessageController extends Controller
{
    use ResponseTrait;
    public $conversationService;
    public function __construct()
    {
        $this->conversationService  = new ConversationService;
    }
    public function instantMessage(InstantMessageRequest $request)
    {
       try {
            DB::beginTransaction();
            if (!is_null($request->id)){
                $obj = InstantMessage::find($request->id);
                $msg = __("Instant Message Update successfully!");
            }else{
                $obj = new InstantMessage();
                $msg = __("Instant Message Created successfully!");
            }
            $obj->title = $request->title;
            $obj->message = $request->message;
            $obj->status =  STATUS_ACTIVE;
            $obj->tenant_id =  auth()->user()->tenant_id;
            $obj->save();
           DB::commit();
           return redirect()->back()->with('success', $msg);
       }catch (\Exception $exception){
           DB::rollBack();
           return redirect()->back()->with('error', SOMETHING_WENT_WRONG);
       }
    }
    public function instantmessageDelete($id)
    {
        try {
            $data = InstantMessage::find($id);
            $data->delete();
            $message = getMessage(DELETED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (\Exception $e) {
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }
    public function instantmessageSearch(Request $request)
    {
        $data['searchData'] = InstantMessage::where('title', 'LIKE', '%' . $request['content'] . '%')->get();
        return view('agent.tickets.ticket_details.search-instant-message', $data)->render();
    }

}

