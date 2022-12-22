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
use App\Http\Controllers\Backend\Affiliate\Report\Children\getTotalCommisionController;
use App\Http\Controllers\Backend\Affiliate\Report\Children\getAffiliateResellerController;
use App\Http\Controllers\Backend\Affiliate\Report\Children\getAffiliateController;

class AffiliateSalesReportOverviewController extends BaseController
{
    private $view = '.affiliatesalesreportoverview';
    private $model = 'affiliatesalesreportoverview';
    private $adminUserModel;

    private $tsAffiliatesModel;
    private $tsAffiliateResellerModel;
    private $tsSalesModel;
    private $tsSalesDeletedModel;
    private $orderItemModel;
    private $orderProductModel;
    private $orderProductCatModel;
    private $getTotalCommCtrl;
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
        $this->getTotalCommCtrl = new getTotalCommisionController();
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
        $result = $this->getTotalCommCtrl->doGetTotalSales($frmDate, $toDate, $reseller, $affiliate);
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
        $result = $this->getTotalCommCtrl->doGetTotalSalesApproved($frmDate, $toDate, $reseller, $affiliate);
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
        $result = $this->getTotalCommCtrl->doGetTotalSalesApprovedPaid($frmDate, $toDate, $reseller, $affiliate);
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
        $result = $this->getTotalCommCtrl->doGetTotalSalesApprovedNotPaid($frmDate, $toDate, $reseller, $affiliate);
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
        $result = $this->getTotalCommCtrl->doGetTotalSalesNotApproved($frmDate, $toDate, $reseller, $affiliate);
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
        $result = $this->getTotalCommCtrl->doGetTotalCommApprovedByDate($frmDate, $toDate, $reseller, $affiliate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }        

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $data['title'] = AFFILIATE_SALES_REPORT_TITLE;
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
        $mLimit = (string) strip_tags(request()->post('mLimit', '10'));
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
        $salesApprovedItemIds = array_column($salesApproved->toArray(), 'ordernum');

        $salesItems = $this->orderItemModel::query()
            ->whereIn('order_id', $salesApprovedItemIds)
            ->selectRaw('pid, name, MAX(price) AS price, SUM(quantity) as quantity, SUM(total_price) as total_price')
            ->orderBy('quantity', 'desc')
            ->groupBy('pid', 'name')
            ->limit(5)
            ->get();

        $TmpsalesCatItems = $this->orderItemModel::query()
            ->whereIn("order_id", $salesApprovedItemIds)
            ->selectRaw("pid, SUM(quantity) as quantity, SUM(total_price) as total_price")
            ->orderBy("quantity", "desc")
            ->groupBy("pid")
            ->get();

        $productIds = array_column($TmpsalesCatItems->toArray(), 'pid');

        $products = $this->orderProductModel::from(LT4_PRODUCTS. " AS t1")
                        ->selectRaw("t1.id, t1.catid")
                        ->whereIn("t1.id", $productIds)
                        ->orderByRaw("t1. id DESC")
                        ->get();

        $productCats = $this->orderProductCatModel::from(LT4_PRODUCTS_CATEGORIES. " AS t1")
                        ->selectRaw("t1.id, t1.name")
                        ->orderByRaw("t1. id DESC")
                        ->get();

        foreach ($TmpsalesCatItems as $key => $item) 
        {
            foreach ($products as $key1 => $item1) 
            {
                if($item->pid == $item1->id )
                {
                    $item->catid = $item1->catid;
                }
            }
        }

        foreach ($TmpsalesCatItems as $key => $item) 
        {
            foreach ($productCats as $key1 => $item1) 
            {
                if($item->catid == $item1->id )
                {
                    $item->catname = $item1->name;
                }
            }
        }
        // this only splits the rows into groups without any thing else.
        // $groups will be a collection, it's keys are 'catid' and it's values collections of rows with the same opposition_id.
        $groupsSalesCatItems = $TmpsalesCatItems->groupBy('catid'); 

        // we will use map to cumulate each group of rows into single row.
        // $group is a collection of rows that has the same catid.
        $salesCatItems = $groupsSalesCatItems->map(function ($group) {
            return (object) [
                'catid' => $group->first()['catid'],
                'catname' => $group->first()['catname'],
                'quantity' => $group->sum('quantity'),
                'total_price' => $group->sum('total_price'),
            ];
        });
        //
        $totalSalesApprovedByDate = $this->FnTotalSalesApprovedByDate($frmDate, $toDate, $reseller, $affiliate);
        //
        $data['reseller'] = $reseller;
        $data['resellers'] = $this->getResellerCtrl->doQuery('%');
        $data['affiliates'] = $this->getAffiliateCtrl->doQuery('%');

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
        $data['salesItems'] = $salesItems;
        $data['salesCatItems'] = $salesCatItems;
        //
        $data['totalSalesApprovedByDate'] = $totalSalesApprovedByDate;

        return view($data['view'] , compact('data'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stats()
    {
        $data['title'] = AFFILIATE_SALES_REPORT_TITLE;
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
        $mLimit = (string) strip_tags(request()->post('mLimit', '10'));
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
        $salesApprovedItemIds = array_column($salesApproved->toArray(), 'ordernum');

        $salesItems = $this->orderItemModel::query()
            ->whereIn('order_id', $salesApprovedItemIds)
            ->selectRaw('pid, name, MAX(price) AS price, SUM(quantity) as quantity, SUM(total_price) as total_price')
            ->orderBy('quantity', 'desc')
            ->groupBy('pid', 'name')
            ->limit(5)
            ->get();

        $TmpsalesCatItems = $this->orderItemModel::query()
            ->whereIn("order_id", $salesApprovedItemIds)
            ->selectRaw("pid, SUM(quantity) as quantity, SUM(total_price) as total_price")
            ->orderBy("quantity", "desc")
            ->groupBy("pid")
            ->get();

        $productIds = array_column($TmpsalesCatItems->toArray(), 'pid');

        $products = $this->orderProductModel::from(LT4_PRODUCTS. " AS t1")
                        ->selectRaw("t1.id, t1.catid")
                        ->whereIn("t1.id", $productIds)
                        ->orderByRaw("t1. id DESC")
                        ->get();

        $productCats = $this->orderProductCatModel::from(LT4_PRODUCTS_CATEGORIES. " AS t1")
                        ->selectRaw("t1.id, t1.name")
                        ->orderByRaw("t1. id DESC")
                        ->get();

        foreach ($TmpsalesCatItems as $key => $item) 
        {
            foreach ($products as $key1 => $item1) 
            {
                if($item->pid == $item1->id )
                {
                    $item->catid = $item1->catid;
                }
            }
        }

        foreach ($TmpsalesCatItems as $key => $item) 
        {
            foreach ($productCats as $key1 => $item1) 
            {
                if($item->catid == $item1->id )
                {
                    $item->catname = $item1->name;
                }
            }
        }
        // this only splits the rows into groups without any thing else.
        // $groups will be a collection, it's keys are 'catid' and it's values collections of rows with the same opposition_id.
        $groupsSalesCatItems = $TmpsalesCatItems->groupBy('catid'); 

        // we will use map to cumulate each group of rows into single row.
        // $group is a collection of rows that has the same catid.
        $salesCatItems = $groupsSalesCatItems->map(function ($group) {
            return (object) [
                'catid' => $group->first()['catid'],
                'catname' => $group->first()['catname'],
                'quantity' => $group->sum('quantity'),
                'total_price' => $group->sum('total_price'),
            ];
        });
        //
        $totalSalesApprovedByDate = $this->FnTotalSalesApprovedByDate($frmDate, $toDate, $reseller, $affiliate);
        //
        $data['reseller'] = $reseller;
        $data['resellers'] = $this->getResellerCtrl->doQuery('%');
        $data['affiliates'] = $this->getAffiliateCtrl->doQuery('%');

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
        $data['salesItems'] = $salesItems;
        $data['salesCatItems'] = $salesCatItems;
        //
        $data['totalSalesApprovedByDate'] = $totalSalesApprovedByDate;

        return view($data['view'] , compact('data'));
    }
}
