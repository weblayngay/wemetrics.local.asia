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

class getTrafficGeoController extends BaseController
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
    public function doGetTrafficRegion($frmDate = '', $toDate = '', $mCountry = '', $mRegion = '', $mSource = '', $mGroupBy = 'region')
    {
        $tblTrafficGeo = 'client_tracking_geolite_details';

	    $query = "  SELECT IFNULL(t1.region, 'Unknown') AS region, IFNULL(t1.country, 'Unknown') AS country, COUNT(IFNULL(t1.region, 0)) AS total FROM $tblTrafficGeo AS t1
	                WHERE 1 = 1
	                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') BETWEEN :frmDate AND :toDate
	                GROUP BY region, country;";

        $args = ['frmDate' => $frmDate, 'toDate' => $toDate];
        $mTmpResult =  \DB::select($query, $args);

	    return $mTmpResult;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTrafficCountry($frmDate = '', $toDate = '', $mCountry = '', $mRegion = '', $mSource = '', $mGroupBy = 'country')
    {
        $tblTrafficGeo = 'client_tracking_geolite_details';

	    $query = "  SELECT IFNULL(t1.country, 'Unknown') AS country, COUNT(IFNULL(t1.country, 0)) AS total FROM $tblTrafficGeo AS t1
	                WHERE 1 = 1
	                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') BETWEEN :frmDate AND :toDate
	                GROUP BY country;";

        $args = ['frmDate' => $frmDate, 'toDate' => $toDate];
        $mTmpResult =  \DB::select($query, $args);

	    return $mTmpResult;
    }
}