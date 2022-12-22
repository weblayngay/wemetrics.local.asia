<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoucherGroupRequest extends FormRequest
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
        $task = $this->task;
        $nameValue = $this->slug;

        if(!empty($nameValue)){
            if($task && $task="update"){
                $slug = 'required|unique:vouchergroup,vouchergroup_name,'. $id.',vouchergroup_id';
            }else{
                $slug = 'required|unique:vouchergroup,vouchergroup_name';
            }

            return [
                'name' => $slug,
            ];
        }else{
            return [
                'name' => 'required',
            ];
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'name.unique' => 'Tên đã tồn tại',
        ];
    }
}
