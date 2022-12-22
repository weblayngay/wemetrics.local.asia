<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
        $email = $this->email;

        if(!empty($email)){
            if($task && $task="update"){
                $email = 'unique:contacts,contact_email,'. $id.',contact_id';
            }else{
                $email = 'unique:contacts,contact_email';
            }

            return [
                'name' => 'required',
                'email' => $email,
            ];
        }else{
            return [
                'name' => 'required'
            ];
        }

    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'email.unique' => 'Email đã tồn tại',
        ];
    }
}
