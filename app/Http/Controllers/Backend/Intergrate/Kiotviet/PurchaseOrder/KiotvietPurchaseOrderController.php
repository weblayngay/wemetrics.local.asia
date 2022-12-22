<?php

namespace App\Http\Controllers\Backend\Intergrate\Kiotviet\PurchaseOrder;

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
use VienThuong\KiotVietClient\Model\PurchaseOrder;
use VienThuong\KiotVietClient\Criteria\PurchaseOrderCriteria;
use VienThuong\KiotVietClient\Resource\PurchaseOrderResource;
use Vienthuong\KiotVietClient\Exception\KiotVietException;
use \stdClass;

class KiotvietPurchaseOrderController extends BaseController
{
    private $view = '.kiotvietpurchaseorder';
    private $model = 'kiotvietpurchaseorder';
    private $imageModel;
    private $adminUserModel;
    private $purchaseOrderModel;
    private $adminMenu;
    private $kiotvietAuth;
    private $getBranchCtrl;

    public function __construct()
    {
        $this->imageModel = new Image();
        $this->adminUserModel = new AdminUser();
        $this->adminMenuModel = new AdminMenu();
        $this->purchaseOrderModel = new PurchaseOrder();
        $this->kiotvietAuth = new KiotvietAuthController();
        $this->getBranchCtrl = new getKiotvietBranchController();
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawLastPurchaseOrder()
    {
        $branch = (string) strip_tags(request()->post('branch', '%')); 
        $pageSize = KIOTVIET_DEFAULT_PAGESIZE;
        $incPayment = 1;
        $incDelivery = 1;
        $client = $this->kiotvietAuth->doCreateClient();
        $purchaseOrderResource = new PurchaseOrderResource($client);
        $purchaseOrder = new PurchaseOrder();
        $criteria = new PurchaseOrderCriteria($purchaseOrder);
        //
        $criteria->setPageSize($pageSize);
        $criteria->setIncludeOrderDelivery($incDelivery);
        $criteria->setIncludePayment($incPayment);
        $criteria->setOrderBy('createdDate');
        $criteria->setOrderDirection('DESC');
        //
        if($branch != '%')
        {
            $criteria->setBranchIds($branch);
        }
        $purchaseOrders = $purchaseOrderResource->search($criteria)->last();

        dd($purchaseOrders);
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawPurchaseOrder()
    {
        $branch = (string) strip_tags(request()->post('branch', '%')); 
        $pageSize = KIOTVIET_DEFAULT_PAGESIZE;
        $incPayment = 1;
        $incDelivery = 1;
        $client = $this->kiotvietAuth->doCreateClient();
        $purchaseOrderResource = new PurchaseOrderResource($client);
        $purchaseOrder = new PurchaseOrder();
        $criteria = new PurchaseOrderCriteria($purchaseOrder);
        //
        $criteria->setPageSize($pageSize);
        $criteria->setIncludeOrderDelivery($incDelivery);
        $criteria->setIncludePayment($incPayment);
        $criteria->setOrderBy('createdDate');
        $criteria->setOrderDirection('DESC');
        //
        if($branch != '%')
        {
            $criteria->setBranchIds($branch);
        }
        $purchaseOrders = $purchaseOrderResource->search($criteria)->all();

        dd($purchaseOrders);
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawPurchaseOrderByDate()
    {
        $branch = (string) strip_tags(request()->post('branch', '%'));
        $frmDate = (string) strip_tags(request()->post('frmDate', date('Y-m-01')));
        $toDate = (string) strip_tags(request()->post('toDate', date('Y-m-d')));
        // 
        $pageSize = KIOTVIET_DEFAULT_PAGESIZE;
        $incPayment = 1;
        $incDelivery = 1;
        $client = $this->kiotvietAuth->doCreateClient();
        $purchaseOrderResource = new PurchaseOrderResource($client);
        $purchaseOrder = new PurchaseOrder();
        $criteria = new PurchaseOrderCriteria($purchaseOrder);
        //
        $criteria->setPageSize($pageSize);
        $criteria->setIncludeOrderDelivery($incDelivery);
        $criteria->setIncludePayment($incPayment);
        $criteria->setOrderBy('createdDate');
        $criteria->setOrderDirection('DESC');
        //
        if($branch != '%')
        {
            $criteria->setBranchIds($branch);
        }
        $purchaseOrders = $purchaseOrderResource->search($criteria);
        //
        $total = $purchaseOrders->getTotal();
        $purchaseOrdersArr = [];
        //
        for ($i = 0; $i < $total; $i = $i + $pageSize) 
        {
            $criteria->setCurrentItem($i);
            $purchaseOrders = $purchaseOrderResource->search($criteria);
            //
            foreach ($purchaseOrders as $key => $item) 
            {
                $createdDate = DateHelper::getDate('Y-m-d', $item->getCreatedDate());
                //
                if($createdDate >= $frmDate && $createdDate <= $toDate)
                {
                    $purchaseOrdersArr[$key] = $item;
                }
            }
        }

        $result = collect($purchaseOrdersArr);

        dd($result);
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawPurchaseOrderByProductByDate()
    {
        $branch = (string) strip_tags(request()->post('branch', '%'));
        $productCode = (string) strip_tags(request()->post('productCode', '%'));
        $frmDate = (string) strip_tags(request()->post('frmDate', date('Y-m-01')));
        $toDate = (string) strip_tags(request()->post('toDate', date('Y-m-d')));
        // 
        $pageSize = KIOTVIET_DEFAULT_PAGESIZE;
        $incPayment = 1;
        $incDelivery = 1;
        $client = $this->kiotvietAuth->doCreateClient();
        $purchaseOrderResource = new PurchaseOrderResource($client);
        $purchaseOrder = new PurchaseOrder();
        $criteria = new PurchaseOrderCriteria($purchaseOrder);
        //
        $criteria->setPageSize($pageSize);
        $criteria->setIncludeOrderDelivery($incDelivery);
        $criteria->setIncludePayment($incPayment);
        $criteria->setOrderBy('createdDate');
        $criteria->setOrderDirection('DESC');
        //
        if($branch != '%')
        {
            $criteria->setBranchIds($branch);
        }
        $purchaseOrders = $purchaseOrderResource->search($criteria);
        //
        $total = $purchaseOrders->getTotal();
        $purchaseOrdersArr = [];
        //
        for ($i = 0; $i < $total; $i = $i + $pageSize) 
        {
            $criteria->setCurrentItem($i);
            $purchaseOrders = $purchaseOrderResource->search($criteria);
            //
            foreach ($purchaseOrders as $key => $item) 
            {
                $createdDate = DateHelper::getDate('Y-m-d', $item->getCreatedDate());
                $status = $item->getStatus();
                //
                if($createdDate >= $frmDate && $createdDate <= $toDate)
                {
                    $otherProperties = (object) $item->getOtherProperties();
                    if(!empty($otherProperties))
                    {
                        $purchaseOrderDetails = (object) $otherProperties->purchaseOrderDetails;
                        if(!empty($purchaseOrderDetails))
                        {
                            foreach ($purchaseOrderDetails as $key2 => $item2) 
                            {
                                $item2 = (object) $item2;
                                if($item2->productCode == $productCode || $productCode == '%')
                                {
                                    $item2->branchId = $otherProperties->branchId;
                                    $item2->branchName = $otherProperties->branchName;
                                    $item2->createdDate = $createdDate;
                                    $item2->status = $status;
                                    $purchaseOrdersArr[$key] = $item2;
                                }
                            }
                        }
                    }
                }
            }
        }

        $purchaseOrdersArr = collect($purchaseOrdersArr);

        $result = $purchaseOrdersArr->groupBy('branchId')
                            ->map(function ($item) {
                                return (object) [
                                    'branchId' => $item->max('branchId'),
                                    'productCode' => $item->max('productCode'),
                                    'quantity' => $item->sum('quantity'),
                                ];
                            })->sortBy([
                                ['branchId', 'asc'],
                            ]);

        dd($result);
    }
}