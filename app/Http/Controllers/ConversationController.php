<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\ConversationRequest;
use App\Http\Services\ConversationService;
use App\Models\Conversation;
use App\Models\FileManager;
use App\Models\Ticket;
use App\Models\TicketRating;
use App\Models\TicketSeenUnseen;
use App\Models\User;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConversationController extends Controller
{
    use ResponseTrait;

    public $conversationService;
    public $ticketTagService;
    public $ticketCategoryService;
    public $ticketDetailsService;

    public function __construct()
    {
        $this->conversationService = new ConversationService;
    }

    public function conversationStore($id, ConversationRequest $request)
    {
        DB::beginTransaction();
        try {
            $ticket_id = decrypt($id);
            $ticket_status = Ticket::find($ticket_id)->status;
            if ($ticket_status == STATUS_CLOSED) {
                return redirect()->back()->with('error', __("Conversation is not possible for closed ticket!"));
            }
            $obj = new Conversation();
            $obj->ticket_id = $ticket_id;
            $obj->body = ($request->conversation_details);
            $obj->created_by = auth()->id();
            $obj->status = STATUS_ACTIVE;
            $obj->tenant_id = auth()->user()->tenant_id;
            /*File Manager Call upload*/
            if ($request->attachment) {
                $fileObj = FileManager::where('id', $obj->file_id)->first();
                if ($fileObj) {
                    $fileObj->removeFile();
                    $upload = $fileObj->upload('User', $request->attachment, '', $fileObj->id);
                    $obj->file_id = $upload->id;
                } else {
                    $new_file = new FileManager();
                    $upload = $new_file->upload('User', $request->attachment);
                    $obj->file_id = $upload->id;
                }
            }

            if ($request->file && count($request->file) > 0) {
                $fileId = [];
                foreach ($request->file as $singlefile) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('reply-file', $singlefile);
                    array_push($fileId, $uploaded->id);
                }
                $obj->file_id = json_encode($fileId);
            }

            $obj->save();
            if ($obj && $obj != null) {
                Ticket::where(['id' => $ticket_id, 'tenant_id' => auth()->user()->tenant_id])
                    ->update([
                        'last_reply_id' => $obj->id,
                        'last_reply_by' => auth()->id(),
                        'last_reply_time' => now(),

                    ]);
            }

            $ticketSeenUnseenData = TicketSeenUnseen::where('ticket_id', $ticket_id)
                ->where('created_by', '!=', auth()->id())
                ->update(['is_seen' => 0]);

            DB::commit();

            if (auth()->user()->role == USER_ROLE_CUSTOMER) {
                ticketConversationEmailNotifyToAdminAndAgent($obj->id);
                ticketConversationNotifyToAdminAndAgent($ticket_id);
            } else {
                ticketConversationEmailNotifyForCustomer($ticket_id);
                ticketConversationNotifyForCustomer($ticket_id);
            }

            return redirect()->back()->with('success', __("Conversation Created successfully!"));
        } catch (Exception $exception) {
            DB::rollBack();
            Log::info($exception->getMessage());
            Log::info($exception->getLine());
            Log::info($exception->getFile());
            return redirect()->back();
        }
    }

    public function guestConversationStore($id, ConversationRequest $request)
    {
        DB::beginTransaction();
        try {
            $ticket_id = decrypt($id);
            $ticket_status = Ticket::find($ticket_id)->status;
            $user = User::find($request->created_by);

            if ($ticket_status == STATUS_CLOSED) {
                return redirect()->back()->with('error', __("Conversation is not possible for closed ticket!"));
            }
            $obj = new Conversation();
            $obj->ticket_id = $ticket_id;
            $obj->body = ($request->conversation_details);
            $obj->created_by = $request->created_by;
            $obj->status = STATUS_ACTIVE;
            $obj->tenant_id = $user->tenant_id;
            /*File Manager Call upload*/
            if ($request->attachment) {

                $fileObj = FileManager::where('id', $obj->file_id)->first();
                if ($fileObj) {
                    $fileObj->removeFile();
                    $upload = $fileObj->upload('User', $request->attachment, '', $fileObj->id);
                    $obj->file_id = $upload->id;
                } else {
                    $new_file = new FileManager();
                    $upload = $new_file->upload('User', $request->attachment);
                    $obj->file_id = $upload->id;
                }
            }

            if ($request->file && count($request->file) > 0) {
                $fileId = [];
                foreach ($request->file as $singlefile) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('reply-file', $singlefile);
                    array_push($fileId, $uploaded->id);
                }
                $obj->file_id = json_encode($fileId);
            }

            $obj->save();
            if ($obj && $obj != null) {
                Ticket::where(['id' => $ticket_id, 'tenant_id' => $user->tenant_id])
                    ->update([
                        'last_reply_id' => $obj->id,
                        'last_reply_by' => $user->id,
                        'last_reply_time' => now(),

                    ]);
            }

            $ticketSeenUnseenData = TicketSeenUnseen::where('ticket_id', $ticket_id)
                ->where('created_by', '!=', $request->created_by)
                ->update(['is_seen' => 0]);

            DB::commit();

            if (getRoleByUserId($user->id) == USER_ROLE_CUSTOMER) {
                ticketConversationEmailNotifyToAdminAndAgent($obj->id);
                ticketConversationNotifyToAdminAndAgent($ticket_id);
            } else {
                ticketConversationEmailNotifyForCustomer($ticket_id);
                ticketConversationNotifyForCustomer($ticket_id);
            }
            return redirect()->back()->with('success', __("Conversation Created successfully!"));
        } catch (Exception $exception) {
            DB::rollBack();
            Log::info($exception->getMessage());
            Log::info($exception->getLine());
            Log::info($exception->getFile());
            return redirect()->back()->with('error', SOMETHING_WENT_WRONG);
        }
    }

    public function conversationUpdate(Request $request)
    {
       $request->validate([
            'conversion_id' => ['required'],
            'conversation_details' => ['required'],
        ]);

        try {
            $data = Conversation::find($request->conversion_id);
            if(!is_null($data)){
                $data->body = $request->conversation_details;
                $data->save();
                return $this->success([], "Conversation Update Successfully");
            }
        }catch (Exception $exception){
            return $this->error([], SOMETHING_WENT_WRONG);
        }
    }

    public function conversationDelete(Request $request){
        try {
            $data = Conversation::find($request->id);
            if(!$data && $data == null){
                return $this->error([], SOMETHING_WENT_WRONG);
            }
            $data->delete();
            return $this->success([], getMessage(DELETED_SUCCESSFULLY));
        } catch (\Exception $e) {
            return $this->error([], $e->getMessage());
        }
    }
}




