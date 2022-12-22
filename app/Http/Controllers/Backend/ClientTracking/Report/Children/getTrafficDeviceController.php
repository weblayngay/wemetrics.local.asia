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

class getTrafficDeviceController extends BaseController
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
    public function doGetTrafficDevice($frmDate = '', $toDate = '', $mDevice = '%')
    {
        $tblTrafficOrganic = 'client_tracking_traffic_details';
	    $tblDevice = 'client_tracking_device';

	    $query = "  SELECT CONCAT(UCASE(SUBSTRING(t1.device_type, 1, 1)), LOWER(SUBSTRING(t1.device_type, 2))) AS label, t2.icon AS icon, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
	                INNER JOIN $tblDevice t2 ON t1.device_type = t2.name
	                WHERE 1 = 1
	                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') BETWEEN :frmDate AND :toDate
	                GROUP BY label, icon;";

        $args = ['frmDate' => $frmDate, 'toDate' => $toDate];
        $mTmpResult =  \DB::select($query, $args);

	    foreach ($mTmpResult as $key => $item) {
	        if($item->label != $mDevice && $mDevice != '%')
	        {
	            unset($mTmpResult[$key]);
	        }
	    }

	    return $mTmpResult;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTrafficDeviceByDate($frmDate = '', $toDate = '', $mDevice = '%')
    {
        $tblTrafficOrganic = 'client_tracking_traffic_details';
	    $tblDevice = 'client_tracking_device';
	    $query = " SELECT name FROM $tblDevice WHERE status = 'activated';";
	    $mTmpDevice = \DB::select($query);
	    $arrDevice = array();
	    foreach ($mTmpDevice as $key => $item) {
	       $arrDevice[$key] = $item->name;
	    }

	    // $arrDevice = ['desktop', 'phone', 'tablet'];

	    $mTmpResult = $this->getRangeDateCtrl->doQuery($frmDate, $toDate);

	    foreach ($mTmpResult as $key => $item) {
	        // $query = "CALL 'sp_job_list'('{$id}', '{$job_title}', '{$qualify}');";
	        $query = "";
	        foreach ($arrDevice as $value) 
	        {
	            $query .= " SELECT '$value' AS label, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
	                        INNER JOIN $tblDevice t2 ON t1.device_type = t2.name
	                        WHERE 1 = 1
	                        AND t1.device_type = '$value'
	                        AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') = '$item->created_at'";

	            if($value != $arrDevice[array_key_last($arrDevice)])
	            {
	                $query .= " UNION ALL ";
	            }
	            else
	            {
	                $query .= ";";
	            }
	        }
	        $mTmp =  \DB::select($query);
	        foreach ($arrDevice as $key => $value) {
	            // echo("<pre>$key: $value</pre>");
	            $value = strtolower($value);
	            $value = str_replace(' ', '', $value);
	            $item->$value = ($mTmp[$key]->total) ? $mTmp[$key]->total : 0;
	        }
	    }

	    return $mTmpResult;
    }
}