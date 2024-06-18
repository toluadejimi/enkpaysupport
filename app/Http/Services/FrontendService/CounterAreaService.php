<?php

namespace App\Http\Services\FrontendService;

use App\Models\CounterArea;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class CounterAreaService
{
    use ResponseTrait;

    public function list()
    {
        $counterArea = CounterArea::all();
        return datatables($counterArea)
            ->addColumn('action', function ($data) {
                return '<div class="action__buttons d-flex justify-content-end">
                    <button onclick="getEditModal(\'' . route('admin.setting.frontend.counter_area.info', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action mr-1 edit" data-toggle="tooltip" title="Edit">
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
            $counterArea = CounterArea::findOrFail($id);
            $counterArea->number = $request->number;
            $counterArea->description = $request->description;
            $counterArea->save();
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
        return CounterArea::findOrFail($id);
    }

    public function getCounterAreaShow()
    {
        return CounterArea::all();
    }

}
