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
use VienThuong\KiotVietClient\Model\PurchaseOrder;
use VienThuong\KiotVietClient\Criteria\PurchaseOrderCriteria;
use VienThuong\KiotVietClient\Resource\PurchaseOrderResource;

class getTotalCateProductController extends BaseController
{
    private $productModel;
    private $invoiceModel;
    private $invoiceDetailModel;
    private $getRangeDateCtrl;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->invoiceModel = new Invoice();
        $this->invoiceDetailModel = new InvoiceDetail();
        $this->kiotvietAuth = new KiotvietAuthController();
        $this->getRangeDateCtrl = new getRangeDateController();
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetProduct($frmDate = '', $toDate = '', $branch = '%', $cateProduct = '%')
    {
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
        $total = $invoices->getTotal();
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
                $branchId = $item->getBranchId();
                $branchName = $item->getBranchName();
                foreach ($invoiceDetails as $key2 => $item2) {
                    //
                    $item2['purchaseDate'] = $purchaseDate;
                    $item2['branchId'] = $branchId;
                    $item2['branchName'] = $branchName;
                    //
                    $productCode = ($item2['productCode']) ? $item2['productCode'] : null;
                    if(!empty($productCode) && !array_key_exists($productCode, $this->productModel::PROD_EXCLUDE_PHUKIEN))
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
                            if(array_key_exists($findstr, $this->productModel::CATE_PHUKIEN) && !array_key_exists($productCode, $this->productModel::PROD_EXCLUDE_PHUKIEN))
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

        $result = collect($products);

        // dd($result);

        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalCateProductByDate($data, $frmDate = '', $toDate = '')
    {
        //
        $groups = $data->groupBy('purchaseDate')->transform(function($item, $k) {
            return $item->groupBy('productCateName')->map(function ($item2) {
                                return (object) [
                                    'purchaseDate' => $item2->max('purchaseDate'),
                                    'productCateName' => $item2->max('productCateName'),
                                    'productCateCode' => $item2->max('productCateCode'),
                                    'quantity' => $item2->sum('quantity'),
                                    'subTotal' => $item2->sum('subTotal'),
                                ];
                            })->sortBy([
                                ['purchaseDate', 'desc'],
                            ]);
        });

        $mTmpResult = $this->getRangeDateCtrl->doQuery($frmDate, $toDate);

        foreach ($mTmpResult as $key1 => $item1) {
            $item1->productCateCode = '';
            $item1->productCateName = '';
            //
            $item1->quantity = 0;
            $item1->subTotal = 0;
            //
            $item1->quantity_capxach = 0;
            $item1->subTotal_capxach = 0;
            //
            $item1->quantity_tuideo = 0;
            $item1->subTotal_tuideo = 0;
            //
            $item1->quantity_tuiquang = 0;
            $item1->subTotal_tuiquang = 0;
            //
            $item1->quantity_tuixach = 0;
            $item1->subTotal_tuixach = 0;
            //
            $item1->quantity_bopvi = 0;
            $item1->subTotal_bopvi = 0;
            //
            $item1->quantity_balo = 0;
            $item1->subTotal_balo = 0;
            //
            $item1->quantity_tuidulich = 0;
            $item1->subTotal_tuidulich = 0;
            //
            $item1->quantity_daynit = 0;
            $item1->subTotal_daynit = 0;
            //
            $item1->quantity_phukien = 0;
            $item1->subTotal_phukien = 0;
            //
            $item1->quantity_quatang = 0;
            $item1->subTotal_quatang = 0;
            //
            $item1->quantity_khac = 0;
            $item1->subTotal_khac = 0;
            //
            foreach($groups as $key2 => $item2) {
                if($item1->created_at == $key2)
                {
                    foreach ($item2 as $key3 => $item3) {
                        // Cặp xách
                        if($item3->productCateName == 'Cặp xách')
                        {
                            $item1->quantity_capxach += $item3->quantity;
                            $item1->subTotal_capxach += $item3->subTotal;
                        }
                        // Túi đeo
                        if($item3->productCateName == 'Túi đeo')
                        {
                            $item1->quantity_tuideo += $item3->quantity;
                            $item1->subTotal_tuideo += $item3->subTotal;
                        }
                        // Túi quàng
                        if($item3->productCateName == 'Túi quàng')
                        {
                            $item1->quantity_tuiquang += $item3->quantity;
                            $item1->subTotal_tuiquang += $item3->subTotal;
                        }
                        // Túi xách
                        if($item3->productCateName == 'Túi xách')
                        {
                            $item1->quantity_tuixach += $item3->quantity;
                            $item1->subTotal_tuixach += $item3->subTotal;
                        }
                        // Bóp ví
                        if($item3->productCateName == 'Bóp ví')
                        {
                            $item1->quantity_bopvi += $item3->quantity;
                            $item1->subTotal_bopvi += $item3->subTotal;
                        }
                        // Balo
                        if($item3->productCateName == 'Balo')
                        {
                            $item1->quantity_balo += $item3->quantity;
                            $item1->subTotal_balo += $item3->subTotal;
                        }
                        // Túi du lịch
                        if($item3->productCateName == 'Túi du lịch')
                        {
                            $item1->quantity_tuidulich += $item3->quantity;
                            $item1->subTotal_tuidulich += $item3->subTotal;
                        }
                        // Dây nịt
                        if($item3->productCateName == 'Dây nịt')
                        {
                            $item1->quantity_daynit += $item3->quantity;
                            $item1->subTotal_daynit += $item3->subTotal;
                        }
                        // Phụ kiện
                        if($item3->productCateName == 'Phụ kiện')
                        {
                            $item1->quantity_phukien += $item3->quantity;
                            $item1->subTotal_phukien += $item3->subTotal;
                        }
                        // Quà tặng
                        if($item3->productCateName == 'Quà tặng')
                        {
                            $item1->quantity_quatang += $item3->quantity;
                            $item1->subTotal_quatang += $item3->subTotal;
                        }
                        // Khác
                        if($item3->productCateName == 'Khác')
                        {
                            $item1->quantity_khac += $item3->quantity;
                            $item1->subTotal_khac += $item3->subTotal;
                        }
                        //
                        $item1->productCateCode = $item3->productCateCode;
                        $item1->productCateName = $item3->productCateName;
                        //                        
                        $item1->quantity += $item3->quantity;
                        $item1->subTotal += $item3->subTotal;
                    }
                }
            }
        }

        $result = $mTmpResult;

        // dd($result);
        
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalCateProductByBranch($data, $frmDate = '', $toDate = '', $branch = '%', $cateProduct = '%')
    {
        //
        $result = [];

        $groups = $data->groupBy('productCateName')->transform(function($item, $k) {
            return $item->groupBy('branchId')->map(function ($item2) {
                                return (object) [
                                    'productCateName' => $item2->max('productCateName'),
                                    'productCateCode' => $item2->max('productCateCode'),
                                    'branchId' => $item2->max('branchId'),
                                    'branchName' => $item2->max('branchName'),
                                    'quantity' => $item2->sum('quantity'),
                                    'subTotal' => $item2->sum('subTotal'),
                                ];
                            })->sortBy([
                                ['quantity', 'desc'],
                                ['subTotal', 'desc'],
                            ]);
        });

        // dd($groups);

        foreach($groups as $key => $item) 
        {
            if($key == 'Cặp xách')
            {
                $result['capxachByBranch'] = $item;
            }
            if($key == 'Túi đeo')
            {
                $result['tuideoByBranch'] = $item;
            }
            if($key == 'Túi quàng')
            {
                $result['tuiquangByBranch'] = $item;
            }
            if($key == 'Túi xách')
            {
                $result['tuixachByBranch'] = $item;
            }
            if($key == 'Bóp ví')
            {
                $result['bopviByBranch'] = $item;
            }
            if($key == 'Balo')
            {
                $result['baloByBranch'] = $item;
            }
            if($key == 'Túi du lịch')
            {
                $result['tuidulichByBranch'] = $item;
            }
            if($key == 'Dây nịt')
            {
                $result['daynitByBranch'] = $item;
            }
            if($key == 'Phụ kiện')
            {
                $result['phukienByBranch'] = $item;
            }
            if($key == 'Quà tặng')
            {
                $result['quatangByBranch'] = $item;
            }
            if($key == 'Khác')
            {
                $result['khacByBranch'] = $item;
            }
        }

        // dd($result);

        return $result;
        
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalCateProduct($data)
    {
        $mTmpResult = collect([
            0    => (object) ['name' => 'Cặp xách', 'code' => 'CX'],
            1    => (object) ['name' => 'Túi đeo', 'code' => 'TD'],
            2    => (object) ['name' => 'Túi quàng', 'code' => 'TQ'],
            3    => (object) ['name' => 'Túi xách', 'code' => 'TX'],
            4    => (object) ['name' => 'Bóp ví', 'code' => 'VI'],
            5    => (object) ['name' => 'Balo', 'code' => 'BL'],
            6    => (object) ['name' => 'Túi du lịch', 'code' => 'DL'],
            7    => (object) ['name' => 'Dây nịt', 'code' => 'DN'],
            8    => (object) ['name' => 'Phụ kiện', 'code' => 'PK'],
        ]);
        foreach ($mTmpResult as $key1 => $item1) {
            $item1->quantity = 0;
            $item1->subTotal = 0;
            foreach ($data as $key2 => $item2) {
                if($item1->name == 'Cặp xách')
                {
                    $item1->quantity += $item2->quantity_capxach;
                    $item1->subTotal += $item2->subTotal_capxach;
                }
                if($item1->name == 'Túi đeo')
                {
                    $item1->quantity += $item2->quantity_tuideo;
                    $item1->subTotal += $item2->subTotal_tuideo;
                }
                if($item1->name == 'Túi quàng')
                {
                    $item1->quantity += $item2->quantity_tuiquang;
                    $item1->subTotal += $item2->subTotal_tuiquang;
                }
                if($item1->name == 'Túi xách')
                {
                    $item1->quantity += $item2->quantity_tuixach;
                    $item1->subTotal += $item2->subTotal_tuixach;
                }
                if($item1->name == 'Bóp ví')
                {
                    $item1->quantity += $item2->quantity_bopvi;
                    $item1->subTotal += $item2->subTotal_bopvi;
                }
                if($item1->name == 'Balo')
                {
                    $item1->quantity += $item2->quantity_balo;
                    $item1->subTotal += $item2->subTotal_balo;
                }
                if($item1->name == 'Túi du lịch')
                {
                    $item1->quantity += $item2->quantity_tuidulich;
                    $item1->subTotal += $item2->subTotal_tuidulich;
                }
                if($item1->name == 'Dây nịt')
                {
                    $item1->quantity += $item2->quantity_daynit;
                    $item1->subTotal += $item2->subTotal_daynit;
                }
                if($item1->name == 'Phụ kiện')
                {
                    $item1->quantity += $item2->quantity_phukien;
                    $item1->subTotal += $item2->subTotal_phukien;
                }
            }
        }

        $result = $mTmpResult->sortBy([
                                ['quantity', 'desc'],
                                ['subTotal', 'desc'],
                            ]);

        // dd($result);

        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalProductByDate($data)
    {
        // $groups will be a collection, it's keys are 'opposition_id' and it's values collections of rows with the same opposition_id.
        $result = $data->groupBy('productCode')
                            ->map(function ($item) {
                                return (object) [
                                    'productCode' => $item->max('productCode'),
                                    'productName' => $item->max('productName'),
                                    'quantity' => $item->sum('quantity'),
                                    'subTotal' => $item->sum('subTotal'),
                                ];
                            })->sortBy([
                                ['quantity', 'desc'],
                                ['subTotal', 'desc'],
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
    public function doGetTotalPurchase($branch = '%', $code = '%', $frmDate = '', $toDate = '')
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

        $result = $purchaseOrdersArr->groupBy('productCode')
                            ->map(function ($item) {
                                return (object) [
                                    'productCode' => $item->max('productCode'),
                                    'productName' => $item->max('productName'),
                                    'maxcreatedDate' => $item->max('createdDate'),
                                    'mincreatedDate' => $item->min('createdDate'),
                                    'quantity' => $item->sum('quantity'),
                                ];
                            })->sortBy([
                                ['quantity', 'desc'],
                            ]);

        // dd($result);

        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalInventory($branch = '%', $code = '%')
    {
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
                        $productInventory['0'] = $item;
                    }
                }
            }
        }
        else
        {
            return $productInventory;
        }

        $result = collect($productInventory);

        // dd($result);
        
        return $result;
    }
}