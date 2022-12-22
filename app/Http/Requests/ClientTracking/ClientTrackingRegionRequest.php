<?php

namespace App\Http\Requests\ClientTracking;

use Illuminate\Foundation\Http\FormRequest;

class ClientTrackingRegionRequest extends FormRequest
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

        return [
            'code'   => 'required|max:50',
            'name'   => 'required|max:50',
            'nation' => 'required|max:50',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Tên không được để trống',
            'code.max' => 'Tên không vượt quá 50 ký tự',
            'name.required' => 'Nhóm không được để trống',
            'name.max' => 'Nhóm không vượt quá 50 ký tự',
            'nation.required' => 'Nhóm không được để trống',
            'nation.max' => 'Nhóm không vượt quá 50 ký tự',                                   
        ];
    }
}
