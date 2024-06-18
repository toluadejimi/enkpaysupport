<?php

namespace App\Http\Services;

use App\Models\CmsSetting;
use App\Models\FileManager;
use App\Models\FrontendSection;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class FrontendService
{
    use ResponseTrait;

    public function sectionList()
    {
        $sections = FrontendSection::where('created_by',auth()->id())->get();

        return datatables($sections)
            ->addIndexColumn()
            ->addColumn('image', function ($data) {
                return '<img src="' . getFileUrl($data->image) . '" alt="icon" class="rounded avatar-xs tbl-user-image">';
            })
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return '<span class="active-status">Active</span>';
                } else {
                    return '<span class="deactivate-status">Deactivate</span>';
                }
            })
            ->addColumn('action', function ($data) {
                return '<div class="action__buttons d-flex justify-content-end">
                    <button onclick="getEditModal(\'' . route('admin.setting.frontend.section.info', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action mr-1 edit" data-toggle="tooltip" title="Edit">
                        <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="edit">
                    </button>
                </div>';
            })
            ->rawColumns(['status', 'image', 'action'])
            ->make(true);
    }
    public function update($request)
    {
        DB::beginTransaction();
        try {
            $section = FrontendSection::findOrfail($request->id);
            $section->title = $request->title ?? '';
            $section->description = $request->description;
            $section->status = $request->status;
            if ($request->hasFile('image')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('frontend-section', $request->image);
                $section->image = $uploaded->id;
            }
            $section->save();
            DB::commit();
            $message = getMessage(UPDATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([],  $message);
        }
    }
    public function heroSectionData()
    {
        return FrontendSection::where('id', HERO_SECTION_ID)->where('status', 1)->first();
    }
    public function cryptocurrencyData(){
        return FrontendSection::where('id', CRYPTOCURRENCY_SECTION_ID)->where('status', 1)->first();
    }
    public function paymentSectionData(){
        return FrontendSection::where('id', PAYMENT_SECTION_ID)->where('status', 1)->first();
    }
//    public function getHomeFrontendSection($created_by){
//        return FrontendSection::where('created_by',$created_by)->get();
//    }

    public function getHomeFrontendSection($tenant=null){
        return FrontendSection::where('created_by', getUserIdByTenant())->get();
    }
    public function getActiveImage()
    {
        return FrontendSection::where('has_image', STATUS_ACTIVE)->get();
    }
    public function getFaqActive(){

        return FrontendSection::where('slug', 'faq_area')
            ->where('created_by', 1)
            ->first();
    }
    public function getById($id)
    {
        return CmsSetting::findOrFail($id);
    }
}
