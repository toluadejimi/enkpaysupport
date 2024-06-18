<?php

namespace App\Http\Controllers;

use App\Models\BlogTag;
use App\Models\BusinessHours;
use App\Models\EmailTemplate;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PragmaRX\Google2FALaravel\Support\Response;

class EmailTemplateController extends Controller
{
    use ResponseTrait;

    public function emailTemplate(Request $request)
    {
        if ($request->ajax()) {
            $temp = EmailTemplate::all();
            return datatables($temp)
                ->addIndexColumn()
                ->addColumn('body', function ($data) {
                    return $data->body;
                })
                ->addColumn('action', function ($data) {
                    return '<div class="action__buttons d-flex justify-content-end">
                    <button onclick="getEditModal(\'' . route('admin.setting.email-edit', $data->id) . '\'' . ', \'#edit-modal\')" class="btn-action me-2 edit" data-toggle="tooltip" title="Edit">
                        <img src="' . asset('admin/images/icons/edit-2.svg') . '" alt="edit">
                    </button>
                </div>';
                })
                ->rawColumns(['action','body'])
                ->make(true);
        }
        $data['pageTitle'] = 'Email Template';
        $data['subNavEmailTempSettingActiveClass'] = 'mm-active';
        $data['subCountryActiveClass'] = 'active';
        return view('admin.setting.email_temp.email-temp', $data);
    }

    public function emailTempEdit($id)
    {

        $data['template'] = EmailTemplate::findOrFail($id);
        return view('admin.setting.email_temp.edit-form', $data);
    }

    public function emailTempUpdate(Request $request, $id){
        try {
            DB::beginTransaction();
            $tempObj = EmailTemplate::findOrFail($id);
            $tempObj->subject = $request->subject;
            $tempObj->body = $request->body;
            $tempObj->save();
            DB::commit();
            $message = getMessage(UPDATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }
}
