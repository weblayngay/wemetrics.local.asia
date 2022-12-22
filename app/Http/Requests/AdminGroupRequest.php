<?php

namespace App\Http\Requests;

use http\Client\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminGroupRequest extends FormRequest
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
            'name'  => 'bail|required|',
            'id'  =>   'integer|not_in:' . implode(',', ROOT_GROUP_IDS),
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên nhóm không được rỗng',
        ];
    }
}
