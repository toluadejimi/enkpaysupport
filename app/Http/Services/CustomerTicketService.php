<?php

namespace App\Http\Services;

use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\DynamicField;
use App\Models\DynamicFieldData;
use App\Models\Envato;
use App\Models\FileManager;
use App\Models\TicketSeenUnseen;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Varity;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendEmailGenericJob;
use App\Mail\SendMailGeneric;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class   CustomerTicketService
{
    use ResponseTrait;

    public $ticketCategoryService;

    public function __construct()
    {
        $this->ticketCategoryService = new TicketCategoryService;
    }

    public function store($request)
    {
//        $envato = Envato::where('tenant_id', auth()->user()->tenant_id)->first();
//        if($envato?->enable_purchase_code == 1){
//            $request->validate([
//                'purchase_code' => 'required',
////                'domain' => 'required',
//            ]);
//        }

        DB::beginTransaction();
        try {
            if ($request->id && $request->id != null) {
                $dataObj = Ticket::where('id', $request->id)->first();
            } else {
                $dataObj = new Ticket();
            }

            $dataObj->ticket_title = $request->subject;
            $dataObj->envato_licence = $request->purchase_code;
            $dataObj->ticket_description = $request->details;
//            $dataObj->domain = $request->domain;
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


            $ctegoryCode = Category::where('id', $dataObj->category_id)->first();
            if($ctegoryCode->is_ticket_prefix){
                $getTrackingPreFixed =  $ctegoryCode->code;
            }else{
                $verity = Varity::where('created_by', getUserIdByTenant())->first();
                $getTrackingPreFixed = isset($verity->ticket_tracking_no_pre_fixed) ? $verity->ticket_tracking_no_pre_fixed : 'ST';

            }

            $trackingNo = $getTrackingPreFixed . sprintf('%06d', $dataObj->id);
            if ($dataObj->id) {
                Ticket::where('id', $dataObj->id)->update(['tracking_no' => $trackingNo]);
                $categoryData = $this->ticketCategoryService->getById($request->category);
                $categoryUser = $categoryData->users->pluck('id')->toArray();
                $dataObj->users()->syncWithPivotValues($categoryUser, ['is_active' => ACTIVE, 'tenant_id' => getTenantId(), 'assigned_by' => getUserIdByTenant()], false);
            }

            $getAlluser = User::where('tenant_id', auth()->user()->tenant_id)
                ->where('role', '!=', USER_ROLE_CUSTOMER)
                ->get();

            $userData = [];

            foreach ($getAlluser as $key => $singleUser) {
                $userData[] = [
                    'ticket_id' => $dataObj->id,
                    'created_by' => $singleUser->id,
                    'tenant_id' => $singleUser->tenant_id,
                    'is_seen' => 0,
                ];
            }
            $userData[] = [
                'ticket_id' => $dataObj->id,
                'created_by' => auth()->id(),
                'tenant_id' => auth()->user()->tenant_id,
                'is_seen' => 1,
            ];

            TicketSeenUnseen::insert($userData);


            DB::commit();

            //add user log start
            addUserActivityLog('ticket-create', auth()->id(), $dataObj->id);
            //add user log end

            //send notification start
//            setCommonNotification(auth()->id(), 'New Ticket created', 'Welcome, You have a new ticket. Ticket tracking number ' . $trackingNo);
            newTicketNotify($dataObj->id);
            //send notification end

            //send email notification start
            newTicketEmailNotify($dataObj->id);
            //send email notification end
            return redirect()->route('customer.ticket.active-ticket')->with('success', __("Ticket created successfully"));
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::info($exception->getMessage());
            return redirect()->back()->with('error', SOMETHING_WENT_WRONG);
        }
    }

    public function guestTicketStore($request)
    {

        DB::beginTransaction();
        try {

            //check user exist or not
            $user = User::where('email', $request->email)->first();
            if (is_null($user)) {
                $remember_token = Str::random(64);
                $google2fa = app('pragmarx.google2fa');

                $userStatus = USER_STATUS_ACTIVE;
                if (getOption('email_verification_status', 0) == 1) {
                    $userStatus = USER_STATUS_UNVERIFIED;
                }
                $user = new User();
                $user->role = USER_ROLE_CUSTOMER;
                $user->name = explode('@', $request->email)[0];
                $user->email = trim($request->email);
                $user->password = Hash::make(123456);
                $user->remember_token = $remember_token;
                $user->status = $userStatus;
                $user->tenant_id = getTenantId();
                $user->google2fa_secret = $google2fa->generateSecretKey();
                $user->save();
            }
            //check user exist or not

            if ($request->id && $request->id != null) {
                $dataObj = Ticket::where('id', $request->id)->first();
            } else {
                $dataObj = new Ticket();
            }

            $dataObj->ticket_title = $request->subject;
            $dataObj->envato_licence = $request->purchase_code;
            $dataObj->ticket_description = $request->details;
            $dataObj->ticket_type = TICKET_TYPE_INTERNAL;
            $dataObj->category_id = $request->category;
            $dataObj->created_by = $user->id;
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
            $dynamicFieldList = DynamicField::where('tenant_id', getTenantId())->orderBy('order', 'ASC')->get();
            if (count($dynamicFieldList) > 0) {
                foreach ($dynamicFieldList as $field) {
                    $dynamicFieldObj = new DynamicFieldData();
                    $dynamicFieldObj->ticket_id = $dataObj->id;
                    $dynamicFieldObj->field_id = $field->id;
                    $dynamicFieldObj->field_value = $request->{$field->name};
                    $dynamicFieldObj->tenant_id = getTenantId();
                    $dynamicFieldObj->save();
                }
            }
            //dynamic field data save
            $ctegoryCode = Category::where('id', $dataObj->category_id)->first();
            if($ctegoryCode->is_ticket_prefix){
                $getTrackingPreFixed =  $ctegoryCode->code;
            }else{
                $verity = Varity::where('created_by', getUserIdByTenant())->first();
                $getTrackingPreFixed = isset($verity->ticket_tracking_no_pre_fixed) ? $verity->ticket_tracking_no_pre_fixed : 'ST';
            }
            $trackingNo = $getTrackingPreFixed . sprintf('%06d', $dataObj->id);
            if ($dataObj->id) {
                Ticket::where('id', $dataObj->id)->update(['tracking_no' => $trackingNo]);
                $categoryData = $this->ticketCategoryService->getById($request->category);
                $categoryUser = $categoryData->users->pluck('id')->toArray();
                $dataObj->users()->syncWithPivotValues($categoryUser, ['is_active' => ACTIVE, 'tenant_id' => getTenantId(), 'assigned_by' => getUserIdByTenant()], false);
            }

            $getAlluser = User::where('tenant_id', getTenantId())
                ->where('role', '!=', USER_ROLE_CUSTOMER)
                ->get();

            $userData = [];

            foreach ($getAlluser as $key => $singleUser) {
                $userData[] = [
                    'ticket_id' => $dataObj->id,
                    'created_by' => $singleUser->id,
                    'tenant_id' => $singleUser->tenant_id,
                    'is_seen' => 0,
                ];
            }
            $userData[] = [
                'ticket_id' => $dataObj->id,
                'created_by' => $user->id,
                'tenant_id' => getTenantId(),
                'is_seen' => 1,
            ];


            TicketSeenUnseen::insert($userData);


            DB::commit();

            //add user log start
            addUserActivityLog('ticket-create', $user->id, $dataObj->id);
            //add user log end

            //send notification start
//            setCommonNotification(auth()->id(), 'New Ticket created', 'Welcome, You have a new ticket. Ticket tracking number ' . $trackingNo);
            newTicketNotify($dataObj->id);
            //send notification end

            //send email notification start
            newTicketEmailNotify($dataObj->id);
            //send email notification end
            return redirect()->route('ticket.guest-create-ticket')->with('success', __("Ticket created successfully"));
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', SOMETHING_WENT_WRONG);
        }
    }

    public function list($request, $ticket_status)
    {
        $envato = Envato::where('tenant_id', auth()->user()->tenant_id)->first();
        $ticketData = null;
        $notActiveStatus = array(STATUS_RESOLVED, STATUS_CLOSED);
        $activeStatus = array(STATUS_RESOLVED, STATUS_SUSPENDED, STATUS_CANCELED, STATUS_CLOSED, STATUS_ON_HOLD);
        $ticketData = Ticket::with('user')->with('category')
            ->where(['tickets.created_by' => auth()->id(),'tickets.tenant_id'=> auth()->user()->tenant_id])
            ->leftJoin('ticket_seen_unseens', function($join){
                $join->on('tickets.id', '=', 'ticket_seen_unseens.ticket_id');
                $join->on('ticket_seen_unseens.created_by', '=', DB::raw(auth()->id()));
            })->join('users', function($join){
                $join->on('tickets.created_by', '=', 'users.id');
            })->whereNull('users.deleted_at')
            ->orderBy('tickets.last_reply_time', 'DESC')
            ->select('users.name','users.image','users.mobile','users.email','tickets.id','tickets.envato_licence','tickets.tracking_no', 'tickets.ticket_title',
                'tickets.created_by','tickets.category_id', 'tickets.status', 'tickets.priority', 'tickets.created_at',
                'tickets.updated_at','ticket_seen_unseens.is_seen','tickets.last_reply_id');
        if ($ticket_status == STATUS_CLOSED) {
            $ticketData->where(['tickets.deleted_at' => NULL, 'tickets.status' => STATUS_CLOSED]);
        } else if ($ticket_status == STATUS_ON_HOLD) {
            $ticketData->where(['tickets.deleted_at' => NULL, 'tickets.status' => STATUS_ON_HOLD]);
        } else if ($ticket_status == STATUS_RESOLVED) {
            $ticketData->where(['tickets.deleted_at' => NULL, 'tickets.status' => STATUS_RESOLVED]);
        } else if ($ticket_status == 'active') {
            $ticketData->whereNotIn('tickets.status', $notActiveStatus);
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
            ->editColumn('status', function ($data) {
                return getTicketStatusHtml($data);
            })
            ->editColumn('created_at', function ($data) {
                return '<p>' . \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d M, Y') . '</p>';
            })
            ->editColumn('updated_at', function ($data) {
                return '<p>' . \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->updated_at)->diffForHumans() . '</p>';
            })
            ->addColumn('action', function ($data) {
                return '<a href="' . route('customer.ticket.ticket-view', $data->id) . '" class="">
                          <img src="' . asset('customer/assets/images/preview-open.png') . '" alt="">
                        </a>

                        <a onclick="deleteItem(\'' . route('customer.ticket.ticket-delete', $data->id) . '\', \'ticketsDataTable\')" class="">
                          <img src="' . asset('customer/assets/images/trash.png') . '" alt="">
                        </a>';
            })
            ->addColumn('ticket_id', function ($data) {
                return getTicketIdHtml($data);
            })
            ->editColumn('updated', function ($data) {
                if($data->lastConversation?->created_at){
                    $last_reply = $data->lastConversationUser?->role == USER_ROLE_CUSTOMER ? 'You': 'Agent';
                    $userHtml = '<div class="ticket-user-name">
                                     <p>'.$last_reply.'</p>
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
            ->rawColumns(['action', 'status', 'ticket_title', 'created_at', 'updated_at', 'checkbox', 'ticket_id', 'updated', 'assigned_to'])
            ->make(true);
    }

    public function deleteById($id)
    {
        DB::beginTransaction();
        try {
            $ticket = Ticket::where(['id'=> $id,'created_by' => Auth::id()])->firstOrFail();
            if (!$ticket && $ticket == null) {
                return $this->error([], SOMETHING_WENT_WRONG);
            }
            $ticket->delete();
            DB::commit();
            return $this->success([], __(DELETED_SUCCESSFULLY));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error([], __(SOMETHING_WENT_WRONG));
        }
    }

    public function multiDeleteById($request)
    {
        DB::beginTransaction();
        try {
            foreach ($request->multicheck_ticket_id as $key => $item) {
                Ticket::where(['id'=> $item,'created_by' => Auth::id()])->delete();
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


}
