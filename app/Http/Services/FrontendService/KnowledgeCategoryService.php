<?php

namespace App\Http\Services\FrontendService;

use App\Models\Knowledge;
use App\Models\KnowledgeCategory;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class KnowledgeCategoryService
{
    use ResponseTrait;

    public function list()
    {
        $knowledgeCategory = KnowledgeCategory::where('created_by',auth()->id())->get();
        return datatables($knowledgeCategory)
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return '<span class="active-status">'.__('Active').'</span>';
                } else {
                    return '<span class="deactivate-status">'.__('Deactivate').'</span>';
                }
            })
            ->addColumn('action', function ($data) {
                return '<div class="action__buttons d-flex justify-content-end">
                <button onclick="getEditModal(\'' . route('admin.setting.frontend.knowledge-category.info', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action mr-1 edit" data-toggle="tooltip" title="Edit">
                    <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="edit">
                </button>
                 <button onclick="deleteItem(\'' . route('admin.setting.frontend.knowledge.category.delete', $data->id) . '\', \'knowledgeCategoryDataTable\')" class="tbl-action-btn text-danger"   title="Delete"><span class="iconify" data-icon="uiw:delete"></span></button>
            </div>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $knowledgeCategory = new KnowledgeCategory();
            $knowledgeCategory->title = $request->title;
            $knowledgeCategory->description = $request->description;
            $knowledgeCategory->status = $request->status;
            $knowledgeCategory->created_by = auth()->id();
            $knowledgeCategory->updated_by = auth()->id();
            $knowledgeCategory->save();
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
            $knowledgeCategory = KnowledgeCategory::findOrFail($id);
            $knowledgeCategory->title = $request->title;
            $knowledgeCategory->description = $request->description;
            $knowledgeCategory->status = $request->status;
            $knowledgeCategory->updated_by = auth()->id();
            $knowledgeCategory->save();
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

            $categoryId = $request->id;
            $faqsInCategory = Knowledge::where('knowledge_category_id', $categoryId)->count();

            if ($faqsInCategory > 0) {
                $message = 'Cannot delete this KnowledgeCategory because it is associated with a Knowledge.';
                return $this->error([], $message);
            }

            $data = KnowledgeCategory::findOrFail($categoryId);
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
        return KnowledgeCategory::findOrFail($id);
    }

    public function getActiveFaqCategory($limit = 100000)
    {
        return KnowledgeCategory::where('status', STATUS_ACTIVE)->limit($limit)->get();
    }

    public function getHomeActiveKnowledgeCategory()
    {
        return KnowledgeCategory::where('created_by',getUserIdByTenant())->get();
    }
    public function getCategoryName(){

        return KnowledgeCategory::where('created_by',auth()->id())->get();
    }
}
