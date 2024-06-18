<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatSession;
use App\Models\FileManager;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    use ResponseTrait;

    public function chatInbox()
    {
        $data['pageTitle'] = 'Chat Inbox';

        $data['inboxData'] = Chat::leftJoin('users', 'chats.sender_id', '=', 'users.id')
            ->leftJoin('chat_sessions', 'chats.session_id', '=', 'chat_sessions.id')
            ->where('chat_sessions.tenant_id', getTenantId())
            ->where('users.role', USER_ROLE_CUSTOMER)
            ->orderBy('chats.id', 'DESC')
            ->groupBy('chats.sender_id')
            ->get([
                'chat_sessions.id  as chat_session_id',
                'chat_sessions.status  as chat_session_status',
                'chat_sessions.created_by  as chat_session_created_by',
                'chat_sessions.tenant_id  as chat_session_tenant_id',
                'chat_sessions.created_at  as chat_session_created_at',
                'users.name',
                'users.email',
                'users.image',
                'chats.*'
            ]);


        return view('agent.chat_inbox.inbox', $data);
    }

    public function fetchMessages(Request $request)
    {
        if (isset($request->sender_id) && $request->sender_id != null) {

            $dataseen = Chat::where('sender_id', $request->sender_id)->get();

            foreach ($dataseen as $item) {
                if ($item->is_seen == 0) {
                    $item->is_seen = 1;
                    $item->save();
                }
            }

            $data['chat'] = Chat::where(function ($query) use ($request) {
                $query->where(['sender_id' => $request->sender_id])
                    ->orWhere(['receiver_id' => $request->sender_id]);
            })->get();

            return view('agent.chat_inbox.chat_board', $data);
        } else {
            if (isset($request->chat_session_id) && $request->chat_session_id != null) {
                $activeSession = ChatSession::find($request->chat_session_id);
            } else {
                if (!Cookie::get('session_id')) {
                    return '';
                }
                $activeSession = ChatSession::where(['created_by' => auth()->id(), 'status' => 1])->first();
            }
            if ($activeSession && $activeSession != null) {

                $dataseen = Chat::where('session_id', $activeSession->id)->get();
                foreach ($dataseen as $item) {
                    if ($item->is_seen == 0) {
                        $item->is_seen = 1;
                        $item->save();
                    }
                }

                $data['chat'] = Chat::where('session_id', $activeSession->id)
                    ->leftJoin('users', 'users.id', '=', 'chats.sender_id')
                    ->where(function ($query) {
                        $query->where('sender_id', auth()->id())
                            ->orWhere('receiver_id', auth()->id());
                    })
                    ->get([
                        'chats.*',
                        'users.name as user_name',
                    ]);

                return view('customer.chat.chat_history', $data);
            }
            return '';
        }

    }


    public function sendMessage(Request $request)
    {
        DB::beginTransaction();
        try {

            if (($request->message == null) && ($request->file == null || count($request->file) == 0)) {
                return $this->error([], 'Enter the filed!');
            }

            $chatObj = new Chat();
            if (isset($request->receiver_id) && $request->receiver_id != null) {
                $chatObj->sender_id = auth()->id();
                $chatObj->receiver_id = $request->receiver_id;
                $chatObj->tenant_id = auth()->user()->tenant_id;
                $chatObj->message = $request->message;

                $session = ChatSession::where(['created_by' => $request->receiver_id, 'status' => 1])->first();
                if ($session && $session != null) {
                    $chatObj->session_id = $session->id;
                    $pushableData = [
                        'chat_session_id' => $session->id,
                        'chat_session_status' => 'active',
                        'receiver_id' => $request->receiver_id,
                    ];
                } else {
                    $chatData = Chat::where('sender_id', $request->receiver_id)->orderBy('id', 'desc')->first();
                    $chatObj->session_id = $chatData->session_id;
                    $pushableData = [
                        'chat_session_id' => $chatObj->session_id,
                        'chat_session_status' => 'inactive',
                        'receiver_id' => $request->receiver_id,
                    ];
                }


            } else {
                $chatObj->sender_id = auth()->id();
                $chatObj->tenant_id = auth()->user()->tenant_id;
                $chatObj->message = $request->message;
                $chatObj->is_seen = 0;

                if (!Cookie::get('session_id')) {
                    $activeSession = ChatSession::where(['created_by' => auth()->id(), 'status' => 1])->first();
                    if ($activeSession && $activeSession != null) {
                        $activeSession->status = 0;
                        $activeSession->save();
                    }
                    $sessionObj = new ChatSession();
                    $sessionObj->time = Carbon::now()->timestamp;
                    $sessionObj->tenant_id = auth()->user()->tenant_id;
                    $sessionObj->created_by = auth()->id();
                    $sessionObj->save();
                    $this->setCookie($sessionObj->id);
                    $chatObj->session_id = $sessionObj->id;

                    $pushableData = [
                        'chat_session_id' => $chatObj->session_id,
                        'chat_session_status' => 'inactive',
                        'receiver_id' => auth()->id(),
                    ];

                } else {
                    $sessionId = Cookie::get('session_id');
                    $this->setCookie($sessionId, 'update');
                    $chatObj->session_id = $sessionId;

                    $activeSession = ChatSession::where('id', $sessionId)->first();
                    $pushableData = [
                        'chat_session_id' => $chatObj->session_id,
                        'chat_session_status' => 'active',
                        'receiver_id' => auth()->id(),
                    ];
                }
            }

            if ($request->file && count($request->file) > 0) {
                $fileId = [];
                foreach ($request->file as $singlefile) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('chat-images', $singlefile);
                    array_push($fileId, $uploaded->id);
                }
                $chatObj->file = json_encode($fileId);
            }

            $chatObj->save();
            DB::commit();


            //pusher data push start
            if (getOption('pusher_status') == 1) {
                broadcastChatData($pushableData);
            }
            //pusher data push end

            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }

    }

    public function setCookie($session_id, $status = null)
    {
        $minutes = env('CHAT_SESSION_TIMEOUT');
        $response = new Response('Chat Session Data');
        if ($status == 'update') {
            Cookie::forget('session_id');
            Cookie::queue('session_id', $session_id, $minutes);
        } else {
            Cookie::queue('session_id', $session_id, $minutes);
        }

        return $response;
    }

    public function fetchMessagesAgent(Request $request)
    {
        $dataseen = Chat::where('sender_id', $request->sender_id)->get();
        foreach ($dataseen as $item) {
            if ($item->is_seen == 0) {
                $item->is_seen = 1;
                $item->save();
            }
        }

        $data['chat'] = Chat::leftJoin('users as sender', 'sender.id', '=', 'chats.sender_id')
            ->where(function ($query) use ($request) {
                $query->where(['sender_id' => $request->sender_id])
                    ->orWhere(['receiver_id' => $request->sender_id]);
            })
            ->get([
                'chats.*',
                'sender.id as sender_id',
                'sender.role as sender_role',
            ]);


        return view('agent.chat_inbox.chat_board', $data);

    }

    public function sendMessageAgent(Request $request)
    {
        DB::beginTransaction();
        try {

            if (($request->message == null) && ($request->file == null || count($request->file) == 0)) {
                return $this->error([], 'Enter the filed!');
            }

            $chatObj = new Chat();
            if (isset($request->receiver_id) && $request->receiver_id != null) {
                $chatObj->sender_id = auth()->id();
                $chatObj->receiver_id = $request->receiver_id;
                $chatObj->tenant_id = auth()->user()->tenant_id;
                $chatObj->message = $request->message;

                $session = ChatSession::where(['created_by' => $request->receiver_id, 'status' => 1])->first();
                if ($session && $session != null) {
                    $chatObj->session_id = $session->id;
                    $pushableData = [
                        'chat_session_id' => $session->id,
                        'chat_session_status' => 'active',
                        'receiver_id' => $request->receiver_id,
                    ];
                } else {
                    $chatData = Chat::where('sender_id', $request->receiver_id)->orderBy('id', 'desc')->first();
                    $chatObj->session_id = $chatData->session_id;
                    $pushableData = [
                        'chat_session_id' => $chatObj->session_id,
                        'chat_session_status' => 'inactive',
                        'receiver_id' => $request->receiver_id,
                    ];
                }


            } else {
                $chatObj->sender_id = auth()->id();
                $chatObj->tenant_id = auth()->user()->tenant_id;
                $chatObj->message = $request->message;
                $chatObj->is_seen = 0;

                if (!Cookie::get('session_id')) {
                    $activeSession = ChatSession::where(['created_by' => auth()->id(), 'status' => 1])->first();
                    if ($activeSession && $activeSession != null) {
                        $activeSession->status = 0;
                        $activeSession->save();
                    }
                    $sessionObj = new ChatSession();
                    $sessionObj->time = Carbon::now()->timestamp;
                    $sessionObj->tenant_id = auth()->user()->tenant_id;
                    $sessionObj->created_by = auth()->id();
                    $sessionObj->save();
                    $this->setCookie($sessionObj->id);
                    $chatObj->session_id = $sessionObj->id;

                    $pushableData = [
                        'chat_session_id' => $chatObj->session_id,
                        'chat_session_status' => 'inactive',
                        'receiver_id' => auth()->id(),
                    ];

                } else {
                    $sessionId = Cookie::get('session_id');
                    $this->setCookie($sessionId, 'update');
                    $chatObj->session_id = $sessionId;

                    $activeSession = ChatSession::where('id', $sessionId)->first();
                    $pushableData = [
                        'chat_session_id' => $chatObj->session_id,
                        'chat_session_status' => 'active',
                        'receiver_id' => auth()->id(),
                    ];
                }
            }

            if ($request->file && count($request->file) > 0) {
                $fileId = [];
                foreach ($request->file as $singlefile) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('chat-images', $singlefile);
                    array_push($fileId, $uploaded->id);
                }
                $chatObj->file = json_encode($fileId);
            }

            $chatObj->save();
            DB::commit();


            //pusher data push start
            if (getOption('pusher_status') == 1) {
                broadcastChatData($pushableData);
            }
            //pusher data push end

            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }

    }

    public function sessionStatusChange(Request $request)
    {
        if (!Cookie::get('session_id')) {
            $activeSession = ChatSession::where(['created_by' => auth()->id(), 'status' => 1])->first();
            if ($activeSession && $activeSession != null) {
                $activeSession->status = 0;
                $activeSession->save();
            }
        }
    }

    public function chathistory(Request $request)
    {
        $exp_time = time();
        $id = auth()->id();

        $chat = Chat::with('session_thread')
            ->leftJoin('users', 'users.id', '=', 'chats.sender_id')
            ->where(function ($query) use ($id) {
                $query->where(['sender_id' => $id])
                    ->orWhere(['receiver_id' => $id]);
            })->select(DB::raw('chats.*,users.image,users.name'))
            ->get();
        $data['history'] = $chat->groupBy('session_id');
        foreach ($data['history'] as $history) {
            $history->chat_users = $history->unique('image')->pluck('image');
            if ($history->last()->role = USER_ROLE_CUSTOMER && $exp_time > (strtotime($history->max('created_at')) + env('CHAT_SESSION_TIMEOUT') * 60)) {
                ChatSession::where('id', $history->last()->session_id)->update(['status' => 0]);
            }
        }

        return view('customer.chat.history', $data);
    }

    public function getSingleHistoryData(Request $request)
    {

        $session = ChatSession::where('id', $request->chat_session_id)->first('status');
        $data['session'] = $session;

        if ($session->status == 1) {
            $data['chat'] = Chat::join('users', 'chats.sender_id', '=', 'users.id')
                ->where('session_id', $request->chat_session_id)->get();
            return view('customer.chat.chat_board', $data);
        } else {
            $data['chat'] = Chat::join('users', 'chats.sender_id', '=', 'users.id')
                ->where('session_id', $request->chat_session_id)->get();
            return view('customer.chat.chat_history', $data);

        }


//
//        $data['chat'] = Chat::join('users','chats.sender_id','=','users.id')
//            ->leftJoin('chat_sessions', 'chats.session_id', '=', 'chat_sessions.id')
//            ->where('session_id',$request->chat_session_id)
//            ->get([
//                'chats.*',
//                'users.*',
//                'chat_sessions.status as session_status',
//            ]);


    }

    public function unseenMsg()
    {
        $data['unseen_count'] = Chat::leftJoin('users', 'chats.sender_id', '=', 'users.id')
            ->leftJoin('chat_sessions', 'chats.session_id', '=', 'chat_sessions.id')
            ->where('chat_sessions.tenant_id', getTenantId())
            ->where('chats.is_seen', 0)
            ->where('users.role', USER_ROLE_CUSTOMER)
            ->orderBy('chats.id', 'DESC')
            ->groupBy('chats.sender_id')
            ->count();
        return $data;
    }


}
