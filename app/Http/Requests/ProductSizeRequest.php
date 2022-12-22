<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductSizeRequest extends FormRequest
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

        if($task && $task="update"){
            $value = 'required|unique:product_sizes,psize_value,'. $id.',psize_id';
        }else{
            $value = 'required|unique:product_sizes,psize_value';
        }

        return [
            'code' => 'required',
            'value' => $value,
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Mã không được để trống',
            'value.required' => 'Kích thước không được để trống',
            'value.unique' => 'Mã kích thước đã tồn tại'
        ];
    }
}
