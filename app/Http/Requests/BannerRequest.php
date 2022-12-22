<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
        // $urlValue = $this->url;

        // if(!empty($urlValue)){
        //     if($task && $task="update"){
        //         $url = 'unique:banners,banner_url,'. $id.',banner_id';
        //     }else{
        //         $url = 'unique:banners,banner_url';
        //     }

        //     return [
        //         'name' => 'required',
        //         //'url' => $url,
        //     ];
        // }else{
        //     return [
        //         'name' => 'required',
        //     ];
        // }

        return [
            'name' => 'required'
        ];

    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống'//,
            // 'url.unique' => 'Url đã tồn tại'
        ];
    }
}
