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
use App\Helpers\CollectionPaginateHelper;
use App\Models\AdminUser;
use DB;
use App\Http\Controllers\Backend\Campaign\Report\Children\getRangeDateController;

class getTotalVoucherController extends BaseController
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
    public function doGetTotalVoucher($voucherGroup = '0')
    {
        $tblVoucher = 'vouchers';

        if($voucherGroup != '0')
        {
		    $query = "  SELECT IFNULL(t1.voucher_group, '') AS voucher_group, COUNT(IFNULL(t1.voucher_code, '')) AS total
						FROM $tblVoucher t1
						WHERE t1.voucher_group = '$voucherGroup'
						GROUP BY t1.voucher_group;";
        }
        else
        {
		    $query = "  SELECT 'Unknown' AS voucher_group, 0 AS total;";
        }

        $mTmpResult =  \DB::select($query);

	    return $mTmpResult;
    }
}