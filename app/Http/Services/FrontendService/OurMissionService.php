<?php

namespace App\Http\Services\FrontendService;

use App\Models\FileManager;
use App\Models\OurMission;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class OurMissionService
{
    use ResponseTrait;

    public function list()
    {
        $ourMission = OurMission::all();
        return datatables($ourMission)
            ->addIndexColumn()
            ->addColumn('image', function ($data) {
                return '<img src="' . getFileUrl($data->image) . '" alt="icon" class="rounded avatar-xs tbl-user-image">';
            })
            ->addColumn('action', function ($data) {
                return '<div class="action__buttons d-flex justify-content-end">
                    <button onclick="getEditModal(\'' . route('admin.setting.frontend.our_mission.info', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action mr-1 edit" data-toggle="tooltip" title="Edit">
                        <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="edit">
                    </button>
                </div>';
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $ourMission = OurMission::findOrFail($id);
            $ourMission->title = $request->title;
            $ourMission->description = $request->description;
            $ourMission->description_point = $request->description_point;
            if ($request->hasFile('image')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('ourMission', $request->image);
                $ourMission->image = $uploaded->id;
            }
            $ourMission->save();
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
        return OurMission::findOrFail($id);
    }

    public function getActiveOurMission()
    {
        return OurMission::all();
    }
}
