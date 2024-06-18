<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GeneralSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'app_name' => 'required|unique',
            'app_email' => 'required',
            'app_contact_number' => 'required',
            'app_location' => 'required',
            'app_copyright' => 'required',
            'app_developed' => 'required',
            'app_timezone' => 'required',
            'app_debug' => 'required',
            'app_date_format' => 'required',
            'app_time_format' => 'required',
        ];

        return $rules;
    }
}
