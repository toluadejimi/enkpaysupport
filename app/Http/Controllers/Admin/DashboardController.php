<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\TicketService;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Package;
use App\Models\Ticket;
use App\Models\User;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    use ResponseTrait;

    public $ticketService;

    public function __construct()
    {
        $this->ticketService = new TicketService;
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = 'Dashboard';
        $data['navDashboard'] = 'mm-active';
        //admin
        if(isAddonInstalled('DESKSAAS') > 0){
            if(auth()->user()->role == USER_ROLE_ADMIN){
                if ($request->ajax()) {
                    return $this->ticketService->list($request, 'active');
                }

                $notActiveStatus = array(STATUS_RESOLVED, STATUS_SUSPENDED, STATUS_CANCELED, STATUS_CLOSED, STATUS_ON_HOLD);
                $data['closedTicketCount'] = Ticket::with('user')->where(['tenant_id' => auth()->user()->tenant_id, 'deleted_at' => NULL, 'status' => STATUS_CLOSED])->count();
                $data['onHoldTicketCount'] = Ticket::with('user')->where(['tenant_id' => auth()->user()->tenant_id, 'deleted_at' => NULL, 'status' => STATUS_RESOLVED])->count();
                $data['activeTicketCount'] = Ticket::with('user')->where(['tenant_id' => auth()->user()->tenant_id, 'deleted_at' => NULL])->whereNotIn('status', $notActiveStatus)->count();
                $data['recentTicketCount'] = Ticket::where(['tenant_id'=> auth()->user()->tenant_id])->where(['status'=>STATUS_PENDING,'deleted_at'=>NULL])->count();
                $data['myAssignTicketCount'] = User::find(auth()->id())->myAssignedTickets()->count();
                $data['totalTicketCount'] = Ticket::where(['tenant_id' => auth()->user()->tenant_id, 'deleted_at' => NULL])->count();

                $d = array();
                for ($i = 0; $i < 30; $i++) {
                    $d[] = date("M d", strtotime('-' . $i . ' days'));
                }

                $data['day'] = $d;
                $data['chart'] = $this->dashboardDailyTicketChart();
                $data['categoryChart'] = $this->dashboardCategoryChart();
                $data['targetDataUrl'] = route('admin.tickets.activeTicketList');
            }

            if(auth()->user()->role == USER_ROLE_SUPER_ADMIN){
                $data['newUser'] = User::where('role', USER_ROLE_ADMIN)->where('status', ACTIVE)->count();
                $deletedData = User::withTrashed()->where('role', USER_ROLE_ADMIN)->get();
                $deletedUserCount = 0;
                foreach ($deletedData as $user){
                    if($user->deleted_at != null){
                        $deletedUserCount = $deletedUserCount+1;
                    }
                }
                $data['deletedUser'] = $deletedUserCount;
                $data['suspendedUser'] = User::where('role', USER_ROLE_ADMIN)->where('status', STATUS_SUSPENDED)->count();

                $orders = Order::query()
                    ->leftJoin('packages', 'orders.package_id', '=', 'packages.id')
                    ->leftJoin('gateways', 'orders.gateway_id', '=', 'gateways.id')
                    ->leftJoin('users', 'orders.user_id', '=', 'users.id')
                    ->leftJoin('file_managers', ['orders.deposit_slip_id' => 'file_managers.id']);
                if ($request->status == 'bank') {
                    $orders->whereNotNull('orders.deposit_slip_id');
                }
                $data['pendingOrder'] = $orders->select(['orders.*', 'packages.name as packageName', 'gateways.title as gatewayTitle', 'gateways.slug as gatewaySlug'])
                    ->where('orders.payment_status', 'pending')->count();

                $d = array();
                for ($i = 0; $i < 30; $i++) {
                    $d[] = date("M d", strtotime('-' . $i . ' days'));
                }
                $data['day'] = $d;
                $data['chart'] = $this->dashboardDailyOrderChart();
                $data['categoryChart'] = $this->dashboardCategoryChart();
            }
        }else{
                if ($request->ajax()) {
                    return $this->ticketService->list($request, 'active');
                }

                $notActiveStatus = array(STATUS_RESOLVED, STATUS_SUSPENDED, STATUS_CANCELED, STATUS_CLOSED, STATUS_ON_HOLD);
                $data['closedTicketCount'] = Ticket::with('user')->where(['tenant_id' => auth()->user()->tenant_id, 'deleted_at' => NULL, 'status' => STATUS_CLOSED])->count();
                $data['onHoldTicketCount'] = Ticket::with('user')->where(['tenant_id' => auth()->user()->tenant_id, 'deleted_at' => NULL, 'status' => STATUS_RESOLVED])->count();
                $data['activeTicketCount'] = Ticket::with('user')->where(['tenant_id' => auth()->user()->tenant_id, 'deleted_at' => NULL])->whereNotIn('status', $notActiveStatus)->count();
                $data['recentTicketCount'] = Ticket::where(['tenant_id'=> auth()->user()->tenant_id])->where(['status'=>STATUS_PENDING,'deleted_at'=>NULL])->count();
                $data['myAssignTicketCount'] = User::find(auth()->id())->myAssignedTickets()->count();
                $data['totalTicketCount'] = Ticket::where(['tenant_id' => auth()->user()->tenant_id, 'deleted_at' => NULL])->count();

                $d = array();
                for ($i = 0; $i < 30; $i++) {
                    $d[] = date("M d", strtotime('-' . $i . ' days'));
                }

                $data['day'] = $d;
                $data['chart'] = $this->dashboardDailyTicketChart();
                $data['categoryChart'] = $this->dashboardCategoryChart();
                $data['targetDataUrl'] = route('admin.tickets.activeTicketList');

        }

        return view('admin.dashboard.dashboard', $data);
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
        $chatData =[];
        $emptyDay= [];
        for ($i = 0; $i < 30; $i++) {
            $emptyDay[date("M d", strtotime('-' . $i . ' days'))] = 0;
        }
        foreach ($cat as $c){
            $day = $emptyDay;
            foreach ($mainData as $data){
                if($c->id == $data->category_id){
                    $day[$data->day] = $data->total;
                    $chatData[$c->name] = $day;
                }
            }
        }
        return $chatData;
    }

    public function dashboardDailyOrderChart()
    {
        $startDate = Carbon::now();
        $firstDayOfMonth = date("Y-m-d H:i:s", strtotime('-30 days'));
        $lastDayOfMonth = date("Y-m-d H:i:s");
        $package = Package::all();
        $mainData = Order::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
            ->where('payment_status', ORDER_PAYMENT_STATUS_PAID)
            ->groupBy('package_id', DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"))
            ->select(DB::raw("DATE_FORMAT(created_at,'%b %d') as day, package_id,count('package_id') as total"))
            ->get();
        $chatData =[];
        $emptyDay= [];
        for ($i = 0; $i < 30; $i++) {
            $emptyDay[date("M d", strtotime('-' . $i . ' days'))] = 0;
        }
        foreach ($package as $p){
            $day = $emptyDay;
            foreach ($mainData as $data){
                if($p->id == $data->package_id){
                    $day[$data->day] = $data->total;
                    $chatData[$p->name] = $day;
                }
            }
        }
        return $chatData;
    }

    public function dashboardCategoryChart()
    {
        $chatData=[];
        $cat = Category::all();
        $mainData = Ticket::select(DB::raw("category_id,count('category_id') as total"))
            ->where('tenant_id', auth()->user()->tenant_id)
            ->groupBy('category_id')
            ->get();
            foreach ($cat as $c){
                foreach ($mainData as $key=>$data){
                    if($c->id == $data->category_id){
                        $chatData[] =[
                            'category_name' => $c->name,
                            'total' =>  $data->total
                        ];
                    }
                }
            }

        return $chatData;
    }

}
