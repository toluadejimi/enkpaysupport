<?php

namespace App\Http\Services;

use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Ticket;
use App\Models\User;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class TicketTagsService
{
    use ResponseTrait;

    public function list()
    {
        $blogCategory = Tag::where('tenant_id', auth()->user()->tenant_id)->get();
        return datatables($blogCategory)
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
                    <button onclick="getEditModal(\'' . route('admin.tickets.tag-edit', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action edit" data-toggle="tooltip" title="Edit">
                        <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="edit">
                    </button>
                    <button onclick="deleteItem(\'' . route('admin.tickets.tag-delete', $data->id) . '\', \'ticketTagsDataTable\')" class="tbl-action-btn text-danger"   title="Delete"><span class="iconify" data-icon="uiw:delete"></span></button>
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
                $dataObj = Tag::where('id', $request->id)->first();
            } else {
                $dataObj = new Tag();
            }

            $dataObj->name = $request->name;
            $dataObj->status = $request->status;
            $dataObj->tenant_id = auth()->user()->tenant_id != "" ? auth()->user()->tenant_id : "";
            $dataObj->save();
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
        return Tag::findOrFail($id);
    }

    public function deleteById($id)
    {
        DB::beginTransaction();
        try {
            $data = Tag::where('id', $id)->firstOrFail();
            if (!$data && $data == null) {
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

    public function userList()
    {
        return User::where('tenant_id', auth()->user()->tenant_id)
            ->where('role', USER_ROLE_AGENT)
            ->get();
    }

    public function getAllTags()
    {
        return Tag::where('tenant_id', auth()->user()->tenant_id)
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function getTagsByTicketId($ticketId)
    {
        $ticket_tags = [];
        $tickets = Ticket::withTrashed()->find($ticketId);;
        if ($tickets) {
            $ticket_tags['ids'] = $tickets->tags->pluck('id')->toArray();
            $ticket_tags['names'] = $tickets->tags->pluck('name')->toArray();
        }
        return $ticket_tags;
    }

    public function addTicketTags($request)
    {
        $ticket_id = $request->ticket_id;
        $tag_id = $request->tag_id;
        $tag_check_status = $request->tagChecked;
        DB::beginTransaction();
        try {
            if ($ticket_id && $ticket_id) {
                $dataObj = Ticket::where('id', $ticket_id)->first();
            } else {
                $dataObj = new Ticket();
            }
            if ($tag_check_status == 1) {
                $tenant_id = auth()->user()->tenant_id != "" ? auth()->user()->tenant_id : "";
                $dataObj->tags()->syncWithPivotValues($tag_id, ['tenant_id' => $tenant_id], false);
                $message = "Ticket Tag Assigned Successfully";
            } else {
                $dataObj->tags()->detach($tag_id);
                $message = "Ticket Tag Removed Successfully";
            }

            DB::commit();
            $getTicketTags = $this->getTagsByTicketId($ticket_id);
            return $this->success($getTicketTags, $message);
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
