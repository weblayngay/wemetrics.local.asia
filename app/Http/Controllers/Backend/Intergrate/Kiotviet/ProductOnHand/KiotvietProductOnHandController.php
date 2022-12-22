<?php

namespace App\Http\Controllers\Backend\Intergrate\Kiotviet\ProductOnHand;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Helpers\UrlHelper;
use App\Helpers\DateHelper;
use App\Helpers\ImageHelper;
use App\Helpers\ArrayHelper;
use App\Helpers\StringHelper;
use App\Helpers\CollectionPaginateHelper;
use App\Models\Image;
use App\Models\AdminUser;
use App\Models\AdminMenu;
use App\Http\Controllers\Backend\Intergrate\Kiotviet\Auth\KiotvietAuthController;
use App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\Children\getKiotvietBranchController;
use VienThuong\KiotVietClient;
use VienThuong\KiotVietClient\Model\ProductOnHand;
use VienThuong\KiotVietClient\Criteria\ProductOnHandCriteria;
use VienThuong\KiotVietClient\Resource\ProductOnHandResource;
use Vienthuong\KiotVietClient\Exception\KiotVietException;
use \stdClass;

class KiotvietProductOnHandController extends BaseController
{
    private $view = '.kiotvietproductonhand';
    private $model = 'kiotvietproductonhand';
    private $imageModel;
    private $adminUserModel;
    private $productOnHandModel;
    private $adminMenu;
    private $kiotvietAuth;
    private $getBranchCtrl;

    public function __construct()
    {
        $this->imageModel = new Image();
        $this->adminUserModel = new AdminUser();
        $this->adminMenuModel = new AdminMenu();
        $this->productOnHandModel = new ProductOnHand();
        $this->kiotvietAuth = new KiotvietAuthController();
        $this->getBranchCtrl = new getKiotvietBranchController();
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawProductOnHand()
    {
        $branch = (string) strip_tags(request()->post('branch', '%'));
        $toDate = (string) strip_tags(request()->post('toDate', date('Y-m-d')));
        $toDate = date("Y-m-d", strtotime($toDate) )."T".date( "H:i:s", strtotime($toDate));
        //
        $result = [];
        //
        $pageSize = KIOTVIET_DEFAULT_PAGESIZE;
        $client = $this->kiotvietAuth->doCreateClient();
        $productOnHandResource = new ProductOnHandResource($client);
        $productOnHand = new ProductOnHand();
        $criteria = new ProductOnHandCriteria($productOnHand);
        //
        $criteria->setPageSize($pageSize);
        $criteria->setLastModifiedFrom($toDate);
        $criteria->setOrderBy('createdDate');
        $criteria->setOrderDirection('DESC');
        //
        if($branch != '%')
        {
            $criteria->setBranchIds($branch);
        }
        $productOnHands = $productOnHandResource->search($criteria);
        $total = $productOnHands->getTotal();

        for ($i = 0; $i < $total; $i = $i + $pageSize)
        {
            $criteria->setCurrentItem($i);
            $productOnHands = $productOnHandResource->search($criteria)->all();
            //
            foreach($productOnHands as $key => $item)
            {
                $inventories = $item->getInventories();
                $productCode = $item->getCode();
                $createdDate = DateHelper::getDate('Y-m-d', $item->getCreatedDate());
                foreach ($inventories as $key2 => $item2) {
                    if($item2['onHand'] > 0)
                    {
                        $item2['productCode'] = $productCode;
                        $item2['createdDate'] = $createdDate;
                        $result[($item->getId() * 100) + $key2] = $item2;
                    }
                }
            }
        }
        $result = collect($result);

        dd($result);
    }
}