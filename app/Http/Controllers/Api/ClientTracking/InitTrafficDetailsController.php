<?php

namespace App\Http\Controllers\Api\ClientTracking;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\ClientTracking\ClientTrackingTrafficDetailsRequest;
use App\Helpers\CryptHelper;
use App\Helpers\JsonHelper;
use App\Helpers\RequestHelper;
use App\Models\ClientTracking\ClientTrackingTrafficDetails;
use App\Models\ClientTracking\ClientTrackingGeoLiteDetails;
use App\Models\ClientTracking\ClientTrackingBlockIp;
use App\Http\Controllers\Api\Self\AccesstokenController;
use Abstractapi\IpGeolocation\AbstractIpGeolocation;


class InitTrafficDetailsController extends BaseController
{
    private $clienttrackingtrafficdetailsModel;
    private $clienttrackinggeolitedetailsModel;
    private $clienttrackingblockipModel;
    private $accesstokenController;
    private $geolocationController;
    private $geolocationapikey;

    public function __construct()
    {
        $this->clienttrackingtrafficdetailsModel     = new ClientTrackingTrafficDetails();
        $this->clienttrackinggeolitedetailsModel     = new ClientTrackingGeoLiteDetails();
        $this->clienttrackingblockipModel            = new ClientTrackingBlockIp();
        $this->accesstokenController                 = new AccesstokenController();
        $this->geolocationController                 = new AbstractIpGeolocation();
        $this->geolocationapikey                     = config('geolocation.providers.ipgeolocation.access_token');
        $this->geolocationController::configure($this->geolocationapikey);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $verfiyHashHeaderResult = $this->accesstokenController->verifyHashHeader($request);
        $verfiyHashHeaderResult = JsonHelper::getObjectFromArray($verfiyHashHeaderResult);
        if($verfiyHashHeaderResult->original->status === 'success' && $verfiyHashHeaderResult->original->code === '200')
        {
            $mbodyStr                   = JsonHelper::getPhpInput();
            $mbodyIterator              = JsonHelper::getIteratorFromString($mbodyStr);
            $mbodyIteratorArr           = JsonHelper::getArrayFromIterator($mbodyIterator);
            // Begin Check the block ip
            $checkBlockIp               = self::checkBlockIp($mbodyIteratorArr);
            if(!empty($checkBlockIp))
            {
                return response()->json(
                [
                    'message'   => 'Cập nhật dữ liệu không thành công',
                    'reason'    => 'Địa chỉ IP nằm trong danh sách cấm',
                    'status'    => 'fail',
                    'mode'      => '0',
                    'code'      => '100'
                ]);
            }
            // End Check the block ip

            // Begin Check Exist Data
            $checkExistTrafficDetails   = self::checkExistTrafficDetails($mbodyIteratorArr);
            if(empty($checkExistTrafficDetails))
            {
                $params = $this->clienttrackingtrafficdetailsModel->revertAlias($mbodyIteratorArr);
            }
            else
            {
                return response()->json(
                [
                    'message'   => 'Cập nhật dữ liệu không thành công',
                    'reason'    => 'Đã tồn tại đối tượng trong cùng thời gian',
                    'status'    => 'fail',
                    'mode'      => '0',
                    'code'      => '100'
                ]);
            }
            // End Check Exist Data
            try {
                $clientTrackingTrafficDetails = $this->clienttrackingtrafficdetailsModel::query()->create($params);
                //
                $geoDetails = $this->geolocationController::look_up($clientTrackingTrafficAds->ip);
                $mbodyGeoArr = array();
                $mbodyGeoArr['clientId'] = $mbodyIteratorArr['clientId'];
                $mbodyGeoArr['createdAt'] = $mbodyIteratorArr['createdAt'];
                $mbodyGeoArr = self::setBodyGeoArr($mbodyGeoArr, $geoDetails);
                //
                $checkExistGeoLiteDetails   = self::checkExistGeoLiteDetails($mbodyGeoArr);
                if(empty($checkExistGeoLiteDetails))
                {
                    $params = $this->clienttrackinggeolitedetailsModel->revertAlias($mbodyGeoArr);
                    $clientTrackingGeoLiteDetails = $this->clienttrackinggeolitedetailsModel::query()->create($params);
                }
                //
                return response()->json(
                [
                    'message'   => 'Cập nhật dữ liệu thành công',
                    'reason'    => '',
                    'status'    => 'success',
                    'mode'      => '0',
                    'code'      => '200'
                ]);
            } catch ( \Exception $e ) {
                return response()->json(
                [
                    'message'   => 'Cập nhật dữ liệu không thành công',
                    'reason'    => '',
                    'status'    => 'fail',
                    'mode'      => '0',
                    'code'      => '100'
                ]);
            }
        }
        else
        {
            return response()->json(
            [
                'message'   => 'Cập nhật dữ liệu không thành công',
                'reason'    => '',
                'status'    => 'fail',
                'mode'      => '0',
                'code'      => '100'
            ]);
        }
    }

    /**
     * @param Array $data
     * @return Object $result
     */
    public function checkBlockIp($data)
    {
        $result = $this->clienttrackingblockipModel::where('ip', $data['ip'])->where('status', 'activated')->first();
        return $result;
    }

    /**
     * @param Array $data
     * @return Object $result
     */
    public function checkExistTrafficDetails($data)
    {
        $result = $this->clienttrackingtrafficdetailsModel::where('client_id', $data['clientId'])->where('device_type', $data['deviceType'])->where('created_at', $data['createdAt'])->first();
        return $result;
    }

    /**
     * @param Array $data
     * @return Object $result
     */
    public function checkExistGeoLiteDetails($data)
    {
        $result = $this->clienttrackinggeolitedetailsModel::where('client_id', $data['clientId'])
                                                            ->where('ip', $data['ip'])
                                                            ->where('city', $data['city'])
                                                            ->where('country', $data['country'])
                                                            ->where('created_at', $data['createdAt'])
                                                            ->first();
        return $result;
    }

    /**
     * @param Array $data
     * @param Object $data
     * @return Object $result
     */
    public function setBodyGeoArr($arr, $data)
    {
        $arr['ip'] = $data->ip_address;
        $arr['city'] = $data->city;
        $arr['cityId'] = $data->city_geoname_id;
        $arr['region'] = $data->region;
        $arr['regionCode'] = $data->region_iso_code;
        $arr['regionId'] = $data->region_geoname_id;
        $arr['postalCode'] = $data->postal_code;
        $arr['country'] = $data->country;
        $arr['countryCode'] = $data->country_code;
        $arr['continent'] = $data->continent;
        $arr['continentCode'] = $data->continent_code;
        $arr['continentId'] = $data->continent_geoname_id;
        $arr['longitude'] = $data->longitude;
        $arr['latitude'] = $data->latitude;
        $arr['isVpn'] = ($data->security->is_vpn) ? $data->security->is_vpn : 'false';

        return $arr;
    }
}