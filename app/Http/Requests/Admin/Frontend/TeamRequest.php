<?php

namespace App\Http\Requests\Admin\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class TeamRequest extends FormRequest
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
            'facebook_link' => 'required',
            'instagram_link' => 'required',
            'twitter_link' => 'required',
            'image' => 'required'
        ];

        if (!$this->id) {
            $rules['image'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => __('Name is required!'),
            'designation.required' => __('Designation is required!'),
            'facebook_link.required' => __('Facebook link is required!'),
            'instagram_link.required' => __('Instagram link is required!'),
            'twitter_link.required' => __('Twitter link is required!'),
            'image.required' => __('Image is required!')
        ];
    }
}
