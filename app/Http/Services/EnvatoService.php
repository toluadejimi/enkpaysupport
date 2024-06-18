<?php

namespace App\Http\Services;

use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\Envato;
use App\Models\Ticket;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class EnvatoService
{
    use ResponseTrait;

    public function list()
    {
        $ticketData = Ticket::with('user')->where(['tenant_id'=> auth()->user()->tenant_id,'deleted_at'=>NULL])->orderBy('id', 'ASC')->select('id','tracking_no', 'ticket_title', 'created_by', 'status', 'priority', 'created_at');
        return datatables($ticketData)
            ->addIndexColumn()
            ->editColumn('created_by', function ($data) {
                return $data->user->name;
            })
            ->editColumn('ticket_title', function ($data) {
                $ticketDetails =  '<h3>'.htmlspecialchars($data->ticket_title).'</h3>
                <div>
                  <span>
                    <li>'. $data->tracking_no .'</li>
                  </span>
                  <span>
                    <li>'. \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d M Y') .'</li>
                  </span>';
                  if($data->priority == LOW ){
                    $ticketDetails .='<span class="low">
                    <li>Low</li>
                  </span>';
                  } else if($data->priority == MEDIUM ){
                    $ticketDetails .='<span class="generally">
                    <li>Medium</li>
                  </span>';
                  } else if($data->priority == HIGH ){
                    $ticketDetails .='<span class="high">
                    <li>High</li>
                  </span>';
                  }else if($data->priority == CRITICAL ){
                    $ticketDetails .='<span class="critical">
                    <li>Critical</li>
                  </span>';
                  }
                  $ticketDetails .='</div>';
                  return $ticketDetails;
            })
            ->editColumn('status', function ($data) {
                if ($data->status == STATUS_OPEND) {
                    return '<button class="small-btn pending-btn">New</button>';
                } else if($data->status == STATUS_INPROGRESS){
                    return '<button class="small-btn processing-btn">In Progress</button>';
                } else if($data->status == STATUS_CANCELED){
                return '<button class="small-btn canceled-btn">Canceled</button>';
                } else if($data->status == STATUS_ON_HOLD){
                    return '<button class="small-btn onhold-btn">On Hold</button>';
                } else if($data->status == STATUS_CLOSED){
                    return '<button class="small-btn close-btn">Closed</button>';
                } else if($data->status == STATUS_RESOLVED){
                    return '<button class="small-btn solved-btn">Solved</button>';
                } else if($data->status == STATUS_REOPEN){
                    return '<button class="small-btn success-btn">Re Open</button>';
                }
                else{

                }
            })
            ->addColumn('assigned_to', function ($data) {
                $vassign =  '<select name="assign_to" id="assign_to" required class="form-control">
                <option value="assing">';
                $vassign .=__('Assign');
                $vassign .='</option>
                <option value="self">';
                $vassign .=__('Self');
                $vassign .='</option><option value="others">';
                $vassign .=__('Others');
                $vassign .='</option></select>';
                return $vassign;
            })
            ->addColumn('action', function ($data) {
                return'<div class="action__buttons d-flex justify-content-end">
                    <button onclick="window.location=\''.route('admin.tickets.ticket_view', $data->id).'\' " class="btn-action me-2 edit" data-toggle="tooltip" title="Ticket Details">
                    <img src="' . asset('admin/images/yajra-datatable/preview-open.png') . '" alt="view ticket">
                    </button>
                    <button onclick="deleteItem(\'' . route('admin.tickets.ticket-delete', $data->id) . '\', \'blogCategoryDataTable\')" class="tbl-action-btn text-danger"   title="Delete"><img src="' . asset('admin/images/yajra-datatable/trash.png') . '" alt="delete ticket"></button>
                </div>';
            })
            ->rawColumns(['action', 'status','ticket_title','assigned_to'])
            ->make(true);
    }

    public function sotre($request)
    {

        DB::beginTransaction();
        try {
            if( $request->key == 'enable_purchase_code'){
                $dataObj = Envato::where('tenant_id', auth()->user()->tenant_id)->first();

                if ($dataObj && $dataObj != null) {
                    $dataObj->enable_purchase_code = $request->value;
                    $dataObj->save();
                } else {
                    $dataObj = new Envato();
                    $dataObj->enable_purchase_code = $request->value;
                    $dataObj->tenant_id = auth()->user()->tenant_id;
                    $dataObj->save();
                }
            }

            if( $request->key == 'envato_expired_on'){
                $dataObj = Envato::where('tenant_id', auth()->user()->tenant_id)->first();

                if ($dataObj && $dataObj != null) {
                    $dataObj->envato_expired_on = $request->value;
                    $dataObj->save();
                } else {
                    $dataObj = new Envato();
                    $dataObj->envato_expired_on = $request->value;
                    $dataObj->tenant_id = auth()->user()->tenant_id;
                    $dataObj->save();
                }
            }

            DB::commit();
            return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
    public function sotreConfigData($request)
    {
        DB::beginTransaction();
        try {
                $dataObj = Envato::where('tenant_id', auth()->user()->tenant_id)->first();
                if ($dataObj && $dataObj != null) {
                    $dataObj->personal_api_token = $request->envato_personal_api_token;
                    $dataObj->save();
                } else {
                    $dataObj = new Envato();
                    $dataObj->personal_api_token = $request->envato_personal_api_token;
                    $dataObj->tenant_id = auth()->user()->tenant_id;
                    $dataObj->save();
                }
            DB::commit();
            return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function getById($id)
    {
        return Ticket::findOrFail($id);
    }

    public function deleteById($id)
    {
        DB::beginTransaction();
        try {
            $ticket = Ticket::where('id', $id)->firstOrFail();
            if(!$ticket && $ticket == null){
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
    public function getEnvatoConfigData(){
        return Envato::where('tenant_id',auth()->user()->tenant_id)->first();
    }

    public  function licenseVerification($request){

        try {
            $request->validate([
                'envato_license' => 'required',
            ]);

            $licenseKey = trim($request->get('envato_license'));
            $getToken = Envato::where('tenant_id', auth()->user()->tenant_id)->first();

            if(!$getToken || $getToken->personal_api_token ==null){
                return $this->error([], __("First setup your personal api token"));
            }

            $headers = [
                'Authorization' => 'Bearer '.$getToken->personal_api_token,
                'Accept' => 'application/json',
            ];

            $response = Http::withHeaders($headers)->get('https://api.envato.com/v3/market/author/sale?code='. $licenseKey);

            if ($response->successful()) {
                $data = $response->json();
                return $this->success($data, __("License verified successfully"));
            } else {
                $statusCode = $response->status();
                return $this->error([], __("License not verified"));
            }
        } catch (\Exception $e) {
            return $this->error([], __("An error occurred!"));
        }

    }

    public function licenseVerificationForTicket($ticketData){

        try {

            $licenseKey = trim($ticketData->envato_licence);
            $getToken = Envato::where('tenant_id', auth()->user()->tenant_id)->first();

            if(!$getToken || $getToken->personal_api_token ==null){
                return null;
            }

            $headers = [
                'Authorization' => 'Bearer '.$getToken->personal_api_token,
                'Accept' => 'application/json',
            ];

            $response = Http::withHeaders($headers)->get('https://api.envato.com/v3/market/author/sale?code='. $licenseKey);
            if ($response->successful()) {
                $responseData = [
                    "status" => true,
                    "msg" => 'verified',
                    "data" => $response->json()
                ];
            } else {
                $responseData = [
                    "status" => false,
                    "msg" => 'unverified',
                    "data" => null
                ];
            }
            return $responseData;
        } catch (\Exception $e) {
            return null;
        }

    }
}
