<?php

namespace App\Http\Services;

use App\Models\Conversation;
use App\Models\Category;
use App\Models\User;
use App\Models\Ticket;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendEmailGenericJob;
use App\Mail\SendMailGeneric;
use Illuminate\Support\Facades\Mail;
use App\Models\InstantMessage;
class ConversationService
{
    use ResponseTrait;

    public function getById($id)
    {
        return Ticket::findOrFail($id);
    }

    public function conversationStore($request)
    {
        try {
            DB::beginTransaction();
            $obj = new Conversation();
            $obj->ticket_id = session()->get('ticket_conversation_id');
            $obj->body = $request->conversation_details;
            $obj->created_by =  auth()->user()->id;
            $obj->status =  STATUS_ACTIVE;
            $obj->tenant_id =  auth()->user()->tenant_id;
            $obj->save();
            DB::commit();
            return "Conversation Created successfully!";
        } catch (Exception $e) {
            DB::rollBack();
            return  getMessage(SOMETHING_WENT_WRONG);
        }
    }
    public function getConversationData($ticketId){
       $conversionData =  Conversation::with('user','fileManager')->where(['ticket_id'=>$ticketId,'status'=>STATUS_ACTIVE])->orderBy('created_at','DESC')->get();
       return $conversionData;
    }
    public function getInstantMessage()
    {
        return InstantMessage::orderBy('title')->get();
    }
}
