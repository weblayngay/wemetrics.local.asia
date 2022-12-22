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
use App\Models\ClientTracking\ClientTrackingPlatform;
use DB;
use App\Http\Controllers\Backend\ClientTracking\Report\Children\getTrafficByDateController;
use App\Http\Controllers\Backend\ClientTracking\Report\Children\getTrafficPlatformController;

class ClienttrackingreportplatformController extends BaseController
{
    private $view = '.clienttrackingreportplatform';
    private $model = 'clienttrackingreportplatform';
    private $adminUserModel;
    private $clienttrackingplatformModel;

    private $getTrafficByDateCtrl;
    private $getTrafficPlatformCtrl;

    public function __construct()
    {
        $this->adminUserModel = new AdminUser();
        $this->clienttrackingplatformModel = new ClientTrackingPlatform();
        $this->getTrafficByDateCtrl = new getTrafficByDateController();
        $this->getTrafficPlatformCtrl = new getTrafficPlatformController();
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
    public function FntotalTrafficPlatformByDate($frmDate = '', $toDate = '', $mPlatform = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTrafficPlatformCtrl->doGetTrafficPlatformByDate($frmDate, $toDate, $mPlatform);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = 'Client Tracking Platform';
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
        $mRegion = (string) strip_tags(request()->post('mRegion', '%'));
        $mCountry = (string) strip_tags(request()->post('mCountry', '%'));
        $mAds = (string) strip_tags(request()->post('mAds', '%'));
        $mSourceMaster = (string) strip_tags(request()->post('mSourceMaster', '%'));

        $data['platforms'] = $this->clienttrackingplatformModel::query()->select('name')->IsActivated()->get();
        $data['mPlatform'] = $mPlatform;
        $data['totalTrafficByDate'] = $this->FntotalTrafficByDate($frmDate, $toDate, $mSourceMaster);
        $data['totalTrafficPlatform'] = $this->FntotalTrafficPlatform($frmDate, $toDate, $mPlatform);
        $data['totalTrafficPlatformByDate'] = $this->FntotalTrafficPlatformByDate($frmDate, $toDate, $mPlatform);

        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function stats()
    {
        $data['title'] = 'Client Tracking Platform';
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
        $mRegion = (string) strip_tags(request()->post('mRegion', '%'));
        $mCountry = (string) strip_tags(request()->post('mCountry', '%'));
        $mAds = (string) strip_tags(request()->post('mAds', '%'));
        $mSourceMaster = (string) strip_tags(request()->post('mSourceMaster', '%'));

        $data['platforms'] = $this->clienttrackingplatformModel::query()->select('name')->IsActivated()->get();
        $data['mPlatform'] = $mPlatform;
        $data['totalTrafficByDate'] = $this->FntotalTrafficByDate($frmDate, $toDate, $mSourceMaster);
        $data['totalTrafficPlatform'] = $this->FntotalTrafficPlatform($frmDate, $toDate, $mPlatform);
        $data['totalTrafficPlatformByDate'] = $this->FntotalTrafficPlatformByDate($frmDate, $toDate, $mPlatform);

        return view($data['view'] , compact('data'));
    }
}
