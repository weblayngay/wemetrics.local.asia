<?php

namespace App\Http\Controllers\Backend\Intergrate\Kiotviet\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use VienThuong\KiotVietClient;
use App\Helpers\UrlHelper;
use App\Helpers\DateHelper;
use App\Helpers\ImageHelper;
use App\Helpers\ArrayHelper;
use App\Helpers\StringHelper;
use App\Models\Image;
use App\Models\AdminUser;
use App\Models\AdminMenu;
use App\Models\ApiOut\CTokenOut;
use App\Models\ApiOut\CTokenVendor;

class KiotvietAuthController extends BaseController
{
    private $view = '.kiotvietauth';
    private $model = 'kiotvietauth';
    private $imageModel;
    private $adminUserModel;
    private $adminMenu;
    private $ctokenoutModel;
    private $ctokenvendorModel;
    private $vendor;

    public function __construct()
    {
        $this->imageModel = new Image();
        $this->adminUserModel = new AdminUser();
        $this->adminMenuModel = new AdminMenu();
        $this->ctokenoutModel = new CTokenOut();
        $this->ctokenvendorModel = new CTokenVendor();
        $this->vendor = 'kiotviet.vn';
    }

    /**
     * @return Application|Factory|View
     */
    public function doCreateClient()
    {
    	$dataVendor = $this->ctokenvendorModel::from(CTOKENVENDOR_TBL. " AS t1")
    			->selectRaw("t1.vendor_id AS id")
    			->whereRaw("t1.vendor_name = '".$this->vendor."'")
    			->first();

        $data = $this->ctokenoutModel::from(CTOKENOUT_TBL. " AS t1")
                ->selectRaw("t1.ctokenout_name AS name, t1.ctokenout_value AS value")
                ->whereRaw("t1.ctokenout_vendor = '".$dataVendor->id."'")
                ->get();

        $clientId = '';
        $clientSecret = '';

        foreach($data as $key => $item)
        {
            if($item->name == 'client_id')
            {
                $clientId = $item->value;
            }

            if($item->name == 'client_secret')
            {
                $clientSecret = $item->value;
            }
        }

        $client = new KiotVietClient\Client($clientId, $clientSecret);

        // Fetch access token
        $token = $client->fetchAccessToken();

        $client->setExpiresAt(0);

        // Set token callback
        $client->setTokenCallback(function ($token) {
            var_dump("Token is Refreshed");
            var_dump($token);
        });

        return $client;
    }
}