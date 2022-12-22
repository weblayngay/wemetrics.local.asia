<?php

namespace App\Http\Controllers\Backend\Affiliate\Report;

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
use App\Models\Affiliate\tsAffiliates;
use App\Models\Affiliate\tsSales;
use App\Models\Affiliate\tsSalesDeleted;
use App\Models\Affiliate\tsAffiliateResellers;
use App\Models\Affiliate\tsPayments;
use App\Models\Websites\W0001\lt4ProductsOrdersDetail;
use App\Models\Websites\W0001\lt4Products;
use App\Models\Websites\W0001\lt4ProductsCategories;
use DB;
use App\Http\Controllers\Backend\Affiliate\Report\Children\getTotalPayCommController;
use App\Http\Controllers\Backend\Affiliate\Report\Children\getAffiliateResellerController;
use App\Http\Controllers\Backend\Affiliate\Report\Children\getAffiliateController;

class AffiliatePayCommReportOverviewController extends BaseController
{
    private $view = '.affiliatepaycommreportoverview';
    private $model = 'affiliatepaycommreportoverview';
    private $adminUserModel;

    private $tsAffiliatesModel;
    private $tsAffiliateResellerModel;
    private $tsSalesModel;
    private $tsSalesDeletedModel;
    private $tsPaymentsModel;
    private $orderItemModel;
    private $orderProductModel;
    private $orderProductCatModel;
    private $getTotalPayCommCtrl;
    private $getResellerCtrl;
    private $getAffiliateCtrl;

    public function __construct()
    {
        $this->adminUserModel = new AdminUser();
        $this->tsAffiliatesModel = new tsAffiliates();
        $this->tsAffiliateResellerModel = new tsAffiliateResellers();
        $this->tsSalesModel = new tsSales();
        $this->tsSalesDeletedModel = new tsSalesDeleted();
        $this->tsPaymentsModel = new tsPayments();
        $this->orderProductModel = new lt4Products();
        $this->orderProductCatModel = new lt4ProductsCategories();
        $this->orderItemModel = new lt4ProductsOrdersDetail();
        $this->getTotalPayCommCtrl = new getTotalPayCommController();
        $this->getResellerCtrl = new getAffiliateResellerController();
        $this->getAffiliateCtrl = new getAffiliateController();
    }

    /**
     * @return Application|Factory|View
     */
    public function FnTotalSalesApprovedByDate($frmDate = '', $toDate = '', $reseller = '%', $affiliate = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalPayCommCtrl->doGetTotalCommApprovedByDate($frmDate, $toDate, $reseller, $affiliate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FnTotalPayments($frmDate = '', $toDate = '', $affiliate = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalPayCommCtrl->doGetTotalPayments($frmDate, $toDate, $affiliate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FnTotalPaidPayments($frmDate = '', $toDate = '', $affiliate = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalPayCommCtrl->doGetTotalPaidPayments($frmDate, $toDate, $affiliate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }    

    /**
     * @return Application|Factory|View
     */
    public function FnTotalNotPaidPayments($frmDate = '', $toDate = '', $affiliate = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalPayCommCtrl->doGetTotalNotPaidPayments($frmDate, $toDate, $affiliate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    } 

    /**
     * @return Application|Factory|View
     */
    public function FnTotalCommByDate($frmDate = '', $toDate = '', $affiliate = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalPayCommCtrl->doGetTotalCommByDate($frmDate, $toDate, $affiliate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FnTotalAffiliateByPayComm($frmDate = '', $toDate = '', $affiliate = '%', $mLimit = '15')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalPayCommCtrl->doGetTotalAffiliateByPayComm($frmDate, $toDate, $affiliate, $mLimit);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }      

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $data['title'] = AFFILIATE_PAYMENTS_REPORT_TITLE;
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

        $reseller = (string) strip_tags(request()->post('reseller', '%'));
        $affiliate = (string) strip_tags(request()->post('affiliate', '%'));
        $mLimit = (string) strip_tags(request()->post('mLimit', '15'));
        //
        $payments = $this->FnTotalPayments($frmDate, $toDate, $affiliate);
        $paidPayments = $this->FnTotalPaidPayments($frmDate, $toDate, $affiliate);
        $notPaidPayments = $this->FnTotalNotPaidPayments($frmDate, $toDate, $affiliate);
        //
        $totalPayAmount = $payments->sum('amount');
        $totalPaidAmount = $paidPayments->sum('amount');
        $totalNotPaidAmount = $notPaidPayments->sum('amount');
        //
        $totalSalesApprovedByDate = $this->FnTotalSalesApprovedByDate($frmDate, $toDate, $reseller, $affiliate);
        $totalCommByDate = $this->FnTotalCommByDate($frmDate, $toDate, $affiliate);
        $totalAffiliateByPayComm = $this->FnTotalAffiliateByPayComm($frmDate, $toDate, $affiliate, $mLimit);
        //
        $data['reseller'] = $reseller;
        $data['resellers'] = $this->getResellerCtrl->doQuery('%');
        $data['affiliates'] = $this->getAffiliateCtrl->doQuery('%');
        //
        $data['payments'] = $payments;
        $data['paidPayments'] = $paidPayments;
        $data['notPaidPayments'] = $notPaidPayments;
        //
        $data['totalPayAmount'] = $totalPayAmount;
        $data['totalPaidAmount'] = $totalPaidAmount;
        $data['totalNotPaidAmount'] = $totalNotPaidAmount;
        //
        $data['totalSalesApprovedByDate'] = $totalSalesApprovedByDate;
        $data['totalCommByDate'] = $totalCommByDate;
        $data['totalAffiliateByPayComm'] = $totalAffiliateByPayComm;

        return view($data['view'] , compact('data'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stats()
    {
        $data['title'] = AFFILIATE_PAYMENTS_REPORT_TITLE;
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

        $reseller = (string) strip_tags(request()->post('reseller', '%'));
        $affiliate = (string) strip_tags(request()->post('affiliate', '%'));
        $mLimit = (string) strip_tags(request()->post('mLimit', '15'));
        //
        $payments = $this->FnTotalPayments($frmDate, $toDate, $affiliate);
        $paidPayments = $this->FnTotalPaidPayments($frmDate, $toDate, $affiliate);
        $notPaidPayments = $this->FnTotalNotPaidPayments($frmDate, $toDate, $affiliate);
        //
        $totalPayAmount = $payments->sum('amount');
        $totalPaidAmount = $paidPayments->sum('amount');
        $totalNotPaidAmount = $notPaidPayments->sum('amount');
        //
        $totalSalesApprovedByDate = $this->FnTotalSalesApprovedByDate($frmDate, $toDate, $reseller, $affiliate);
        $totalCommByDate = $this->FnTotalCommByDate($frmDate, $toDate, $affiliate);
        $totalAffiliateByPayComm = $this->FnTotalAffiliateByPayComm($frmDate, $toDate, $affiliate, $mLimit);
        //
        $data['reseller'] = $reseller;
        $data['resellers'] = $this->getResellerCtrl->doQuery('%');
        $data['affiliates'] = $this->getAffiliateCtrl->doQuery('%');
        //
        $data['payments'] = $payments;
        $data['paidPayments'] = $paidPayments;
        $data['notPaidPayments'] = $notPaidPayments;
        //
        $data['totalPayAmount'] = $totalPayAmount;
        $data['totalPaidAmount'] = $totalPaidAmount;
        $data['totalNotPaidAmount'] = $totalNotPaidAmount;
        //
        $data['totalSalesApprovedByDate'] = $totalSalesApprovedByDate;
        $data['totalCommByDate'] = $totalCommByDate;
        $data['totalAffiliateByPayComm'] = $totalAffiliateByPayComm;

        return view($data['view'] , compact('data'));
    }
}
