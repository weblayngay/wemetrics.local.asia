<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
        // $id = (int) $this->id;
        // $task = $this->task;

        // if($task && $task="update"){
        //     $url = 'required|:menus,menu_url,'. $id.',menu_id';
        // }else{
        //     $url = 'required|:menus,menu_url';
        // }

        // return [
        //     'name' => 'required',
        //     'url' => $url,
        // ];

        return [
            'name' => 'required'
        ];
    }

    public function messages()
    {
        // return [
        //     'name.required' => 'Tên không được để trống',
        //     'url.required' => 'Url không được để trống',
        //     'url.unique' => 'Url đã tồn tại'
        // ];
        return [
            'name.required' => 'Tên không được để trống'
        ];
    }
}
