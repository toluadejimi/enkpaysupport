<?php

namespace App\Http\Requests\customer;

use Illuminate\Foundation\Http\FormRequest;

class TicketRatingRequest extends FormRequest
{

    public function rules()
    {
        $rules['rating_category'] = 'bail|required';
        $rules['rate'] = 'bail|required';
        $rules['target_ticket'] = 'bail|required';
        $rules['rating_comment'] = 'bail|required';
        return $rules;
    }
}
