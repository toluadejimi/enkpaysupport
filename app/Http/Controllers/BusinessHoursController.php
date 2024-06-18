<?php

namespace App\Http\Controllers;

use App\Models\BusinessHours;
use App\Models\Varity;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusinessHoursController extends Controller
{
    use ResponseTrait;

    public function businessHours()
    {
        $data['pageTitle'] = 'Support Schedule';
        $data['subNavBusinessHoursSettingActiveClass'] = 'mm-active';
        $data['subCountryActiveClass'] = 'active';
        $data['timeArray'] = [
            '12:00 AM',
            '12:30 AM',
            '01:00 AM',
            '01:30 AM',
            '02:00 AM',
            '02:30 AM',
            '03:00 AM',
            '03:30 AM',
            '04:00 AM',
            '04:30 AM',
            '05:00 AM',
            '05:30 AM',
            '06:00 AM',
            '06:30 AM',
            '07:00 AM',
            '07:30 AM',
            '08:00 AM',
            '08:30 AM',
            '09:00 AM',
            '09:30 AM',
            '10:00 AM',
            '10:30 AM',
            '11:00 AM',
            '11:30 AM',
            '12:00 PM',
            '12:30 PM',
            '01:00 PM',
            '01:30 PM',
            '02:00 PM',
            '02:30 PM',
            '03:00 PM',
            '03:30 PM',
            '04:00 PM',
            '04:30 PM',
            '05:00 PM',
            '05:30 PM',
            '06:00 PM',
            '06:30 PM',
            '07:00 PM',
            '07:30 PM',
            '08:00 PM',
            '08:30 PM',
            '09:00 PM',
            '09:30 PM',
            '10:00 PM',
            '10:30 PM',
            '11:00 PM',
            '11:30 PM'
        ];
        $data['businessHours'] = BusinessHours::all();
        $data['configData'] = Varity::where('created_by', auth()->id())->first();
        return view('admin.setting.business_hours.business-hours', $data);
    }

    public function businessHourStore(Request $request)
    {
        try {
            $checkData = BusinessHours::where('user_id', $request->user_id)->get();
            if (count($checkData) > 0) {
                foreach ($checkData as $item) {
                    $item->delete();
                }
            }
            for ($i = 0; $i < 7; $i++) {
                $dataObj = new BusinessHours();
                $dataObj->days = $request->day[$i];
                $dataObj->status = $request->status[$i];
                $dataObj->start_time = $request->start_time[$i];
                $dataObj->end_time = $request->end_time[$i];
                $dataObj->user_id = $request->user_id;
                $dataObj->save();
            }
            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
        } catch (Exception $e) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }

    }

    public function businessHoursSectionDataStore(Request $request)
    {

        $request->validate([
            'schedule_title' => 'required',
            'schedule_desc' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $checkData = Varity::where('created_by', $request->user_id)->first();
            if ($checkData && $checkData != null) {
                $checkData->schedule_title = $request->schedule_title;
                $checkData->schedule_desc = $request->schedule_desc;
                $checkData->save();
            } else {
                $dataObj = new Varity();
                $dataObj->schedule_title = $request->schedule_title;
                $dataObj->schedule_desc = $request->schedule_desc;
                $dataObj->created_by = auth()->id();
                $dataObj->save();
            }

            DB::commit();
            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }

    }
}
