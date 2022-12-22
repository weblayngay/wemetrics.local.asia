<?php

namespace App\Http\Requests\ClientTracking;

use Illuminate\Foundation\Http\FormRequest;

class ClientTrackingDeviceRequest extends FormRequest
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
            'name' => 'required|max:255',
            'icon' => 'required|max:50',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'name.max' => 'Tên không vượt quá 255 ký tự',
            'icon.required' => 'Biểu tượng không được để trống',
            'icon.max' => 'Biểu tượng không vượt quá 50 ký tự',
        ];
    }
}
