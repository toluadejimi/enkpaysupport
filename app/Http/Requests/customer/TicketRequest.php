<?php

namespace App\Http\Requests\customer;

use App\Models\DynamicField;
use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{

    public function rules()
    {
        $rules['subject'] = 'bail|required';
        $rules['category'] = 'bail|required';
        $rules['details'] = 'bail|required';
        if ($this->attachment) {
            $rules['attachment'] = 'mimes:jpeg,jpg,bmp,png,gif,svg,pdf';
        }
        if ($this->guest) {
            $rules['email'] = 'bail|required';
        }
        //dynamic field validation
        $tenantId = auth()->check() == true?auth()->user()->tenant_id:getTenantId();
        $dynamicFieldList = DynamicField::where('tenant_id', $tenantId)->orderBy('order', 'ASC')->get();
        if (count($dynamicFieldList) > 0) {
            foreach ($dynamicFieldList as $field) {
                if ($field->required == REQUIRED_YES) {
                    $rules[$field->name] = 'bail|required';
                }
            }
        }
        //dynamic field validation

        return $rules;
    }
}
