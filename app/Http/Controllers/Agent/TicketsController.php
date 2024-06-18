<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\customer\TicketRequest;
use App\Http\Services\AgentTicketService;
use App\Http\Services\ConversationService;
use App\Http\Services\EnvatoService;
use App\Http\Services\NoteService;
use App\Http\Services\TicketCategoryService;
use App\Http\Services\TicketDetailsService;
use App\Http\Services\TicketService;
use App\Http\Services\TicketTagsService;
use App\Models\Category;
use App\Models\DynamicField;
use App\Models\Ticket;
use App\Models\TicketLicenseVerify;
use App\Models\TicketSeenUnseen;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class   TicketsController extends Controller
{
    use ResponseTrait;

    public $ticketCategoryService;
    public $ticketService;
    public $adminTicketService;
    public $ticketTagService;
    public $ticketDetailsService;
    public $conversationService;
    public $noteService;

    public $envatoService;

    public function __construct()
    {
        $this->ticketCategoryService = new TicketCategoryService;
        $this->ticketService = new AgentTicketService;
        $this->adminTicketService = new TicketService;
        $this->ticketTagService = new TicketTagsService;
        $this->ticketCategoryService = new TicketCategoryService;
        $this->ticketDetailsService = new TicketDetailsService;
        $this->conversationService = new ConversationService;
        $this->noteService = new NoteService;
        $this->envatoService = new EnvatoService;

    }

    public function createTicket()
    {
        $data['pageTitle'] = 'Create Ticket';
        $data['category'] = Category::where('tenant_id', auth()->user()->tenant_id)->get();
        $data['dynamicFields'] = DynamicField::where('tenant_id', auth()->user()->tenant_id)->orderBy('order', 'ASC')->get();
        return view('agent.tickets.create_ticket', $data);
    }

    public function store(TicketRequest $request)
    {
        return $this->ticketService->store($request);
    }

    public function activeTicket(Request $request)
    {
        if ($request->ajax()) {
            return $this->ticketService->list($request, 'active');
        }
        $data['pageTitle'] = 'Active Ticket';
        $data['navMain'] = 'mm-active';
        $data['targetDataUrl'] = route('agent.ticket.active-ticket');
        return view('agent.tickets.active_ticket', $data);
    }

    public function myTicketHistory(Request $request, $id)
    {
        if ($request->ajax()) {
            return $this->ticketService->myTicketHistory($request, $id);
        }
        $data['pageTitle'] = __('Ticket History');
        $data['navTicketActiveClass'] = 'mm-active';
        $data['my_id'] = $id;
        return view('agent.tickets.my-ticket-history', $data);
    }

    public function recentTicket(Request $request)
    {
        if ($request->ajax()) {
            return $this->ticketService->list($request, 'recent');
        }
        $data['pageTitle'] = 'Recent Ticket';
        $data['navMain'] = 'mm-active';
        $data['targetDataUrl'] = route('agent.ticket.recent-ticket');
        return view('agent.tickets.recent_ticket', $data);
    }

    public function allTicket(Request $request)
    {
        if ($request->ajax()) {
            return $this->ticketService->list($request, 'all');
        }
        $data['pageTitle'] = 'All Ticket';
        $data['navMain'] = 'mm-active';
        $data['targetDataUrl'] = route('agent.ticket.all-ticket');
        return view('agent.tickets.all_ticket', $data);
    }

    public function suspendTicket(Request $request)
    {
        if ($request->ajax()) {
            return $this->ticketService->list($request, STATUS_SUSPENDED);
        }
        $data['pageTitle'] = 'Suspended Ticket';
        $data['navMain'] = 'mm-active';
        return view('agent.tickets.suspended_ticket', $data);
    }

    public function selfAssignedTicket(Request $request)
    {
        if ($request->ajax()) {
            return $this->ticketService->list($request, 'self-assigned-tickets');
        }
        $data['pageTitle'] = 'Self Assigned Ticket';
        $data['navMain'] = 'mm-active';
        return view('agent.tickets.self_assigned_ticket', $data);
    }

    public function myAssignedTicket(Request $request)
    {
        if ($request->ajax()) {
            return $this->ticketService->list($request, 'my-assigned-tickets');
        }
        $data['pageTitle'] = 'My Assigned Ticket';
        $data['navMain'] = 'mm-active';
        return view('agent.tickets.my_assigned_ticket', $data);
    }

    public function resolvedTicketList(Request $request)
    {
        if ($request->ajax()) {
            return $this->ticketService->list($request, STATUS_RESOLVED);
        }
        $data['pageTitle'] = 'Resolved Ticket';
        $data['navMain'] = 'mm-active';
        return view('agent.tickets.resolved_ticket', $data);
    }

    public function onHoldTickets(Request $request)
    {
        if ($request->ajax()) {
            return $this->ticketService->list($request, STATUS_ON_HOLD);
        }
        $data['pageTitle'] = 'On-Hold Ticket';
        $data['navMain'] = 'mm-active';
        return view('agent.tickets.onhold_ticket', $data);
    }

    public function closedTickets(Request $request)
    {
        if ($request->ajax()) {
            return $this->ticketService->list($request, STATUS_CLOSED);
        }
        $data['pageTitle'] = 'Closed Ticket';
        $data['navMain'] = 'mm-active';
        return view('agent.tickets.closed_ticket', $data);
    }

    public function deleteTicketList(Request $request)
    {
        $ticket_status = 'delete';
        if ($request->ajax()) {
            return $this->ticketService->list($request, $ticket_status);
        } else {
            $data['pageTitle'] = __('Trashed Tickets');
            $data['navMain'] = 'mm-active';
            return view('agent.tickets.deleted_ticket', $data);
        }
    }

    public function ticketView($id, $user_id = null)
    {
        if ($user_id != null) {
            $data['singleData'] = $this->adminTicketService->getByTicketIdAndUserId($id, $user_id);
        }
        $data['singleData'] = $this->adminTicketService->getById($id);
        if (empty($data['singleData'])) {
            return redirect()->back()->with('message', __('Ticket Information Not Available!'));
        }
//        session()->put('ticket_conversation_id', $id);
//        session()->put('ticket_note_id', $id);
        $data['pageTitle'] = __('Ticket Details');
        $data['navTicketActiveClass'] = 'mm-active';
        $data['ticketData'] = $this->adminTicketService->getTicketDeatilsByTicketId($id);
        $data['ticketDynamicFieldData'] = $this->adminTicketService->getTicketDynamicFieldDeatilsByTicketId($id);
        $data['allTagsData'] = $this->ticketTagService->getAllTags();
        $data['existingTagsData'] = $this->ticketTagService->getTagsByTicketId($id);
        $data['ticketCategory'] = Category::orderBy('name')->where(['tenant_id' => auth()->user()->tenant_id, 'status' => STATUS_ACTIVE])->get();
        $data['priorities'] = getPriorityStatus();
        $data['userList'] = $this->adminTicketService->userList();

//        $data['ticketUserData'] = getTicketAssignedAgentArray($id);
        $data['ticketUserData'] = $data['singleData']->users()->where(['is_active' => 1])->pluck('id')->toArray();

        $data['ticketUserDataStatus'] = $data['singleData']->users->pluck('status')->toArray();
        $data['ticketCreatorData'] = $this->ticketDetailsService->getTicketCreatorInfo($data['singleData']->created_by);
        $data['conversationData'] = $this->conversationService->getConversationData($id);
        $data['noteData'] = $this->noteService->getNoteData($id);
        $data['instantMessageData'] = $this->conversationService->getInstantMessage();
        $data['envatoConfigData'] = $this->envatoService->getEnvatoConfigData();
        $data['envatoData'] = null;
        if (isset($data['envatoConfigData']->envato_expired_on) && $data['envatoConfigData']->envato_expired_on == STATUS_ACTIVE) {
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


        return view('agent.tickets.ticket_details.index', $data);
    }

    public function ticketDelete($id)
    {
        return $this->ticketService->deleteById($id);
    }

    public function ticketMultiDelete(Request $request)
    {
        return $this->ticketService->multiDeleteById($request);
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

    public function assignTicketUser(Request $request)
    {
        return $this->adminTicketService->ticketAssignment($request);
    }

    public function ticketStatusUpdate(Request $request)
    {
        try {
            Ticket::where(['id' => $request->ticket_id])
                ->update([
                    'status' => $request->ticket_status,
                    'status_change_by' => auth()->id()
                ]);
            $status_after_change = getTicketStatus($request->ticket_status);
            $ticketUser = $this->adminTicketService->getById($request->ticket_id);
            $ticketCreatorData = $this->ticketDetailsService->getTicketCreatorInfo($ticketUser->created_by);
            ticketStatusChangeEmailNotify($request->ticket_id);
            ticketStatusChangeNotify($request->ticket_id);
            return $this->success(['status_after_change' => $status_after_change], "Ticket Status Updated Successfully");
        } catch (Exception $e) {
            return $this->error([], "Something Went Wrong!");
        }
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
