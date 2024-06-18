<?php

namespace App\Http\Services;

use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\User;
use App\Traits\ResponseTrait;
use App\Models\Ticket;

use Exception;
use Illuminate\Support\Facades\DB;

class TicketCategoryService
{
    use ResponseTrait;

    public function list()
    {
        $blogCategory = Category::where('tenant_id', auth()->user()->tenant_id)->get();

        return datatables($blogCategory)
            ->addIndexColumn()
            ->editColumn('is_ticket_prefix', function ($data) {
                if ($data->is_ticket_prefix == 1) {
                    return '<span class="text-success">True</span>';
                } else {
                    return '<span class="text-danger">False</span>';
                }
            })->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return '<span class="text-success">Active</span>';
                } else {
                    return '<span class="text-danger">Deactivate</span>';
                }
            })
            ->addColumn('action', function ($data) {
                return '<div class="action__buttons d-flex justify-content-end">
                    <button onclick="getEditModal(\'' . route('admin.tickets.category-edit', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action edit" data-toggle="tooltip" title="Edit">
                        <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="edit">
                    </button>
                    <button onclick="deleteItem(\'' . route('admin.tickets.category-delete', $data->id) . '\', \'ticketCategoryDataTable\')" class="tbl-action-btn text-danger"   title="Delete"><span class="iconify" data-icon="uiw:delete"></span></button>
                </div>';
            })
            ->rawColumns(['action', 'status','is_ticket_prefix'])
            ->make(true);
    }

    public function sotre($request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $request->id,
            'code' => 'required|unique:categories,code,' . $request->id,
        ]);

        DB::beginTransaction();
        try {

            if ($request->id && $request->id != null) {
                $dataObj = Category::where('id', $request->id)->first();
            } else {
                $dataObj = new Category();
            }
            $dataObj->name = $request->name;
            $dataObj->code = $request->code;
            $dataObj->is_ticket_prefix = $request->is_ticket_prefix;
            $dataObj->status = $request->status;
            $dataObj->tenant_id = auth()->user()->tenant_id !=""?auth()->user()->tenant_id:"";
            $dataObj->save();
//            $dataObj->users()->sync($request->group_user);
            $dataObj->users()->syncWithPivotValues($request->group_user, ['tenant_id' => auth()->user()->tenant_id]);
            DB::commit();

            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function getById($id)
    {
        return Category::findOrFail($id);
    }

    public function deleteById($id)
    {
        DB::beginTransaction();
        try {
            $category = Category::where('id', $id)->firstOrFail();
            if(!$category && $category == null){
                return $this->error([], SOMETHING_WENT_WRONG);
            }
            $category->delete();
            DB::commit();
            $message = getMessage(DELETED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function userList(){
        return User::where('tenant_id',auth()->user()->tenant_id)
            ->where('role', USER_ROLE_AGENT)
            ->get();
    }

    public function updateCategory($request)
    {
        DB::beginTransaction();
        try {
            if ($request->category_ticket_id && $request->category_ticket_id != null) {
                // $dataObj = Ticket::where('category_id', $request->category_ticket_id)
                // ->update(['category_id' => $request->ticket-category]);
            } else {
                $dataObj = new Ticket();
            }
            $dataObj->name = $request->name;
            $dataObj->status = $request->status;
            $dataObj->tenant_id = auth()->user()->tenant_id !=""?auth()->user()->tenant_id:"";
            $dataObj->save();
//            $dataObj->users()->sync($request->group_user);
            $dataObj->users()->syncWithPivotValues($request->group_user, ['tenant_id' => auth()->user()->tenant_id]);
            DB::commit();

            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
