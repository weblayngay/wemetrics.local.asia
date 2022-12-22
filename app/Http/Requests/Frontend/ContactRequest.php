<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'phoneNumber' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'g-recaptcha-response' => 'required|captcha'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'phoneNumber.required' => 'Số điện thoại không được để trống',
            'email.required' => 'Email không được để trống',
            'subject.required' => 'Chủ để không được để trống',
        ];
    }
}
