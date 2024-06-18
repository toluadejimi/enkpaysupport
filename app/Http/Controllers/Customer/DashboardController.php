<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Services\CustomerTicketService;
use App\Http\Services\NewsService;
use App\Http\Services\NotificationService;
use App\Models\Bank;
use App\Models\Category;
use App\Models\FileManager;
use App\Models\Ticket;
use App\Models\User;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use ResponseTrait;

    public $ticketService;

    public function __construct()
    {
        $this->ticketService = new CustomerTicketService;
    }


    public function index(Request $request)
    {


        $notActiveStatus = array(STATUS_RESOLVED, STATUS_SUSPENDED, STATUS_CANCELED, STATUS_CLOSED, STATUS_ON_HOLD);
        $data['closedTicketCount'] = Ticket::with('user')->where(['created_by' => auth()->id(), 'deleted_at' => NULL, 'status' => STATUS_CLOSED])->count();
        $data['onHoldTicketCount'] = Ticket::with('user')->where(['created_by' => auth()->id(), 'deleted_at' => NULL, 'status' => STATUS_RESOLVED])->count();
        $data['activeTicketCount'] = Ticket::with('user')->where(['created_by' => auth()->id(), 'deleted_at' => NULL])->whereNotIn('status', $notActiveStatus)->count();
        $data['totalTicketCount'] = Ticket::where(['created_by' => auth()->id(), 'deleted_at' => NULL])->count();

        if ($request->ajax()) {
            return $this->ticketService->list($request, 'active');
        }

        return view('customer.dashboard', $data);
    }

    public function testConversation(Request $request)
    {
        $ticketData = Ticket::with('user')
            ->where(['tickets.tenant_id' => auth()->user()->tenant_id, 'deleted_at' => NULL])
            ->leftJoin('ticket_seen_unseens', function ($join) {
                $join->on('tickets.id', '=', 'ticket_seen_unseens.ticket_id');
                $join->on('ticket_seen_unseens.created_by', '=', DB::raw(auth()->id()));
            })
            ->orderBy('tickets.last_reply_time', 'DESC')
            ->select('tickets.id', 'tickets.envato_licence', 'tickets.tracking_no', 'tickets.ticket_title',
                'tickets.created_by', 'tickets.status', 'tickets.priority', 'tickets.created_at',
                'ticket_seen_unseens.is_seen', 'tickets.last_reply_id', 'tickets.updated_at', 'tickets.category_id')->get();


        $ticket_id = 22;
        $lc = getLastConversationByTicketId($ticket_id);

    }

    public function setSessionData()
    {
        $sessionData = session('dark_mood');
        if ($sessionData == 0 || $sessionData == 1) {
            if ($sessionData == 0) {
                session()->put('dark_mood', 1);
            } else {
                session()->put('dark_mood', 0);
            }
        }
    }

    public function announcementSeen()
    {
        try {
            DB::beginTransaction();
            $user = User::find(auth()->id());
            $user->announcement_seen = 1;
            $user->save();
            DB::commit();
            return "Msg seen successfully!";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }

    }

}
