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
use DB;
use App\Http\Controllers\Backend\Order\Report\Children\getRangeDateController;
use App\Http\Controllers\Backend\Affiliate\Report\Children\getAffiliateResellerController;
use App\Http\Controllers\Backend\Affiliate\Report\Children\getAffiliateController;

class getTotalCommisionController extends BaseController
{
    private $adminUserModel;
    private $affiliateModel;
    private $affiliateResellerModel;
    private $salesModel;
    private $salesDeletedModel;

	private $getRangeDateCtrl;
    private $getResellerCtrl;

    public function __construct()
    {
        $this->adminUserModel = new AdminUser();
        $this->affiliateModel = new tsAffiliates();
        $this->affiliateResellerModel = new tsAffiliateResellers();
        $this->salesModel = new tsSales();
        $this->salesDeletedModel = new tsSalesDeleted();
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
                ->selectRaw('t1.id, t1.afid, t1.ordernum, t1.amount, t1.comm_amount, t1.approved, t1.paid, t1.created, t1.bonus')
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
                ->selectRaw('t1.id, t1.afid, t1.ordernum, t1.amount, t1.comm_amount, t1.approved, t1.paid, t1.created, t1.bonus')
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
                ->selectRaw('t1.id, t1.afid, t1.ordernum, t1.amount, t1.comm_amount, t1.approved, t1.paid, t1.created, t1.bonus')
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
                ->selectRaw('t1.id, t1.afid, t1.ordernum, t1.amount, t1.comm_amount, t1.approved, t1.paid, t1.created, t1.bonus')
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
                ->selectRaw('t1.id, t1.created, t1.ordernum, t1.afid, t1.amount, t1.comm_amount')
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
}