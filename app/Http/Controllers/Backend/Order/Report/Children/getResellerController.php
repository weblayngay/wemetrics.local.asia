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
use App\Helpers\StringHelper;
use App\Helpers\CollectionPaginateHelper;
use App\Models\AdminUser;
use DB;

class getResellerController extends BaseController
{
    /**
     * @return Application|Factory|View
     */
    public function doQuery($reseller = '%')
    {
      $query = DB::table(LT4_RESELLER. " AS t1")
              ->selectRaw("t1.id, t1.kv_rid, t1.aff_rid, t1.name AS reseller, t1.enable")
              ->whereRaw("t1.enable = 1")
              ->whereRaw("t1.id LIKE CASE WHEN '".$reseller."' = '%' THEN '%' ELSE '".$reseller."' END")
              ->orderByRaw("t1.id DESc");

      $result = $query->get();

      return $result;
    }
}