<?php

namespace App\Http\Services\FrontendService;

use App\Models\Faq;
use App\Models\Faq_category;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FaqCategoryService
{
    use ResponseTrait;

    public function list()
    {
        $faqCategory = Faq_category::where('created_by', auth()->id())->get();
        return datatables($faqCategory)
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return '<span class="active-status">Active</span>';
                } else {
                    return '<span class="deactivate-status">Deactivate</span>';
                }
            })
            ->addColumn('action', function ($data) {
                return '<div class="action__buttons d-flex justify-content-end">
                <button onclick="getEditModal(\'' . route('admin.setting.frontend.faq-category.info', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action mr-1 edit" data-toggle="tooltip" title="Edit">
                    <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="edit">
                </button>
                 <button onclick="deleteItem(\'' . route('admin.setting.frontend.delete', $data->id) . '\', \'faqCategoryDataTable\')" class="tbl-action-btn text-danger"   title="Delete"><span class="iconify" data-icon="uiw:delete"></span></button>
            </div>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $faqCategory = new Faq_category();
            $faqCategory->title = $request->title;
            $faqCategory->status = $request->status;
            $faqCategory->created_by = auth()->id();
            $faqCategory->updated_by = auth()->id();
            $faqCategory->save();
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
            $faqCategory = Faq_category::findOrFail($id);
            $faqCategory->title = $request->title;
            $faqCategory->status = $request->status;
            $faqCategory->updated_by = auth()->id();
            $faqCategory->save();
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
            $faqsInCategory = Faq::where('faq_category_id', $categoryId)->count();

            if ($faqsInCategory > 0) {
                $message = 'Cannot delete this Faq_category because it is associated with a Faq.';
                return $this->error([], $message);
            }

            $data = Faq_category::findOrFail($categoryId);
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
        return Faq_category::findOrFail($id);
    }

    public function getActiveFaqCategory($limit = 100000)
    {
        return Faq_category::where('status', STATUS_ACTIVE)->limit($limit)->get();
    }

    public function getHomeActiveFaqCategory()
    {
        return Faq_category::where('created_by',getUserIdByTenant())->get();
    }

    public function getCategoryName(){

        return Faq_category::where('created_by',auth()->id())->get();
    }
    public function getCategorySuperAdmin(){

        return Faq_category::where('created_by',getUserIdByTenant())->get();
    }
}
