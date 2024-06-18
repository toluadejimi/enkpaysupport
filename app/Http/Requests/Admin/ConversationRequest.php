<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ConversationRequest extends FormRequest
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
        $id = !is_null($this->id) ? $this->id : null;
        $rules = [
            'conversation_details' => 'required|string'
        ];
        if ($this->attachment) {
            $rules['attachment'] = 'mimes:jpeg,jpg,bmp,png,gif,svg,pdf';
        }
        return $rules;
    }
}
