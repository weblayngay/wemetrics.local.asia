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

class getTrafficSourceController extends BaseController
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
    public function doGetTrafficSource($frmDate = '', $toDate = '', $mSource = '%')
    {
        $tblTrafficOrganic = 'client_tracking_traffic_details';
	    $tblReferer = 'client_tracking_referer';

	    $lbGoogleSearch = 'Google Search';
	    $iconGoogleSearch = 'google.png';
	    //
	    $lbFacebookMsg = 'Facebook Messenger';
	    $iconFacebookMsg = 'facebook-messenger.png';
	    //
	    $lbFacebookPost = 'Facebook Post';
	    $iconFacebookPost = 'facebook-fanpage.png';
	    //
	    $lbInstagramMsg = 'Instagram Messenger';
	    $iconInstagramMsg = 'instagram-messenger.png';
	    //
	    $lbInstagramPost = 'Instagram Post';
	    $iconInstagramPost = 'instagram-fanpage.png';
	    //
	    $lbBing = 'Bing';
	    $iconBing = 'bing.png';
	    //
	    $lbCocCoc = 'CocCoc';
	    $iconCocCoc = 'coccoc.png';
	    //
	    $lbTiktok = 'Tiktok';
	    $iconTiktok = 'tiktok.png';
	    //
	    $lbZaloMsg = 'Zalo Messenger';
	    $iconZaloMsg = 'zalo.png';
	    //
	    $lbReferral = 'Referral';
	    $iconReferral = 'referral.png';
	    //
	    $lbDirect = 'Direct';
	    $iconDirect = 'direct.png';

	    $args = [	'lbGoogleSearch' => $lbGoogleSearch, 
	    			'iconGoogleSearch' => $iconGoogleSearch, 
	    			'lbBing' => $lbBing, 
	    			'iconBing' => $iconBing, 
	    			'lbCocCoc' => $lbCocCoc,
	    			'iconCocCoc' => $iconCocCoc,
	    			'lbTiktok' => $lbTiktok,
	    			'iconTiktok' => $iconTiktok,
	    			'lbFacebookMsg' => $lbFacebookMsg,
	    			'iconFacebookMsg' => $iconFacebookMsg,
	    			'lbFacebookPost' => $lbFacebookPost,
	    			'iconFacebookPost' => $iconFacebookPost,
	    			'lbInstagramMsg' => $lbInstagramMsg,
	    			'iconInstagramMsg' => $iconInstagramMsg,
	    			'lbInstagramPost' => $lbInstagramPost,
	    			'iconInstagramPost' => $iconInstagramPost,
	    			'lbZaloMsg' => $lbZaloMsg,
	    			'iconZaloMsg' => $iconZaloMsg,
	    			'lbReferral' => $lbReferral,
	    			'iconReferral' => $iconReferral,
	    			'lbDirect' => $lbDirect,
	    			'iconDirect' => $iconDirect
	    		];

	    $query = "SELECT :lbGoogleSearch AS label, :iconGoogleSearch AS icon, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
	                INNER JOIN $tblReferer t2 ON t2.type = 'external'
	                AND t2.category = 'search' 
	                AND t2.provider = 'google' 
	                AND LOCATE(t2.referral, t1.referer) > 0
	                WHERE 1=1
	                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') BETWEEN '$frmDate' AND '$toDate'
	                GROUP BY label, icon

	                UNION ALL

	                SELECT :lbBing AS label, :iconBing AS icon, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
	                INNER JOIN $tblReferer t2 ON t2.type = 'external'
	                AND t2.category = 'search' 
	                AND t2.provider = 'bing' 
	                AND LOCATE(t2.referral, t1.referer) > 0
	                WHERE 1=1
	                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') BETWEEN '$frmDate' AND '$toDate'
	                GROUP BY label, icon

	                UNION ALL

	                SELECT :lbCocCoc AS label, :iconCocCoc AS icon, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
	                INNER JOIN {$tblReferer} t2 ON t2.type = 'external'
	                AND t2.category = 'search' 
	                AND t2.provider = 'coccoc' 
	                AND LOCATE(t2.referral, t1.referer) > 0
	                WHERE 1=1
	                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') BETWEEN '$frmDate' AND '$toDate'
	                GROUP BY label, icon

	                UNION ALL

	                SELECT :lbTiktok AS label, :iconTiktok AS icon, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
	                INNER JOIN {$tblReferer} t2 ON t2.type = 'external'
	                AND t2.category = 'ads' 
	                AND t2.provider = 'tiktok' 
	                AND LOCATE(t2.referral, t1.referer) > 0
	                WHERE 1=1
	                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') BETWEEN '$frmDate' AND '$toDate'
	                GROUP BY label, icon

	                UNION ALL

	                SELECT :lbFacebookMsg AS label, :iconFacebookMsg AS icon, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
	                INNER JOIN {$tblReferer} t2 ON t2.type = 'external'
	                AND t2.category = 'messenger' 
	                AND t2.provider = 'facebook' 
	                AND LOCATE(t2.referral, t1.referer) > 0
	                WHERE 1=1
	                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') BETWEEN '$frmDate' AND '$toDate'
	                GROUP BY label, icon

	                UNION ALL

	                SELECT :lbFacebookPost AS label, :iconFacebookPost AS icon, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
	                INNER JOIN {$tblReferer} t2 ON t2.type = 'external'
	                AND t2.category = 'post' 
	                AND t2.provider = 'facebook' 
	                AND LOCATE(t2.referral, t1.referer) > 0
	                WHERE 1=1
	                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') BETWEEN '$frmDate' AND '$toDate'
	                GROUP BY label, icon

	                UNION ALL

	                SELECT :lbInstagramMsg AS label, :iconInstagramMsg AS icon, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
	                INNER JOIN {$tblReferer} t2 ON t2.type = 'external'
	                AND t2.category = 'messenger' 
	                AND t2.provider = 'instagram' 
	                AND LOCATE(t2.referral, t1.referer) > 0
	                WHERE 1=1
	                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') BETWEEN '$frmDate' AND '$toDate'
	                GROUP BY label, icon

	                UNION ALL

	                SELECT :lbInstagramPost AS label, :iconInstagramPost AS icon, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
	                INNER JOIN {$tblReferer} t2 ON t2.type = 'external'
	                AND t2.category = 'post' 
	                AND t2.provider = 'facebook' 
	                AND LOCATE(t2.referral, t1.referer) > 0
	                WHERE 1=1
	                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') BETWEEN '$frmDate' AND '$toDate'
	                GROUP BY label, icon

	                UNION ALL

	                SELECT :lbZaloMsg AS label, :iconZaloMsg AS icon, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
	                INNER JOIN {$tblReferer} t2 ON t2.type = 'external'
	                AND t2.category = 'messenger' 
	                AND t2.provider = 'zalo' 
	                AND LOCATE(t2.referral, t1.referer) > 0
	                WHERE 1=1
	                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') BETWEEN '$frmDate' AND '$toDate'
	                GROUP BY label, icon

	                UNION ALL

	                SELECT :lbReferral AS label, :iconReferral AS icon, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
	                INNER JOIN {$tblReferer} t2 ON t2.type = 'internal' 
	                AND LOCATE(t2.referral, t1.referer) > 0
	                WHERE 1=1
	                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') BETWEEN '$frmDate' AND '$toDate'
	                GROUP BY label, icon

	                UNION ALL

	                SELECT :lbDirect AS label, :iconDirect AS icon, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
	                WHERE 1=1
	                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') BETWEEN '$frmDate' AND '$toDate'
	                AND t1.referer = ''
	                GROUP BY label, icon;";

        $mTmpResult =  \DB::select($query, $args);

	    foreach ($mTmpResult as $key => $item) {
	        if($item->label != $mSource && $mSource != '%')
	        {
	            unset($mTmpResult[$key]);
	        }
	    }

	    return $mTmpResult;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTrafficSourceByDate($frmDate = '', $toDate = '', $mSource = '%')
    {
        $tblTrafficOrganic = 'client_tracking_traffic_details';
	    $tblReferer = 'client_tracking_referer';

	    $lbGoogleSearch = 'Google Search';
	    $iconGoogleSearch = 'google.png';
	    //
	    $lbFacebookMsg = 'Facebook Messenger';
	    $iconFacebookMsg = 'facebook-messenger.png';
	    //
	    $lbFacebookPost = 'Facebook Post';
	    $iconFacebookPost = 'facebook-fanpage.png';
	    //
	    $lbInstagramMsg = 'Instagram Messenger';
	    $iconInstagramMsg = 'instagram-messenger.png';
	    //
	    $lbInstagramPost = 'Instagram Post';
	    $iconInstagramPost = 'instagram-fanpage.png';
	    //
	    $lbBing = 'Bing';
	    $iconBing = 'bing.png';
	    //
	    $lbCocCoc = 'CocCoc';
	    $iconCocCoc = 'coccoc.png';
	    //
	    $lbTiktok = 'Tiktok';
	    $iconTiktok = 'tiktok.png';
	    //
	    $lbZaloMsg = 'Zalo Messenger';
	    $iconZaloMsg = 'zalo.png';
	    //
	    $lbReferral = 'Referral';
	    $iconReferral = 'referral.png';
	    //
	    $lbDirect = 'Direct';
	    $iconDirect = 'direct.png';

    	$mTmpResult = $this->getRangeDateCtrl->doQuery($frmDate, $toDate);

	    $args = [	'lbGoogleSearch' => $lbGoogleSearch, 
	    			'lbBing' => $lbBing, 
	    			'lbCocCoc' => $lbCocCoc,
	    			'lbTiktok' => $lbTiktok,
	    			'lbFacebookMsg' => $lbFacebookMsg,
	    			'lbFacebookPost' => $lbFacebookPost,
	    			'lbInstagramMsg' => $lbInstagramMsg,
	    			'lbInstagramPost' => $lbInstagramPost,
	    			'lbZaloMsg' => $lbZaloMsg,
	    			'lbReferral' => $lbReferral,
	    			'lbDirect' => $lbDirect,
	    		];

	    foreach ($mTmpResult as $key => $item) {

		    $query = "SELECT :lbGoogleSearch AS label, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
		                INNER JOIN $tblReferer t2 ON t2.type = 'external'
		                AND t2.category = 'search' 
		                AND t2.provider = 'google' 
		                AND LOCATE(t2.referral, t1.referer) > 0
		                WHERE 1=1
		                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') = '{$item->created_at}'

		                UNION ALL

		                SELECT :lbBing AS label, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
		                INNER JOIN $tblReferer t2 ON t2.type = 'external'
		                AND t2.category = 'search' 
		                AND t2.provider = 'bing' 
		                AND LOCATE(t2.referral, t1.referer) > 0
		                WHERE 1=1
						AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') = '{$item->created_at}'

		                UNION ALL

		                SELECT :lbCocCoc AS label, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
		                INNER JOIN {$tblReferer} t2 ON t2.type = 'external'
		                AND t2.category = 'search' 
		                AND t2.provider = 'coccoc' 
		                AND LOCATE(t2.referral, t1.referer) > 0
		                WHERE 1=1
		                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') = '{$item->created_at}'

		                UNION ALL

		                SELECT :lbTiktok AS label, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
		                INNER JOIN {$tblReferer} t2 ON t2.type = 'external'
		                AND t2.category = 'ads' 
		                AND t2.provider = 'tiktok' 
		                AND LOCATE(t2.referral, t1.referer) > 0
		                WHERE 1=1
		                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') = '{$item->created_at}'

		                UNION ALL

		                SELECT :lbFacebookMsg AS label, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
		                INNER JOIN {$tblReferer} t2 ON t2.type = 'external'
		                AND t2.category = 'messenger' 
		                AND t2.provider = 'facebook' 
		                AND LOCATE(t2.referral, t1.referer) > 0
		                WHERE 1=1
		                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') = '{$item->created_at}'

		                UNION ALL

		                SELECT :lbFacebookPost AS label, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
		                INNER JOIN {$tblReferer} t2 ON t2.type = 'external'
		                AND t2.category = 'post' 
		                AND t2.provider = 'facebook' 
		                AND LOCATE(t2.referral, t1.referer) > 0
		                WHERE 1=1
		                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') = '{$item->created_at}'

		                UNION ALL

		                SELECT :lbInstagramMsg AS label, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
		                INNER JOIN {$tblReferer} t2 ON t2.type = 'external'
		                AND t2.category = 'messenger' 
		                AND t2.provider = 'instagram' 
		                AND LOCATE(t2.referral, t1.referer) > 0
		                WHERE 1=1
		                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') = '{$item->created_at}'

		                UNION ALL

		                SELECT :lbInstagramPost AS label, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
		                INNER JOIN {$tblReferer} t2 ON t2.type = 'external'
		                AND t2.category = 'post' 
		                AND t2.provider = 'facebook' 
		                AND LOCATE(t2.referral, t1.referer) > 0
		                WHERE 1=1
		                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') = '{$item->created_at}'

		                UNION ALL

		                SELECT :lbZaloMsg AS label, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
		                INNER JOIN {$tblReferer} t2 ON t2.type = 'external'
		                AND t2.category = 'messenger' 
		                AND t2.provider = 'zalo' 
		                AND LOCATE(t2.referral, t1.referer) > 0
		                WHERE 1=1
		                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') = '{$item->created_at}'

		                UNION ALL

		                SELECT :lbReferral AS label, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
		                INNER JOIN {$tblReferer} t2 ON t2.type = 'internal' 
		                AND LOCATE(t2.referral, t1.referer) > 0
		                WHERE 1=1
		                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') = '{$item->created_at}'

		                UNION ALL

		                SELECT :lbDirect AS label, SUM(IFNULL(t1.views, 0)) AS total FROM $tblTrafficOrganic AS t1
		                WHERE 1=1
		                AND DATE_FORMAT(DATE(t1.created_at), '%Y-%m-%d') = '{$item->created_at}'
		                AND t1.referer = '';";

        	$mTmp =  \DB::select($query, $args);
	        $item->google_search = ($mTmp[0]->total) ? $mTmp[0]->total : 0;
	        $item->bing = ($mTmp[1]->total) ? $mTmp[1]->total : 0;
	        $item->coccoc = ($mTmp[2]->total) ? $mTmp[2]->total : 0;
	        $item->tiktok = ($mTmp[3]->total) ? $mTmp[3]->total : 0;
	        $item->facebook_messenger = ($mTmp[4]->total) ? $mTmp[4]->total : 0;
	        $item->facebook_post = ($mTmp[5]->total) ? $mTmp[5]->total : 0;
	        $item->instagram_messenger = ($mTmp[6]->total) ? $mTmp[6]->total : 0;
	        $item->instagram_post = ($mTmp[7]->total) ? $mTmp[7]->total : 0;
	        $item->zalo_messenger = ($mTmp[8]->total) ? $mTmp[8]->total : 0;
	        $item->referral = ($mTmp[9]->total) ? $mTmp[9]->total : 0;
	        $item->direct = ($mTmp[10]->total) ? $mTmp[10]->total : 0;
	    }

	    return $mTmpResult;
    }
}