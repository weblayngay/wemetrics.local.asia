<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
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
        $codeValue = $this->code;

        if(!empty($codeValue)){
            if($task && $task="update"){
                $code = 'required|unique:vouchers,voucher_code,'. $id.',voucher_id';
            }else{
                $code = 'required|unique:vouchers,voucher_code';
            }

            return [
                'name' => 'required',
                'code' => $code
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
            'name.required' => 'Mã giảm giá không được để trống',
            'code.unique' => 'Mã giảm giá đã tồn tại'
        ];
    }
}
