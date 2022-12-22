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

class getTotalAssignedVoucherController extends BaseController
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
    public function doGetTotalAssignedVoucher($campaign = '0', $voucherGroup = '0', $frmDate = '', $toDate = '')
    {
        if($campaign != '0')
        {
            $campaigns = DB::table(VOUCHER_TBL. " AS t1")
                    ->selectRaw("CASE WHEN IFNULL(t2.voucher_id, '') != '' THEN 'Đã cấp phát' ELSE 'Chưa cấp phát' END AS isAssigned, COUNT(IFNULL(t1.voucher_id, '')) AS total")
                    ->leftjoin(CAMPAIGN_RESULT_TBL." AS t2", function ($join) use ($campaign, $frmDate, $toDate) {
                        $join->on("t1.voucher_id", "=", "t2.voucher_id")
                        ->where("t2.campaign_id", "=", $campaign)
                        ->whereRaw("DATE_FORMAT(DATE(t2.campaignresult_created_at), '%Y-%m-%d') BETWEEN ".StringHelper::escapeString($frmDate). " AND ". StringHelper::escapeString($toDate));
                    })
                    ->whereRaw("1 = 1")
                    ->where("t1.voucher_group", "=", $voucherGroup)
                    ->groupByRaw("isAssigned");

            $mTmpResult = $campaigns->get();
        }
        else
        {
		    $query = "  SELECT 'Đã cấp phát' AS isAssigned, 0 AS total
                        UNION ALL
                        SELECT 'Chưa cấp phát' AS isAssigned, 0 AS total;";
            $args = [];

            $mTmpResult =  \DB::select($query, $args);
        }

	    return $mTmpResult;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalAssignedVoucherGroupByDevice($campaign = '0', $voucherGroup = '0', $frmDate = '', $toDate = '')
    {
        if($campaign != '0')
        {
            $campaigns = DB::table(VOUCHER_TBL. " AS t1")
                    ->selectRaw("IFNULL(t2.deviceType, '') AS deviceType, COUNT(IFNULL(t1.voucher_id, '')) AS total")
                    ->join(CAMPAIGN_RESULT_TBL." AS t2", function ($join) use ($campaign) {
                        $join->on("t1.voucher_id", "=", "t2.voucher_id")
                        ->where("t2.campaign_id", "=", $campaign);
                    })
                    ->whereRaw("1 = 1")
                    ->where("t1.voucher_group", "=", $voucherGroup)
                    ->whereRaw("DATE_FORMAT(DATE(t2.campaignresult_created_at), '%Y-%m-%d') BETWEEN ".StringHelper::escapeString($frmDate). " AND ". StringHelper::escapeString($toDate))
                    ->groupByRaw("deviceType");

            $mTmpResult = $campaigns->get();
        }
        else
        {
            $query = "  SELECT '' AS deviceType, 0 AS total;";
            $args = [];

            $mTmpResult =  \DB::select($query, $args);
        }

        return $mTmpResult;
    }
}