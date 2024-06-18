<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\customer\TicketRequest;
use App\Http\Services\ConversationService;
use App\Http\Services\CustomerTicketService;
use App\Http\Services\NoteService;
use App\Http\Services\TicketCategoryService;
use App\Http\Services\TicketDetailsService;
use App\Http\Services\TicketService;
use App\Http\Services\TicketTagsService;
use App\Models\Category;
use App\Models\DynamicField;
use App\Models\Envato;
use App\Models\KpiSession;
use App\Models\RatingCategory;
use App\Models\Ticket;
use App\Models\TicketRating;
use App\Models\User;
use App\Traits\ResponseTrait;
use Exception;
use App\Models\TicketSeenUnseen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class   TicketsController extends Controller
{
    use ResponseTrait;
    public $ticketCategoryService;
    public $ticketService;
    public $ticketDetailsService;
    public $conversationService;
    public $noteService;
    public $adminTicketService;
    public $ticketTagService;

    public function __construct()
    {
        $this->ticketCategoryService = new TicketCategoryService;
        $this->ticketService = new CustomerTicketService;
        $this->ticketDetailsService = new TicketDetailsService;
        $this->conversationService = new ConversationService;
        $this->noteService = new NoteService;
        $this->adminTicketService = new TicketService;
        $this->ticketTagService = new TicketTagsService;
    }

    public function createTicket()
    {
        $data['pageTitle'] = 'Create Ticket';
        $data['category'] = Category::where('tenant_id', auth()->user()->tenant_id)->get();
        $data['envato'] = Envato::where('tenant_id', auth()->user()->tenant_id)->first();
        $data['dynamicFields'] = DynamicField::where('tenant_id', auth()->user()->tenant_id)->orderBy('order', 'ASC')->get();
        return view('customer.tickets.create_ticket', $data);
    }

    public function store(TicketRequest $request)
    {
        return $this->ticketService->store($request);
    }
    public function guestCreateTicket()
    {
        $data['pageTitle'] = 'Create Ticket';
        $data['category'] = Category::where('tenant_id', getTenantId())->get();
        $data['envato'] = Envato::where('tenant_id', getTenantId())->first();
        $data['dynamicFields'] = DynamicField::where('tenant_id', getTenantId())->orderBy('order', 'ASC')->get();
        return view('customer.tickets.guest_create_ticket', $data);
    }

    public function guestTicketStore(TicketRequest $request)
    {
        return $this->ticketService->guestTicketStore($request);
    }

    public function activeTicket(Request $request)
    {
        if ($request->ajax()) {
            return $this->ticketService->list($request, 'active');
        }
        $data['pageTitle'] = 'Active Ticket';
        $data['navMain'] = 'mm-active';
        return view('customer.tickets.active_ticket', $data);
    }

    public function onHoldTickets(Request $request)
    {
        if ($request->ajax()) {
            return $this->ticketService->list($request, STATUS_ON_HOLD);
        }
        $data['pageTitle'] = 'On-Hold Ticket';
        $data['navMain'] = 'mm-active';
        return view('customer.tickets.onhold_ticket', $data);
    }

    public function resolvedTicketList(Request $request)
    {
        if ($request->ajax()) {
            return $this->ticketService->list($request, STATUS_RESOLVED);
        }
        $data['pageTitle'] = 'Resolved Ticket';
        $data['navMain'] = 'mm-active';
        return view('customer.tickets.resolved_ticket', $data);
    }

    public function closedTickets(Request $request)
    {
        if ($request->ajax()) {
            return $this->ticketService->list($request, STATUS_CLOSED);
        }
        $data['pageTitle'] = 'Closed Ticket';
        $data['navMain'] = 'mm-active';
        return view('customer.tickets.closed_ticket', $data);
    }

//    public function ticketEdit($id)
//    {
//        $data['singleData'] = $this->adminTicketService->getById($id);
//        if (empty($data['singleData'])) {
//            return redirect()->back()->with('message', __('Ticket Information Not Available!'));
//        }
//        $data['pageTitle'] = 'Edit Ticket';
//        $data['category'] = Category::where('tenant_id', auth()->user()->tenant_id)->get();
//        $data['envato'] = Envato::where('tenant_id', auth()->user()->tenant_id)->first();
//        $data['dynamicFields'] = DynamicField::where('tenant_id', auth()->user()->tenant_id)->orderBy('order', 'ASC')->get();
//        $data['ticketDynamicFieldData'] = $this->adminTicketService->getTicketDynamicFieldDeatilsByTicketId($id);
//        return view('customer.tickets.edit_ticket', $data);
//    }

    public function ticketView($id)
    {
        $data['singleData'] = $this->adminTicketService->getById($id);
        if (empty($data['singleData'])) {
            return redirect()->back()->with('error', __('Ticket Not Available!'));
        }
        if (Auth::id() != $data['singleData']->created_by) {
            return redirect()->back()->with('error', __('Ticket Not Available!'));
        }
//        session()->put('ticket_conversation_id', $id);
//        session()->put('ticket_note_id', $id);
        $data['pageTitle'] = __('View Tickets');
        $data['navTicketActiveClass'] = 'mm-active';
        $data['ticketData'] = $this->adminTicketService->getTicketDeatilsByTicketId($id);
        $data['ticketDynamicFieldData'] = $this->adminTicketService->getTicketDynamicFieldDeatilsByTicketId($id);
        $data['allTagsData'] = $this->ticketTagService->getAllTags();
        $data['existingTagsData'] = $this->ticketTagService->getTagsByTicketId($id);

        $data['ticketCategory'] = Category::orderBy('name')->where(['tenant_id' => auth()->user()->tenant_id, 'status' => STATUS_ACTIVE])->get();

        $data['priorities'] = getPriorityStatus();
        $data['userList'] = $this->adminTicketService->userList();
        $data['ticketUserData'] = getTicketAssignedAgentArray($id);
        $data['ticketUserDataStatus'] = $data['singleData']->users->pluck('status')->toArray();
        $data['ticketCreatorData'] = $this->ticketDetailsService->getTicketCreatorInfo($data['singleData']->created_by);
        $data['conversationData'] = $this->conversationService->getConversationData($id);
        $data['noteData'] = $this->noteService->getNoteData($id);
        $data['instantMessageData'] = $this->conversationService->getInstantMessage();
        $data['ratingCategory'] = RatingCategory::orderBy('name')->where(['status' => STATUS_ACTIVE])->get();
//        $data['ticketRatingData'] = TicketRating::orderBy('id')->where(['ticket_id' => $id, 'status' => STATUS_ACTIVE])->first();

//        $data['ticketRatingData'] = TicketRating::query()
//            ->leftJoin('users', 'ticket_ratings.agent_id', '=', 'users.id')
//            ->where(['ticket_ratings.ticket_id' => $id, 'ticket_ratings.status' => STATUS_ACTIVE])
//            ->selectRaw('ticket_ratings.agent_id as agent_id, users.name as agent_name, AVG(ticket_ratings.rating) as total_rating_point')
//            ->groupBy('ticket_ratings.agent_id')
//            ->get();


        $data['envato'] = Envato::where('tenant_id', auth()->user()->tenant_id)->first();

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
        return view('customer.tickets.ticket_details.index', $data);
    }

    public function ticketDelete($id)
    {
        return $this->ticketService->deleteById($id);
    }

    public function ticketMultiDelete(Request $request)
    {
        return $this->ticketService->multiDeleteById($request);
    }

//    public function assignTicketUser(Request $request)
//    {
//        return $this->adminTicketService->ticketAssignment($request);
//    }

    public function guestTicketDetails($id)
    {
        //decode id

        $decode_id=0;
        try {
            $decode_id = decrypt($id);
        }catch (Exception $exception){
            abort(404);
        }

        $data['singleData'] = $this->adminTicketService->getById($decode_id);

        if (empty($data['singleData'])) {
            return redirect()->back()->with('message', __('Ticket Information Not Available!'));
        }
//        session()->put('ticket_conversation_id', $decode_id);
//        session()->put('ticket_note_id', $decode_id);
        $data['pageTitle'] = __('View Tickets');
        $data['navTicketActiveClass'] = 'mm-active';
        $data['ticketData'] = $this->adminTicketService->getTicketDeatilsByTicketId($decode_id);
        $data['ticketDynamicFieldData'] = $this->adminTicketService->getTicketDynamicFieldDeatilsByTicketId($id);
        $data['id'] = $decode_id;
//        $data['allTagsData'] = $this->ticketTagService->getAllTags();
        $data['existingTagsData'] = $this->ticketTagService->getTagsByTicketId($decode_id);

//        $data['ticketCategory'] = Category::orderBy('name')->where(['tenant_id' => getTenantId(), 'status' => STATUS_ACTIVE])->get();

        $data['priorities'] = getPriorityStatus();

//        $data['userList'] =  User::where('tenant_id',getTenantId())
//            ->where('role', USER_ROLE_AGENT)
//            ->get();

        $data['ticketUserData'] = getTicketAssignedAgentArray($decode_id);
        $data['ticketUserDataStatus'] = $data['singleData']->users->pluck('status')->toArray();
        $data['ticketCreatorData'] = $this->ticketDetailsService->getTicketCreatorInfo($data['singleData']->created_by);
        $data['conversationData'] = $this->conversationService->getConversationData($decode_id);
        $data['noteData'] = $this->noteService->getNoteData($decode_id);
        $data['instantMessageData'] = $this->conversationService->getInstantMessage();
        $data['ratingCategory'] = RatingCategory::orderBy('name')->where(['status' => STATUS_ACTIVE])->get();
        $data['ticketRatingData'] = TicketRating::orderBy('id')->where(['ticket_id' => $decode_id, 'status' => STATUS_ACTIVE])->first();
        return view('customer.tickets.ticket_details_guest.index', $data);
    }

    public function ticketStatusUpdate(Request $request)
    {
        try{
            $ticket = Ticket::where(['id'=> $request->ticket_id, 'created_by' => Auth::id()])->first();
            if(is_null($ticket)){
                throw new Exception(SOMETHING_WENT_WRONG);
            }
            if(!in_array($request->ticket_status,[STATUS_CLOSED,STATUS_RESOLVED])){
                throw new Exception(SOMETHING_WENT_WRONG);
            }
            $ticket->status = $request->ticket_status;
            $ticket->status_change_by = auth()->id();
            $ticket->save();

            $status_after_change = getTicketStatus($request->ticket_status);
//            $ticketUser = Ticket::find($ticket->id);
//            $this->ticketDetailsService->getTicketCreatorInfo($ticketUser->created_by);
//            ticketStatusChangeEmailNotify($ticket->id);
//            ticketStatusChangeNotify($ticket->id);
            return $this->success(['status_after_change'=>$status_after_change], "Ticket Status Updated Successfully");
        }catch(Exception $e){
            return $this->error([], "Something Went Wrong!");
        }
    }

    public function guestTicketStatusUpdate(Request $request)
    {
        try{
//            Log::info("aaaaaa");
            $id = decrypt($request->id);
//            Log::info($id);
            $ticket = Ticket::where(['id'=> $id])->first();
            if(is_null($ticket)){
                throw new Exception(SOMETHING_WENT_WRONG);
            }
            if(!in_array($request->ticket_status,[STATUS_CLOSED,STATUS_RESOLVED])){
                throw new Exception(SOMETHING_WENT_WRONG);
            }
//            Log::info(json_encode($ticket));
//            Log::info("=====================");
            $ticket->status = $request->ticket_status;
            $ticket->status_change_by = $ticket->created_by;
            $ticket->save();
//            Log::info(json_encode($ticket));
//            Log::info("=====================");



            $status_after_change = getTicketStatus($request->ticket_status);
//            $user = User::find($ticket->created_by);
//            ticketStatusChangeEmailNotify($id);
//            ticketStatusChangeNotify($id);
            return $this->success(['status_after_change'=>$status_after_change], "Ticket Status Updated Successfully");
        }catch(Exception $e){
            return $this->error([], "Something Went Wrong!");
        }
    }

}
