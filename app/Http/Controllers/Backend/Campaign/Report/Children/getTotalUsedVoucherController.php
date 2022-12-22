<?php

namespace App\Http\Controllers\Backend\Campaign\Report\Children;

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
use DB;
use App\Http\Controllers\Backend\Campaign\Report\Children\getRangeDateController;

class getTotalUsedVoucherController extends BaseController
{
	private $getRangeDateCtrl;
    public function __construct()
    {
        $this->adminUserModel = new AdminUser();
        $this->getRangeDateCtrl = new getRangeDateController();
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalUsedVoucher($campaign = '0', $voucherGroup = '0', $frmDate = '', $toDate = '')
    {
        $queryOrders = DB::table(LT4_PRODUCTS_ORDERS. " AS t1")
                ->selectRaw("t1.vcode AS voucherCode")
                ->whereRaw("1 = 1")
                ->whereRaw("IFNULL(t1.vcode, '') != ''")
                ->whereRaw("DATE_FORMAT(DATE(t1.created), '%Y-%m-%d') BETWEEN ".StringHelper::escapeString($frmDate). " AND ". StringHelper::escapeString($toDate));

        $orders = $queryOrders->get();

        $voucherCodes = [];
        if($orders->count() > 0){
            $voucherCodes = array_column($orders->toArray(), 'voucherCode');
        }

        if($campaign != '0')
        {
            $vouchers = DB::table(VOUCHER_TBL. " AS t1")
                    ->selectRaw("CASE WHEN IFNULL(t1.voucher_is_used, '') = 'yes' THEN 'Đã sử dụng' ELSE 'Chưa sử dụng' END AS isUsed, COUNT(IFNULL(t1.voucher_code, '')) AS total")
                    ->join(CAMPAIGN_RESULT_TBL." AS t2", function ($join) use ($campaign) {
                        $join->on("t1.voucher_id", "=", "t2.voucher_id")
                        ->where("t2.campaign_id", "=", $campaign);
                    })
                    ->whereRaw("1 = 1")
                    ->where("t1.voucher_group", "=", $voucherGroup)
                    ->whereIn("t1.voucher_code", $voucherCodes)
                    ->whereRaw("DATE_FORMAT(DATE(t2.campaignresult_created_at), '%Y-%m-%d') BETWEEN ".StringHelper::escapeString($frmDate). " AND ". StringHelper::escapeString($toDate))
                    ->groupByRaw("isUsed");

            $mTmpResult = $vouchers->get();
        }
        else
        {
		    $query = "  SELECT 'Đã sử dụng' AS isUsed, 0 AS total
                        UNION ALL
                        SELECT 'Chưa sử dụng' AS isUsed, 0 AS total;";
            $args = [];

            $mTmpResult =  \DB::select($query, $args);
        }

	    return $mTmpResult;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalUsedVoucherGroupByDevice($campaign = '0', $voucherGroup = '0', $frmDate = '', $toDate = '')
    {
        $queryOrders = DB::table(LT4_PRODUCTS_ORDERS. " AS t1")
                ->selectRaw("t1.vcode AS voucherCode")
                ->whereRaw("1 = 1")
                ->whereRaw("IFNULL(t1.vcode, '') != ''")
                ->whereRaw("DATE_FORMAT(DATE(t1.created), '%Y-%m-%d') BETWEEN ".StringHelper::escapeString($frmDate). " AND ". StringHelper::escapeString($toDate));

        $orders = $queryOrders->get();

        $voucherCodes = [];
        if($orders->count() > 0){
            $voucherCodes = array_column($orders->toArray(), 'voucherCode');
        }

        if($campaign != '0')
        {
            $vouchers = DB::table(VOUCHER_TBL. " AS t1")
                    ->selectRaw("IFNULL(t2.deviceType, '') AS deviceType, COUNT(IFNULL(t1.voucher_id, '')) AS total")
                    ->join(CAMPAIGN_RESULT_TBL." AS t2", function ($join) use ($campaign) {
                        $join->on("t1.voucher_id", "=", "t2.voucher_id")
                        ->where("t2.campaign_id", "=", $campaign);
                    })
                    ->whereRaw("1 = 1")
                    ->where("t1.voucher_group", "=", $voucherGroup)
                    ->whereIn("t1.voucher_code", $voucherCodes)
                    ->whereRaw("DATE_FORMAT(DATE(t2.campaignresult_created_at), '%Y-%m-%d') BETWEEN ".StringHelper::escapeString($frmDate). " AND ". StringHelper::escapeString($toDate))
                    ->groupByRaw("deviceType");

            $mTmpResult = $vouchers->get();
        }
        else
        {
            $query = "  SELECT 'Đã sử dụng' AS isUsed, 0 AS total
                        UNION ALL
                        SELECT 'Chưa sử dụng' AS isUsed, 0 AS total;";
            $args = [];

            $mTmpResult =  \DB::select($query, $args);
        }

        return $mTmpResult;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalUsedVoucherGroupByDate($campaign = '0', $voucherGroup = '0', $frmDate = '', $toDate = '')
    {
        $mTmpResult = $this->getRangeDateCtrl->doQuery($frmDate, $toDate);

        $queryOrders = DB::table(LT4_PRODUCTS_ORDERS. " AS t1")
                ->selectRaw("t1.vcode AS voucherCode")
                ->whereRaw("1 = 1")
                ->whereRaw("IFNULL(t1.vcode, '') != ''")
                ->whereRaw("DATE_FORMAT(DATE(t1.created), '%Y-%m-%d') BETWEEN ".StringHelper::escapeString($frmDate). " AND ". StringHelper::escapeString($toDate));

        $orders = $queryOrders->get();

        $voucherCodes = [];
        if($orders->count() > 0){
            $voucherCodes = array_column($orders->toArray(), 'voucherCode');
        }

        $queryTotalVoucher = DB::table(VOUCHER_TBL. " AS t1")
                ->selectRaw("COUNT(IFNULL(t1.voucher_code, '')) AS totalVoucher, DATE_FORMAT(DATE(t2.campaignresult_created_at), '%Y-%m-%d') AS created_at")
                ->join(CAMPAIGN_RESULT_TBL." AS t2", function ($join) use ($campaign) {
                    $join->on("t1.voucher_id", "=", "t2.voucher_id")
                    ->where("t2.campaign_id", "=", $campaign);
                })
                ->whereRaw("1 = 1")
                ->where("t1.voucher_group", "=", $voucherGroup)
                ->whereIn("t1.voucher_code", $voucherCodes)
                ->whereRaw("DATE_FORMAT(DATE(t2.campaignresult_created_at), '%Y-%m-%d') BETWEEN ".StringHelper::escapeString($frmDate). " AND ". StringHelper::escapeString($toDate))
                ->groupByRaw("created_at");

        $mTmpTotalVoucher = $queryTotalVoucher->get();

        foreach($mTmpResult as $key => $item)
        {
            $item->totalVoucher = 0;
            foreach ($mTmpTotalVoucher as $key1 => $item1) 
            {
                if($item->created_at == $item1->created_at)
                {
                    $item->totalVoucher += ($item1->totalVoucher) ?? $item1->totalVoucher;
                    break;
                }
            }
        }

        return $mTmpResult;
    }
}