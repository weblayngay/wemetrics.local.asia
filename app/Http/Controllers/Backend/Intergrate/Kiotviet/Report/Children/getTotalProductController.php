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
use App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\Children\getRangeDateController;
use App\Http\Controllers\Backend\Intergrate\Kiotviet\Auth\KiotvietAuthController;
use VienThuong\KiotVietClient;
use VienThuong\KiotVietClient\Model\Product;
use VienThuong\KiotVietClient\Criteria\ProductCriteria;
use VienThuong\KiotVietClient\Resource\ProductResource;
//
use VienThuong\KiotVietClient\Model\Invoice;
use VienThuong\KiotVietClient\Model\InvoiceDetail;
use VienThuong\KiotVietClient\Criteria\InvoiceCriteria;
use VienThuong\KiotVietClient\Criteria\InvoiceDetailCriteria;
use VienThuong\KiotVietClient\Resource\InvoiceResource;
use VienThuong\KiotVietClient\Resource\InvoiceDetailResource;
use Vienthuong\KiotVietClient\Exception\KiotVietException;
//
use App\Models\Websites\W0001\lt4Products;
//
use VienThuong\KiotVietClient\Model\PurchaseOrder;
use VienThuong\KiotVietClient\Criteria\PurchaseOrderCriteria;
use VienThuong\KiotVietClient\Resource\PurchaseOrderResource;

class getTotalProductController extends BaseController
{
    private $productModel;
    private $invoiceModel;
    private $invoiceDetailModel;
    private $getRangeDateCtrl;
    private $lt4ProductModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->invoiceModel = new Invoice();
        $this->invoiceDetailModel = new InvoiceDetail();
        $this->kiotvietAuth = new KiotvietAuthController();
        $this->getRangeDateCtrl = new getRangeDateController();
        $this->lt4ProductModel = new lt4Products();
    }

    /**
     * @return Application|Factory|View
     */
    public function getListProduct()
    {
        $result = $this->lt4ProductModel::from(LT4_PRODUCTS. " AS t1")
                ->selectRaw('TRIM(t1.code) AS code, t1.name')
                ->IsNotGift()
                ->IsEnabled()
                ->get();

        // dd($result);

        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function getTotalProduct($isActive = true)
    {
        $client = $this->kiotvietAuth->doCreateClient();
        $productResource = new ProductResource($client);
        $product = new Product();
        $product->setProductType(Product::PRODUCT_TYPE_NORMAL);
        //
        $criteria = new ProductCriteria($product);
        $criteria->setPageSize(1);
        $criteria->addCriteria('name', $product->getName());
        $criteria->addCriteria('isActive', true);
        //
        $product = $productResource->search($criteria);
        //
        $result = $product->getTotal();
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetProduct($frmDate = '', $toDate = '', $branch = '%', $code = '%', $cateProduct = '%')
    {
        $findProductCode = $code;
        $client = $this->kiotvietAuth->doCreateClient();
        $incDelivery = KIOTVIET_INC_DELIVERY;
        $incPayment = KIOTVIET_INC_PAYMENT;
        $pageSize = KIOTVIET_DEFAULT_PAGESIZE;

        $invoiceResource = new InvoiceResource($client);
        $invoice = new Invoice();
        $criteria = new InvoiceCriteria($invoice);
        //
        $criteria->setPageSize($pageSize);
        $criteria->setFromPurchaseDate($frmDate);
        $criteria->setToPurchaseDate($toDate);
        $criteria->setIncludeOrderDelivery($incDelivery);
        $criteria->setIncludePayment($incPayment);
        $criteria->setStatus($this->invoiceModel::STATUSES['COMPLETED']);
        //
        if($branch != '%')
        {
            $criteria->setBranchIds($branch);
        }

        $invoices = $invoiceResource->search($criteria);
        //
        if(!empty($findProductCode))
        {
            $total = $invoices->getTotal();
        }
        else
        {
            $total = 1;
        }
        // /
        $products = array();

        for ($i = 0; $i < $total; $i = $i + $pageSize) 
        {
            $criteria->setCurrentItem($i);
            $invoices = $invoiceResource->search($criteria);
            //
            $invoiceItems = $invoices->getItems();
            //
            foreach ($invoiceItems as $key => $item)
            {
                $invoiceDetails = $item->getInvoiceDetails();
                $purchaseDate = DateHelper::getDate('Y-m-d', $item->getPurchaseDate());
                $status = $item->getStatus();
                $branchId = $item->getBranchId();
                $branchName = $item->getBranchName();
                if($status != '2')
                {
                    foreach ($invoiceDetails as $key2 => $item2) 
                    {
                        //
                        $item2['purchaseDate'] = $purchaseDate;
                        $item2['status'] = $status;
                        $item2['branchId'] = $branchId;
                        $item2['branchName'] = $branchName;
                        //
                        $productCode = ($item2['productCode']) ? $item2['productCode'] : null;
                        //
                        if(!empty($productCode) && $productCode == $findProductCode)
                        {
                            if($cateProduct == '%')
                            {
                                $findstr = substr($productCode, 0, 2);
                                if(array_key_exists($findstr, $this->productModel::PRODUCT_CATE))
                                {
                                    $item2['productCateName'] = $this->productModel::PRODUCT_CATE[$findstr];
                                    $item2['productCateCode'] = $findstr;
                                }
                                else
                                {
                                    $item2['productCateName'] = 'Khác';
                                    $item2['productCateCode'] = 'KH';
                                }
                                $products[($item->getId() * 100) + $key2] = $item2;
                            }
                            // Cặp xách
                            if($cateProduct == 'CX')
                            {
                                $findstr = substr($productCode, 0, 2);
                                if(array_key_exists($findstr, $this->productModel::CATE_CAPXACH))
                                {
                                    $item2['productCateName'] = $this->productModel::CATE_CAPXACH[$findstr];
                                    $item2['productCateCode'] = $findstr;
                                    $products[($item->getId() * 100) + $key2] = $item2;
                                }
                            }
                            // Túi đeo
                            if($cateProduct == 'TD')
                            {
                                $findstr = substr($productCode, 0, 2);
                                if(array_key_exists($findstr, $this->productModel::CATE_TUIDEO))
                                {
                                    $item2['productCateName'] = $this->productModel::CATE_TUIDEO[$findstr];
                                    $item2['productCateCode'] = $findstr;
                                    $products[($item->getId() * 100) + $key2] = $item2;
                                }
                            }
                            // Túi quàng
                            if($cateProduct == 'TQ')
                            {
                                $findstr = substr($productCode, 0, 2);
                                if(array_key_exists($findstr, $this->productModel::CATE_TUIQUANG))
                                {
                                    $item2['productCateName'] = $this->productModel::CATE_TUIQUANG[$findstr];
                                    $item2['productCateCode'] = $findstr;
                                    $products[($item->getId() * 100) + $key2] = $item2;
                                }
                            }
                            // Túi xách
                            if($cateProduct == 'TX')
                            {
                                $findstr = substr($productCode, 0, 2);
                                if(array_key_exists($findstr, $this->productModel::CATE_TUIXACH))
                                {
                                    $item2['productCateName'] = $this->productModel::CATE_TUIXACH[$findstr];
                                    $item2['productCateCode'] = $findstr;
                                    $products[($item->getId() * 100) + $key2] = $item2;
                                }
                            }
                            // Bóp ví
                            if($cateProduct == 'VI')
                            {
                                $findstr = substr($productCode, 0, 2);
                                if(array_key_exists($findstr, $this->productModel::CATE_BOPVI))
                                {
                                    $item2['productCateName'] = $this->productModel::CATE_BOPVI[$findstr];
                                    $item2['productCateCode'] = $findstr;
                                    $products[($item->getId() * 100) + $key2] = $item2;
                                }
                            }
                            // BALO
                            if($cateProduct == 'BL')
                            {
                                $findstr = substr($productCode, 0, 2);
                                if(array_key_exists($findstr, $this->productModel::CATE_BALO))
                                {
                                    $item2['productCateName'] = $this->productModel::CATE_BALO[$findstr];
                                    $item2['productCateCode'] = $findstr;
                                    $products[($item->getId() * 100) + $key2] = $item2;
                                }
                            }
                            // Túi du lịch
                            if($cateProduct == 'DL')
                            {
                                $findstr = substr($productCode, 0, 2);
                                if(array_key_exists($findstr, $this->productModel::CATE_TUIDULICH))
                                {
                                    $item2['productCateName'] = $this->productModel::CATE_TUIDULICH[$findstr];
                                    $item2['productCateCode'] = $findstr;
                                    $products[($item->getId() * 100) + $key2] = $item2;
                                }
                            }
                            // Dây nịt
                            if($cateProduct == 'NI')
                            {
                                $findstr = substr($productCode, 0, 2);
                                if(array_key_exists($findstr, $this->productModel::CATE_DAYNIT))
                                {
                                    $item2['productCateName'] = $this->productModel::CATE_DAYNIT[$findstr];
                                    $item2['productCateCode'] = $findstr;
                                    $products[($item->getId() * 100) + $key2] = $item2;
                                }
                            }
                            // Phụ kiện
                            if($cateProduct == 'PK')
                            {
                                $findstr = substr($productCode, 0, 2);
                                if(array_key_exists($findstr, $this->productModel::CATE_PHUKIEN))
                                {
                                    $item2['productCateName'] = $this->productModel::CATE_PHUKIEN[$findstr];
                                    $item2['productCateCode'] = $findstr;
                                    $products[($item->getId() * 100) + $key2] = $item2;
                                }
                            }
                        }
                    }
                    // dd($products);
                }
            }
        }

        $result = collect($products);

        // dd($result);

        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalProductByDate($data)
    {
        // $groups will be a collection, it's keys are 'opposition_id' and it's values collections of rows with the same opposition_id.
        $result = $data->groupBy('purchaseDate')
                            ->map(function ($item) {
                                return (object) [
                                    'purchaseDate' => $item->max('purchaseDate'),
                                    'productCode' => $item->max('productCode'),
                                    'productName' => $item->max('productName'),
                                    'quantity' => $item->sum('quantity'),
                                    'subTotal' => $item->sum('subTotal'),
                                ];
                            })->sortBy([
                                ['purchaseDate', 'asc'],
                            ]);

        // dd($result);
        
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalTopProductByDate($data, $mLimit = '10')
    {

        // $groups will be a collection, it's keys are 'opposition_id' and it's values collections of rows with the same opposition_id.
        $result = $data->take($mLimit);

        // dd($result);
        
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetProductInventory($now = '', $code = '%', $branch = '%', $data)
    {
        // $groups will be a collection, it's keys are 'opposition_id' and it's values collections of rows with the same opposition_id.
        $dataSalesByBranch = $data->groupBy('branchId')
                            ->map(function ($item) {
                                return (object) [
                                    'branchId' => $item->max('branchId'),
                                    'productCode' => $item->max('productCode'),
                                    'productName' => $item->max('productName'),
                                    'quantity' => $item->sum('quantity'),
                                    'subTotal' => $item->sum('subTotal'),
                                ];
                            })->sortBy([
                                ['branchId', 'asc'],
                            ]);
        // dd($dataSalesByBranch);
        $productInventory = [];
        if($code == '%')
        {
            return $productInventory;
        }
        else
        {
            $client = $this->kiotvietAuth->doCreateClient();
            $productResource = new ProductResource($client);
            $product = $productResource->getByCode($code);
        }
        if(!empty($product))
        {
            if($branch == '%')
            {
                $inventory = $product->getInventories();
                foreach ($inventory as $key => $item) 
                {
                    if($item->getOnHand() > 0 || $item->getReserved() > 0)
                    {
                        $item->productCode = $product->getCode();
                        $item->productName = $product->getName();
                        //
                        if(!empty($dataSalesByBranch))
                        {
                            foreach($dataSalesByBranch as $key2 => $item2)
                            {
                                if($item2->branchId == $item->getBranchId())
                                {
                                    $item->setQuantity(!empty($item2->quantity) ? $item2->quantity : 0);
                                    $item->setSubTotal(!empty($item2->subTotal) ? $item2->subTotal : 0);
                                }
                            }
                        }
                        //
                        $productInventory[$key] = $item;
                    }
                }
            }
            else
            {
                $inventory = $product->getInventories();
                foreach ($inventory as $key => $item) 
                {
                    if($item->getBranchId() == $branch)
                    {
                        $item->productCode = $product->getCode();
                        $item->productName = $product->getName();
                        //
                        if(!empty($dataSalesByBranch))
                        {
                            foreach($dataSalesByBranch as $key2 => $item2)
                            {
                                if($item2->branchId == $item->getBranchId())
                                {
                                    $item->setQuantity(!empty($item2->quantity) ? $item2->quantity : 0);
                                    $item->setSubTotal(!empty($item2->subTotal) ? $item2->subTotal : 0);
                                }
                            }
                        }
                        //
                        $productInventory['0'] = $item;
                    }
                }
            }
        }
        else
        {
            return $productInventory;
        }
        //
        if(!empty($productInventory))
        {
            foreach ($productInventory as $key => $item) 
            {
                $itemBranchId = $item->getBranchId();
                $itemProductCode = $item->productCode;
                $purchaseProduct = $this->doGetPurchaseOrderByProductByDate($now, $itemBranchId, $itemProductCode);
                //
                if(!empty($purchaseProduct->all()))
                {
                    $purchaseQuantity = $purchaseProduct['0']->quantity;
                    $item->purchaseQuantity = $purchaseQuantity;

                    $maxcreatedDate = $purchaseProduct['0']->maxcreatedDate;
                    $item->maxcreatedDate = $maxcreatedDate;

                    $mincreatedDate = $purchaseProduct['0']->mincreatedDate;
                    $item->mincreatedDate = $mincreatedDate;
                }
                else
                {
                    $item->purchaseQuantity = 0;
                    $item->maxcreatedDate = '';
                    $item->mincreatedDate = '';
                }

                $item->salesQuantity = intval($item->getQuantity());
                $item->salesSubTotal = intval($item->getSubTotal());
            }
        }

        $result = collect($productInventory);

        $result = $result->sortBy([
            ['salesQuantity', 'desc']
        ]);
        
        // dd($result);
        
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetPurchaseOrderByProductByDate($now = '', $branch = '%', $code = '%')
    {
        $frmDate = (string) strip_tags(request()->post('frmDate', date('Y-m-01')));
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
                if($createdDate >= $frmDate && $createdDate <= $now)
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
                                if($item2->productCode == $code || $code == '%')
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
                                    'maxcreatedDate' => $item->max('createdDate'),
                                    'mincreatedDate' => $item->min('createdDate'),
                                    'quantity' => $item->sum('quantity'),
                                ];
                            })->sortBy([
                                ['branchId', 'asc'],
                            ]);

        return $result;
    }
}