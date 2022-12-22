<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampaignRequest extends FormRequest
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
                $slug = 'unique:campaigns,campaign_slug,'. $id.',campaign_id';
            }else{
                $slug = 'unique:campaigns,campaign_slug';
            }

            return [
                'name' => 'required',
                'type' => 'required|not_in:0',
                'group' => 'required|not_in:0',
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
            'type.required' => 'Loại không được để trống',
            'type.not_in' => 'Loại không được để trống',
            'group.required' => 'Nhóm không được để trống',
            'group.not_in' => 'Loại không được để trống',
            'slug.unique' => 'Url đã tồn tại'
        ];
    }
}
