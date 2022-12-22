<?php

namespace App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\Children;

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
use App\Http\Controllers\Backend\Intergrate\Kiotviet\Auth\KiotvietAuthController;
use VienThuong\KiotVietClient;
use VienThuong\KiotVietClient\Model\Branch;
use VienThuong\KiotVietClient\Criteria\BranchCriteria;
use VienThuong\KiotVietClient\Resource\BranchResource;
use Vienthuong\KiotVietClient\Exception\KiotVietException;

class getKiotvietBranchController extends BaseController
{
    private $branchModel;

    public function __construct()
    {
        $this->branchModel = new Branch();
        $this->kiotvietAuth = new KiotvietAuthController();
    }

    /**
     * @return Application|Factory|View
     */
    public function doQuery($branch = '%')
    {
      $pageSize = KIOTVIET_DEFAULT_PAGESIZE;
      $client = $this->kiotvietAuth->doCreateClient();

      $customResource = new KiotVietClient\Resource\CustomResource($client);
      $customresponse = $customResource
          ->setExpectedModel(KiotVietClient\Model\Branch::class)
          ->setCollectionClass(KiotVietClient\Collection\BranchCollection::class)
          ->setEndPoint(KiotVietClient\Endpoint::BRANCH_ENDPOINT);
      //
      $branch = new Branch();
      $criteria = new BranchCriteria($branch);
      $criteria->setPageSize($pageSize);
      //
      $branchs = $customresponse->search($criteria);

      $result = $branchs;

      return $result;
    }
}