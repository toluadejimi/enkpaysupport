<?php

namespace App\Http\Services\FrontendService;

use App\Models\FileManager;
use App\Models\FrontendSection;
use App\Models\GetInTouch;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class GetInTouchService
{
    use ResponseTrait;

    public function getData()
    {
        $platforms = GetInTouch::all();
        return datatables($platforms)
            ->addIndexColumn()
            ->addColumn('image', function ($data) {
                return '<img src="' . getFileUrl($data->image) . '" alt="icon" class="rounded avatar-xs tbl-user-image">';
            })
            ->addColumn('status', function ($data) {
                if ($data->status == ACTIVE) {
                    return '<span class="active-status">Active</span>';
                } else {
                    return '<span class="deactivate-status">Deactivate</span>';
                }
            })
            ->addColumn('action', function ($data) {
                return '<div class="action__buttons d-flex justify-content-end">
                    <button onclick="getEditModal(\'' . route('admin.setting.frontend.get-touch.info', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action mr-1 edit" data-toggle="tooltip" title="Edit">
                        <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="edit">
                    </button>
                    <button onclick="deleteItem(\'' . route('admin.setting.frontend.get-touch.delete', $data->id) . '\', \'commonDataTable\')" class="p-1 tbl-action-btn"   title="Delete"><span class="iconify" data-icon="ep:delete-filled"></span></button>
                </div>';
            })
            ->rawColumns(['image', 'status', 'action'])
            ->make(true);
    }
    public function store($request)
    {
        try {
            DB::beginTransaction();
            $newsObj = new GetInTouch();
            $newsObj->title = $request->title;
            $newsObj->description = $request->description;
            $newsObj->status = ACTIVE;
            $newsObj->section_id = GET_IN_TOUCH_SECTION_ID;
            if ($request->hasFile('image')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('getIn-touch', $request->image);
                $newsObj->image = $uploaded->id;
            }
            $newsObj->save();
            DB::commit();
            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }
    public function update($request)
    {
        DB::beginTransaction();
        try {
            $section = GetInTouch::findOrfail($request->id);
            $section->title = $request->title;
            $section->description = $request->description;
            $section->status = $request->status;
            if ($request->hasFile('image')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('getIn-touch', $request->image);
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
    public function delete($request)
    {
        try {
            DB::beginTransaction();
            $data = GetInTouch::findOrFail($request->id);
            $file = FileManager::where('id', $data->image)->first();
            if ($file) {
                $file->removeFile();
                $file->delete();
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
    public function allActiveGetInTouch()
    {
        $data = GetInTouch::where('status', ACTIVE)->get();
        $section = FrontendSection::where('id', GET_IN_TOUCH_SECTION_ID)->where('status', ACTIVE)->first();
        return [$data, $section];
    }
}