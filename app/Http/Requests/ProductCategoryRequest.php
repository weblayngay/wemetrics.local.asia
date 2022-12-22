<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryRequest extends FormRequest
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
            'pcat_name'  => 'bail|required',
            'id'  =>   'integer',
            'parent'  =>   'bail|integer|not_in:1',
        ];
    }

    public function messages()
    {
        return [
            'pcat_name.required' => 'Tên không được rỗng',
        ];
    }
}
