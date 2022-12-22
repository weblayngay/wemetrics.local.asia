<?php

namespace App\Http\Requests;

use http\Client\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUserRequest extends FormRequest
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
        $id = $this->post('id', 0);

        $rules = [
            'name'      => 'bail|required|min:5',
            'email'     => 'bail|email|nullable',
            'adgroup_id'=> 'bail|integer|required',
            'status'    => 'bail|required|in:inactive,activated',
            'id'        => 'bail|integer|not_in:' . implode(',', ROOT_USER_IDS),

        ];

        if ($id == 0) {
            $rules['password'] = 'bail|required|confirmed|between:6,255|regex:/^[a-zA-Z0-9!@#$%^&*]+$/';
            $rules['username'] = 'bail|required|between:6,255|unique:admin_users,username';
        }else{
            $rules['password'] = 'bail|confirmed|nullable|between:6,255|regex:/^[a-zA-Z0-9!@#$%^&*]+$/';
            $rules['username'] = 'bail|between:6,255|exists:admin_users,username,aduser_id,' . $id;
        }


        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Họ tên không được rỗng',
            'name.min'      => 'Họ tên ít nhất 5 ký tự',
        ];
    }
}
