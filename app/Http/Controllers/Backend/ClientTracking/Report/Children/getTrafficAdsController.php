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

class getTrafficAdsController extends BaseController
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
    public function doGetTrafficAds($frmDate = '', $toDate = '', $mAds = '%')
    {
        $tblTrafficAds = 'client_tracking_traffic_ads';
	    $tblUtmSource = 'client_tracking_utm_source';

	    $query = "  SELECT CONCAT(UCASE(SUBSTRING(t1.utm_source, 1, 1)), LOWER(SUBSTRING(t1.utm_source, 2))) AS label, t2.icon AS icon, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficAds AS t1
	                INNER JOIN $tblUtmSource t2 ON t1.utm_source = t2.name
	                WHERE 1 = 1
	                AND t1.utm_source IS NOT NULL
	                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') BETWEEN :frmDate AND :toDate
	                GROUP BY label, icon;";

        $args = ['frmDate' => $frmDate, 'toDate' => $toDate];
        $mTmpResult =  \DB::select($query, $args);

	    foreach ($mTmpResult as $key => $item) {
	        if($item->label != $mAds && $mAds != '%')
	        {
	            unset($mTmpResult[$key]);
	        }
	    }

	    return $mTmpResult;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTrafficAdsByDate($frmDate = '', $toDate = '', $mAds = '%')
    {
        $tblTrafficAds = 'client_tracking_traffic_ads';
	    $tblUtmSource = 'client_tracking_utm_source';
	    $query = " SELECT name FROM $tblUtmSource WHERE status = 'activated';";
	    $mTmpUtmSource = \DB::select($query);
	    $arrUtmSource = array();
	    foreach ($mTmpUtmSource as $key => $item) {
	       $arrUtmSource[$key] = $item->name;
	    }
	    // $arrUtmSource = ['zalo', 'google', 'facebook', 'twitter', 'instagram', 'pinterest', 'tiktok', 'coccoc', 'bing', 'mailchimp', 'youtube', 'tumblr'];

	    $mTmpResult = $this->getRangeDateCtrl->doQuery($frmDate, $toDate);

	    foreach ($mTmpResult as $key => $item) {
	        // $query = "CALL 'sp_job_list'('{$id}', '{$job_title}', '{$qualify}');";
	        $query = "";
	        foreach($arrUtmSource as $value)
	        {
	            $query .= " SELECT CONCAT(UCASE(SUBSTRING('$value', 1, 1)), LOWER(SUBSTRING('$value', 2))) AS label, SUM(IFNULL(t1.views, 0)) AS total 
	                        FROM $tblTrafficAds AS t1
	                        INNER JOIN $tblUtmSource t2 ON t1.utm_source = t2.name
	                        WHERE 1 = 1
	                        AND t1.utm_source = '$value'
	                        AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') = '$item->created_at'";
	            if($value != $arrUtmSource[array_key_last($arrUtmSource)])
	            {
	                $query .= " UNION ALL ";
	            }
	            else
	            {
	                $query .= ";";
	            }
	        }
	        $mTmp =  \DB::select($query);
	        foreach ($arrUtmSource as $key => $value) {
	            // echo("<pre>$key: $value</pre>");
	            $item->$value = ($mTmp[$key]->total) ? $mTmp[$key]->total : 0;
	        }
	    }

	    return $mTmpResult;
    }
}