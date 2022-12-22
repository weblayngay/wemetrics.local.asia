<?php

namespace App\Http\Requests\ClientTracking;

use Illuminate\Foundation\Http\FormRequest;

class ClientTrackingGeoLiteDetailsRequest extends FormRequest
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
            'client_id'             => 'required|max:50',
            'ip'                    => 'required|max:50',
            'city'                  => 'required|max:50',
            'city_geoname_id'       => 'required|max:50',
            'region'                => 'required|max:50',
            'region_iso_code'       => 'required|max:50',
            'region_geoname_id'     => 'required|max:50',
            'postal_code'           => 'required|max:50',
            'country'               => 'required|max:50',
            'country_code'          => 'required|max:50',
            'continent'             => 'required|max:50',
            'continent_code'        => 'required|max:50',
            'continent_geoname_id'  => 'required|max:50',
            'longitude'             => 'required|max:50',
            'latitude'              => 'required|max:50',
            'is_vpn'                => 'required|max:50',
        ];
    }

    public function messages()
    {
        return [
            'client_id.required'            => 'Client id không được để trống',
            'client_id.max'                 => 'Client id không vượt quá 50 ký tự',
            'ip.required'                   => 'ip không được để trống',
            'ip.max'                        => 'ip không vượt quá 50 ký tự',
            'city.required'                 => 'Thành phố không được để trống',
            'city.max'                      => 'Thành phố không vượt quá 50 ký tự',
            'city_geoname_id.required'      => 'Mã thành phố không được để trống',
            'city_geoname_id.max'           => 'Mã thành phố không vượt quá 50 ký tự',
            'region.required'               => 'Tỉnh thành không được để trống',
            'region.max'                    => 'Tỉnh thành không vượt quá 50 ký tự',
            'region_iso_code.required'      => 'Mã iso tỉnh thành không được để trống',
            'region_iso_code.max'           => 'Mã iso tỉnh thành không vượt quá 50 ký tự',
            'region_geoname_id.required'    => 'Tên tỉnh thành không được để trống',
            'region_geoname_id.max'         => 'Tên tỉnh thành không vượt quá 50 ký tự',
            'postal_code.required'          => 'Mã vùng không được để trống',
            'postal_code.max'               => 'Mã vùng không vượt quá 50 ký tự',
            'country.required'              => 'Tên quốc gia không được để trống',
            'country.max'                   => 'Tên quốc gia không vượt quá 50 ký tự',
            'country_code.required'         => 'Mã quốc gia không được để trống',
            'country_code.max'              => 'Mã quốc gia không vượt quá 50 ký tự',
            'continent.required'            => 'Lục địa không được để trống',
            'continent.max'                 => 'Lục địa không vượt quá 50 ký tự',
            'continent_code.required'       => 'Mã lục địa không được để trống',
            'continent_code.max'            => 'Mã lục địa không vượt quá 50 ký tự',
            'continent_geoname_id.required' => 'Tên lục địa không được để trống',
            'continent_geoname_id.max'      => 'Tên lục địa không vượt quá 50 ký tự',
            'longitude.required'            => 'Kinh độ không được để trống',
            'longitude.max'                 => 'Kinh độ không vượt quá 50 ký tự',
            'latitude.required'             => 'Vĩ độ không được để trống',
            'latitude.max'                  => 'Vĩ độ không vượt quá 50 ký tự',
            'is_vpn.required'               => 'Truy cập Proxy không được để trống',
            'is_vpn.max'                    => 'Truy cập Proxy không vượt quá 50 ký tự',
        ];
    }
}
