<?php

namespace App\Http\Controllers\Backend\Order\Report\Children;

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
use App\Models\Websites\W0001\lt4ProductsOrders;
use App\Models\Websites\W0001\lt4ProductsOrdersDetail;
use App\Models\Websites\W0001\lt4ProductsOrdersUserInfo;
use App\Models\Websites\W0001\lt4Products;
use App\Models\Websites\W0001\lt4ProductsCategories;
use DB;
use App\Http\Controllers\Backend\Order\Report\Children\getRangeDateController;
use App\Http\Controllers\Backend\Order\Report\Children\getResellerController;

class getTotalOrderByPayOnlineController extends BaseController
{
    private $adminUserModel;
    private $orderModel;
    private $orderItemModel;
    private $orderUserInfoModel;
    private $orderProductModel;
    private $orderProductCatModel;
    //
	private $getRangeDateCtrl;
    private $getResellerCtrl;
    public function __construct()
    {
        $this->adminUserModel = new AdminUser();
        $this->orderModel = new lt4ProductsOrders();
        $this->orderItemModel = new lt4ProductsOrdersDetail();
        $this->orderUserInfoModel = new lt4ProductsOrdersUserInfo();
        $this->orderProductModel = new lt4Products();
        $this->orderProductCatModel = new lt4ProductsCategories();
        $this->getRangeDateCtrl = new getRangeDateController();
        $this->getResellerCtrl = new getResellerController();
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalOrder($frmDate = '', $toDate = '', $reseller = '%')
    {
        $result = $this->orderModel::from(LT4_PRODUCTS_ORDERS. " AS t1")
                ->selectRaw('t1.id, t1.rid, t1.order_total, t1.vdiscount, t1.engrave_fee, t1.amount, t1.status_id, t1.paid, t1.payonline')
                ->whereRaw("DATE_FORMAT(DATE(t1.created), '%Y-%m-%d') BETWEEN '".$frmDate."' AND '".$toDate."'")
                ->whereRaw("t1.rid LIKE CASE WHEN '".$reseller."' = '%' THEN '%' ELSE '".$reseller."' END")
                ->IsPayOnline()
                ->get();

        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalOrderLatest($frmDate = '', $toDate = '', $mLimit = 10, $reseller = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $orderLatest = $this->orderModel::from(LT4_PRODUCTS_ORDERS. " AS t1")
                ->selectRaw('t1.id, t1.user_info_id, t1.rid, t1.order_total, t1.vdiscount, t1.engrave_fee, t1.amount, t1.status_id, t1.paid, t1.payonline')
                ->whereRaw("DATE_FORMAT(DATE(t1.created), '%Y-%m-%d') BETWEEN '".$frmDate."' AND '".$toDate."'")
                ->IsPayOnline()
                ->isPaid()
                ->whereRaw("t1.rid LIKE CASE WHEN '".$reseller."' = '%' THEN '%' ELSE '".$reseller."' END")
                ->orderBy('id', 'DESC')
                ->limit($mLimit)
                ->get();
        // dd(\DB::getQueryLog()); // Show results of log

        $orderLatestUserInfoIds = array_column($orderLatest->toArray(), 'user_info_id');

        $userInfo = $this->orderUserInfoModel::query()
                    ->whereIn('id', $orderLatestUserInfoIds)
                    ->get();

        foreach($orderLatest as $key => $item)
        {
            $item->name = '';
            $item->address = '';
            $item->province = '';
            $item->district = '';
            $item->email = '';
            $item->phone = '';

            $item->gfname = '';
            $item->gfaddress = '';
            $item->gfprovince = '';
            $item->gfdistrict = '';
            $item->gfemail = '';
            $item->gfphone = '';

            foreach ($userInfo as $key1 => $item1) {
                if($item->user_info_id == $item1->id)
                {
                    $item->name = $item1->name;
                    $item->address = $item1->address;
                    $item->province = $item1->city_name;
                    $item->district = $item1->dist_name;
                    $item->email = $item1->email;
                    $item->phone = $item1->phone;
                    //
                    $item->gfname = $item1->gf_name;
                    $item->gfaddress = $item1->gf_address;
                    $item->gfprovince = $item1->gf_city_name;
                    $item->gfdistrict = $item1->gf_dist_name;
                    $item->gfemail = $item1->gf_email;
                    $item->gfphone = $item1->gf_phone;
                    break;
                }
            }
        }

        $result = $orderLatest;

        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetOrderProcessing($frmDate = '', $toDate = '', $reseller = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->orderModel::from(LT4_PRODUCTS_ORDERS. " AS t1")
                ->selectRaw('t1.id, t1.rid, t1.order_total, t1.vdiscount, t1.engrave_fee, t1.amount, t1.status_id')
                ->whereRaw("DATE_FORMAT(DATE(t1.created), '%Y-%m-%d') BETWEEN '".$frmDate."' AND '".$toDate."'")
                ->IsProcessing()
                ->IsPayOnline()
                ->whereRaw("t1.rid LIKE CASE WHEN '".$reseller."' = '%' THEN '%' ELSE '".$reseller."' END")
                ->get();
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetOrderShipping($frmDate = '', $toDate = '', $reseller = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->orderModel::from(LT4_PRODUCTS_ORDERS. " AS t1")
                ->selectRaw('t1.id, t1.rid, t1.order_total, t1.vdiscount, t1.engrave_fee, t1.amount, t1.status_id')
                ->whereRaw("DATE_FORMAT(DATE(t1.created), '%Y-%m-%d') BETWEEN '".$frmDate."' AND '".$toDate."'")
                ->IsShipping()
                ->IsPayOnline()
                ->whereRaw("t1.rid LIKE CASE WHEN '".$reseller."' = '%' THEN '%' ELSE '".$reseller."' END")
                ->get();
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetOrderCanceled($frmDate = '', $toDate = '', $reseller = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->orderModel::from(LT4_PRODUCTS_ORDERS. " AS t1")
                ->selectRaw('t1.id, t1.rid, t1.order_total, t1.vdiscount, t1.engrave_fee, t1.amount, t1.status_id')
                ->whereRaw("DATE_FORMAT(DATE(t1.created), '%Y-%m-%d') BETWEEN '".$frmDate."' AND '".$toDate."'")
                ->IsCanceled()
                ->IsPayOnline()
                ->whereRaw("t1.rid LIKE CASE WHEN '".$reseller."' = '%' THEN '%' ELSE '".$reseller."' END")
                ->get();
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetOrderCompleted($frmDate = '', $toDate = '', $reseller = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->orderModel::from(LT4_PRODUCTS_ORDERS. " AS t1")
                ->selectRaw('t1.id, t1.rid, t1.order_total, t1.vdiscount, t1.engrave_fee, t1.amount, t1.status_id')
                ->whereRaw("DATE_FORMAT(DATE(t1.created), '%Y-%m-%d') BETWEEN '".$frmDate."' AND '".$toDate."'")
                ->IsCompleted()
                ->IsPayOnline()
                ->whereRaw("t1.rid LIKE CASE WHEN '".$reseller."' = '%' THEN '%' ELSE '".$reseller."' END")
                ->get();
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetOrderPaid($frmDate = '', $toDate = '', $reseller = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->orderModel::from(LT4_PRODUCTS_ORDERS. " AS t1")
                ->selectRaw('t1.id, t1.rid, t1.order_total, t1.vdiscount, t1.engrave_fee, t1.amount, t1.status_id')
                ->whereRaw("DATE_FORMAT(DATE(t1.created), '%Y-%m-%d') BETWEEN '".$frmDate."' AND '".$toDate."'")
                ->IsPaid()
                ->IsPayOnline()
                ->whereRaw("t1.rid LIKE CASE WHEN '".$reseller."' = '%' THEN '%' ELSE '".$reseller."' END")
                ->get();
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetOrderUnPaid($frmDate = '', $toDate = '', $reseller = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->orderModel::from(LT4_PRODUCTS_ORDERS. " AS t1")
                ->selectRaw('t1.id, t1.rid, t1.order_total, t1.vdiscount, t1.engrave_fee, t1.amount, t1.status_id')
                ->whereRaw("DATE_FORMAT(DATE(t1.created), '%Y-%m-%d') BETWEEN '".$frmDate."' AND '".$toDate."'")
                ->IsNotPaid()
                ->IsPayOnline()
                ->whereRaw("t1.rid LIKE CASE WHEN '".$reseller."' = '%' THEN '%' ELSE '".$reseller."' END")
                ->get();
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalOrderByDate($frmDate = '', $toDate = '', $reseller = '%')
    {
        $mTmpResult = $this->getRangeDateCtrl->doQuery($frmDate, $toDate);

        $queryTotalOrder = $this->orderModel::from(LT4_PRODUCTS_ORDERS. " AS t1")
                ->selectRaw("COUNT(IFNULL(t1.id, '')) AS totalOrder,
                            COUNT(CASE WHEN t1.paid = 1 THEN 1 END) AS totalOrderPaid, 
                            COUNT(CASE WHEN t1.paid = 0 THEN 1 END) AS totalOrderUnPaid, 
                            SUM(CASE WHEN t1.paid = 1 THEN t1.amount END) AS totalPaidAmount, 
                            SUM(CASE WHEN t1.paid = 0 THEN t1.amount END) AS totalUnPaidAmount, 
                            DATE_FORMAT(DATE(t1.created), '%Y-%m-%d') AS created_at")
                ->whereRaw("1 = 1")
                ->whereRaw("DATE_FORMAT(DATE(t1.created), '%Y-%m-%d') BETWEEN ".StringHelper::escapeString($frmDate). " AND ". StringHelper::escapeString($toDate))
                ->whereRaw("t1.rid LIKE CASE WHEN '".$reseller."' = '%' THEN '%' ELSE '".$reseller."' END")
                ->IsPayOnline()
                ->groupByRaw("created_at")
                ->orderByraw("created_at");

        $mTmpTotalOrder = $queryTotalOrder->get();

        foreach($mTmpResult as $key => $item)
        {
            $item->totalOrder = 0;
            $item->totalOrderPaid = 0;
            $item->totalOrderUnPaid = 0;
            $item->totalPaidAmount = 0;
            $item->totalUnPaidAmount = 0;

            foreach($mTmpTotalOrder AS $key2 => $item2)
            {
                if($item->created_at == $item2->created_at)
                {
                    $item->totalOrder += ($item2->totalOrder) ?? $item2->totalOrder;
                    $item->totalOrderPaid += ($item2->totalOrderPaid) ?? $item2->totalOrderPaid;
                    $item->totalOrderUnPaid += ($item2->totalOrderUnPaid) ?? $item2->totalOrderUnPaid;
                    $item->totalPaidAmount += ($item2->totalPaidAmount) ?? $item2->totalPaidAmount;
                    $item->totalUnPaidAmount += ($item2->totalUnPaidAmount) ?? $item2->totalUnPaidAmount;
                    break;    
                }
            }
        }
        return $mTmpResult;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalOrderByReseller($frmDate = '', $toDate = '', $reseller = '%')
    {
        $mTmpResult = $this->getResellerCtrl->doQuery();

        $queryTotalOrder = $this->orderModel::from(LT4_PRODUCTS_ORDERS. " AS t1")
                ->selectRaw("COUNT(IFNULL(t1.id, '')) AS totalOrder,     
                            COUNT(CASE WHEN t1.paid = 1 THEN 1 END) AS totalOrderPaid, 
                            COUNT(CASE WHEN t1.paid = 0 THEN 1 END) AS totalOrderUnPaid, 
                            SUM(CASE WHEN t1.paid = 1 THEN t1.amount END) AS totalPaidAmount, 
                            SUM(CASE WHEN t1.paid = 0 THEN t1.amount END) AS totalUnPaidAmount, 
                            t1.rid AS rid")
                ->whereRaw("1 = 1")
                ->whereRaw("DATE_FORMAT(DATE(t1.created), '%Y-%m-%d') BETWEEN ".StringHelper::escapeString($frmDate). " AND ". StringHelper::escapeString($toDate))
                ->whereRaw("t1.rid LIKE CASE WHEN '".$reseller."' = '%' THEN '%' ELSE '".$reseller."' END")
                ->IsPayOnline()
                ->groupByRaw("rid")
                ->orderByraw("totalOrder");

        $mTmpTotalOrder = $queryTotalOrder->get();

        foreach($mTmpResult as $key => $item)
        {
            $item->totalOrder = 0;
            $item->totalOrderPaid = 0;
            $item->totalOrderUnPaid = 0;
            $item->totalPaidAmount = 0;
            $item->totalUnPaidAmount = 0;

            foreach($mTmpTotalOrder AS $key1 => $item1)
            {
                if($item->id == $item1->rid)
                {
                    $item->totalOrder += ($item1->totalOrder) ?? $item1->totalOrder;
                    $item->totalOrderPaid += ($item1->totalOrderPaid) ?? $item1->totalOrderPaid;
                    $item->totalOrderUnPaid += ($item1->totalOrderUnPaid) ?? $item1->totalOrderUnPaid;
                    $item->totalPaidAmount += ($item1->totalPaidAmount) ?? $item1->totalPaidAmount;
                    $item->totalUnPaidAmount += ($item1->totalUnPaidAmount) ?? $item1->totalUnPaidAmount;
                    break;    
                }
            }
        }

        foreach ($mTmpResult as $key => $item) {
            if($item->totalOrder == 0)
            {
                unset($mTmpResult[$key]);
            }
        }

        $mTmpResult = ArrayHelper::arraySort($mTmpResult, 'totalOrder', SORT_DESC);

        return $mTmpResult;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalOrderItems($frmDate = '', $toDate = '', $reseller = '%', $mLimit = '10')
    {
        $orders = $this->orderModel::from(LT4_PRODUCTS_ORDERS. " AS t1")
                ->selectRaw('t1.id, t1.rid, t1.order_total, t1.vdiscount, t1.engrave_fee, t1.amount, t1.status_id, t1.paid, t1.payonline')
                ->whereRaw("DATE_FORMAT(DATE(t1.created), '%Y-%m-%d') BETWEEN '".$frmDate."' AND '".$toDate."'")
                ->whereRaw("t1.rid LIKE CASE WHEN '".$reseller."' = '%' THEN '%' ELSE '".$reseller."' END")
                ->IsPayOnline()
                ->get();

        $orderItemIds = array_column($orders->toArray(), 'id');

        $orderItems = $this->orderItemModel::query()
            ->whereIn('order_id', $orderItemIds)
            ->selectRaw('pid, name, MAX(price) AS price, SUM(quantity) as quantity, SUM(total_price) as total_price')
            ->orderBy('quantity', 'desc')
            ->groupBy('pid', 'name')
            ->limit($mLimit)
            ->get();

        return $orderItems;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalOrderCatItems($frmDate = '', $toDate = '', $reseller = '%')
    {
        $orders = $this->orderModel::from(LT4_PRODUCTS_ORDERS. " AS t1")
                ->selectRaw('t1.id, t1.rid, t1.order_total, t1.vdiscount, t1.engrave_fee, t1.amount, t1.status_id, t1.paid, t1.payonline')
                ->whereRaw("DATE_FORMAT(DATE(t1.created), '%Y-%m-%d') BETWEEN '".$frmDate."' AND '".$toDate."'")
                ->whereRaw("t1.rid LIKE CASE WHEN '".$reseller."' = '%' THEN '%' ELSE '".$reseller."' END")
                ->IsPayOnline()
                ->get();

        $orderItemIds = array_column($orders->toArray(), 'id');

        $TmporderCatItems = $this->orderItemModel::query()
            ->whereIn("order_id", $orderItemIds)
            ->selectRaw("pid, SUM(quantity) as quantity, SUM(total_price) as total_price")
            ->orderBy("quantity", "desc")
            ->groupBy("pid")
            ->get();

        $productIds = array_column($TmporderCatItems->toArray(), 'pid');

        $products = $this->orderProductModel::from(LT4_PRODUCTS. " AS t1")
                        ->selectRaw("t1.id, t1.catid")
                        ->whereIn("t1.id", $productIds)
                        ->orderByRaw("t1. id DESC")
                        ->get();

        $productCats = $this->orderProductCatModel::from(LT4_PRODUCTS_CATEGORIES. " AS t1")
                        ->selectRaw("t1.id, t1.name")
                        ->orderByRaw("t1. id DESC")
                        ->get();

        foreach ($TmporderCatItems as $key => $item) 
        {
            foreach ($products as $key1 => $item1) 
            {
                if($item->pid == $item1->id )
                {
                    $item->catid = $item1->catid;
                }
            }
        }

        foreach ($TmporderCatItems as $key => $item) 
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
        $groupsOrderCatItems = $TmporderCatItems->groupBy('catid'); 

        // we will use map to cumulate each group of rows into single row.
        // $group is a collection of rows that has the same catid.
        $orderCatItems = $groupsOrderCatItems->map(function ($group) {
            return (object) [
                'catid' => $group->first()['catid'],
                'catname' => $group->first()['catname'],
                'quantity' => $group->sum('quantity'),
                'total_price' => $group->sum('total_price'),
            ];
        });

        $orderCatItems = ArrayHelper::arraySort($orderCatItems, 'total_price', SORT_DESC);

        return $orderCatItems;
    }
}