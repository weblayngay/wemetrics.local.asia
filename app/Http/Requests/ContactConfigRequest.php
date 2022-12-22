<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactConfigRequest extends FormRequest
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
        $phoneNumbers = $this->phoneNumbers;
        $emails = $this->emails;

        return [
            'name' => 'required',
            'phoneNumbers' => 'required|regex:/^0\d[0-9]{8}(?:;\d{1})?(?:;0\d[0-9]{8}(?:;\d{1})?)*$/', // Bắt đầu bằng 0 tiếp theo là các ký tự từ 0 đến 9. Không kết thúc bằng ; nếu có nhiều hơn 2 số điện thoại thì ngăn cách nhau bằng dấu ;
            'emails' => 'required|regex:/(?!.*;$)^([-\w]+?@\w+\.\w+(?:\s*;\s*)?)+$/' // Bắt đầu bằng các ký tự 0-9 a-z A-Z tiếp theo là @ và domain. Không kết thúc bằng ; nếu có nhiều hơn 2 email thì ngăn sách nhau bằng dấu ;
        ];

    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'phoneNumbers.required' => 'Điện thoại không được để trống',
            'phoneNumbers.regex' => 'Điện thoại không hợp lệ',
            'emails.required' => 'Email không được để trống',
            'emails.regex' => 'Email không hợp lệ'
        ];
    }
}
