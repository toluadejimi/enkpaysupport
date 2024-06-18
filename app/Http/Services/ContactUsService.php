<?php

namespace App\Http\Services;

use App\Models\ContactMessages;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;


class ContactUsService
{
    use ResponseTrait;

    public function store($request)
    {

        DB::beginTransaction();
        try {

            $obj = new ContactMessages();
            $obj->name = $request->name;
            $obj->email = $request->email;
            $obj->subject =  $request->subject;
            $obj->phone =  $request->phone;
            $obj->message =  $request->message;
            $obj->created_by =  $request->created_by;
            $obj->save();
            DB::commit();
            return "message sent successfully!";
        } catch (Exception $e) {
            DB::rollBack();
            return  getMessage(SOMETHING_WENT_WRONG);
        }
    }
    public function contactSMSList(){
        // $sms = ContactMessages::all();
        $sms = ContactMessages::where('created_by',auth()->id())->get();

        return datatables($sms)
            ->addIndexColumn()
            ->addColumn('message', function ($data) {
                return '<div>'.nl2br($data->message).'</div>';
            })
            ->addColumn('action', function ($data) {
                return '<div class="action__buttons d-flex justify-content-end">
                    <button onclick="deleteItem(\'' . route('admin.setting.contact.sms.delete', $data->id) . '\', \'commonDataTable\')" class="p-1 tbl-action-btn"   title="Delete"><span class="iconify" data-icon="ep:delete-filled"></span></button>
                </div>';
            })
            ->rawColumns(['action', 'message'])
            ->make(true);
    }

    public function deleteContactSMS($request)
    {
        try {
            DB::beginTransaction();
            $data = ContactMessages::findOrFail($request->id);
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
}
