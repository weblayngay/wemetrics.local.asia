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
use App\Models\Websites\W0001\lt4ProductsOrdersDetail;
use App\Models\Websites\W0001\lt4Products;
use App\Models\Websites\W0001\lt4ProductsCategories;
use DB;
use App\Http\Controllers\Backend\Affiliate\Report\Children\getTotalAffiliateController;
use App\Http\Controllers\Backend\Affiliate\Report\Children\getAffiliateResellerController;
use App\Http\Controllers\Backend\Affiliate\Report\Children\getAffiliateController;

class AffiliateCommReportOverviewController extends BaseController
{
    private $view = '.affiliatecommreportoverview';
    private $model = 'affiliatecommreportoverview';
    private $adminUserModel;

    private $tsAffiliatesModel;
    private $tsAffiliateResellerModel;
    private $tsSalesModel;
    private $tsSalesDeletedModel;
    private $orderItemModel;
    private $orderProductModel;
    private $orderProductCatModel;
    private $getTotalAffiliateCtrl;
    private $getResellerCtrl;
    private $getAffiliateCtrl;

    public function __construct()
    {
        $this->adminUserModel = new AdminUser();
        $this->tsAffiliatesModel = new tsAffiliates();
        $this->tsAffiliateResellerModel = new tsAffiliateResellers();
        $this->tsSalesModel = new tsSales();
        $this->tsSalesDeletedModel = new tsSalesDeleted();
        $this->orderProductModel = new lt4Products();
        $this->orderProductCatModel = new lt4ProductsCategories();
        $this->orderItemModel = new lt4ProductsOrdersDetail();
        $this->getTotalAffiliateCtrl = new getTotalAffiliateController();
        $this->getResellerCtrl = new getAffiliateResellerController();
        $this->getAffiliateCtrl = new getAffiliateController();
    }

    /**
     * @return Application|Factory|View
     */
    public function FnTotalSales($frmDate = '', $toDate = '', $reseller = '%', $affiliate = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalAffiliateCtrl->doGetTotalSales($frmDate, $toDate, $reseller, $affiliate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }     

    /**
     * @return Application|Factory|View
     */
    public function FnTotalSalesApproved($frmDate = '', $toDate = '', $reseller = '%', $affiliate = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalAffiliateCtrl->doGetTotalSalesApproved($frmDate, $toDate, $reseller, $affiliate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FnTotalSalesApprovedPaid($frmDate = '', $toDate = '', $reseller = '%', $affiliate = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalAffiliateCtrl->doGetTotalSalesApprovedPaid($frmDate, $toDate, $reseller, $affiliate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }     

    /**
     * @return Application|Factory|View
     */
    public function FnTotalSalesApprovedNotPaid($frmDate = '', $toDate = '', $reseller = '%', $affiliate = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalAffiliateCtrl->doGetTotalSalesApprovedNotPaid($frmDate, $toDate, $reseller, $affiliate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    } 

    /**
     * @return Application|Factory|View
     */
    public function FnTotalSalesNotApproved($frmDate = '', $toDate = '', $reseller = '%', $affiliate = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalAffiliateCtrl->doGetTotalSalesNotApproved($frmDate, $toDate, $reseller, $affiliate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FnTotalSalesApprovedByDate($frmDate = '', $toDate = '', $reseller = '%', $affiliate = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalAffiliateCtrl->doGetTotalCommApprovedByDate($frmDate, $toDate, $reseller, $affiliate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FnTotalAffiliateRegByDate($frmDate = '', $toDate = '', $reseller = '%', $affiliate = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalAffiliateCtrl->doGetTotalAffiliateRegByDate($frmDate, $toDate, $reseller, $affiliate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }  

    /**
     * @return Application|Factory|View
     */
    public function FnTotalAffiliateBySalesApproved($frmDate = '', $toDate = '', $reseller = '%', $affiliate = '%', $mLimit = '15')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalAffiliateCtrl->doGetTotalAffiliateBySalesApproved($frmDate, $toDate, $reseller, $affiliate, $mLimit);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }           

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $data['title'] = AFFILIATE_COMM_REPORT_TITLE;
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
        $sales = $this->FnTotalSales($frmDate, $toDate, $reseller, $affiliate);
        $salesApproved = $this->FnTotalSalesApproved($frmDate, $toDate, $reseller, $affiliate);
        $salesNotApproved = $this->FnTotalSalesNotApproved($frmDate, $toDate, $reseller, $affiliate);
        //
        $salesApprovedPaid = $this->FnTotalSalesApprovedPaid($frmDate, $toDate, $reseller, $affiliate);
        $salesApprovedNotPaid = $this->FnTotalSalesApprovedNotPaid($frmDate, $toDate, $reseller, $affiliate);
        //
        $totalCommApproved = $salesApproved->sum('comm_amount');
        $totalCommNotApproved = $salesNotApproved->sum('comm_amount');
        $totalComm = $totalCommApproved + $totalCommNotApproved;
        //
        $totalCommApprovedPaid = $salesApprovedPaid->sum('comm_amount');
        $totalCommApprovedNotPaid = $salesApprovedNotPaid->sum('comm_amount');
        //
        $totalSalesApprovedByDate = $this->FnTotalSalesApprovedByDate($frmDate, $toDate, $reseller, $affiliate);
        $totalAffiliateRegByDate = $this->FnTotalAffiliateRegByDate($frmDate, $toDate, $reseller, $affiliate);
        $totalAffiliateBySalesApproved = $this->FnTotalAffiliateBySalesApproved($frmDate, $toDate, $reseller, $affiliate, $mLimit);
        //
        $data['reseller'] = $reseller;
        $data['resellers'] = $this->getResellerCtrl->doQuery('%');
        $data['affiliates'] = $this->getAffiliateCtrl->doQuery('%');
        //
        $data['sales'] = $sales;
        $data['salesApproved'] = $salesApproved;
        $data['salesNotApproved'] = $salesNotApproved;
        $data['salesApprovedPaid'] = $salesApprovedPaid;
        $data['salesApprovedNotPaid'] = $salesApprovedNotPaid;
        //
        $data['totalComm'] = $totalComm;
        $data['totalCommApproved'] = $totalCommApproved;
        $data['totalCommNotApproved'] = $totalCommNotApproved;
        $data['totalCommApprovedPaid'] = $totalCommApprovedPaid;
        $data['totalCommApprovedNotPaid'] = $totalCommApprovedNotPaid;
        //
        $data['totalSalesApprovedByDate'] = $totalSalesApprovedByDate;
        $data['totalAffiliateRegByDate'] = $totalAffiliateRegByDate;
        $data['totalAffiliateBySalesApproved'] = $totalAffiliateBySalesApproved;

        return view($data['view'] , compact('data'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stats()
    {
        $data['title'] = AFFILIATE_COMM_REPORT_TITLE;
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
        $sales = $this->FnTotalSales($frmDate, $toDate, $reseller, $affiliate);
        $salesApproved = $this->FnTotalSalesApproved($frmDate, $toDate, $reseller, $affiliate);
        $salesNotApproved = $this->FnTotalSalesNotApproved($frmDate, $toDate, $reseller, $affiliate);
        //
        $salesApprovedPaid = $this->FnTotalSalesApprovedPaid($frmDate, $toDate, $reseller, $affiliate);
        $salesApprovedNotPaid = $this->FnTotalSalesApprovedNotPaid($frmDate, $toDate, $reseller, $affiliate);
        //
        $totalCommApproved = $salesApproved->sum('comm_amount');
        $totalCommNotApproved = $salesNotApproved->sum('comm_amount');
        $totalComm = $totalCommApproved + $totalCommNotApproved;
        //
        $totalCommApprovedPaid = $salesApprovedPaid->sum('comm_amount');
        $totalCommApprovedNotPaid = $salesApprovedNotPaid->sum('comm_amount');
        //
        $totalSalesApprovedByDate = $this->FnTotalSalesApprovedByDate($frmDate, $toDate, $reseller, $affiliate);
        $totalAffiliateRegByDate = $this->FnTotalAffiliateRegByDate($frmDate, $toDate, $reseller, $affiliate);
        $totalAffiliateBySalesApproved = $this->FnTotalAffiliateBySalesApproved($frmDate, $toDate, $reseller, $affiliate, $mLimit);
        //
        $data['reseller'] = $reseller;
        $data['resellers'] = $this->getResellerCtrl->doQuery('%');
        $data['affiliates'] = $this->getAffiliateCtrl->doQuery('%');
        //
        $data['sales'] = $sales;
        $data['salesApproved'] = $salesApproved;
        $data['salesNotApproved'] = $salesNotApproved;
        $data['salesApprovedPaid'] = $salesApprovedPaid;
        $data['salesApprovedNotPaid'] = $salesApprovedNotPaid;
        //
        $data['totalComm'] = $totalComm;
        $data['totalCommApproved'] = $totalCommApproved;
        $data['totalCommNotApproved'] = $totalCommNotApproved;
        $data['totalCommApprovedPaid'] = $totalCommApprovedPaid;
        $data['totalCommApprovedNotPaid'] = $totalCommApprovedNotPaid;
        //
        $data['totalSalesApprovedByDate'] = $totalSalesApprovedByDate;
        $data['totalAffiliateRegByDate'] = $totalAffiliateRegByDate;
        $data['totalAffiliateBySalesApproved'] = $totalAffiliateBySalesApproved;

        return view($data['view'] , compact('data'));
    }
}
