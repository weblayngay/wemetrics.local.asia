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
use VienThuong\KiotVietClient\Model\Invoice;
use VienThuong\KiotVietClient\Model\InvoiceDetail;
use VienThuong\KiotVietClient\Criteria\InvoiceCriteria;
use VienThuong\KiotVietClient\Criteria\InvoiceDetailCriteria;
use VienThuong\KiotVietClient\Resource\InvoiceResource;
use VienThuong\KiotVietClient\Resource\InvoiceDetailResource;
use Vienthuong\KiotVietClient\Exception\KiotVietException;

class getTotalInvoiceController extends BaseController
{
    private $invoiceModel;
    private $invoiceDetailModel;
    private $getRangeDateCtrl;

    public function __construct()
    {
        $this->invoiceModel = new Invoice();
        $this->invoiceDetailModel = new InvoiceDetail();
        $this->kiotvietAuth = new KiotvietAuthController();
        $this->getRangeDateCtrl = new getRangeDateController();
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
                if($item->getStatus() == '1')
                {
                    $item->totalAmountCompleted = $item->getTotal();
                    $item->totalInvoiceCompleted = 1;
                    //
                    $item->totalAmountCanceled = 0;
                    $item->totalInvoiceCanceled = 0;
                    //
                    $item->totalAmountProcess = 0;
                    $item->totalInvoiceProcess = 0;
                }
                if($item->getStatus() == '2')
                {
                    $item->totalAmountCanceled = $item->getTotal();
                    $item->totalInvoiceCanceled = 1;
                    //
                    $item->totalAmountProcess = 0;
                    $item->totalInvoiceProcess = 0;
                    //
                    $item->totalAmountCompleted = 0;
                    $item->totalInvoiceCompleted = 0;
                }
                if($item->getStatus() == '3')
                {
                    $item->totalAmountProcess = $item->getTotal();
                    $item->totalInvoiceProcess = 1;
                    //
                    $item->totalAmountCanceled = 0;
                    $item->totalInvoiceCanceled = 0;
                    //
                    $item->totalAmountCompleted = 0;
                    $item->totalInvoiceCompleted = 0;
                }
                $purchaseDate = DateHelper::getDate('Y-m-d', $item->getPurchaseDate());
                $item->shortPurchaseDate = $purchaseDate;
                $item->totalAmount = $item->getTotal();
                
                $invoiceArr[$item->getId() * 100 + $key] = $item;
            }
        }

        $result = collect($invoiceArr);

        // dd($result);

        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalInvoices($data, $branch = '%')
    {
        // $groups will be a collection, it's keys are 'opposition_id' and it's values collections of rows with the same opposition_id.
        $result = $data->count('code');

        // dd($result);
        
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

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalAmount($data, $branch = '%')
    {
        // $groups will be a collection, it's keys are 'opposition_id' and it's values collections of rows with the same opposition_id.
        $result = $data->sum('totalAmount');

        // dd($result);
        
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalInvoiceCompleted($data, $branch = '%')
    {
        // $groups will be a collection, it's keys are 'opposition_id' and it's values collections of rows with the same opposition_id.
        $result = $data->sum('totalInvoiceCompleted');

        // dd($result);
        
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalAmountCompleted($data, $branch = '%')
    {
        // $groups will be a collection, it's keys are 'opposition_id' and it's values collections of rows with the same opposition_id.
        $result = $data->sum('totalAmountCompleted');

        // dd($result);
        
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalInvoiceProcess($data, $branch = '%')
    {
        // $groups will be a collection, it's keys are 'opposition_id' and it's values collections of rows with the same opposition_id.
        $result = $data->sum('totalInvoiceProcess');

        // dd($result);
        
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalAmountProcess($data, $branch = '%')
    {
        // $groups will be a collection, it's keys are 'opposition_id' and it's values collections of rows with the same opposition_id.
        $result = $data->sum('totalAmountProcess');

        // dd($result);
        
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalInvoiceCanceled($data, $branch = '%')
    {
        // $groups will be a collection, it's keys are 'opposition_id' and it's values collections of rows with the same opposition_id.
        $result = $data->sum('totalInvoiceCanceled');

        // dd($result);
        
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalAmountCanceled($data, $branch = '%')
    {
        // $groups will be a collection, it's keys are 'opposition_id' and it's values collections of rows with the same opposition_id.
        $result = $data->sum('totalAmountCanceled');

        // dd($result);
        
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalInvoiceByDate($data, $branch = '%')
    {
        // $groups will be a collection, it's keys are 'opposition_id' and it's values collections of rows with the same opposition_id.
        $result = $data->groupBy('shortPurchaseDate')
                            ->map(function ($item) {
                                return (object) [
                                    'purchaseDate' => $item->max('shortPurchaseDate'),
                                    'totalInvoice' => $item->count('code'),
                                ];
                            });

        // dd($result);
        
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalInvoiceCompletedByDate($data, $branch = '%')
    {
        // $groups will be a collection, it's keys are 'opposition_id' and it's values collections of rows with the same opposition_id.
        $result = $data->groupBy('shortPurchaseDate')
                            ->map(function ($item) {
                                return (object) [
                                    'purchaseDate' => $item->max('shortPurchaseDate'),
                                    'totalInvoice' => $item->sum('totalInvoiceCompleted'),
                                    'totalAmountCompleted' => $item->sum('totalAmountCompleted'),
                                ];
                            });

        // dd($result);
        
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalInvoiceCanceledByDate($data, $branch = '%')
    {
        // $groups will be a collection, it's keys are 'opposition_id' and it's values collections of rows with the same opposition_id.
        $result = $data->groupBy('shortPurchaseDate')
                            ->map(function ($item) {
                                return (object) [
                                    'purchaseDate' => $item->max('shortPurchaseDate'),
                                    'totalInvoice' => $item->sum('totalInvoiceCanceled'),
                                    'totalAmountCompleted' => $item->sum('totalAmountCanceled'),
                                ];
                            });

        // dd($result);
        
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function doGetTotalInvoiceProcessByDate($data, $branch = '%')
    {
        // $groups will be a collection, it's keys are 'opposition_id' and it's values collections of rows with the same opposition_id.
        $result = $data->groupBy('shortPurchaseDate')
                            ->map(function ($item) {
                                return (object) [
                                    'purchaseDate' => $item->max('shortPurchaseDate'),
                                    'totalInvoice' => $item->sum('totalInvoiceProcess'),
                                    'totalAmountCompleted' => $item->sum('totalAmountProcess'),
                                ];
                            });

        // dd($result);
        
        return $result;
    }
}