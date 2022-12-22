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

class getTrafficPlatformController extends BaseController
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
    public function doGetTrafficPlatform($frmDate = '', $toDate = '', $mPlatform = '%')
    {
        $tblTrafficOrganic = 'client_tracking_traffic_details';
	    $tblPlatform = 'client_tracking_platform';

	    $query = "  SELECT t1.platform AS label, t2.icon AS icon, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
	                INNER JOIN $tblPlatform t2 ON t1.platform = t2.name
	                WHERE 1 = 1
	                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') BETWEEN :frmDate AND :toDate
	                GROUP BY label, icon;";

        $args = ['frmDate' => $frmDate, 'toDate' => $toDate];
        $mTmpResult =  \DB::select($query, $args);

	    foreach ($mTmpResult as $key => $item) {
	        if($item->label != $mPlatform && $mPlatform != '%')
	        {
	            unset($mTmpResult[$key]);
	        }
	    }

	    return $mTmpResult;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTrafficPlatformByDate($frmDate = '', $toDate = '', $mPlatform = '%')
    {
        $tblTrafficOrganic = 'client_tracking_traffic_details';
	    $tblPlatform = 'client_tracking_platform';
	    $query = " SELECT name FROM $tblPlatform WHERE status = 'activated';";
	    $mTmpPlatform = \DB::select($query);
	    $arrPlatform = array();
	    foreach ($mTmpPlatform as $key => $item) {
	       $arrPlatform[$key] = $item->name;
	    }

	    // $arrPlatform = ['Windows', 'Windows NT', 'Mac OS X', 'Debian', 'Ubuntu', 'PPC', 'OpenBSD', 'Linux', 'ChromeOS', 'AndroidOS', 'BlackBerryOS', 'OS X', 'iOS'];

	    $mTmpResult = $this->getRangeDateCtrl->doQuery($frmDate, $toDate);

	    foreach ($mTmpResult as $key => $item) {
	        // $query = "CALL 'sp_job_list'('{$id}', '{$job_title}', '{$qualify}');";
	        $query = "";
	        foreach ($arrPlatform as $value) {
	            $query .= " SELECT '$value' AS label, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
	                        INNER JOIN $tblPlatform t2 ON t1.platform = t2.name
	                        WHERE 1 = 1
	                        AND t1.platform = '$value'
	                        AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') = '$item->created_at'";

	            if($value != $arrPlatform[array_key_last($arrPlatform)])
	            {
	                $query .= " UNION ALL ";
	            }
	            else
	            {
	                $query .= ";";
	            }
	        }
	        $mTmp =  \DB::select($query);
	        foreach ($arrPlatform as $key => $value) {
	            // echo("<pre>$key: $value</pre>");
	            $value = strtolower($value);
	            $value = str_replace(' ', '', $value);
	            $item->$value = ($mTmp[$key]->total) ? $mTmp[$key]->total : 0;
	        }
	    }

	    return $mTmpResult;
    }
}