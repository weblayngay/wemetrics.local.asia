<?php

namespace App\Http\Requests\ApiIn;

use Illuminate\Foundation\Http\FormRequest;

class CTokenInRequest extends FormRequest
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
        $clientIdValue = $this->client_id;
        $clientKeyValue = $this->client_key;

        if(!empty($clientIdValue) || !empty($clientKeyValue)){
            if($task && $task="update"){
                $clientId = 'required|max:255|min:22|unique:ctokenin,client_id,'. $id.',ctokenin_id';
                $clientKey = 'required|max:255|min:32|unique:ctokenin,client_key,'. $id.',ctokenin_id';
            }else{
                $clientId = 'required|max:255|min:22|unique:ctokenin,client_id';
                $clientKey = 'required|max:255|min:32|unique:ctokenin,client_key';
            }

            return [
                'name' => 'required|max:255',
                'client_id' => $clientId,
                'client_key' => $clientKey,
            ];
        }else{
            return [
                'name' => 'required|max:255',
            ];
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'name.max' => 'Tên không vượt quá 255 ký tự',
            'client_id.required' => 'Client Id không được để trống',
            'client_key.required' => 'Client Key không được để trống',
            'client_id.unique' => 'Client Id đã tồn tại',
            'client_key.unique' => 'Client Key đã tồn tại',
            'client_id.max' => 'Client Id không vượt quá 255 ký tự',
            'client_key.max' => 'Client Key không vượt quá 255 ký tự',
            'client_id.min' => 'Client Id không thấp hơn 22 ký tự',
            'client_key.min' => 'Client Key không thấp hơn 32 ký tự',
        ];
    }
}
