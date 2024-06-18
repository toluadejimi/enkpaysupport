<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationSettingRequest extends FormRequest
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
        return [
            'app_name' => 'bail|required',
            'app_email' => 'bail|required',
            'app_contact_number' => 'bail|required',
            'app_location' => 'bail|required',
            'app_copyright' => 'bail|required',
            'app_developed' => 'bail|required',
            'currency_id' => 'bail|required',
            'language_id' => 'bail|required',
            'app_timezone' => 'bail|required',
            'app_preloader_status' => 'bail|required',
            'sign_up_left_text_title' => 'bail|nullable',
            'sign_up_left_text_subtitle' => 'bail|nullable',
            'forgot_title' => 'bail|nullable',
            'forgot_subtitle' => 'bail|nullable',
            'forgot_btn_name' => 'bail|nullable',
            'app_preloader' => 'bail|nullable',
            'app_logo' => 'bail|nullable',
            'app_fav_icon' => 'bail|nullable',
            'app_footer_logo' => 'bail|nullable',
            'facebook_url' => 'bail|nullable',
            'instagram_url' => 'bail|nullable',
            'linkedin_url' => 'bail|nullable',
            'twitter_url' => 'bail|nullable',
        ];
    }
}
