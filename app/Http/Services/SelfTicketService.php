<?php

namespace App\Http\Services;

use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class SelfTicketService
{
    use ResponseTrait;

    public function list($type)
    {
        $ticketData = null;
        if ($type == 'self-assing-tickets') {
            $ticketData = User::find(auth()->id())->tickets()->having('pivot_assigned_by','=',auth()->id())->get();
        } else if ($type == 'my-assing-tickets') {
            $ticketData = User::find(auth()->id())->tickets()->having('pivot_assigned_by','!=',auth()->id())->get();
        }else if ($type == 'closed-tickets') {
            $ticketData = User::find(auth()->id())->tickets()->having('status','=',STATUS_CLOSED)->get();
        } else if ($type == 'suspend-tickets') {
            $ticketData = User::find(auth()->id())->tickets()->having('status','=',STATUS_CANCELED)->get();
        }


        return datatables($ticketData)
            ->addIndexColumn()
            ->editColumn('created_by', function ($data) {
                return $data->name;
            }) ->editColumn('assigned_to', function ($data) {
                return getUserNameById($data['pivot']['assigned_by']);
            })
            ->editColumn('status', function ($data) {
                if ($data->status == STATUS_OPEND) {
                    return '<span class="text-success">New</span>';
                } else if ($data->status == STATUS_INPROGRESS) {
                    return '<span class="text-success">In Progress</span>';
                } else if ($data->status == STATUS_CANCELED) {
                    return '<span class="text-success">Canceled</span>';
                } else if ($data->status == STATUS_ON_HOLD) {
                    return '<span class="text-success">On Hold</span>';
                } else if ($data->status == STATUS_CLOSED) {
                    return '<span class="text-success">Closed</span>';
                } else if ($data->status == STATUS_RESOLVED) {
                    return '<span class="text-success">Solved</span>';
                } else if ($data->status == STATUS_REOPEN) {
                    return '<span class="text-success">Re Open</span>';
                } else {

                }
            })
            ->addColumn('action', function ($data) {
                return '<div class="action__buttons d-flex justify-content-end">
                    <button onclick="getEditModal(\'' . route('admin.tickets.category-edit', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action edit" data-toggle="tooltip" title="Edit">
                        <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="edit">
                    </button>
                    <button onclick="deleteItem(\'' . route('admin.tickets.category-delete', $data->id) . '\', \'blogCategoryDataTable\')" class="tbl-action-btn text-danger"   title="Delete"><span class="iconify" data-icon="uiw:delete"></span></button>
                </div>';
            })
            ->rawColumns(['action', 'status', 'assigned_to'])
            ->make(true);
    }

    public function sotre($request)
    {
        DB::beginTransaction();
        try {
            if ($request->id && $request->id != null) {
                $dataObj = Ticket::where('id', $request->id)->first();
            } else {

                $dataObj = new Category();
            }
            $dataObj->name = $request->name;
            $dataObj->status = $request->status;
            $dataObj->tenant_id = auth()->user()->tenant_id != null ? auth()->user()->tenant_id : null;
            $dataObj->save();
            DB::commit();
            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
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
}
