<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Services\AgentTicketService;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use ResponseTrait;

    public $ticketService;

    public function __construct()
    {

        $this->ticketService = new AgentTicketService;
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            return $this->ticketService->list($request, 'active');
        }
        $notActiveStatus = array(STATUS_RESOLVED, STATUS_SUSPENDED, STATUS_CANCELED, STATUS_CLOSED, STATUS_ON_HOLD);
        $data['closedTicketCount'] = Ticket::with('user')->where(['tenant_id' => getTenantId(), 'deleted_at' => NULL, 'status' => STATUS_CLOSED])->count();
        $data['onHoldTicketCount'] = Ticket::with('user')->where(['tenant_id' => getTenantId(), 'deleted_at' => NULL, 'status' => STATUS_RESOLVED])->count();
        $data['activeTicketCount'] = Ticket::with('user')->where(['tenant_id' => getTenantId(), 'deleted_at' => NULL])->whereNotIn('status', $notActiveStatus)->count();
        $data['recentTicketCount'] = Ticket::where(['tenant_id'=> auth()->user()->tenant_id])->where(['status'=>STATUS_PENDING,'deleted_at'=>NULL])->count();
        $data['myAssignTicketCount'] = User::find(auth()->id())->myAssignedTickets()->count();
        $data['totalTicketCount'] = Ticket::where(['tenant_id' => getTenantId(), 'deleted_at' => NULL])->count();

        $d = array();
        for ($i = 0; $i < 30; $i++) {
            $d[] = date("M d", strtotime('-' . $i . ' days'));
        }

        $data['day'] = $d;
        $data['chart'] = $this->dashboardDailyTicketChart();
        $data['categoryChart'] = $this->dashboardCategoryChart();
        return view('agent.dashboard', $data);
    }

    public function dashboardDailyTicketChart()
    {

        $startDate = Carbon::now();
        $firstDayOfMonth = date("Y-m-d H:i:s", strtotime('-30 days'));
        $lastDayOfMonth = date("Y-m-d H:i:s");
        $cat = Category::all();
        $mainData = Ticket::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
            ->where('tenant_id', auth()->user()->tenant_id)
            ->groupBy('category_id', DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"))
            ->select(DB::raw("DATE_FORMAT(created_at,'%b %d') as day, category_id,count('category_id') as total"))
            ->get();


        $chatData = [];
        $emptyDay= [];
        for ($i = 0; $i < 30; $i++) {
            $emptyDay[date("M d", strtotime('-' . $i . ' days'))] = 0;
        }
        foreach ($cat as $c) {
            $day = $emptyDay;
            foreach ($mainData as $data) {
                if ($c->id == $data->category_id) {
                    $day[$data->day] = $data->total;
                    $chatData[$c->name] = $day;
                }
            }

        }
        return $chatData;
    }

    public function dashboardCategoryChart()
    {
        $chatData = [];
        $cat = Category::all();
        $mainData = Ticket::where('tenant_id', auth()->user()->tenant_id)
            ->select(DB::raw("category_id,count('category_id') as total"))
            ->groupBy('category_id')
            ->get();
        foreach ($cat as $c) {
            foreach ($mainData as $key => $data) {
                if ($c->id == $data->category_id) {
                    $chatData[] = [
                        'category_name' => $c->name,
                        'total' => $data->total
                    ];
                }
            }
        }
        return $chatData;
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

    public function tester(Request $request)
    {
        $userId = 4;
        try {
            $agent_data = [
                'total_ticket' => 0,
                'rating_count' => 0,
                'rating_avg' => 0
            ];

            $ratings = Ticket::join('ticket_ratings', 'tickets.id', '=', 'ticket_ratings.ticket_id')
                ->join('ticket_assignee', function ($join) use ($userId) {
                    $join->on('tickets.id', '=', 'ticket_assignee.ticket_id');
                    $join->on('ticket_assignee.assigned_to', '=', DB::raw($userId));
                })->get();

            $agent_data['total_ticket'] = $ratings->count();
            $agent_data['rating_count'] = $ratings->sum('rating');
            $agent_data['rating_avg'] = $ratings->sum('rating') / $ratings->count();

            return $agent_data;

        } catch (Exception $e) {
            return $agent_data = [
                'total_ticket' => 0,
                'rating_count' => 0,
                'rating_avg' => 0,
            ];
        }
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
}

