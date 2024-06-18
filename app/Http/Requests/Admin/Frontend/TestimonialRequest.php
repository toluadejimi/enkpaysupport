<?php

namespace App\Http\Requests\Admin\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
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
            'name' => 'required',
            'designation' => 'required',
            'comment' => 'required',
            'star' => 'bail|required|integer|min:0|max:5',
        ];

        if (!$this->id) {
            $rules['image'] = 'required';
            $rules['logo'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'name is required!',
            'designation.required' => 'designation is required!',
            'comment.required' => 'comment is required!',
            'image.required' => 'image is required!',
            'logo.required' => 'logo is required!'
        ];
    }
}
