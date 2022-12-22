<?php

namespace App\Http\Requests\ClientTracking;

use Illuminate\Foundation\Http\FormRequest;

class ClientTrackingReplaceReqRuiRequest extends FormRequest
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
            'value' => 'required|max:50',
        ];
    }

    public function messages()
    {
        return [
            'value.required' => 'Giá trị không được để trống',
            'value.max' => 'Giá trị không vượt quá 50 ký tự',
        ];
    }
}
