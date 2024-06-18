<?php

namespace App\Http\Services\FrontendService;

use App\Models\Faq;
use App\Models\Knowledge;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class KnowledgeService
{
    use ResponseTrait;

    public function list()
    {
        $knowledge = Knowledge::where('created_by',auth()->id())->get();
        return datatables($knowledge)
            ->addColumn('category_name',function ($data){
                return $data->knowledgeCategory->title;
            })
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return '<span class="active-status">' . __('Active') . '</span>';
                } else {
                    return '<span class="deactivate-status">' . __('Deactivate') . '</span>';
                }
            })
            ->addColumn('action', function ($data) {
                return '<div class="action__buttons d-flex justify-content-end">
                <button onclick="getEditModal(\'' . route('admin.setting.frontend.knowledge.info', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action mr-1 edit" data-toggle="tooltip" title="Edit">
                    <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="edit">
                </button>
                 <button onclick="deleteItem(\'' . route('admin.setting.frontend.knowledge.delete', $data->id) . '\', \'knowledgeDataTable\')" class="tbl-action-btn text-danger"   title="Delete"><span class="iconify" data-icon="uiw:delete"></span></button>
            </div>';
            })
            ->rawColumns(['category_name', 'status', 'action'])
            ->make(true);
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $knowledge = new Knowledge();
            $knowledge->knowledge_category_id = $request->knowledge_category_id;
            $knowledge->title = $request->title;
            $knowledge->description = $request->description;
            $knowledge->status = $request->status;
            $knowledge->created_by = auth()->id();
            $knowledge->updated_by = auth()->id();
            $knowledge->save();
            DB::commit();
            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $knowledge = Knowledge::findOrFail($id);
            $knowledge->title = $request->title;
            $knowledge->description = $request->description;
            $knowledge->status = $request->status;
            $knowledge->updated_by = auth()->id();
            $knowledge->save();
            DB::commit();
            $message = getMessage(UPDATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function delete($request)
    {
        try {
            DB::beginTransaction();
            $data = Knowledge::findOrFail($request->id);
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


    public function getById($id)
    {
        return Knowledge::findOrFail($id);
    }

    public function getActiveKnowledge($limit = 100000)
    {
        return Knowledge::where('status', STATUS_ACTIVE)->limit($limit)->get();
    }

    public function getHomeActiveKnowledge()
    {
        return Knowledge::where('created_by',getUserIdByTenant())->get();
    }
}
