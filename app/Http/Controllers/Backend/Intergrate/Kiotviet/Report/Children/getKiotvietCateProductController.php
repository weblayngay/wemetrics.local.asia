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
use VienThuong\KiotVietClient\Model\Category;
use VienThuong\KiotVietClient\Criteria\CategoryCriteria;
use VienThuong\KiotVietClient\Resource\CategoryResource;
use Vienthuong\KiotVietClient\Exception\KiotVietException;

class getKiotvietCateProductController extends BaseController
{
    private $categoryProductModel;

    public function __construct()
    {
        $this->categoryProductModel = new Category();
        $this->kiotvietAuth = new KiotvietAuthController();
    }

    /**
     * @return Application|Factory|View
     */
    public function doQuery($categoryProduct = '%')
    {
      $pageSize = KIOTVIET_DEFAULT_PAGESIZE;
      $client = $this->kiotvietAuth->doCreateClient();

      $customResource = new KiotVietClient\Resource\CustomResource($client);
      $customresponse = $customResource
          ->setExpectedModel(KiotVietClient\Model\Category::class)
          ->setCollectionClass(KiotVietClient\Collection\CategoryCollection::class)
          ->setEndPoint(KiotVietClient\Endpoint::CATEGORY_ENDPOINT);
      //
      $cateProduct = new Category();
      $criteria = new CategoryCriteria($cateProduct);
      $criteria->setPageSize($pageSize);
      //
      $cateProducts = $customresponse->search($criteria);

      $result = $cateProducts;

      return $result;
    }
}