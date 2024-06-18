<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class NewsAndArticlesRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'title' => 'required|min:10|max:255|unique:new_articles,title,' . $this->id,
            'description' => 'required'
        ];

        if (is_null($this->id)) {
            $rules['image'] = 'required|mimes:jpeg,png,jpg,webp|file|max:2048';
        } else {
            $rules['image'] = 'mimes:jpeg,png,jpg,webp|file|max:2048';
        }


        return $rules;
    }
}
