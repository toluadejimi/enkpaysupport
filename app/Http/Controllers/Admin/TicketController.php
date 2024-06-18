<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\ConversationService;
use App\Http\Services\EnvatoService;
use App\Http\Services\NoteService;
use App\Http\Services\TicketCategoryService;
use App\Http\Services\TicketDetailsService;
use App\Http\Services\TicketService;
use App\Http\Services\TicketTagsService;
use App\Models\Category;
use App\Models\Envato;
use App\Models\Ticket;
use App\Models\TicketLicenseVerify;
use App\Models\TicketSeenUnseen;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    use ResponseTrait;
    public $ticketService;
    public $ticketTagService;
    public $ticketCategoryService;
    public $ticketDetailsService;
    public $conversationService;
    public $noteService;

    public $adminTicketService;

    public $envatoService;
    public function __construct()
    {
        $this->ticketService = new TicketService;
        $this->ticketTagService = new TicketTagsService;
        $this->ticketCategoryService = new TicketCategoryService;
        $this->ticketDetailsService = new TicketDetailsService;
        $this->conversationService = new ConversationService;
        $this->noteService = new NoteService;
        $this->adminTicketService = new TicketService;
        $this->envatoService = new EnvatoService;

    }

    public function ticketList(Request $request)
    {
        $ticket_status = 'all';
        if ($request->ajax()) {
            return $this->ticketService->list($request,$ticket_status);
        } else {
            $data['pageTitle'] = __('All Tickets List');
            $data['navTicketAllClass'] = 'mm-active';
            $data['targetDataUrl'] = route('admin.tickets.ticketList');
            return view('admin.tickets.management.index', $data);
        }
    }

    public function categoryStore(Request $request)
    {
       return $this->ticketService->ticketAssignment($request);
    }
    public function ticketView($id,$user_id=null)
    {
        if($user_id!=null){
            $data['singleData'] = $this->ticketService->getByTicketIdAndUserId($id,$user_id);
        }
        $data['singleData'] = $this->ticketService->getById($id);
        if(empty($data['singleData'])){
            return redirect()->back()->with('message',__('Ticket Information Not Available!'));
        }
//        session()->put('ticket_conversation_id',$id);
//        session()->put('ticket_note_id',$id);
        $data['pageTitle'] = __('Ticket Details lsit');
        $data['navTicketActiveClass'] = 'mm-active';
        $data['ticketData'] = $this->ticketService->getTicketDeatilsByTicketId($id);
        $data['ticketDynamicFieldData'] = $this->adminTicketService->getTicketDynamicFieldDeatilsByTicketId($id);
        $data['allTagsData'] = $this->ticketTagService->getAllTags();
        $data['existingTagsData'] = $this->ticketTagService->getTagsByTicketId($id);

        $data['ticketCategory'] = Category::orderBy('name')->where(['tenant_id'=>auth()->user()->tenant_id,'status'=>STATUS_ACTIVE])->get();

        $data['priorities'] = getPriorityStatus();
        $data['userList'] = $this->ticketService->userList();
        $data['ticketUserData'] = $data['singleData']->users()->where(['is_active' => 1])->pluck('id')->toArray();

        $data['ticketUserDataStatus'] = $data['singleData']->users->pluck('status')->toArray();
        $data['ticketCreatorData'] = $this->ticketDetailsService->getTicketCreatorInfo($data['singleData']->created_by);
        $data['conversationData'] = $this->conversationService->getConversationData($id);
        $data['noteData'] = $this->noteService->getNoteData($id);
        $data['instantMessageData'] = $this->conversationService->getInstantMessage();
        $data['agent_fake_name_config'] = getAgentFakeNameConfig();
        $data['envato'] = Envato::where('tenant_id', auth()->user()->tenant_id)->first();

        $data['envatoData'] = null;
        if (isset($data['envato']->envato_expired_on) && $data['envato']->envato_expired_on == STATUS_ACTIVE) {

            $responseData = null;
            $getData = TicketLicenseVerify::where('ticket_id', $id)->first();
            if($getData != null){
                if ($getData->response_json != null && date('d-m-Y', strtotime($getData->verified_at)) < date('d-m-Y')){
                    $responseData = $this->envatoService->licenseVerificationForTicket($data['ticketData']);
                }
            }else{
                $responseData = $this->envatoService->licenseVerificationForTicket($data['ticketData']);
            }

            if ($responseData != null) {
                //response save start
                if (!is_null($getData)){
                    $dataObj = TicketLicenseVerify::where('ticket_id', $id)->first();
                }else{
                    $dataObj = new TicketLicenseVerify();
                }
                $dataObj->ticket_id = $id;
                $dataObj->response_json = $responseData['status'] == true? json_encode($responseData['data']):null;
                $dataObj->verified_at = $responseData['status'] == true? now():null;
                $dataObj->save();
                //response save end

            }

            $dbdata = TicketLicenseVerify::where('ticket_id', $id)->first();
            $responseData = json_decode($dbdata?->response_json);

            $currentDate = date("Y-m-d");
            $currentTime = date("H:i:s");
            $currentDate = Carbon::parse(date("Y-m-d H:i:s", strtotime($currentDate . $currentTime)));
            $supportuntil = Carbon::parse(date('Y-m-d', strtotime($responseData?->supported_until)));
            if ($currentDate < $supportuntil) {
                $data['envatoDayCount'] = $currentDate->diffInDays($supportuntil);
            } else {
                $data['envatoDayCount'] = 0;
            }

            $data['envatoData'] = $responseData;
        }
        $seenUneenData = TicketSeenUnseen::where(['ticket_id'=>$id, 'created_by'=>auth()->id()])->first();
        if(is_null($seenUneenData)){
            $seenUneenData = new TicketSeenUnseen();
            $seenUneenData->ticket_id = $id;
            $seenUneenData->created_by = auth()->id();
            $seenUneenData->is_seen = 1;
            $seenUneenData->tenant_id = auth()->user()->tenant_id;
        }else{
            $seenUneenData->is_seen = 1;
        }
        $seenUneenData->save();

        return view('admin.tickets.management.ticket_details.index', $data);
    }
    public function ticketDelete($id)
    {
        return $this->ticketService->deleteById($id);
    }

    public function ticketAssignTo(Request $request){
        $ticketId = $request->ticketId;
       $msg =  $this->ticketService->ticketAssignTo($ticketId);
       $data = array(
        'status'=>$msg->getData()->status,
        'message'=>$msg->getData()->message,
       );
       die(json_encode($data));
    }
    public function ticketAssignToUsers($id)
    {
        $data['userList'] = $this->ticketService->userList();
        $data['singleData'] = $this->ticketService->getById($id);
        $data['ticketUserData'] = $data['singleData']->users->pluck('id')->toArray();
        $data['ticketUserDataStatus'] = $data['singleData']->users->pluck('status')->toArray();

        return view('admin.tickets.management.ticket-assign-form', $data);
    }

    public function assignTicketsDataStore(Request $request)
    {
        return $this->ticketService->ticketAssignment($request);
    }

    public function recentTicketList(Request $request)
    {
        $ticket_status = STATUS_PENDING;
        if ($request->ajax()) {
            return $this->ticketService->list($request,$ticket_status);
        } else {
            $data['pageTitle'] = __('Recent Tickets List');
            $data['navTicketRecentClass'] = 'mm-active';
            $data['targetDataUrl'] = route('admin.tickets.recentTicketList');
            return view('admin.tickets.management.index', $data);
        }
    }

    public function activeTicketList(Request $request)
    {
        $ticket_status = 'active';
        if ($request->ajax()) {
            return $this->ticketService->list($request,$ticket_status);
        } else {
            $data['pageTitle'] = __('Active Tickets List');
            $data['navTicketActiveClass'] = 'mm-active';
            $data['targetDataUrl'] = route('admin.tickets.activeTicketList');
            return view('admin.tickets.management.index', $data);
        }
    }

    public function closedTicketList(Request $request)
    {
        $ticket_status = STATUS_CLOSED;
        if ($request->ajax()) {
            return $this->ticketService->list($request,$ticket_status);
        } else {
            $data['pageTitle'] = __('Closed Tickets List');
            $data['navTicketClosedClass'] = 'mm-active';
            $data['targetDataUrl'] = route('admin.tickets.closedTicketList');
            return view('admin.tickets.management.index', $data);
        }
    }

    public function onHoldTicketList(Request $request)
    {
        $ticket_status = STATUS_ON_HOLD;
        if ($request->ajax()) {
            return $this->ticketService->list($request,$ticket_status);
        } else {
            $data['pageTitle'] = __('On Hold Tickets List');
            $data['navTicketOnHoldClass'] = 'mm-active';
            $data['targetDataUrl'] = route('admin.tickets.onHoldTicketList');
            return view('admin.tickets.management.index', $data);
        }
    }

    public function assignedTicketList(Request $request)
    {
        $ticket_status = STATUS_INPROGRESS;
        if ($request->ajax()) {
            return $this->ticketService->list($request,$ticket_status);
        } else {
            $data['pageTitle'] = __('Assigned Tickets List');
            $data['navTicketAssignedClass'] = 'mm-active';
            $data['targetDataUrl'] = route('admin.tickets.assignedTicketList');
            return view('admin.tickets.management.index', $data);
        }
    }

    public function suspendedTicketList(Request $request)
    {
        $ticket_status = STATUS_SUSPENDED;
        if ($request->ajax()) {
            return $this->ticketService->list($request,$ticket_status);
        } else {
            $data['pageTitle'] = __('Suspended Tickets List');
            $data['navTicketSuspendedClass'] = 'mm-active';
            $data['targetDataUrl'] = route('admin.tickets.suspendedTicketList');
            return view('admin.tickets.management.index', $data);
        }
    }

    public function resolvedTicketList(Request $request)
    {
        $ticket_status = STATUS_RESOLVED;
        if ($request->ajax()) {
            return $this->ticketService->list($request,$ticket_status);
        } else {
            $data['pageTitle'] = __('Resolved Tickets List');
            $data['navTicketResolvedClass'] = 'mm-active';
            $data['targetDataUrl'] = route('admin.tickets.resolvedTicketList');
            return view('admin.tickets.management.index', $data);
        }
    }

    public function deleteTicketList(Request $request)
    {
        $ticket_status = 'delete';
        if ($request->ajax()) {
            return $this->ticketService->list($request,$ticket_status);
        } else {
            $data['pageTitle'] = __('Trashed Tickets List');
            $data['navTicketDeleteClass'] = 'mm-active';
            $data['targetDataUrl'] = route('admin.tickets.deleted-tickets');
            return view('admin.tickets.management.index', $data);
        }
    }


    public function flyingTicket(Request $request){
        if ($request->ajax()) {
            return $this->ticketService->flyingTicketList($request);
        } else {
            $data['pageTitle'] = __('Flying Ticket');
            $data['navFlyingTicket'] = 'mm-active';
            return view('admin.tickets.flying_tickets.index', $data);
        }
    }
    public function addTicketTags(Request $request){
        return $this->ticketTagService->addTicketTags($request);
    }

    public function categoryUpdate(Request $request)
    {
        Ticket::where('id', $request->category_ticket_id)->update(['category_id' => $request->ticket_category]);
        return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
    }

    public function priorityUpdate(Request $request)
    {
        Ticket::where('id', $request->priority_ticket_id)->update(['priority' => $request->ticket_priority]);
        return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
    }
    public function assignTicketUser(Request $request){
       return $this->ticketService->ticketAssignment($request);
    }

    public function ticketStatusUpdate(Request $request)
    {
        try{
            Ticket::where(['id'=> $request->ticket_id])
            ->update([
                    'status' => $request->ticket_status,
                    'status_change_by' => auth()->id()
                ]);
                $status_after_change = getTicketStatus($request->ticket_status);
                $ticketUser = $this->ticketService->getById($request->ticket_id);
                $ticketCreatorData = $this->ticketDetailsService->getTicketCreatorInfo($ticketUser->created_by);
                ticketStatusChangeEmailNotify($request->ticket_id);
//                ticketStatusChangeNotify($request->ticket_id);
                return $this->success(['status_after_change'=>$status_after_change], "Ticket Status Updated Successfully");
        }catch(Exception $e){
            return $this->error([], "Something Went Wrong!");
        }
    }

    public function ticketMultiDelete(Request $request){
        return $this->ticketService->multiDeleteById($request);
    }

    public function myTicketHistory(Request $request,$id)
    {
        if ($request->ajax()) {
            return $this->ticketService->myTicketHistory($request,$id);
        }
        $data['pageTitle'] = __('Ticket History');
        $data['navTicketActiveClass'] = 'mm-active';
        $data['my_id'] = $id;
        return view('admin.tickets.management.my-ticket-history', $data);
    }

    public function licenseDataUpdate(Request $request)
    {
        try {
            Ticket::where(['id' => $request->ticket_id])
                ->update([
                    'envato_licence' => $request->license
                ]);
            return $this->success([], "License Updated Successfully");
        } catch (Exception $e) {
            return $this->error([], "Something Went Wrong!");
        }
    }

}
