<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactMessageRequest extends FormRequest
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
            'email' => 'required | regex:/(.+)@(.+)\.(.+)/i', 'email',
            'phone' => 'required',
            'subject' => 'required',
            'message' => 'required'
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'name is required!',
            'email.required' => 'email is required!',
            'email.regex' => 'invalid email!',
            'phone.required' => 'phone is required!',
            'subject.required' => 'subject is required!',
            'message.required' => 'message is required!'
        ];
    }
}
