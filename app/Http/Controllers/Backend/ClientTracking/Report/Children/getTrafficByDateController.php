<?php

namespace App\Http\Controllers\Backend\ClientTracking\Report\Children;

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
use DB;
use App\Http\Controllers\Backend\ClientTracking\Report\Children\getRangeDateController;

class getTrafficByDateController extends BaseController
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
    public function doGetTrafficByDate($frmDate = '', $toDate = '', $mSourceMaster = '')
    {
        $mTmpResult = $this->getRangeDateCtrl->doQuery($frmDate, $toDate);
        $tblTrafficOrganic = 'client_tracking_traffic_details';
        $tblTrafficAds = 'client_tracking_traffic_ads';
	    foreach($mTmpResult as $key => $item)
	    {
	    	$item->organic = 0;
	    	$item->ads = 0;

	    	$query = "SELECT SUM(t1.views) AS total 
	    			FROM $tblTrafficOrganic AS t1
					WHERE 1=1
					AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') = :created_at;";
			$args = ['created_at' => $item->created_at];
			$mTmpOrganic = \DB::select($query, $args);

	    	$query = "SELECT SUM(t1.views) AS total 
	    			FROM $tblTrafficAds AS t1
					WHERE 1=1
					AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') = :created_at;";
			$args = ['created_at' => $item->created_at];
			$mTmpAds =  \DB::select($query, $args);

			$item->organic += ($mTmpOrganic[0]->total) ?? $mTmpOrganic[0]->total;
			$item->ads += ($mTmpAds[0]->total) ?? $mTmpAds[0]->total;
	    }
        return $mTmpResult;
    }
}