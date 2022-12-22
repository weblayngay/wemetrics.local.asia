<?php

namespace App\Http\Controllers\Backend\ClientTracking\Report;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Helpers\UrlHelper;
use App\Helpers\ArrayHelper;
use App\Helpers\DateHelper;
use App\Helpers\CollectionPaginateHelper;
use App\Models\AdminUser;
use DB;
use App\Http\Controllers\Backend\ClientTracking\Report\Children\getTrafficByDateController;
use App\Http\Controllers\Backend\ClientTracking\Report\Children\getTrafficSourceController;
use App\Http\Controllers\Backend\ClientTracking\Report\Children\getTrafficBrowserController;
use App\Http\Controllers\Backend\ClientTracking\Report\Children\getTrafficDeviceController;
use App\Http\Controllers\Backend\ClientTracking\Report\Children\getTrafficPlatformController;
use App\Http\Controllers\Backend\ClientTracking\Report\Children\getTrafficAdsController;

class ClienttrackingreportoverviewController extends BaseController
{
    private $view = '.clienttrackingreportoverview';
    private $model = 'clienttrackingreportoverview';
    private $adminUserModel;

    private $getTrafficByDateCtrl;
    private $getTrafficSourceCtrl;
    private $getTrafficBrowserCtrl;
    private $getTrafficDeviceCtrl;
    private $getTrafficPlatformCtrl;
    private $getTrafficAdsCtrl;

    public function __construct()
    {
        $this->adminUserModel = new AdminUser();
        $this->getTrafficByDateCtrl = new getTrafficByDateController();
        $this->getTrafficSourceCtrl = new getTrafficSourceController();
        $this->getTrafficBrowserCtrl = new getTrafficBrowserController();
        $this->getTrafficDeviceCtrl = new getTrafficDeviceController();
        $this->getTrafficPlatformCtrl = new getTrafficPlatformController();
        $this->getTrafficAdsCtrl = new getTrafficAdsController();
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalTrafficByDate($frmDate = '', $toDate = '', $mSourceMaster = '')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTrafficByDateCtrl->doGetTrafficByDate($frmDate, $toDate, $mSourceMaster);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalTrafficSource($frmDate = '', $toDate = '', $mSource = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTrafficSourceCtrl->doGetTrafficSource($frmDate, $toDate, $mSource);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalTrafficBrowser($frmDate = '', $toDate = '', $mBrowser = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTrafficBrowserCtrl->doGetTrafficBrowser($frmDate, $toDate, $mBrowser);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalTrafficDevice($frmDate = '', $toDate = '', $mDevice = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTrafficDeviceCtrl->doGetTrafficDevice($frmDate, $toDate, $mDevice);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalTrafficPlatform($frmDate = '', $toDate = '', $mPlatform = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTrafficPlatformCtrl->doGetTrafficPlatform($frmDate, $toDate, $mPlatform);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalTrafficAds($frmDate = '', $toDate = '', $mAds = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTrafficAdsCtrl->doGetTrafficAds($frmDate, $toDate, $mAds);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = 'Client Tracking Overview';
        $data['view']  = $this->viewPath . $this->view . '.list';

        $frmDate = (string) strip_tags(request()->post('frmDate', date('Y-m-01')));
        if(empty($frmDate))
        {
            $error   = 'Vui lòng chọn điều kiện lọc thời gian';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
        else
        {
            $frmDate = DateHelper::getDate('Y-m-d', $frmDate);
        }

        $toDate = (string) strip_tags(request()->post('toDate', date('Y-m-d')));
        if(empty($toDate))
        {
            $error   = 'Vui lòng chọn điều kiện lọc thời gian';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
        else
        {
            $toDate = DateHelper::getDate('Y-m-d', $toDate);
        }
        
        $mSource = (string) strip_tags(request()->post('mSource', '%'));
        $mDevice = (string) strip_tags(request()->post('mDevice', '%'));
        $mPlatform = (string) strip_tags(request()->post('mPlatform', '%'));
        $mBrowser = (string) strip_tags(request()->post('mBrowser', '%'));
        $mAds = (string) strip_tags(request()->post('mAds', '%'));
        $mSourceMaster = (string) strip_tags(request()->post('mSourceMaster', '%'));

        $data['totalTrafficByDate'] = $this->FntotalTrafficByDate($frmDate, $toDate, $mSourceMaster);
        $data['totalTrafficSource'] = $this->FntotalTrafficSource($frmDate, $toDate, $mSource);
        $data['totalTrafficBrowser'] = $this->FntotalTrafficBrowser($frmDate, $toDate, $mBrowser);
        $data['totalTrafficDevice'] = $this->FntotalTrafficDevice($frmDate, $toDate, $mDevice);
        $data['totalTrafficPlatform'] = $this->FntotalTrafficPlatform($frmDate, $toDate, $mPlatform);
        $data['totalTrafficAds'] = $this->FntotalTrafficAds($frmDate, $toDate, $mAds);

        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function stats()
    {
        $data['title'] = 'Client Tracking Overview';
        $data['view']  = $this->viewPath . $this->view . '.list';

        $frmDate = (string) strip_tags(request()->post('frmDate', date('Y-m-01')));
        if(empty($frmDate))
        {
            $error   = 'Vui lòng chọn điều kiện lọc thời gian';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
        else
        {
            $frmDate = DateHelper::getDate('Y-m-d', $frmDate);
        }

        $toDate = (string) strip_tags(request()->post('toDate', date('Y-m-d')));
        if(empty($toDate))
        {
            $error   = 'Vui lòng chọn điều kiện lọc thời gian';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
        else
        {
            $toDate = DateHelper::getDate('Y-m-d', $toDate);
        }

        $mSource = (string) strip_tags(request()->post('mSource', '%'));
        $mDevice = (string) strip_tags(request()->post('mDevice', '%'));
        $mPlatform = (string) strip_tags(request()->post('mPlatform', '%'));
        $mBrowser = (string) strip_tags(request()->post('mBrowser', '%'));
        $mAds = (string) strip_tags(request()->post('mAds', '%'));
        $mSourceMaster = (string) strip_tags(request()->post('mSourceMaster', '%'));

        $data['totalTrafficByDate'] = $this->FntotalTrafficByDate($frmDate, $toDate, $mSourceMaster);
        $data['totalTrafficSource'] = $this->FntotalTrafficSource($frmDate, $toDate, $mSource);
        $data['totalTrafficBrowser'] = $this->FntotalTrafficBrowser($frmDate, $toDate, $mBrowser);
        $data['totalTrafficDevice'] = $this->FntotalTrafficDevice($frmDate, $toDate, $mDevice);
        $data['totalTrafficPlatform'] = $this->FntotalTrafficPlatform($frmDate, $toDate, $mPlatform);
        $data['totalTrafficAds'] = $this->FntotalTrafficAds($frmDate, $toDate, $mAds);

        return view($data['view'] , compact('data'));
    }
}
