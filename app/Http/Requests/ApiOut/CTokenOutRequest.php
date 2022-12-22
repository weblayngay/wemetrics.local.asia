<?php

namespace App\Http\Requests\ApiOut;

use Illuminate\Foundation\Http\FormRequest;

class CTokenOutRequest extends FormRequest
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
        $value = $this->value;

        if(!empty($value)){
            if($task && $task="update"){
                $keyValue = 'required|max:255|min:8|unique:ctokenout,ctokenout_value,'. $id.',ctokenout_id';
            }else{
                $keyValue = 'required|max:255|min:8|unique:ctokenout,ctokenout_value';
            }

            return [
                'name' => 'required|max:255',
                'vendor' => 'required|not_in:0',
                'value' => $keyValue,
            ];
        }else{
            return [
                'name' => 'required|max:255',
                'vendor' => 'required|not_in:0',
            ];
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'name.max' => 'Tên không vượt quá 255 ký tự',
            'vendor.required' => 'Nhà cung cấp không được để trống',
            'vendor.not_in' => 'Nhà cung cấp không được để trống',
            'value.required' => 'Giá trị khóa không được để trống',
            'value.unique' => 'Giá trị khóa đã tồn tại',
            'value.max' => 'Giá trị khóa không vượt quá 255 ký tự',
            'value.min' => 'Giá trị khóa không thấp hơn 8 ký tự',
        ];
    }
}
