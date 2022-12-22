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
use App\Models\Affiliate\tsPayments;
use DB;
use App\Http\Controllers\Backend\Order\Report\Children\getRangeDateController;
use App\Http\Controllers\Backend\Affiliate\Report\Children\getAffiliateResellerController;
use App\Http\Controllers\Backend\Affiliate\Report\Children\getAffiliateController;

class getTotalPayCommController extends BaseController
{
    private $adminUserModel;
    private $affiliateModel;
    private $affiliateResellerModel;
    private $paymentsModel;
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
        $this->paymentsModel = new tsPayments();
        $this->getRangeDateCtrl = new getRangeDateController();
        $this->getResellerCtrl = new getAffiliateResellerController();
        $this->getAffiliateCtrl = new getAffiliateController();
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
    public function doGetTotalPayments($frmDate = '', $toDate = '', $affiliate = '%')
    {
        $result = $this->salesModel::from(TS_PAYMENTS. " AS t1")
                ->selectRaw("t1.*")
                ->whereRaw("FROM_UNIXTIME(t1.created,'%Y-%m-%d') BETWEEN '".$frmDate."' AND '".$toDate."'")
                ->whereRaw("t1.afid LIKE CASE WHEN '".$affiliate."' = '%' THEN '%' ELSE '".$affiliate."' END")
                ->get();

        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalPaidPayments($frmDate = '', $toDate = '', $affiliate = '%')
    {
        $result = $this->salesModel::from(TS_PAYMENTS. " AS t1")
                ->selectRaw("t1.*")
                ->whereRaw("FROM_UNIXTIME(t1.created,'%Y-%m-%d') BETWEEN '".$frmDate."' AND '".$toDate."'")
                ->whereRaw("t1.afid LIKE CASE WHEN '".$affiliate."' = '%' THEN '%' ELSE '".$affiliate."' END")
                ->IsPaid()
                ->get();

        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalNotPaidPayments($frmDate = '', $toDate = '', $affiliate = '%')
    {
        $result = $this->salesModel::from(TS_PAYMENTS. " AS t1")
                ->selectRaw("t1.*")
                ->whereRaw("FROM_UNIXTIME(t1.created,'%Y-%m-%d') BETWEEN '".$frmDate."' AND '".$toDate."'")
                ->whereRaw("t1.afid LIKE CASE WHEN '".$affiliate."' = '%' THEN '%' ELSE '".$affiliate."' END")
                ->IsNotPaid()
                ->get();

        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalCommByDate($frmDate = '', $toDate = '', $affiliate = '%')
    {
        $mTmpResult = $this->getRangeDateCtrl->doQuery($frmDate, $toDate);

        $mTmpTotalAmount = $this->salesModel::from(TS_PAYMENTS. " AS t1")
                ->selectRaw("SUM(CASE WHEN t1.paid = 1 THEN t1.amount ELSE 0 END) AS totalPaidAmount, 
                    SUM(CASE WHEN t1.paid = 0 THEN t1.amount ELSE 0 END) AS totalNotPaidAmount, 
                    FROM_UNIXTIME(t1.created,'%Y-%m-%d') AS created_at")
                ->whereRaw("FROM_UNIXTIME(t1.created,'%Y-%m-%d') BETWEEN '".$frmDate."' AND '".$toDate."'")
                ->whereRaw("t1.afid LIKE CASE WHEN '".$affiliate."' = '%' THEN '%' ELSE '".$affiliate."' END")
                ->groupByRaw("created_at")
                ->get();

        foreach($mTmpResult as $key => $item)
        {
            $item->totalPaidAmount = 0;
            $item->totalNotPaidAmount = 0;

            foreach($mTmpTotalAmount AS $key2 => $item2)
            {
                if($item->created_at == $item2->created_at)
                {
                    $item->totalPaidAmount += ($item2->totalPaidAmount) ?? $item2->totalPaidAmount;
                    $item->totalNotPaidAmount += ($item2->totalNotPaidAmount) ?? $item2->totalNotPaidAmount;
                    break;    
                }
            }
        }
        return $mTmpResult;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalAffiliateByPayComm($frmDate = '', $toDate = '', $affiliate = '%', $mLimit = '15')
    {
        $mTmpAffiliate = $this->getAffiliateCtrl->doQuery($affiliate);

        $mTmpResult = $this->salesModel::from(TS_PAYMENTS. " AS t1")
                ->selectRaw("
                    SUM(t1.amount) AS totalAmount,
                    SUM(CASE WHEN t1.paid = 1 THEN t1.amount ELSE 0 END) AS totalPaidAmount, 
                    SUM(CASE WHEN t1.paid = 0 THEN t1.amount ELSE 0 END) AS totalNotPaidAmount, 
                    t1.afid AS afid, 
                    '' AS name")
                ->whereRaw("FROM_UNIXTIME(t1.created,'%Y-%m-%d') BETWEEN '".$frmDate."' AND '".$toDate."'")
                ->whereRaw("t1.afid LIKE CASE WHEN '".$affiliate."' = '%' THEN '%' ELSE '".$affiliate."' END")
                ->groupByRaw("afid")
                ->orderByRaw("totalAmount, totalPaidAmount DESC")
                ->Limit($mLimit)
                ->get();

        foreach($mTmpResult as $key => $item)
        {
            foreach($mTmpAffiliate AS $key2 => $item2)
            {
                if($item->afid == $item2->id)
                {
                    $item->name = $item2->name;
                    break;    
                }
            }
        }
        return $mTmpResult;
    }
}