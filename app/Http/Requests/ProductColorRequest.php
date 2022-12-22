<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductColorRequest extends FormRequest
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
            $hex = 'required|unique:product_colors,pcolor_hex,'. $id.',pcolor_id';
        }else{
            $hex = 'required|unique:product_colors,pcolor_hex';
        }

        return [
            'code' => 'required',
            'hex' => $hex
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Màu không được để trống',
            'hex.required' => 'Mã màu không được để trống',
            'hex.unique' => 'Mã màu đã tồn tại'
        ];
    }
}
