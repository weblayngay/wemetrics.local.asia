<?php

namespace App\Http\Controllers\Backend\Order\Report\Children;

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

class getRangeDateController extends BaseController
{
    /**
     * @return Application|Factory|View
     */
    public function doQuery($frmDate = '', $toDate = '')
    {
        $query = "  WITH recursive Date_Ranges AS (
                       SELECT :frmDate as created_at
                       UNION ALL
                       SELECT created_at + interval 1 day
                       FROM Date_Ranges
                       WHERE created_at < :toDate)
                    SELECT created_at FROM Date_Ranges";
        $args = ['frmDate' => $frmDate, 'toDate' => $toDate];
        $result = \DB::select($query, $args);
        return $result;
    }
}