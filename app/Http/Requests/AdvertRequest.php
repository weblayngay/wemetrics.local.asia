<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertRequest extends FormRequest
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
        $slugValue = $this->slug;

        if(!empty($slugValue)){
            if($task && $task="update"){
                $slug = 'unique:adverts,advert_slug,'. $id.',advert_id';
            }else{
                $slug = 'unique:adverts,advert_slug';
            }

            return [
                'name' => 'required',
                'slug' => $slug
            ];
        }else{
            return [
                'name' => 'required',
            ];
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'slug.unique' => 'Url đã tồn tại'
        ];
    }
}
