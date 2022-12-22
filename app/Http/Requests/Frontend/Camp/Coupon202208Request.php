<?php

namespace App\Http\Requests\Frontend\Camp;

use Illuminate\Foundation\Http\FormRequest;

class Coupon202208Request extends FormRequest
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
        $id = (int) $this->id;
        return [
            // 'email' => 'required|email|unique:campaign_results,email,'. $id.',id',
            'phoneNumber' => 'required|between:9,15|regex:/^[0-9]+$/',
        ];  

    }

    public function messages()
    {
        return [
            'phoneNumber.required'     => 'Điện thoại không được để trống',
            'phoneNumber.regex'        => 'Điện thoại không đúng định dạng', 
            'phoneNumber.between'      => 'Điện thoại phải từ 9 ký tự',           
        ];
    }
}
