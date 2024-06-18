<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserRequest extends FormRequest
{
    protected $id;

    public function __construct(Request $request)
    {
        $this->id = $request->route()->user;
    }

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
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|unique:users,mobile',
            'dob' => 'required',
            'gender' => 'required',
            'phone_verification_status' => 'required',
            'email_verification_status' => 'required',
            'address' => 'required',
            'password' => 'required|string|min:6',
            'status' => 'required',
            'profile_image' => 'required',
        ];

        if ($this->getMethod() == 'PUT') {
            $rules['email'] = 'required|email|unique:users,email,' . $this->id;
            $rules['password'] = 'nullable|min:6';
        }

        return $rules;
    }
}
