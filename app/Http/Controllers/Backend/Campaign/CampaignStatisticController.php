<?php

namespace App\Http\Controllers\Backend\Campaign;

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
use App\Models\Campaign;
use App\Models\CampaignResult;
use App\Models\Voucher;
use DB;

use App\Http\Controllers\Backend\Campaign\Report\Children\getTotalVoucherController;
use App\Http\Controllers\Backend\Campaign\Report\Children\getTotalAssignedVoucherController;
use App\Http\Controllers\Backend\Campaign\Report\Children\getTotalUsedVoucherController;
use App\Http\Controllers\Backend\Campaign\Report\Children\getTotalOrderController;

class CampaignStatisticController extends BaseController
{
    private $view = '.campaignstatistic';
    private $model = 'campaignstatistic';
    private $campaignModel;
    private $campaignResultModel;
    private $voucherModel;
    private $imageModel;
    private $adminUserModel;

    private $getTotalVoucherCtrl;
    private $getTotalAssignedVoucherCtrl;
    private $getTotalUsedVoucherCtrl;
    private $getTotalOrderCtrl;

    public function __construct()
    {
        $this->campaignModel = new Campaign();
        $this->campaignResultModel = new CampaignResult();
        $this->voucherModel = new Voucher();
        $this->adminUserModel = new AdminUser();
        $this->getTotalVoucherCtrl = new getTotalVoucherController();
        $this->getTotalAssignedVoucherCtrl = new getTotalAssignedVoucherController();
        $this->getTotalUsedVoucherCtrl = new getTotalUsedVoucherController();
        $this->getTotalOrderController = new getTotalOrderController();
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalVoucher($voucherGroup = '0')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalVoucherCtrl->doGetTotalVoucher($voucherGroup);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalAssignedVoucher($campaign = '0', $voucherGroup = '0', $frmDate = '', $toDate = '')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalAssignedVoucherCtrl->doGetTotalAssignedVoucher($campaign, $voucherGroup, $frmDate, $toDate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalAssignedVoucherGroupByDevice($campaign = '0', $voucherGroup = '0', $frmDate = '', $toDate = '')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalAssignedVoucherCtrl->doGetTotalAssignedVoucherGroupByDevice($campaign, $voucherGroup, $frmDate, $toDate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalUsedVoucher($campaign = '0', $voucherGroup = '0', $frmDate = '', $toDate = '')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalUsedVoucherCtrl->doGetTotalUsedVoucher($campaign, $voucherGroup, $frmDate, $toDate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalUsedVoucherGroupByDevice($campaign = '0', $voucherGroup = '0', $frmDate = '', $toDate = '')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalUsedVoucherCtrl->doGetTotalUsedVoucherGroupByDevice($campaign, $voucherGroup, $frmDate, $toDate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrderAndVoucherByDate($campaign = '0', $voucherGroup = '0', $frmDate = '', $toDate = '')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderController->doGetTotalOrderAndVoucherByDate($campaign, $voucherGroup, $frmDate, $toDate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrderUsedVoucherByReseller($campaign = '0', $voucherGroup = '0', $frmDate = '', $toDate = '', $mLimit = 10)
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderController->doGetTotalOrderByReseller($campaign, $voucherGroup, $frmDate, $toDate, $mLimit);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrderUsedVoucherByCity($campaign = '0', $voucherGroup = '0', $frmDate = '', $toDate = '', $mLimit = 10)
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderController->doGetTotalOrderByCity($campaign, $voucherGroup, $frmDate, $toDate, $mLimit);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = CAMPAIGN_STATISTIC_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';
        $data['campaigns'] = $this->campaignModel::query()->IsActivated()->get();

        $campaign = (string) strip_tags(request()->post('campaign', ''));
        $campaign = !empty($campaign) ? $campaign : 0;
        $campaigns = $this->campaignModel::query()->find($campaign);
        $voucherGroup = !empty($campaigns->voucher_group) ? $campaigns->voucher_group : 0;

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

        $mLimit = (int) strip_tags(request()->post('mLimit', 10));

        $data['totalVoucher'] = $this->FntotalVoucher($voucherGroup);
        $data['totalAssignedVoucher'] = $this->FntotalAssignedVoucher($campaign, $voucherGroup, $frmDate, $toDate);
        $data['totalUsedVoucher'] = $this->FntotalUsedVoucher($campaign, $voucherGroup, $frmDate, $toDate);
        $data['totalUsedVoucherGroupByDevice'] = $this->FntotalUsedVoucherGroupByDevice($campaign, $voucherGroup, $frmDate, $toDate);
        $data['totalOrderAndVoucherByDate'] = $this->FntotalOrderAndVoucherByDate($campaign, $voucherGroup, $frmDate, $toDate);
        $data['totalorderUsedVoucherByReseller'] = $this->FntotalOrderUsedVoucherByReseller($campaign, $voucherGroup, $frmDate, $toDate, $mLimit);
        $data['totalAssignedVoucherGroupByDevice'] = $this->FntotalAssignedVoucherGroupByDevice($campaign, $frmDate, $toDate);
        $data['totalorderUsedVoucherByCity'] = $this->FntotalOrderUsedVoucherByCity($campaign, $voucherGroup, $frmDate, $toDate, $mLimit);

        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function stats()
    {
        $data['title'] = CAMPAIGN_STATISTIC_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';
        $data['campaigns'] = $this->campaignModel::query()->IsActivated()->get();

        $campaign = (string) strip_tags(request()->post('campaign', ''));
        if(empty($campaign))
        {
            $error   = 'Vui lòng chọn điều kiện lọc chiến dịch';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
        $campaigns = $this->campaignModel::query()->find($campaign);
        $voucherGroup = ($campaigns->voucher_group) ? $campaigns->voucher_group : 0;

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

        $mLimit = (int) strip_tags(request()->post('mLimit', 10));

        $data['totalVoucher'] = $this->FntotalVoucher($voucherGroup);
        $data['totalAssignedVoucher'] = $this->FntotalAssignedVoucher($campaign, $voucherGroup, $frmDate, $toDate);
        $data['totalUsedVoucher'] = $this->FntotalUsedVoucher($campaign, $voucherGroup, $frmDate, $toDate);
        $data['totalUsedVoucherGroupByDevice'] = $this->FntotalUsedVoucherGroupByDevice($campaign, $voucherGroup, $frmDate, $toDate);
        $data['totalOrderAndVoucherByDate'] = $this->FntotalOrderAndVoucherByDate($campaign, $voucherGroup, $frmDate, $toDate);
        $data['totalorderUsedVoucherByReseller'] = $this->FntotalOrderUsedVoucherByReseller($campaign, $voucherGroup, $frmDate, $toDate, $mLimit);
        $data['totalAssignedVoucherGroupByDevice'] = $this->FntotalAssignedVoucherGroupByDevice($campaign, $voucherGroup, $frmDate, $toDate);
        $data['totalorderUsedVoucherByCity'] = $this->FntotalOrderUsedVoucherByCity($campaign, $voucherGroup, $frmDate, $toDate, $mLimit);

        return view($data['view'] , compact('data'));
    }
}
