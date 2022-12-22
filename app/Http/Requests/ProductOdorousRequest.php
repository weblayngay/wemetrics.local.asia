<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductOdorousRequest extends FormRequest
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
            $name = 'required|unique:product_odorous,podo_name,'. $id.',podo_id';
        }else{
            $name = 'required|unique:product_odorous,podo_name';
        }

        return [
            'name' => $name
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'name.unique' => 'Tên màu đã tồn tại'
        ];
    }
}
