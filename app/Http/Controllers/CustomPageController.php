<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BusinessHours;
use App\Models\CustomPage;
use App\Models\EmailTemplate;
use App\Rules\ReCaptcha;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomPageController extends Controller
{
    use ResponseTrait;

    public function customPages(Request $request)
    {
        if ($request->ajax()) {
            $pages = CustomPage::all();
            return datatables($pages)
                ->addIndexColumn()
                ->addColumn('link', function ($data) {
                    return url('custom-page/' . htmlspecialchars($data->slug)) . ' <button class="btn btn-outline-info copy-custom-page-link" data-src="' . url('custom-page/' . htmlspecialchars($data->slug)) . '"><i class="fa fa-copy"></i> </button>';
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return '<span class="text-success">Published</span>';
                    } else {
                        return '<span class="text-danger">Unpublished</span>';
                    }
                })
                ->addColumn('created_at', function ($data) {
                    return date('Y-m-d H:i:s', strtotime($data->created_at));
                })
                ->addColumn('action', function ($data) {
                    return '<div class="action__buttons d-flex justify-content-end">
                    <button onclick="getEditModal(\'' . route('admin.custom-pages-edit', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action me-2 edit" data-toggle="tooltip" title="Edit">
                        <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="edit">
                    </button>
                    <button onclick="deleteItem(\'' . route('admin.custom-pages-delete', $data->id) . '\', \'customPageDataTable\')" class="tbl-action-btn text-danger"   title="Delete"><span class="iconify" data-icon="uiw:delete"></span></button>
                </div>';
                })
                ->rawColumns(['status', 'action', 'created_at', 'link'])
                ->make(true);
        }

        $data['pageTitle'] = 'Pages';
        $data['subNavPagesActiveClass'] = 'mm-active';
        $data['navCustomPageActiveClass'] = 'active';
        return view('admin.custom_page.pages', $data);
    }

    public function customErrorPages()
    {

    }

    public function customMaintenancePages()
    {

    }

    public function customPagesStore(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:custom_pages|max:255',
            'details' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $dataObj = new CustomPage();
            $dataObj->title = $request->title;
            $dataObj->slug = strtolower(str_replace(' ', '-', $request->title));
            $dataObj->desc = $request->details;
            $dataObj->status = $request->status;
            $dataObj->save();
            DB::commit();
            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }


    }

    public function customPagesEdit($id)
    {

        $data['page'] = CustomPage::findOrFail($id);
        return view('admin.custom_page.edit-form', $data);
    }

    public function customPagesUpdate(Request $request, $id)
    {

        $request->validate([
            'title' => 'required|unique:custom_pages,title,' . $id,
            'details' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $dataObj = CustomPage::findOrFail($id);
            $dataObj->title = $request->title;
            $dataObj->slug = strtolower(str_replace(' ', '-', $request->title));
            $dataObj->desc = $request->details;
            $dataObj->status = $request->status;
            $dataObj->save();
            DB::commit();
            return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function customPagesDelete($id)
    {
        DB::beginTransaction();
        try {
            $dataObj = CustomPage::findOrFail($id);
            $dataObj->delete();
            DB::commit();
            return $this->success([], getMessage(DELETED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }
}
