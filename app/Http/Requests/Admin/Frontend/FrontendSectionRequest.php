<?php

namespace App\Http\Requests\Admin\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class FrontendSectionRequest extends FormRequest
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
        $rules = [];
        if (request()->input('slug') != 'growing_company') {
            $rules = [
                'title' => 'required'
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'title is required!'
        ];
    }
}
