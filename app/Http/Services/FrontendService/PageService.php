<?php

namespace App\Http\Services\FrontendService;

use App\Models\Page;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class PageService
{
    use ResponseTrait;

    public function list()
    {
        $data = Page::where(['created_by'=> auth()->id()]);
            return datatables($data)
            ->addColumn('type', function($data){
                return getPageType($data->type);
            })->addColumn('action', function ($data) {
                return '<div class="action__buttons d-flex justify-content-end">
                    <button onclick="getEditModal(\'' . route('admin.setting.frontend.pages.info', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action mr-1 edit" data-toggle="tooltip" title="Edit">
                        <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="edit">
                    </button>
                </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $aboutUs = Page::findOrFail($id);
            $aboutUs->title = $request->title;
            $aboutUs->description = $request->description;
            $aboutUs->save();
            DB::commit();
            $message = getMessage(UPDATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function getById($id)
    {
        return Page::findOrFail($id);
    }

    public function getPageByType($type)
    {
        return Page::where(['type'=> $type, 'created_by'=> getIdByTenantId(getTenantId())])->first();
    }

    public function getHomeActiveAboutUs()
    {
        return Page::all();
    }
}
