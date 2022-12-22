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
use App\Http\Controllers\Backend\Campaign\Report\Children\getResellerController;

class getTotalOrderController extends BaseController
{
	private $getRangeDateCtrl;
    private $getResellerCtrl;
    public function __construct()
    {
        $this->adminUserModel = new AdminUser();
        $this->getRangeDateCtrl = new getRangeDateController();
        $this->getResellerCtrl = new getResellerController();
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalOrderAndVoucherByDate($campaign = '0', $voucherGroup = '0', $frmDate = '', $toDate = '')
    {
        $mTmpResult = $this->getRangeDateCtrl->doQuery($frmDate, $toDate);

        $queryTotalVoucher = DB::table(VOUCHER_TBL. " AS t1")
                ->selectRaw("COUNT(IFNULL(t1.voucher_code, '')) AS totalVoucher, DATE_FORMAT(DATE(t2.campaignresult_created_at), '%Y-%m-%d') AS created_at")
                ->join(CAMPAIGN_RESULT_TBL." AS t2", function ($join) use ($campaign) {
                    $join->on("t1.voucher_id", "=", "t2.voucher_id")
                    ->where("t2.campaign_id", "=", $campaign);
                })
                ->whereRaw("1 = 1")
                ->where("t1.voucher_group", "=", $voucherGroup)
                ->whereRaw("DATE_FORMAT(DATE(t2.campaignresult_created_at), '%Y-%m-%d') BETWEEN ".StringHelper::escapeString($frmDate). " AND ". StringHelper::escapeString($toDate))
                ->groupByRaw("created_at")
                ->orderByraw("created_at");

        $mTmpTotalVoucher = $queryTotalVoucher->get();

        $queryTotalOrder = DB::table(LT4_PRODUCTS_ORDERS. " AS t1")
                ->selectRaw("COUNT(IFNULL(t1.id, '')) AS totalOrder, DATE_FORMAT(DATE(t1.created), '%Y-%m-%d') AS created_at")
                ->whereRaw("1 = 1")
                ->whereRaw("DATE_FORMAT(DATE(t1.created), '%Y-%m-%d') BETWEEN ".StringHelper::escapeString($frmDate). " AND ". StringHelper::escapeString($toDate))
                ->groupByRaw("created_at")
                ->orderByraw("created_at");

        $mTmpTotalOrder = $queryTotalOrder->get();

        foreach($mTmpResult as $key => $item)
        {
            $item->totalVoucher = 0;
            $item->totalOrder = 0;
            foreach($mTmpTotalVoucher AS $key1 => $item1)
            {
                if($item->created_at == $item1->created_at)
                {
                    $item->totalVoucher += ($item1->totalVoucher) ?? $item1->totalVoucher;
                    break;    
                }
            }

            foreach($mTmpTotalOrder AS $key2 => $item2)
            {
                if($item->created_at == $item2->created_at)
                {
                    $item->totalOrder += ($item2->totalOrder) ?? $item2->totalOrder;
                    break;    
                }
            }
        }
        return $mTmpResult;
    }
}