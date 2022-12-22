<?php

namespace App\Http\Requests\ClientTracking;

use Illuminate\Foundation\Http\FormRequest;

class ClientTrackingTrafficDetailsRequest extends FormRequest
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
            'client_id'         => 'required|max:50',
            'browser'           => 'required|max:50',
            'version_browser'   => 'required|max:50',
            'device_type'       => 'required|max:50',
            'platform'          => 'required|max:50',
            'version_platform'  => 'required|max:50',
            'ip'                => 'required|max:50',
            'request_rui'       => 'required|max:50',
            'referer'           => 'required|max:50',
        ];
    }

    public function messages()
    {
        return [
            'client_id.required' => 'Client id không được để trống',
            'client_id.max' => 'Client id không vượt quá 50 ký tự',
            'browser.required' => 'Trình duyệt không được để trống',
            'browser.max' => 'Trình duyệt không vượt quá 50 ký tự',
            'version_browser.required' => 'Phiên bản trình duyệt không được để trống',
            'version_browser.max' => 'Phiên bản trình duyệt không vượt quá 50 ký tự',
            'device_type.required' => 'Loại thiết bị không được để trống',
            'device_type.max' => 'Loại thiết bị không vượt quá 50 ký tự',
            'platform.required' => 'Nền tảng không được để trống',
            'platform.max' => 'Nền tảng không vượt quá 50 ký tự',
            'version_platform.required' => 'Phiên bản nền tảng không được để trống',
            'version_platform.max' => 'Phiên bản nền tảng không vượt quá 50 ký tự',
            'ip.required' => 'ip không được để trống',
            'ip.max' => 'ip không vượt quá 50 ký tự',
            'request_rui.required' => 'Yêu cầu truy cập không được để trống',
            'request_rui.max' => 'Yêu cầu truy cập không vượt quá 50 ký tự',
            'referer.required' => 'Nguồn truy cập không được để trống',
            'referer.max' => 'Nguồn truy cập không vượt quá 50 ký tự',
        ];
    }
}
