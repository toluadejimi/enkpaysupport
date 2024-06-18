<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessages;
use App\Models\DynamicField;
use App\Models\DynamicFieldData;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use WpOrg\Requests\Auth;

class DynamicFieldController extends Controller
{
    use ResponseTrait;
    public function dynamicFields(Request $request)
    {
        $data['pageTitle'] = __('Dynamic Fields');
        $data['subDynamicFieldsActiveClass'] = 'mm-active';
        $data['filedList'] = DynamicField::where('created_by', auth()->id())->get();
        return view('admin.dynamic_fields.index', $data);
    }

    public function dynamicFieldsStore(Request $request)
    {

        if(isset($request->level)){
            $request->validate([
                'type.*' => 'required',
                'level.*' => 'required'
            ]);

            try {
                $chekDataExist = DynamicField::where('created_by', auth()->id())->get();
                if (count($chekDataExist) > 0) {
                    foreach ($chekDataExist as $item){
                        $item->delete();
                    }
                }
                foreach ($request->type as $key => $field) {
                    $dataObj = new DynamicField();
                    $dataObj->type = $request->type[$key];
                    $dataObj->level = $request->level[$key];
                    $dataObj->name = str_replace(" ", "_", Str::lower($request->level[$key]));
                    $dataObj->placeholder = $request->placeholder[$key];
                    $dataObj->required = $request->required[$key];
                    $dataObj->width = $request->width[$key];
                    $dataObj->order = $request->order[$key];
                    $dataObj->created_by = auth()->id();
                    $dataObj->tenant_id = auth()->user()->tenant_id;
                    $dataObj->save();
                }
                return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
            } catch (\Exception $exception) {
                return $this->error([], getMessage(SOMETHING_WENT_WRONG));
            }
        }else{
            DB::beginTransaction();
            $data = DynamicField::where('created_by', auth()->id())->get();
            $data->each->delete();
            DB::commit();
            return $this->success([], getMessage(DELETED_SUCCESSFULLY));
        }


    }

    public function dynamicFieldsDataUpdate(Request $request)
    {
        if($request->required == 1){
            if($request->text_field_value !=null){
                $request->validate([
                    'text_field_value' => 'required',
                ]);
            }else{
                $request->validate([
                    'textarea_field_value' => 'required',
                ]);
            }
        }

        try {
            $data = DynamicFieldData::find($request->id);
            $data->field_value = $request->text_field_value !=null?$request->text_field_value:$request->textarea_field_value;
            $data->save();
            return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
        } catch (\Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }

    }
}
