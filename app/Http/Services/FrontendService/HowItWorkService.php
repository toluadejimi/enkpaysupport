<?php

namespace App\Http\Services\FrontendService;

use App\Models\HowItWork;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class HowItWorkService
{
    use ResponseTrait;

    public function list()
    {
        $howItWork = HowItWork::all();
        return datatables($howItWork)
            ->addColumn('action', function ($data) {
                return '<div class="action__buttons d-flex justify-content-end">
                    <button onclick="getEditModal(\'' . route('admin.setting.frontend.how_it_work.info', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action mr-1 edit" data-toggle="tooltip" title="Edit">
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
            $howItWork = HowItWork::findOrFail($id);
            $howItWork->title = $request->title;
            $howItWork->description = $request->description;
            $howItWork->save();
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
        return HowItWork::findOrFail($id);
    }

    public function getHowToWorkAll()
    {
        return HowItWork::all();
    }

}
