<?php

namespace App\Http\Services;

use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\DynamicField;
use App\Models\DynamicFieldData;
use App\Models\Envato;
use App\Models\FileManager;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Varity;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendEmailGenericJob;
use App\Mail\SendMailGeneric;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class   AgentTicketService
{
    use ResponseTrait;

    public $ticketCategoryService;

    public function __construct()
    {
        $this->ticketCategoryService = new TicketCategoryService;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {

            if ($request->id && $request->id != null) {
                $dataObj = Ticket::where('id', $request->id)->first();
            } else {
                $dataObj = new Ticket();
            }

            $dataObj->ticket_title = $request->subject;
            $dataObj->ticket_description = $request->details;
            $dataObj->ticket_type = TICKET_TYPE_INTERNAL;
            $dataObj->category_id = $request->category;
            $dataObj->created_by = auth()->id();
            $dataObj->last_reply_time = now();
            $dataObj->status = STATUS_PENDING;
            $dataObj->priority = GENERALLY;
            $dataObj->tenant_id = getTenantId();

            /*File Manager Call upload*/
            if ($request->file && count($request->file) > 0) {
                $fileId = [];
                foreach ($request->file as $singlefile) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('ticket-documents', $singlefile);
                    array_push($fileId, $uploaded->id);
                }
                $dataObj->file_id = json_encode($fileId);
            }

            /*End*/
            $dataObj->save();

            //dynamic field data save
            $dynamicFieldList = DynamicField::where('tenant_id', auth()->user()->tenant_id)->orderBy('order', 'ASC')->get();
            if (count($dynamicFieldList) > 0) {
                foreach ($dynamicFieldList as $field) {
                    $dynamicFieldObj = new DynamicFieldData();
                    $dynamicFieldObj->ticket_id = $dataObj->id;
                    $dynamicFieldObj->field_id = $field->id;
                    $dynamicFieldObj->field_value = $request->{$field->name};
                    $dynamicFieldObj->tenant_id = auth()->user()->tenant_id;
                    $dynamicFieldObj->save();
                }
            }
            //dynamic field data save

            $getTrackingPreFixed = Varity::where('created_by', getUserIdByTenant())->first();
            $getTrackingPreFixed = isset($getTrackingPreFixed->ticket_tracking_no_pre_fixed) ? $getTrackingPreFixed->ticket_tracking_no_pre_fixed : 'ST';
            $trackingNo = $getTrackingPreFixed . sprintf('%06d', $dataObj->id);
            if ($dataObj->id) {
                Ticket::where('id', $dataObj->id)->update(['tracking_no' => $trackingNo]);

                $categoryData = $this->ticketCategoryService->getById($request->category);
                $categoryUser = $categoryData->users->pluck('id')->toArray();
                $dataObj->users()->syncWithPivotValues($categoryUser, ['is_active' => ACTIVE, 'tenant_id' => getTenantId(), 'assigned_by' => getUserIdByTenant()], false);
            }

            DB::commit();

            //add user log start
            addUserActivityLog('ticket-create', auth()->id(), $dataObj->id);
            //add user log end

            //send notification start
            setCommonNotification('New Ticket created', 'Welcome, You have a new ticket. Ticket tracking number ' . $trackingNo, auth()->id());
            //send notification end

            //send email notification start
            newTicketEmailNotify($dataObj->id);
            //send email notification end
            return redirect()->route('agent.ticket.active-ticket')->with('success', __("Ticket created successfully"));
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', SOMETHING_WENT_WRONG);
        }
    }


    public function list($request, $ticket_status, $customer_id = null)
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
            ->select('users.name','users.image','users.mobile','users.email','tickets.id','tickets.envato_licence','tickets.tracking_no', 'tickets.ticket_title',
                'tickets.created_by','tickets.category_id', 'tickets.status', 'tickets.priority', 'tickets.created_at',
                'tickets.updated_at','ticket_seen_unseens.is_seen','tickets.last_reply_id','tickets.last_reply_by');

        if ($ticket_status == STATUS_CLOSED) {
            $ticketData->where(['tickets.status'=>STATUS_CLOSED,'tickets.deleted_at'=>NULL]);
        } else if ($ticket_status == STATUS_SUSPENDED) {
            $ticketData->where(['tickets.status'=>STATUS_SUSPENDED,'tickets.deleted_at'=>NULL]);
        } else if ($ticket_status == STATUS_ON_HOLD) {
                        $ticketData->where(['tickets.status'=>STATUS_ON_HOLD,'tickets.deleted_at'=>NULL]);

        } else if ($ticket_status == STATUS_RESOLVED) {
                        $ticketData->where(['tickets.status'=>STATUS_RESOLVED,'tickets.deleted_at'=>NULL]);

        } else if ($ticket_status == 'active') {
            $ticketData->whereNotIn('tickets.status', $notActiveStatus);

        } else if ($ticket_status == 'all') {
                        $ticketData->where(['tickets.deleted_at'=>NULL]);

        } else if ($ticket_status == 'recent') {
                        $ticketData->where(['tickets.status'=>STATUS_PENDING,'tickets.deleted_at'=>NULL]);

        } else if ($ticket_status == 'self-assigned-tickets') {
                        $ticketData->where(['tickets.deleted_at'=>NULL])
                ->join('ticket_assignee', function($join){
                    $join->on('tickets.id', '=', 'ticket_assignee.ticket_id');
                    $join->on('ticket_assignee.assigned_to', '=', DB::raw(auth()->id()));
                });
        } else if ($ticket_status == 'my-assigned-tickets') {
            $ticketData->join('ticket_assignee', function($join){
                $join->on('tickets.id', '=', 'ticket_assignee.ticket_id');
                $join->on('ticket_assignee.assigned_to', '=', DB::raw(auth()->id()));
            });

        } else if ($ticket_status == 'my_ticket_history') {
                        $ticketData->where(['tickets.deleted_at'=>NULL]);

        } else if ($ticket_status == 'delete') {
            $ticketData->onlyTrashed();
        }

        return datatables($ticketData)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($data) {
                return '<td>
                        <div class="round">
                          <input type="checkbox" class="allSelect" name="multicheck_ticket_id[]" id="checkbox' . $data->id . '" value="' . $data->id . '" />
                          <label for="checkbox' . $data->id . '"></label>
                        </div>
                      </td>';
            })
            ->editColumn('ticket_title', function ($data) use ($envato) {
                return getTicketTitleHtml($data,$envato);
            })
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
                                     <p>'.$data->lastConversationUser?->name.'</p>
                                     '.Carbon::createFromFormat('Y-m-d H:i:s', $data->lastConversation?->created_at)->diffForHumans().'
                                </div>';
                    return $userHtml;
                }else{
                    return "no-conversion";
                }

            })

            ->editColumn('status', function ($data) {
               return getTicketStatusHtml($data);
            })
            ->editColumn('created_at', function ($data) {
                return '<p>' . \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('Y-m-d H:i:s') . '</p>';
            })
            ->editColumn('updated_at', function ($data) {
                try {
                    return '<p>' . \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->updated_at)->diffForHumans() . '</p>';
                }catch (\Exception $exception){
                    return "";
                }
            })
            ->addColumn('action', function ($data) {
                return '<a href="' . route('agent.ticket.view-ticket', $data->id) . '" class="">
                          <img src="' . asset('customer/assets/images/preview-open.png') . '" alt="">
                        </a>
                        ';

            })
            ->addColumn('assigned_to', function ($data) {
                return getTicketAssignToHtml($data);
            })
            ->addColumn('ticket_id', function ($data) {
               return getTicketIdHtml($data);
            })
            ->rawColumns(['action', 'status', 'ticket_title', 'created_at', 'updated_at', 'checkbox','ticket_id','created_by','updated','assigned_to'])
            ->make(true);
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
            return redirect()->back()->with('success', DELETED_SUCCESSFULLY);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', SOMETHING_WENT_WRONG);
        }
    }

    public function multiDeleteById($request)
    {
        DB::beginTransaction();
        try {
            foreach ($request->multicheck_ticket_id as $key => $item) {
                Ticket::where('id', $item)->delete();
            }
            DB::commit();
            return redirect()->back()->with('success', DELETED_SUCCESSFULLY);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', SOMETHING_WENT_WRONG);
        }
    }

    public function detailsById($id)
    {
        return Ticket::find($id);
    }

    public function getByTicketIdAndUserId($ticketId, $user_id)
    {
        return Ticket::find()->where(['id' => $ticketId, 'created_by' => $user_id]);
    }

    public function myTicketHistory($request, $customer_id = null)
    {
        $ticketData = null;
        $envato = Envato::where('tenant_id', auth()->user()->tenant_id)->first();
        $notActiveStatus = array(STATUS_RESOLVED, STATUS_SUSPENDED, STATUS_CANCELED, STATUS_CLOSED, STATUS_ON_HOLD);
        $ticketData = Ticket::with('user')
            ->where(['tickets.tenant_id' => auth()->user()->tenant_id, 'tickets.created_by' => $customer_id, 'tickets.deleted_at' => NULL])
            ->leftJoin('ticket_seen_unseens', function($join){
                $join->on('tickets.id', '=', 'ticket_seen_unseens.ticket_id');
                $join->on('ticket_seen_unseens.created_by', '=', DB::raw(auth()->id()));
            })
            ->join('users', function($join){
                $join->on('tickets.created_by', '=', 'users.id');
            })->whereNull('users.deleted_at')
            ->orderBy('tickets.last_reply_time', 'DESC')
            ->select('users.name','users.image','users.mobile','users.email','tickets.id','tickets.envato_licence','tickets.tracking_no', 'tickets.ticket_title',
                'tickets.created_by', 'tickets.status', 'tickets.priority', 'tickets.created_at',
                'ticket_seen_unseens.is_seen','tickets.last_reply_id', 'tickets.updated_at', 'tickets.category_id');

        return datatables($ticketData)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($data) {
                return '<td>
                        <div class="round">
                          <input type="checkbox" class="allSelect" name="multicheck_ticket_id[]" id="checkbox' . $data->id . '" value="' . $data->id . '" />
                          <label for="checkbox' . $data->id . '"></label>
                        </div>
                      </td>';
            })
//            ->editColumn('ticket_title', function ($data) {
//                $ticketPriority = '';
//                if ($data->priority == LOW) {
//                    $ticketPriority .= '<span class="low">
//                    <li>Low</li>
//                  </span>';
//                } else if ($data->priority == MEDIUM) {
//                    $ticketPriority .= '<span class="generally">
//                    <li>Medium</li>
//                  </span>';
//                } else if ($data->priority == HIGH) {
//                    $ticketPriority .= '<span class="high">
//                    <li>High</li>
//                  </span>';
//                } else if ($data->priority == CRITICAL) {
//                    $ticketPriority .= '<span class="critical">
//                    <li>Critical</li>
//                  </span>';
//                } else if ($data->priority == GENERALLY) {
//                    $ticketPriority .= '<span class="generally">
//                    <li>Generally</li>
//                  </span>';
//                }
//
//                return '<a href="viewTickets.html">' . htmlspecialchars($data->ticket_title) . '</a>
//                        <div>
//                          <span>
//                            <li> ' . getCategoryNameById($data->category_id) . '</li>
//                          </span>' . $ticketPriority . '
//                        </div>';
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
                    $last_reply = $data->lastConversationUser?->role == USER_ROLE_CUSTOMER ? 'Customer': 'Agent';
                    $userHtml = '<div class="ticket-user-name">
                                     <p>'.$last_reply.'</p>
                                     '.Carbon::createFromFormat('Y-m-d H:i:s', $data->lastConversation?->created_at)->diffForHumans().'
                                </div>';
                    return $userHtml;
                }else{
                    return "no-conversion";
                }

            })
            ->editColumn('status', function ($data) {
                if ($data->status == STATUS_OPEND) {
                    return '<button class="small-btn pending-btn">New</select>';
                } else if ($data->status == STATUS_INPROGRESS) {
                    return '<button class="small-btn processing-btn">In Progress</button>';
                } else if ($data->status == STATUS_CANCELED) {
                    return '<button class="small-btn canceled-btn">Canceled</button>';
                } else if ($data->status == STATUS_ON_HOLD) {
                    return '<button class="small-btn success-btn">On Hold</button>';
                } else if ($data->status == STATUS_CLOSED) {
                    return '<button class="small-btn close-btn">Closed</button>';
                } else if ($data->status == STATUS_RESOLVED) {
                    return '<button class="small-btn resolved-btn">Resolved</button>';
                } else if ($data->status == STATUS_REOPEN) {
                    return '<button class="small-btn success-btn">Re Open</button>';
                } else if ($data->status == STATUS_SUSPENDED) {
                    return '<button class="small-btn suspend-btn">Suspended</button>';
                } else {
                }

            })
            ->editColumn('created_at', function ($data) {

                return '<p>' . \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d M, Y') . '</p>';
            })
            ->editColumn('updated_at', function ($data) {
                return '<p>' . \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->updated_at)->diffForHumans() . '</p>';
            })
            ->addColumn('action', function ($data) {
                return '<a href="' . route('agent.ticket.view-ticket', $data->id) . '" class="">
                          <img src="' . asset('customer/assets/images/preview-open.png') . '" alt="">
                        </a>
                        <a href="#" onclick="deleteItem(\'' . route('agent.ticket.ticket-delete', $data->id) . '\', \'ticketsDataTable\')" class="">
                          <img src="' . asset('customer/assets/images/trash.png') . '" alt="">
                        </a>';

            })
            ->addColumn('ticket_id', function ($data) {
                if($data->last_reply_id == null){
                    return '<a href="'.route('agent.ticket.view-ticket', $data->id).'" class="btn btn-outline-primary position-relative px-5 py-4 agent-ticket-id" href="">
                            '.$data->tracking_no.'
                             <span class="badge bg-pink-500 position-absolute rounded-pill agent-msg top-0 translate-middle">
                                New
                             </span>
                        </a>';
                }else if ($data->is_seen == 0){
                    return '<a href="'.route('agent.ticket.view-ticket', $data->id).'" class="btn btn-outline-primary position-relative px-5 py-4 agent-ticket-id" href="">
                            '.$data->tracking_no.'
                            <span class="badge bg-pink-500 position-absolute rounded-pill agent-msg top-0 translate-middle">
                                <i class="fa-regular fa-envelope h6 mb-0"></i>
                             </span>
                        </a>';
                }else{
                    return '<a href="'.route('agent.ticket.view-ticket', $data->id).'" class="btn btn-outline-primary position-relative px-5 py-4 agent-ticket-id" href="">
                            '.$data->tracking_no.'
                        </a>';
                }
            })
            ->editColumn('ticket_title', function ($data) use ($envato) {
                return getTicketTitleHtml($data,$envato);
            })
            ->addColumn('assigned_to', function ($data) {
                return getTicketAssignToHtml($data);
            })
            ->rawColumns(['action', 'status', 'ticket_title', 'created_at', 'updated_at', 'checkbox','ticket_id','created_by','updated','assigned_to'])
            ->make(true);

    }

}
