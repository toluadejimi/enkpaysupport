<?php

namespace App\Http\Services\FrontendService;

use App\Models\FileManager;
use App\Models\Team;
use App\Traits\ResponseTrait;
use Exception;
use http\Env\Request;
use Illuminate\Support\Facades\DB;

class TeamService
{
    use ResponseTrait;

    public function list()
    {
        $teams = Team::all();
        return datatables($teams)
            ->addIndexColumn()
            ->addColumn('image', function ($data) {
                return '<img src="' . getFileUrl($data->image) . '" alt="icon" class="rounded avatar-xs tbl-user-image">';
            })
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return '<span class="active-status">' . __('Active') . '</span>';
                } else {
                    return '<span class="deactivate-status">' . __('Deactivate') . '</span>';
                }
            })
            ->addColumn('action', function ($data) {
                return '<div class="action__buttons d-flex justify-content-end">
                    <button onclick="getEditModal(\'' . route('admin.setting.frontend.team.info', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action mr-1 edit" data-toggle="tooltip" title="Edit">
                        <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="edit">
                    </button>
                    <button onclick="deleteItem(\'' . route('admin.setting.frontend.team.delete', $data->id) . '\', \'teamDataTable\')" class="tbl-action-btn text-danger"   title="Delete"><span class="iconify" data-icon="uiw:delete"></span></button>
                </div>';
            })
            ->rawColumns(['status', 'image', 'action'])
            ->make(true);
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $team = new Team();
            $team->name = $request->name;
            $team->designation = $request->designation;
            $team->facebook_link = $request->facebook_link;
            $team->instagram_link = $request->instagram_link;
            $team->twitter_link = $request->twitter_link;
            $team->status = $request->status;

            if ($request->hasFile('image')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('team', $request->image);
                $team->image = $uploaded->id;
            }
            $team->save();
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
            $team = Team::findOrFail($id);
            $team->name = $request->name;
            $team->designation = $request->designation;
            $team->facebook_link = $request->facebook_link;
            $team->instagram_link = $request->instagram_link;
            $team->twitter_link = $request->twitter_link;
            $team->status = $request->status;

            if ($request->hasFile('image')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('team', $request->image);
                $team->image = $uploaded->id;
            }
            $team->save();
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
            $data = Team::findOrFail($request->id);
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

    public function getById($id)
    {
        return Team::findOrFail($id);
    }

    public function getActiveTeam()
    {
        return Team::where('status', 1)->get();
    }
}
