<?php

namespace App\Http\Services\FrontendService;

use App\Models\Feature;
use App\Models\FileManager;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FeatureService
{
    use ResponseTrait;

    public function list()
    {
        $features = Feature::where('created_by',auth()->id())->get();
        return datatables($features)
            ->addIndexColumn()
            ->addColumn('icon', function ($data) {
                return '<img src="' . getFileUrl($data->icon) . '" alt="icon" class="rounded avatar-xs tbl-user-image">';
            })
            ->addColumn('status', function ($data) {
                if ($data->status == STATUS_ACTIVE) {
                    return '<span class="active-status d-inline-block">' . __('Active') . '</span>';
                } else {
                    return '<span class="deactivate-status">' . __('Deactivate') . '</span>';
                }
            })
            ->addColumn('action', function ($data) {
                return '<div class="action__buttons d-flex justify-content-end">
                    <button onclick="getEditModal(\'' . route('admin.setting.frontend.feature.info', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action mr-1 edit" data-toggle="tooltip" title="Edit">
                        <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="edit">
                    </button>
                </div>';
            })
            ->rawColumns(['status', 'icon', 'action'])
            ->make(true);
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $feature = new Feature();
            $feature->title = $request->title;
            $feature->description = $request->description;

            if ($request->hasFile('icon')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('feature', $request->icon);
                $feature->icon = $uploaded->id;
            }
            $feature->save();
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
            $feature = Feature::findOrFail($id);
            $feature->title = $request->title;
            $feature->description = $request->description;
            $feature->status = $request->status;
            if ($request->hasFile('icon')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('feature', $request->icon);
                $feature->icon = $uploaded->id;
            }
            $feature->save();
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
            $data = Feature::findOrFail($request->id);
            $file = FileManager::where('id', $data->icon)->first();
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

    public function getById($id)
    {
        return Feature::findOrFail($id);
    }

    public function getActiveFeature()
    {
        return Feature::where('status', 1)->where('created_by', getUserIdByTenant())->get();
    }

    public function getHomeFeature()
    {
        return Feature::where('created_by', getUserIdByTenant())->get();
    }
    public function getTenantShow(){
        return Feature::where('created_by',getUserIdByTenant())->get();
    }
}
