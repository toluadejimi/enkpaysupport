<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required'
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'title is required!',
            'title.unique' => 'title already exist!',
            'description.required' => 'description is required!'
        ];
    }
}
