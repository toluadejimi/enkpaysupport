<?php

namespace App\Http\Services\FrontendService;

use Exception;
use App\Models\Faq;
use App\Models\Faq_category;
use App\Traits\ResponseTrait;
use App\Models\FrontendSection;
use Illuminate\Support\Facades\DB;

class FaqService
{
    use ResponseTrait;

    public function list()
    {
        $faq = Faq::where('created_by', auth()->id())->get();
        return datatables($faq)
            ->addColumn('category_name', function ($data) {
                return $data->faqCategory->title;
            })
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return '<span class="active-status d-inline-block">' . __('Active') . '</span>';
                } else {
                    return '<span class="deactivate-status d-inline-block">' . __('Deactivate') . '</span>';
                }
            })
            ->addColumn('action', function ($data) {
                return '<div class="action__buttons d-flex justify-content-end">
                <button onclick="getEditModal(\'' . route('admin.setting.frontend.faq.info', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action mr-1 edit" data-toggle="tooltip" title="Edit">
                    <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="edit">
                </button>
                 <button onclick="deleteItem(\'' . route('admin.setting.frontend.faq.delete', $data->id) . '\', \'faqDataTable\')" class="tbl-action-btn text-danger"   title="Delete"><span class="iconify" data-icon="uiw:delete"></span></button>
            </div>';
            })
            ->rawColumns(['category_name', 'status', 'action'])
            ->make(true);
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $faq = new Faq();
            $faq->faq_category_id = $request->faq_category_id;
            $faq->question = $request->question;
            $faq->answer = $request->answer;
            $faq->status = $request->status;
            $faq->created_by = auth()->id();
            $faq->updated_by = auth()->id();
            $faq->save();
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
            $faq = Faq::findOrFail($id);
            $faq->question = $request->question;
            $faq->question = $request->question;
            $faq->answer = $request->answer;
            $faq->status = $request->status;
            $faq->updated_by = auth()->id();
            $faq->save();
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
            $data = Faq::findOrFail($request->id);
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
        return Faq::findOrFail($id);
    }

    public function getActiveFaq($limit = 100)
    {
        return Faq::where('status', STATUS_ACTIVE)
            ->where('created_by', getUserIdByTenant())
            ->limit($limit)->get();
    }

    public function getHomeActiveFaq()
    {
        return Faq::where('created_by', getUserIdByTenant())->get();
    }

    public function getUserActiveFaq()
    {

        return Faq::where('created_by', getUserIdByTenant())->get();
    }

    public function getFaqTitle()
    {
        return FrontendSection::where('slug', 'faq_area')->where('created_by', getUserIdByTenant())->first();
    }

    public function faqCategory()
    {
        return Faq_category::where('created_by', getUserIdByTenant())->get();
    }

    public function faq()
    {
        return Faq::where('created_by', getUserIdByTenant())->get();
    }
}
