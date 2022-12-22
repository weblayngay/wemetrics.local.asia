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
use VienThuong\KiotVietClient\Model\Customer;
use VienThuong\KiotVietClient\Criteria\CustomerCriteria;
use VienThuong\KiotVietClient\Resource\CustomerResource;
//
use VienThuong\KiotVietClient\Model\Invoice;
use VienThuong\KiotVietClient\Model\InvoiceDetail;
use VienThuong\KiotVietClient\Criteria\InvoiceCriteria;
use VienThuong\KiotVietClient\Criteria\InvoiceDetailCriteria;
use VienThuong\KiotVietClient\Resource\InvoiceResource;
use VienThuong\KiotVietClient\Resource\InvoiceDetailResource;
use Vienthuong\KiotVietClient\Exception\KiotVietException;

class getTotalCustomerController extends BaseController
{
    private $customerModel;
    private $invoiceModel;
    private $invoiceDetailModel;
    private $getRangeDateCtrl;

    public function __construct()
    {
        $this->customerModel = new Customer();
        $this->invoiceModel = new Invoice();
        $this->invoiceDetailModel = new InvoiceDetail();
        $this->kiotvietAuth = new KiotvietAuthController();
        $this->getRangeDateCtrl = new getRangeDateController();
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetCustomerByCode($code = '')
    {
        $client = $this->kiotvietAuth->doCreateClient();
        $customerResource = new CustomerResource($client);
        $customer = $customerResource->getByCode($code);
        $result = $customer;
        //
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetInvoices($frmDate = '', $toDate = '', $branch = '%')
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
        //
        if($branch != '%')
        {
            $criteria->setBranchIds($branch);
        }

        $invoices = $invoiceResource->search($criteria);
        $total = $invoices->getTotal();
        $invoiceArr = [];

        for ($i = 0; $i < $total; $i = $i + $pageSize) 
        {
            $criteria->setCurrentItem($i);
            $invoices = $invoiceResource->search($criteria);
            //
            $invoiceItems = $invoices->getItems();
            //
            foreach ($invoiceItems as $key => $item)
            {
                // dd($item);
                $status = $item->getStatus();
                if($status != '2')
                {
                    $purchaseDate = DateHelper::getDate('Y-m-d', $item->getPurchaseDate());
                    $item->shortPurchaseDate = $purchaseDate;
                    //
                    $item->shortCustomerCode = '';
                    $item->totalCustomer = 0;
                    //
                    $item->customerNewCode = '';
                    $item->totalCustomerNew = 0;
                    $item->totalCustomerNewAmount = 0;
                    $item->totalCustomerNewAmountPayment = 0;
                    //
                    $item->customerLoyaltyCode = '';
                    $item->totalCustomerLoyalty = 0;
                    $item->totalCustomerLoyaltyAmount = 0;
                    $item->totalCustomerLoyaltyAmountPayment = 0;                
                    //
                    $customerCode = ($item->getCustomerCode()) ? $item->getCustomerCode() : null;
                    if(!empty($customerCode))
                    {
                        // $customerDetails = $this->doGetCustomerByCode($customerCode, false);
                        // dd($customerDetails);
                        // $customerCreatedDate = DateHelper::getDate('Y-m-d', $item->getCreatedDate());
                        // dd($customerCreatedDate);
                        $item->shortCustomerCode = $customerCode;
                        $item->totalCustomer = 1;
                        if(str_replace('KH', '', $customerCode) > KIOTVIET_CUSTOMER_SPLT) // Split khách mới và khách cũ
                        {
                            $item->customerNewCode = $customerCode;
                            $item->totalCustomerNew = 1;
                            $item->totalCustomerNewAmount = $item->getTotal();
                            $item->totalCustomerNewAmountPayment = $item->getTotalPayment();
                        }
                        else
                        {   
                            $item->customerLoyaltyCode = $customerCode;
                            $item->totalCustomerLoyalty = 1;
                            $item->totalCustomerLoyaltyAmount = $item->getTotal();
                            $item->totalCustomerLoyaltyAmountPayment = $item->getTotalPayment();
                        }
                    }
                    $invoiceArr[$item->getId() * 100 + $key] = $item;
                }
            }
        }

        $result = collect($invoiceArr);

        // dd($result);

        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalCustomerByDate($data, $branch = '%')
    {
        $dataCustomers = $data->unique('shortCustomerCode');

        // $groups will be a collection, it's keys are 'opposition_id' and it's values collections of rows with the same opposition_id.
        $result = $dataCustomers->groupBy('shortPurchaseDate')
                            ->map(function ($item) {
                                return (object) [
                                    'purchaseDate' => $item->max('shortPurchaseDate'),
                                    //
                                    'totalCustomerNew' => $item->sum('totalCustomerNew'),
                                    'totalCustomerNewAmount' => $item->sum('totalCustomerNewAmount'),
                                    'totalCustomerNewAmountPayment' => $item->sum('totalCustomerNewAmountPayment'),
                                    //
                                    'totalCustomerLoyalty' => $item->sum('totalCustomerLoyalty'),
                                    'totalCustomerLoyaltyAmount' => $item->sum('totalCustomerLoyaltyAmount'),
                                    'totalCustomerLoyaltyAmountPayment' => $item->sum('totalCustomerLoyaltyAmountPayment'),
                                ];
                            });
        
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetInvoiceLatest($data, $branch = '%', $mLimit = 10)
    {
        // $groups will be a collection, it's keys are 'opposition_id' and it's values collections of rows with the same opposition_id.
        $result = $data->sortBy([
                                ['shortPurchaseDate', 'desc'],
                            ])->take($mLimit);

        // dd($result);
        
        return $result;
    }
}