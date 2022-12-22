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
use DB;

class getAffiliateController extends BaseController
{
    /**
     * @return Application|Factory|View
     */
    public function doQuery($affiliate = '%')
    {
      $query = DB::table(TS_AFFILIATES. " AS t1")
              ->selectRaw("t1.id, UPPER(t1.name) AS name, t1.username, t1.email, t1.phone")
              ->whereRaw("t1.enable = 1")
              ->whereRaw("t1.id LIKE CASE WHEN '".$affiliate."' = '%' THEN '%' ELSE '".$affiliate."' END")
              ->orderByRaw("t1.id DESC");

      $result = $query->get();

      return $result;
    }
}