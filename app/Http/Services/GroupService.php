<?php

namespace App\Http\Services;

use App\Models\BlogCategory;
use App\Models\Group;
use App\Models\Category;
use App\Models\User;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class GroupService
{
    use ResponseTrait;

    public function list()
    {
        $data = Group::where('tenant_id', auth()->user()->tenant_id)->get();
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return '<span class="text-success">Active</span>';
                } else {
                    return '<span class="text-danger">Deactivate</span>';
                }
            })
            ->addColumn('action', function ($data) {
                return '<div class="action__buttons d-flex justify-content-end">
                    <button onclick="getEditModal(\'' . route('admin.group.edit', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action me-2 edit" data-toggle="tooltip" title="Edit">
                        <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="edit">
                    </button>
                    <button onclick="deleteItem(\'' . route('admin.group.delete', $data->id) . '\', \'blogCategoryDataTable\')" class="tbl-action-btn text-danger"   title="Delete"><span class="iconify" data-icon="uiw:delete"></span></button>
                </div>';
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function sotre($request)
    {

        DB::beginTransaction();
        try {
            if ($request->id && $request->id != null) {
                $dataObj = Group::where('id', $request->id)->first();
            } else {
                $dataObj = new Group();
            }
            $dataObj->name = $request->name;
            $dataObj->user_id = json_encode($request->group_user);
            $dataObj->tenant_id = auth()->user()->tenant_id !=""?auth()->user()->tenant_id:"";
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
        return Group::findOrFail($id);
    }

    public function deleteById($id)
    {
        DB::beginTransaction();
        try {
            $data = Group::where('id', $id)->firstOrFail();
            if(!$data && $data == null){
                return $this->error([], SOMETHING_WENT_WRONG);
            }
            $data->delete();
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
}
