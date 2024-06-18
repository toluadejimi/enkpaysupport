<?php

namespace App\Http\Services\FrontendService;

use App\Models\Service;
use App\Models\FileManager;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class ServiceService
{
    use ResponseTrait;

    public function list()
    {
        $services = Service::all();
        return datatables($services)
            ->addIndexColumn()
            ->addColumn('icon', function ($data) {
                return '<img src="' . getFileUrl($data->icon) . '" alt="icon" class="rounded avatar-xs tbl-user-image">';
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
                    <button onclick="getEditModal(\'' . route('admin.setting.frontend.service.info', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action mr-1 edit" data-toggle="tooltip" title="Edit">
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
            $service = new Service();
            $service->title = $request->title;
            $service->description = $request->description;
            if ($request->hasFile('icon')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('service$service', $request->icon);
                $service->icon = $uploaded->id;
            }

            $service->save();
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
            $service = Service::findOrFail($id);
            $service->title = $request->title;
            $service->description = $request->description;
            if ($request->hasFile('icon')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('service', $request->icon);
                $service->icon = $uploaded->id;
            }
            $service->save();
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
        return Service::findOrFail($id);
    }

    public function getActiveService()
    {
        return Service::where('status', STATUS_ACTIVE)->get();
    }
}
