<?php

namespace App\Http\Requests\ClientTracking;

use Illuminate\Foundation\Http\FormRequest;

class ClientTrackingRefererRequest extends FormRequest
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
            'referral' => 'required|max:255',
            'category' => 'required|max:50',
            'provider' => 'required|max:50',
            'icon'     => 'required|max:50',
        ];
    }

    public function messages()
    {
        return [
            'referral.required' => 'Tên không được để trống',
            'referral.max' => 'Tên không vượt quá 255 ký tự',
            'category.required' => 'Nhóm không được để trống',
            'category.max' => 'Nhóm không vượt quá 50 ký tự',
            'provider.required' => 'Nhóm không được để trống',
            'provider.max' => 'Nhóm không vượt quá 50 ký tự', 
            'icon.required' => 'Nhóm không được để trống',
            'icon.max' => 'Nhóm không vượt quá 50 ký tự',                                    
        ];
    }
}
