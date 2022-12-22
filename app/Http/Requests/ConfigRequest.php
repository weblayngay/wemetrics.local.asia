<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends FormRequest
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
        $id = $this->post('id', 0);
        $rules = [
            'conf_name' => 'bail|required|min:2',
            'conf_key'  => 'bail|required',
            'conf_value'=> 'bail|required',
            'id'        => 'bail|integer'
        ];
        if ($id > 0) {
            $rules['conf_key'] = 'bail|between:2,255';
        }
        return $rules;
    }


}
