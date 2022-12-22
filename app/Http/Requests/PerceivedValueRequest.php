<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerceivedValueRequest extends FormRequest
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
            'description' => 'required',
            'id'  => 'integer'
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'Cảm nhận không được rỗng',
        ];
    }
}
