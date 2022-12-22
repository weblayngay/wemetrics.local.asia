<?php

namespace App\Http\Requests\ClientTracking;

use Illuminate\Foundation\Http\FormRequest;

class ClientTrackingBlockIpRequest extends FormRequest
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
            'ip' => 'required|max:15',
            'reason' => 'required|max:255',
        ];
    }

    public function messages()
    {
        return [
            'ip.required' => 'Địa chỉ ip không được để trống',
            'ip.max' => 'Địa chỉ ip không vượt quá 15 ký tự',
            'reason.required' => 'Lý do không được để trống',
            'reason.max' => 'Lý do không vượt quá 255 ký tự',
        ];
    }
}
