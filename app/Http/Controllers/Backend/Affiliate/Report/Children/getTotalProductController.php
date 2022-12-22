<?php

namespace App\Http\Controllers\Backend\Affiliate\Report\Children;

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
use App\Helpers\StringHelper;
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
use App\Http\Controllers\Backend\Order\Report\Children\getRangeDateController;
use App\Http\Controllers\Backend\Affiliate\Report\Children\getAffiliateResellerController;
use App\Http\Controllers\Backend\Affiliate\Report\Children\getAffiliateController;

class getTotalProductController extends BaseController
{
    private $adminUserModel;
    private $affiliateModel;
    private $affiliateResellerModel;
    private $salesModel;
    private $salesDeletedModel;
    private $orderItemModel;
    private $orderProductModel;
    private $orderProductCatModel;

	private $getRangeDateCtrl;
    private $getResellerCtrl;

    public function __construct()
    {
        $this->adminUserModel = new AdminUser();
        $this->affiliateModel = new tsAffiliates();
        $this->affiliateResellerModel = new tsAffiliateResellers();
        $this->salesModel = new tsSales();
        $this->salesDeletedModel = new tsSalesDeleted();
        $this->orderProductModel = new lt4Products();
        $this->orderProductCatModel = new lt4ProductsCategories();
        $this->orderItemModel = new lt4ProductsOrdersDetail();
        $this->getRangeDateCtrl = new getRangeDateController();
        $this->getResellerCtrl = new getAffiliateResellerController();
        $this->getAffiliateCtrl = new getAffiliateController();
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalSales($frmDate = '', $toDate = '', $reseller = '%', $affiliate = '%')
    {
        $result = $this->salesModel::from(TS_SALES. " AS t1")
                ->selectRaw("t1.id, t1.afid, t1.ordernum, t1.amount, t1.comm_amount, t1.approved, t1.paid, t1.created, t1.bonus, FROM_UNIXTIME(t1.created,'%Y-%m-%d') AS created_at")
                ->whereRaw("FROM_UNIXTIME(t1.created,'%Y-%m-%d') BETWEEN '".$frmDate."' AND '".$toDate."'")
                ->whereRaw("t1.afid LIKE CASE WHEN '".$affiliate."' = '%' THEN '%' ELSE '".$affiliate."' END")
                ->whereRaw("t1.adid LIKE CASE WHEN '".$reseller."' = '%' THEN '%' ELSE '".$reseller."' END")
                ->get();

        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalSalesApproved($frmDate = '', $toDate = '', $reseller = '%', $affiliate = '%')
    {
        $result = $this->salesModel::from(TS_SALES. " AS t1")
                ->selectRaw("t1.id, t1.afid, t1.ordernum, t1.amount, t1.comm_amount, t1.approved, t1.paid, t1.created, t1.bonus, FROM_UNIXTIME(t1.created,'%Y-%m-%d') AS created_at")
                ->whereRaw("FROM_UNIXTIME(t1.created,'%Y-%m-%d') BETWEEN '".$frmDate."' AND '".$toDate."'")
                ->whereRaw("t1.afid LIKE CASE WHEN '".$affiliate."' = '%' THEN '%' ELSE '".$affiliate."' END")
                ->whereRaw("t1.adid LIKE CASE WHEN '".$reseller."' = '%' THEN '%' ELSE '".$reseller."' END")
                ->IsApproved()
                ->get();

        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalSalesApprovedPaid($frmDate = '', $toDate = '', $reseller = '%', $affiliate = '%')
    {
        $result = $this->salesModel::from(TS_SALES. " AS t1")
                ->selectRaw("t1.id, t1.afid, t1.ordernum, t1.amount, t1.comm_amount, t1.approved, t1.paid, t1.created, t1.bonus, FROM_UNIXTIME(t1.created,'%Y-%m-%d') AS created_at")
                ->whereRaw("FROM_UNIXTIME(t1.created,'%Y-%m-%d') BETWEEN '".$frmDate."' AND '".$toDate."'")
                ->whereRaw("t1.afid LIKE CASE WHEN '".$affiliate."' = '%' THEN '%' ELSE '".$affiliate."' END")
                ->whereRaw("t1.adid LIKE CASE WHEN '".$reseller."' = '%' THEN '%' ELSE '".$reseller."' END")
                ->IsApproved()
                ->IsPaid()
                ->get();

        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalSalesApprovedNotPaid($frmDate = '', $toDate = '', $reseller = '%', $affiliate = '%')
    {
        $result = $this->salesModel::from(TS_SALES. " AS t1")
                ->selectRaw("t1.id, t1.afid, t1.ordernum, t1.amount, t1.comm_amount, t1.approved, t1.paid, t1.created, t1.bonus, FROM_UNIXTIME(t1.created,'%Y-%m-%d') AS created_at")
                ->whereRaw("FROM_UNIXTIME(t1.created,'%Y-%m-%d') BETWEEN '".$frmDate."' AND '".$toDate."'")
                ->whereRaw("t1.afid LIKE CASE WHEN '".$affiliate."' = '%' THEN '%' ELSE '".$affiliate."' END")
                ->whereRaw("t1.adid LIKE CASE WHEN '".$reseller."' = '%' THEN '%' ELSE '".$reseller."' END")
                ->IsApproved()
                ->IsNotPaid()
                ->get();

        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalSalesNotApproved($frmDate = '', $toDate = '', $reseller = '%', $affiliate = '%')
    {
        $result = $this->salesModel::from(TS_SALES_DELETED. " AS t1")
                ->selectRaw("t1.id, t1.created, t1.ordernum, t1.afid, t1.amount, t1.comm_amount, FROM_UNIXTIME(t1.created,'%Y-%m-%d') AS created_at")
                ->whereRaw("FROM_UNIXTIME(t1.created,'%Y-%m-%d') BETWEEN '".$frmDate."' AND '".$toDate."'")
                ->whereRaw("t1.afid LIKE CASE WHEN '".$affiliate."' = '%' THEN '%' ELSE '".$affiliate."' END")
                ->whereRaw("t1.adid LIKE CASE WHEN '".$reseller."' = '%' THEN '%' ELSE '".$reseller."' END")
                ->get();

        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalCommApprovedByDate($frmDate = '', $toDate = '', $reseller = '%', $affiliate = '%')
    {
        $mTmpResult = $this->getRangeDateCtrl->doQuery($frmDate, $toDate);

        $mTmpTotalOrder = $this->salesModel::from(TS_SALES. " AS t1")
                ->selectRaw("COUNT(IFNULL(t1.id, '')) AS totalOrder, SUM(t1.amount) AS totalAmount, SUM(t1.comm_amount) AS totalCommAmount, FROM_UNIXTIME(t1.created,'%Y-%m-%d') AS created_at")
                ->whereRaw("FROM_UNIXTIME(t1.created,'%Y-%m-%d') BETWEEN '".$frmDate."' AND '".$toDate."'")
                ->whereRaw("t1.afid LIKE CASE WHEN '".$affiliate."' = '%' THEN '%' ELSE '".$affiliate."' END")
                ->whereRaw("t1.adid LIKE CASE WHEN '".$reseller."' = '%' THEN '%' ELSE '".$reseller."' END")
                ->IsApproved()
                ->groupByRaw("created_at")
                ->get();

        foreach($mTmpResult as $key => $item)
        {
            $item->totalOrder = 0;
            $item->totalAmount = 0;
            $item->totalCommAmount = 0;

            foreach($mTmpTotalOrder AS $key2 => $item2)
            {
                if($item->created_at == $item2->created_at)
                {
                    $item->totalOrder += ($item2->totalOrder) ?? $item2->totalOrder;
                    $item->totalAmount += ($item2->totalAmount) ?? $item2->totalAmount;
                    $item->totalCommAmount += ($item2->totalCommAmount) ?? $item2->totalCommAmount;
                    break;    
                }
            }
        }
        return $mTmpResult;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetCatProductByDate($frmDate = '', $toDate = '', $reseller = '%', $affiliate = '%')
    {
        $mTmpResult = $this->getRangeDateCtrl->doQuery($frmDate, $toDate);
        $salesApproved = $this->doGetTotalSalesApproved($frmDate, $toDate, $reseller, $affiliate);
        $salesApprovedItemIds = array_column($salesApproved->toArray(), 'ordernum');
        $TmpsalesCatItems = $this->orderItemModel::query()
            ->whereIn("order_id", $salesApprovedItemIds)
            ->selectRaw("order_id, pid, SUM(quantity) as quantity, SUM(total_price) as total_price, '' as created_at")
            ->groupBy("order_id", "pid")
            ->orderBy("created_at", "desc")
            ->get();

        foreach($TmpsalesCatItems as $key => $item)
        {
            foreach($salesApproved as $key1 => $item1)
            {
                if($item->order_id == $item1->ordernum)
                {
                    $item->created_at = $item1->created_at;
                }
            }
        }

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

        $catArr = $this->orderProductModel::CATEGORIES;
        foreach ($catArr as $k => $v) {
            $groupsSalesCatItems = $TmpsalesCatItems->groupBy("created_at");
            $salesCatItems = $groupsSalesCatItems->map(function ($group) use ($k) {
                return (object) [
                    'created_at' => $group->first()['created_at'],
                    'totalQuantity' => $group->where('catid', $k)->sum('quantity'),
                    'totalPrice' => $group->where('catid', $k)->sum('total_price'),
                ];
            });

            foreach($mTmpResult as $key => $item)
            {
                $item->{'totalQuantity'.$k} = 0;
                $item->{'totalPrice'.$k} = 0;
                foreach($salesCatItems as $key1 => $item1)
                {
                    if($item->created_at == $item1->created_at)
                    {
                        $item->{'totalQuantity'.$k} = $item1->totalQuantity;
                        $item->{'totalPrice'.$k} = $item1->totalPrice;
                    }
                }
            }
        }

        return $mTmpResult;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetCatProduct($frmDate = '', $toDate = '', $reseller = '%', $affiliate = '%')
    {
        $salesApproved = $this->doGetTotalSalesApproved($frmDate, $toDate, $reseller, $affiliate);
        $salesApprovedItemIds = array_column($salesApproved->toArray(), 'ordernum');
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
        $mTmpResult = $groupsSalesCatItems->map(function ($group) {
            return (object) [
                'catid' => $group->first()['catid'],
                'catname' => $group->first()['catname'],
                'quantity' => $group->sum('quantity'),
                'total_price' => $group->sum('total_price'),
            ];
        });

        $mTmpResult = ArrayHelper::arraySort($mTmpResult, 'total_price', SORT_DESC);

        return $mTmpResult;
    }
}