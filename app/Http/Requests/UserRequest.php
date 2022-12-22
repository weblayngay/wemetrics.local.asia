<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $emailValue = $this->email;
        $passwordValue = $this->password;

        // if(!empty($emailValue)){
        //     if($task && $task="update"){
        //         $email = 'unique:users,email,'. $id.',id';
        //     }else{
        //         $email = 'unique:users,email';
        //     }

        //     return [
        //         'name' => 'required',
        //         'email' => $email
        //     ];
        // }else{

        //     return [
        //         'name' => 'required',
        //     ];
        // }

        if(!empty($passwordValue)){
            if($task && $task="update"){
                $passwordRule = 'required|confirmed|between:8,255|regex:/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$/';
            }else{
                $passwordRule = 'required|confirmed|between:8,255|regex:/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$/';
            }

            return [
                'name'  => 'required',
                'email' => 'required|email|unique:users,email,'. $id.',id',
                'phone' => 'required|between:9,15|regex:/^[0-9]+$/|unique:users,phone,'. $id.',id',
                'address' => 'required',
                'password' => $passwordRule,
            ];  
        }else{

            return [
                'name'  => 'required',
                'email' => 'required|email|unique:users,email,'. $id.',id',
                'phone' => 'required|between:9,15|regex:/^[0-9]+$/|unique:users,phone,'. $id.',id',
                'address' => 'required',
            ];  
        } 

    }

    public function messages()
    {
        return [
            'name.required'      => 'Tên không được để trống',
            'address.required'   => 'Địa chỉ không được để trống',
            'email.required'     => 'Email không được để trống',
            'email.unique'       => 'Email đã tồn tại',
            'email.email'        => 'Email không đúng định dạng',
            'phone.required'     => 'Điện thoại không được để trống',
            'phone.unique'       => 'Điện thoại đã tồn tại',
            'phone.regex'        => 'Điện thoại không đúng định dạng', 
            'phone.between'      => 'Điện thoại phải từ 9 ký tự',         
            'password.required'  => 'Mật khẩu là bắt buộc',
            'password.confirmed' => 'Xác nhận mật khẩu không chính xác',
            'password.between'   => 'Mật khẩu phải từ 8 ký tự',
            'password.regex'     => 'Mật khẩu phải là chữ hoặc số',              
        ];
    }
}
