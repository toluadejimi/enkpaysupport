<?php

namespace App\Http\Services;

use App\Mail\UserEmailVerification;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\DynamicFieldData;
use App\Models\Envato;
use App\Models\FileManager;
use App\Models\TicketRating;
use App\Models\User;
use App\Models\Ticket;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendEmailGenericJob;
use App\Mail\SendMailGeneric;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class   TicketService
{
    use ResponseTrait;

    public $ticketCategoryService;

    public function __construct()
    {
        $this->ticketCategoryService = new TicketCategoryService;
    }

    public function list($request, $ticket_status)
    {
        $envato = Envato::where('tenant_id', auth()->user()->tenant_id)->first();
        $notActiveStatus = array(STATUS_RESOLVED, STATUS_SUSPENDED, STATUS_CANCELED, STATUS_CLOSED, STATUS_ON_HOLD);
        $ticketData = Ticket::with('category','lastConversation','lastConversationUser')
            ->where(['tickets.tenant_id'=> auth()->user()->tenant_id])
            ->leftJoin('ticket_seen_unseens', function($join){
                $join->on('tickets.id', '=', 'ticket_seen_unseens.ticket_id');
                $join->on('ticket_seen_unseens.created_by', '=', DB::raw(auth()->id()));
            })->join('users', function($join){
                $join->on('tickets.created_by', '=', 'users.id');
            })->whereNull('users.deleted_at')
            ->orderBy('tickets.last_reply_time', 'DESC')
            ->with(['assignTo'])
            ->select('users.name','users.image','users.mobile','users.email','tickets.id','tickets.envato_licence','tickets.tracking_no', 'tickets.ticket_title',
                'tickets.created_by','tickets.category_id', 'tickets.status', 'tickets.priority', 'tickets.created_at',
                'ticket_seen_unseens.is_seen','tickets.last_reply_id','tickets.last_reply_by');
        if($ticket_status==STATUS_PENDING){
            $ticketData->where(['tickets.status'=>STATUS_PENDING,'tickets.deleted_at'=>NULL]);
        }
        else if($ticket_status==STATUS_RESOLVED){
            $ticketData->where(['tickets.status'=>STATUS_RESOLVED,'tickets.deleted_at'=>NULL]);
        }
        else if($ticket_status==STATUS_INPROGRESS){
            $ticketData->where(['tickets.status'=>STATUS_INPROGRESS,'tickets.deleted_at'=>NULL]);
        }
        else if($ticket_status==STATUS_CLOSED){
            $ticketData->where(['tickets.status'=>STATUS_CLOSED,'tickets.deleted_at'=>NULL]);
        }
        else if($ticket_status==STATUS_ON_HOLD){
            $ticketData->where(['tickets.status'=>STATUS_ON_HOLD,'tickets.deleted_at'=>NULL]);
        }
        else if($ticket_status==STATUS_SUSPENDED){
            $ticketData->where(['tickets.status'=>STATUS_SUSPENDED,'tickets.deleted_at'=>NULL]);

        } else if ($ticket_status == 'my-assigned-tickets') {
            $ticketData->join('ticket_assignee', function($join){
                $join->on('tickets.id', '=', 'ticket_assignee.ticket_id');
                $join->on('ticket_assignee.assigned_to', '=', DB::raw(auth()->id()));
            });
        }
        else if($ticket_status=='active'){
            $ticketData->whereNotIn('tickets.status', $notActiveStatus);
        }
        else if($ticket_status=='delete'){
            $ticketData->onlyTrashed();
        }else{
            $ticketData->where(['tickets.deleted_at'=>NULL]);
        }


        return datatables($ticketData)
            ->addIndexColumn()
            ->editColumn('created_by', function ($data) {
                $userHtml = '<div class="ticket-info-img">
                                <div class="sf-img">
                                   <img src="'.getFileUrl($data->image).'" alt="">
                                </div>
                                <div class="ticket-user-name">
                                    <h5>
                                        '.$data->name.'
                                    </h5>
                                     <p>'.$data->email.'</p>
                                    <p>'.$data->mobile.'</p>
                                </div>
                           </div>';
                return $userHtml;
            })
            ->editColumn('ticket_title', function ($data) use ($envato){
                return getTicketTitleHtml($data,$envato);
            })
            ->editColumn('status', function ($data) {
                return getTicketStatusHtml($data);
            })
            ->editColumn('updated', function ($data) {
                if($data->lastConversation?->created_at){
                    $userHtml = '<div class="ticket-user-name">
                                     <p>'.$data->lastConversationUser?->name.'</p>
                                    '.Carbon::createFromFormat('Y-m-d H:i:s', $data->lastConversation?->created_at)->diffForHumans().'
                                </div>';
                    return $userHtml;
                }else{
                    return "no-conversion";
                }
            })
            ->addColumn('assigned_to', function ($data) {
                return getTicketAssignToHtml($data);
            })
            ->addColumn('action', function ($data) use ($ticket_status) {
                if($ticket_status == 'delete'){
                    $delete_button = '';
                }else{
                    $delete_button = '<button onclick="deleteItem(\'' . route('admin.tickets.ticket-delete', $data->id) . '\', \'ticketManagementDataTable\')" class="tbl-action-btn text-danger"   title="Delete"><img src="' . asset('admin/images/yajra-datatable/trash.png') . '" alt="delete ticket"></button>';
                }
                return '<div class="action__buttons d-flex justify-content-end">
                            <a href="'.route('admin.tickets.ticket_view', $data->id).'" class="btn-action edit" data-toggle="tooltip" title="Ticket Details">
                            <img src="' . asset('admin/images/yajra-datatable/preview-open.png') . '" alt="view ticket">
                            </a>'.$delete_button.
                    '</div>';
            })
            ->addColumn('ticket_id', function ($data) {
                return getTicketIdHtml($data);
            })
            ->rawColumns(['action', 'status','ticket_title','assigned_to','ticket_id','created_by','updated'])
            ->make(true);
    }

    public function getById($id)
    {
        return Ticket::withTrashed()->find($id);
    }

    public function getByTicketIdAndUserId($id, $user_id)
    {
        return Ticket::where(['id' => $id, 'created_by' => $user_id])->first();
    }

    public function getTicketDeatilsByTicketId($id)
    {
        return Ticket::with('users', 'category', 'activityLog', 'fileManager', 'rating')->withTrashed()->find($id);
    }
    public function getTicketDynamicFieldDeatilsByTicketId($id)
    {
        return DynamicFieldData::leftJoin('dynamic_fields', 'dynamic_field_data.field_id', '=', 'dynamic_fields.id')
        ->where('dynamic_field_data.ticket_id', $id)
            ->get([
                'dynamic_fields.name',
                'dynamic_fields.level',
                'dynamic_fields.type',
                'dynamic_fields.required',
                'dynamic_field_data.field_value',
                'dynamic_field_data.id'
            ]);
    }
    public function deleteById($id)
    {
        DB::beginTransaction();
        try {
            $ticket = Ticket::where('id', $id)->firstOrFail();
            if (!$ticket && $ticket == null) {
                return $this->error([], SOMETHING_WENT_WRONG);
            }
            $ticket->delete();
            DB::commit();
            $message = getMessage(DELETED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function ticketAssignTo($ticketId)
    {
        DB::beginTransaction();
        try {
            $ticket = Ticket::findOrFail($ticketId);
            $adminId = auth()->user()->id;
            $tenantId = auth()->user()->tenant_id;
            Ticket::where(['id'=> $ticketId,'tenant_id' =>$tenantId])
                ->update([
                    'status' => STATUS_ACTIVE
                ]);
            $ticket->users()->syncWithPivotValues($adminId, ['tenant_id' => $tenantId, 'is_active' => 1, 'assigned_by' => auth()->user()->id]);
            DB::commit();
            $message = "Ticket Assigned Successfully";
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function userList()
    {
        return User::where('tenant_id', auth()->user()->tenant_id)
            ->where('role', USER_ROLE_AGENT)
            ->get();
    }

    public function ticketAssignment($request)
    {
        DB::beginTransaction();
        try {
            if ($request->id && $request->id != null) {
                $dataObj = Ticket::where('id', $request->id)->first();
            } else {
                $dataObj = new Ticket();
            }
            $tracking_no = $dataObj->tracking_no;
            $ticket_title = $dataObj->ticket_title;
            Ticket::where(['id'=> $request->id,'tenant_id' =>auth()->user()->tenant_id])
                ->update([
                    'status' => STATUS_ACTIVE
                ]);
            $is_active = $request->is_active;
            $tenant_id = auth()->user()->tenant_id !=""?auth()->user()->tenant_id:"";
            $dataObj->users()->syncWithPivotValues($request->group_user, ['is_active' => $is_active,'tenant_id' => $tenant_id,'assigned_by' => auth()->user()->id ],false);
            $ratingData = TicketRating::withTrashed()->where(['ticket_id' => $request->id, 'agent_id' => $request->group_user])->first();
            if($is_active==STATUS_ACTIVE)
            {
                if (!is_null($ratingData)){
                    $ratingData->restore();
                }
                $message = "Ticket Assigned Successfully";
            }
            else{
                if (!is_null($ratingData)){
                    $ratingData->delete();
                }
                $message = "Ticket Unassigned Successfully";
            }
            DB::commit();
            if (isset($request->group_user) && is_array($request->group_user)) {
                foreach ($request->group_user as $user) {
                    if ($is_active == STATUS_ACTIVE) {
                        $userData = User::find($user);
                        $user_name = $userData->name;
                        $subject = getEmailTemplate('Ticket Assigned', 'subject');
                        $notification_details = "Ticket Assigned! Please check your mail, Ticket tracking number " . $tracking_no;
                        $message = __("You have been assigned a Ticket");
                        //send notification start
                        setCommonNotification($subject, $notification_details, $userData->id);
                        //send notification end
                        $emailCustomDataArray = [
                            TICKET_USERNAME => $user_name,
                            TRACKING_NO => $tracking_no,
                            TICKET_TITLE => $ticket_title,
                            TICKET_DESCRIPTION => $message,
                        ];
                        $emailTemplateBody = getEmailTemplate('Ticket Assigned', 'body', null, $emailCustomDataArray);
                        dispatch(new SendEmailGenericJob($userData, $subject, $emailTemplateBody));
                        $message = "Ticket Assigned Successfully";
                    } else {
                        $subject = getEmailTemplate('Ticket Unassigned', 'subject');
                        $notification_details = __("Ticket Unassigned for the ticket " . $tracking_no);
                        $message = __("You have been Unassigned for the Ticket");
                        notification($title = $subject, $body = $notification_details, $user);
                        $userData = User::find($user);
                        $user_name = $userData->name;
                        $emailCustomDataArray = [
                            TICKET_USERNAME => $user_name,
                            TRACKING_NO => $tracking_no,
                            TICKET_TITLE => $ticket_title,
                            TICKET_DESCRIPTION => $message,
                        ];
                        $emailTemplateBody = getEmailTemplate('Ticket Unassigned', 'body', null, $emailCustomDataArray);
                        dispatch(new SendEmailGenericJob($userData, $subject, $emailTemplateBody));
                        $message = "Ticket Unassigned Successfully";
                    }
                }
            }
            return $this->success([], $message);
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }


    public function flyingTicketList()
    {

    }


    public function myTicketHistory($request, $customer_id = null)
    {
        $ticketData = null;
        $envato = Envato::where('tenant_id', auth()->user()->tenant_id)->first();
        $notActiveStatus = array(STATUS_RESOLVED, STATUS_SUSPENDED, STATUS_CANCELED, STATUS_CLOSED, STATUS_ON_HOLD);
        $ticketData = Ticket::with('user')
            ->where(['tickets.tenant_id' =>auth()->user()->tenant_id,'tickets.created_by' =>$customer_id, 'tickets.deleted_at' => NULL])
            ->leftJoin('ticket_seen_unseens', function($join){
                $join->on('tickets.id', '=', 'ticket_seen_unseens.ticket_id');
                $join->on('ticket_seen_unseens.created_by', '=', DB::raw(auth()->id()));
            }) ->join('users', function($join){
                $join->on('tickets.created_by', '=', 'users.id');
            })->whereNull('users.deleted_at')
            ->orderBy('tickets.last_reply_time', 'DESC')
            ->select('users.name','users.image','users.mobile','users.email','tickets.id','tickets.envato_licence','tickets.tracking_no', 'tickets.ticket_title',
                'tickets.created_by', 'tickets.status', 'tickets.priority', 'tickets.created_at',
                'ticket_seen_unseens.is_seen', 'tickets.last_reply_id','tickets.updated_at', 'tickets.category_id');

//        dd($ticketData);

        return datatables($ticketData)
            ->addIndexColumn()
            ->editColumn('created_by', function ($data) {
                return $data->user->email . '(' . $data->user->name . ')';
            })
//            ->editColumn('ticket_title', function ($data) {
//                $ticketDetails =  '<h3>'.htmlspecialchars($data->ticket_title).'</h3>
//                <div>
//                  <span>
//                    <li>'. $data->tracking_no .'</li>
//                  </span>
//                  <span>
//                    <li>'. \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d M, Y H:i:s') .'</li>
//                  </span>';
//                if($data->priority == LOW ){
//                    $ticketDetails .='<span class="low">
//                    <li>Low</li>
//                  </span>';
//                } else if($data->priority == MEDIUM ){
//                    $ticketDetails .='<span class="generally">
//                    <li>Medium</li>
//                  </span>';
//                } else if($data->priority == HIGH ){
//                    $ticketDetails .='<span class="high">
//                    <li>High</li>
//                  </span>';
//                }else if($data->priority == CRITICAL ){
//                    $ticketDetails .='<span class="critical">
//                    <li>Critical</li>
//                  </span>';
//                }
//                $ticketDetails .='</div>';
//                return $ticketDetails;
//            })
            ->editColumn('created_by', function ($data) {
                $userHtml = '<div class="ticket-info-img">
                                <div class="sf-img">
                                   <img src="'.getFileUrl($data->image).'" alt="">
                                </div>
                                <div class="ticket-user-name">
                                    <h5>
                                        '.$data->name.'
                                    </h5>
                                     <p>'.$data->email.'</p>
                                    <p>'.$data->mobile.'</p>
                                </div>
                           </div>';
                return $userHtml;
            })
            ->editColumn('updated', function ($data) {
                if($data->lastConversation?->created_at){
                    $userHtml = '<div class="ticket-user-name">
                                     <p>'.$data->lastConversationUser?->role == USER_ROLE_CUSTOMER ? 'Customer': 'Agent'.'</p>
                                     '.Carbon::createFromFormat('Y-m-d H:i:s', $data->lastConversation?->created_at)->diffForHumans().'
                                </div>';
                    return $userHtml;
                }else{
                    return "no-conversion";
                }

            })
            ->editColumn('status', function ($data) {
                if ($data->status == STATUS_OPEND) {
                    return '<button class="small-btn pending-btn">New</button>';
                } else if ($data->status == STATUS_INPROGRESS) {
                    return '<button class="small-btn processing-btn">In Progress</button>';
                } else if($data->status == STATUS_CANCELED){
                    return '<button class="small-btn canceled-btn">Canceled</button>';
                } else if($data->status == STATUS_ON_HOLD){
                    return '<button class="small-btn success-btn">On Hold</button>';
                } else if ($data->status == STATUS_CLOSED) {
                    return '<button class="small-btn close-btn">Closed</button>';
                } else if ($data->status == STATUS_RESOLVED) {
                    return '<button class="small-btn resolved-btn">Resolved</button>';
                } else if ($data->status == STATUS_REOPEN) {
                    return '<button class="small-btn success-btn">Re Open</button>';
                } else if ($data->status == STATUS_SUSPENDED) {
                    return '<button class="small-btn suspend-btn">Suspended</button>';
                } else if ($data->status == 'delete') {
                    return '<button class="small-btn pending-btn">Deleted</button>';
                } else {

                }


            })
            ->editColumn('ticket_title', function ($data) use ($envato) {
                return getTicketTitleHtml($data,$envato);
            })
            ->addColumn('assigned_to', function ($data) {
                return getTicketAssignToHtml($data);
            })
            ->addColumn('action', function ($data) {
                return '<div class="action__buttons d-flex justify-content-end">
                    <button onclick="window.location=\'' . route('admin.tickets.ticket_view', $data->id) . '\' " class="btn-action edit" data-toggle="tooltip" title="Ticket Details">
                    <img src="' . asset('admin/images/yajra-datatable/preview-open.png') . '" alt="view ticket">
                    </button>
                    <button onclick="deleteItem(\'' . route('admin.tickets.ticket-delete', $data->id) . '\', \'ticketManagementDataTable\')" class="tbl-action-btn text-danger"   title="Delete"><img src="' . asset('admin/images/yajra-datatable/trash.png') . '" alt="delete ticket"></button>
                </div>';
            })
            ->addColumn('ticket_id', function ($data) {
                if ($data->last_reply_id == null) {
                    return '<a href="' . route('admin.tickets.ticket_view', $data->id) . '" class="btn btn-outline-primary position-relative px-4 py-3" href="">
                            ' . $data->tracking_no . '
                             <span class="badge bg-pink-500 position-absolute rounded-pill start-100 top-0 translate-middle">
                                New
                             </span>
                        </a>';
                } else if ($data->is_seen == 0) {
                    return '<a href="' . route('admin.tickets.ticket_view', $data->id) . '" class="btn btn-outline-primary position-relative px-4 py-3" href="">
                            ' . $data->tracking_no . '
                            <span class="badge bg-pink-500 position-absolute rounded-pill start-100 top-0 translate-middle">
                                1
                             </span>
                        </a>';
                } else {
                    return '<a href="' . route('admin.tickets.ticket_view', $data->id) . '" class="btn btn-outline-primary position-relative px-4 py-3" href="">
                            ' . $data->tracking_no . '
                        </a>';
                }
            })
            ->rawColumns(['action', 'status','ticket_title','assigned_to','ticket_id','created_by','updated','assigned_to'])
            ->make(true);
    }


    public function sendTicketStatusChangeMail($ticket_id, $status_after_change, $ticketCreatorData)
    {
        $subject = getEmailTemplate('Ticket Status Changed', 'subject');
        $message = __("Ticket Status Changed");
        $ticket_info = $this->getById($ticket_id);
        //send notification start
        setCommonNotification('Ticket Status Changed', 'Ticket Status Changed To ' . $status_after_change . ' Please check your mail. Ticket tracking number ' . $ticket_info->tracking_no, $ticketCreatorData->id);
        //send notification end
        $user_name = $ticketCreatorData->name;
        $emailCustomDataArray = [
            TICKET_USERNAME => $user_name,
            TRACKING_NO => $ticket_info->tracking_no,
            TICKET_TITLE => $ticket_info->ticket_title,
            TICKET_DESCRIPTION => $message . ' To ' . $status_after_change,
        ];
        $emailTemplateBody = getEmailTemplate('Ticket Status Changed', 'body', null, $emailCustomDataArray);
        dispatch(new SendEmailGenericJob($ticketCreatorData, $subject, $emailTemplateBody));
        $message = "Ticket Assigned Successfully";
    }

}
