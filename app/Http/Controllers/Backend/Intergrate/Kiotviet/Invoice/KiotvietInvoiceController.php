<?php

namespace App\Http\Controllers\Backend\Intergrate\Kiotviet\Invoice;

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
use VienThuong\KiotVietClient\Model\Invoice;
use VienThuong\KiotVietClient\Model\InvoiceDetail;
use VienThuong\KiotVietClient\Criteria\InvoiceCriteria;
use VienThuong\KiotVietClient\Criteria\InvoiceDetailCriteria;
use VienThuong\KiotVietClient\Resource\InvoiceResource;
use VienThuong\KiotVietClient\Resource\InvoiceDetailResource;
use Vienthuong\KiotVietClient\Exception\KiotVietException;
use \stdClass;

class KiotvietInvoiceController extends BaseController
{
    private $view = '.kiotvietinvoice';
    private $model = 'kiotvietinvoice';
    private $imageModel;
    private $adminUserModel;
    private $invoiceModel;
    private $adminMenu;
    private $kiotvietAuth;
    private $getBranchCtrl;

    public function __construct()
    {
        $this->imageModel = new Image();
        $this->adminUserModel = new AdminUser();
        $this->adminMenuModel = new AdminMenu();
        $this->invoiceModel = new Invoice();
        $this->kiotvietAuth = new KiotvietAuthController();
        $this->getBranchCtrl = new getKiotvietBranchController();
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawInvoice($pageSize = 50, $incDelivery = 0, $incPayment = 0)
    {
        $client = $this->kiotvietAuth->doCreateClient();

        $invoiceResource = new InvoiceResource($client);

        $invoice = new Invoice();

        $criteria = new InvoiceCriteria($invoice);
        //
        $criteria->setPageSize($pageSize);
        $criteria->setIncludeOrderDelivery($incDelivery);
        $criteria->setIncludePayment($incPayment);

        $invoices = $invoiceResource->search($criteria);

        dd($invoices);
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawCompletedInvoice($pageSize = 50, $incDelivery = 0, $incPayment = 0)
    {
        $client = $this->kiotvietAuth->doCreateClient();

        $invoiceResource = new InvoiceResource($client);

        $invoice = new Invoice();

        $criteria = new InvoiceCriteria($invoice);
        //
        $criteria->setPageSize($pageSize);
        $criteria->setStatus($this->invoiceModel::STATUSES['COMPLETED']);
        $criteria->setIncludeOrderDelivery($incDelivery);
        $criteria->setIncludePayment($incPayment);

        $invoices = $invoiceResource->search($criteria);

        dd($invoices);
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawCanceledInvoice($pageSize = 50, $incDelivery = 0, $incPayment = 0)
    {
        $client = $this->kiotvietAuth->doCreateClient();

        $invoiceResource = new InvoiceResource($client);

        $invoice = new Invoice();

        $criteria = new InvoiceCriteria($invoice);
        //
        $criteria->setPageSize($pageSize);
        $criteria->setStatus($this->invoiceModel::STATUSES['CANCELED']);
        $criteria->setIncludeOrderDelivery($incDelivery);
        $criteria->setIncludePayment($incPayment);

        $invoices = $invoiceResource->search($criteria);

        dd($invoices);
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawOngoingInvoice($pageSize = 50, $incDelivery = 0, $incPayment = 0)
    {
        $client = $this->kiotvietAuth->doCreateClient();

        $invoiceResource = new InvoiceResource($client);

        $invoice = new Invoice();

        $criteria = new InvoiceCriteria($invoice);
        //
        $criteria->setPageSize($pageSize);
        $criteria->setStatus($this->invoiceModel::STATUSES['ONGOING']);
        $criteria->setIncludeOrderDelivery($incDelivery);
        $criteria->setIncludePayment($incPayment);

        $invoices = $invoiceResource->search($criteria);

        dd($invoices);
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawCantDeliveryInvoice($pageSize = 50, $incDelivery = 0, $incPayment = 0)
    {
        $client = $this->kiotvietAuth->doCreateClient();

        $invoiceResource = new InvoiceResource($client);

        $invoice = new Invoice();

        $criteria = new InvoiceCriteria($invoice);
        //
        $criteria->setPageSize($pageSize);
        $criteria->setStatus($this->invoiceModel::STATUSES['CANT_DELIVERY']);
        $criteria->setIncludeOrderDelivery($incDelivery);
        $criteria->setIncludePayment($incPayment);

        $invoices = $invoiceResource->search($criteria);

        dd($invoices);
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawInvoiceByStatus($status = '1', $pageSize = 50, $incDelivery = 0, $incPayment = 0)
    {
        $client = $this->kiotvietAuth->doCreateClient();

        $invoiceResource = new InvoiceResource($client);

        $invoice = new Invoice();

        $criteria = new InvoiceCriteria($invoice);
        //
        $criteria->setPageSize($pageSize);
        $criteria->setStatus($status);
        $criteria->setIncludeOrderDelivery($incDelivery);
        $criteria->setIncludePayment($incPayment);

        $invoices = $invoiceResource->search($criteria);

        dd($invoices);
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawInvoiceByBranchId($status = '1', $branchIds = '', $pageSize = 50, $incDelivery = 0, $incPayment = 0)
    {
        $client = $this->kiotvietAuth->doCreateClient();

        $invoiceResource = new InvoiceResource($client);

        $invoice = new Invoice();

        $criteria = new InvoiceCriteria($invoice);
        //
        $criteria->setPageSize($pageSize);
        $criteria->setStatus($status);
        $criteria->setBranchIds($branchIds);
        $criteria->setIncludeOrderDelivery($incDelivery);
        $criteria->setIncludePayment($incPayment);

        $invoices = $invoiceResource->search($criteria);

        dd($invoices);
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawInvoiceByCustomerId($status = '1', $customerIds = '', $pageSize = 50, $incDelivery = 0, $incPayment = 0)
    {
        $client = $this->kiotvietAuth->doCreateClient();

        $invoiceResource = new InvoiceResource($client);

        $invoice = new Invoice();

        $criteria = new InvoiceCriteria($invoice);
        //
        $criteria->setPageSize($pageSize);
        $criteria->setStatus($status);
        $criteria->setCustomerIds($customerIds);
        $criteria->setIncludeOrderDelivery($incDelivery);
        $criteria->setIncludePayment($incPayment);

        $invoices = $invoiceResource->search($criteria);

        dd($invoices);
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawInvoiceByCustomerCode($status = '1', $customerCode = '', $pageSize = 50, $incDelivery = 0, $incPayment = 0)
    {
        $client = $this->kiotvietAuth->doCreateClient();

        $invoiceResource = new InvoiceResource($client);

        $invoice = new Invoice();

        $criteria = new InvoiceCriteria($invoice);
        //
        $criteria->setPageSize($pageSize);
        $criteria->setStatus($status);
        $criteria->setCustomerCode($customerCode);
        $criteria->setIncludeOrderDelivery($incDelivery);
        $criteria->setIncludePayment($incPayment);

        $invoices = $invoiceResource->search($criteria);

        dd($invoices);
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawInvoiceByOrderId($status = '1', $orderIds = '', $pageSize = 50, $incDelivery = 0, $incPayment = 0)
    {
        $client = $this->kiotvietAuth->doCreateClient();

        $invoiceResource = new InvoiceResource($client);

        $invoice = new Invoice();

        $criteria = new InvoiceCriteria($invoice);
        //
        $criteria->setPageSize($pageSize);
        $criteria->setStatus($status);
        $criteria->setOrdersIds($orderIds);
        $criteria->setIncludeOrderDelivery($incDelivery);
        $criteria->setIncludePayment($incPayment);

        $invoices = $invoiceResource->search($criteria);

        dd($invoices);
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawInvoiceByToDate($status = '1', $toDate = '', $pageSize = 50, $incDelivery = 0, $incPayment = 0)
    {
        $client = $this->kiotvietAuth->doCreateClient();

        $invoiceResource = new InvoiceResource($client);

        $invoice = new Invoice();

        $criteria = new InvoiceCriteria($invoice);
        //
        $criteria->setPageSize($pageSize);
        $criteria->setStatus($status);
        $criteria->setToDate($toDate);
        $criteria->setIncludeOrderDelivery($incDelivery);
        $criteria->setIncludePayment($incPayment);

        $invoices = $invoiceResource->search($criteria);

        dd($invoices);
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawInvoiceByPurchaseDate($status = '1', $frmPurDate = '', $toPurDate = '', $pageSize = 50, $incDelivery = 0, $incPayment = 0)
    {
        $client = $this->kiotvietAuth->doCreateClient();

        $invoiceResource = new InvoiceResource($client);

        $invoice = new Invoice();

        $criteria = new InvoiceCriteria($invoice);
        //
        $criteria->setPageSize($pageSize);
        $criteria->setStatus($status);
        $criteria->setFromPurchaseDate($frmPurDate);
        $criteria->setToPurchaseDate($toPurDate);
        $criteria->setIncludeOrderDelivery($incDelivery);
        $criteria->setIncludePayment($incPayment);

        $invoices = $invoiceResource->search($criteria);

        dd($invoices);
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawInvoiceDetailById($id = '')
    {
        $client = $this->kiotvietAuth->doCreateClient();

        $invoiceDetailResource = new InvoiceDetailResource($client);

        $invoiceDetail = $invoiceDetailResource->getById($id);

        dd($invoiceDetail);
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawInvoiceDetailByCode($code = '')
    {
        $client = $this->kiotvietAuth->doCreateClient();

        $invoiceDetailResource = new InvoiceDetailResource($client);

        $invoiceDetail = $invoiceDetailResource->getByCode($code);

        dd($invoiceDetail);
    }

    /**
     * @return Application|Factory|View
     */
    public function listInvoiceByCustomerCode($customerCode = '', $pageSize = 50, $incDelivery = 0, $incPayment = 0)
    {
        $client = $this->kiotvietAuth->doCreateClient();
        $invoiceResource = new InvoiceResource($client);
        $invoice = new Invoice();
        $criteria = new InvoiceCriteria($invoice);
        //
        $criteria->setPageSize($pageSize);
        $criteria->setCustomerCode($customerCode);
        $criteria->setIncludeOrderDelivery($incDelivery);
        $criteria->setIncludePayment($incPayment);

        $invoices = $invoiceResource->search($criteria);

        return $invoices;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function preloadindex()
    {
        $data['view']  = $this->viewPath . $this->view . '.preload';

        $frmDate = (string) strip_tags(request()->post('frmDate', date('Y-m-01')));
        $toDate = (string) strip_tags(request()->post('toDate', date('Y-m-d')));
        $branch = (string) strip_tags(request()->post('branch', '%'));
        $status = (string) strip_tags(request()->post('status', '%'));
        $code = (string) strip_tags(request()->post('code', ''));
        $customercode = (string) strip_tags(request()->post('customercode', ''));
        $_token = (string) strip_tags(request()->post('_token', csrf_token()));
        //
        $data['action'] = 'index';
        $data['frmDate'] = $frmDate;
        $data['toDate'] = $toDate;
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['status'] = $status;
        $data['statuses'] = Invoice::STATUSES_LABEL;
        $data['code'] = $code;
        $data['customercode'] = $customercode;
        $data['_token'] = $_token;
        //
        return view($data['view'] , compact('data'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function preloadsearch()
    {
        $data['view']  = $this->viewPath . $this->view . '.preload';

        $frmDate = (string) strip_tags(request()->post('frmDate', date('Y-m-01')));
        $toDate = (string) strip_tags(request()->post('toDate', date('Y-m-d')));
        $branch = (string) strip_tags(request()->post('branch', '%'));
        $status = (string) strip_tags(request()->post('status', '%'));
        $code = (string) strip_tags(request()->post('code', ''));
        $customercode = (string) strip_tags(request()->post('customercode', ''));
        $_token = (string) strip_tags(request()->post('_token', csrf_token()));
        //
        $data['action'] = 'search';
        $data['frmDate'] = $frmDate;
        $data['toDate'] = $toDate;
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['status'] = $status;
        $data['statuses'] = Invoice::STATUSES_LABEL;
        $data['code'] = $code;
        $data['customercode'] = $customercode;
        $data['_token'] = $_token;
        //
        return view($data['view'] , compact('data'));
    }  

    /**
     * @param $id
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $data['title'] = KIOTVIET_INVOICE_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        $frmDate = (string) strip_tags(request()->post('frmDate', date('Y-m-01')));
        if(empty($frmDate))
        {
            $error   = 'Vui lòng chọn điều kiện lọc thời gian';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
        else
        {
            $frmDate = DateHelper::getDate('Y-m-d', $frmDate);
        }

        $toDate = (string) strip_tags(request()->post('toDate', date('Y-m-d')));
        if(empty($toDate))
        {
            $error   = 'Vui lòng chọn điều kiện lọc thời gian';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
        else
        {
            $toDate = DateHelper::getDate('Y-m-d', $toDate);
        }
        //
        $branch = (string) strip_tags(request()->post('branch', '%'));
        $status = (string) strip_tags(request()->post('status', '%'));
        $code = (string) strip_tags(request()->post('code', ''));
        $customercode = (string) strip_tags(request()->post('customercode', ''));
        //
        $client = $this->kiotvietAuth->doCreateClient();
        $incDelivery = 1;
        $incPayment = 1;
        $pageSize = KIOTVIET_DEFAULT_PAGESIZE;
        //
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
        if($status != '%')
        {
            $criteria->setStatus(Invoice::STATUSES_REVERT[$status]);
        }

        if($branch != '%')
        {
            $criteria->setBranchIds($branch);
        }

        if($customercode != '')
        {
            $criteria->setCustomerCode($customercode);
            $criteria->setFromPurchaseDate('');
            $criteria->setToPurchaseDate('');
        }
        //
        $invoices = $invoiceResource->search($criteria);
        $total = KIOTVIET_INVOICE_PAGINATE;
        //
        $invoiceArr = array();
        $invoiceTotal = $invoices->getTotal();
        //
        for ($i = 0; $i < $total; $i = $i + $pageSize) 
        {
            $criteria->setCurrentItem($i);
            $invoices = $invoiceResource->search($criteria);
            //
            $invoiceItems = $invoices->getItems();
            foreach ($invoiceItems as $key => $item) 
            {
                $invoiceItems[$item->getId()] = $invoiceItems[$key];
                unset($invoiceItems[$key]);
            }
            $invoiceArr += $invoiceItems;
        }

        // dd($total, count($invoiceArr));

        //
        $data['frmDate'] = $frmDate;
        $data['toDate'] = $toDate;
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['status'] = $status;
        $data['statuses'] = Invoice::STATUSES_LABEL;
        $data['code'] = $code;
        $data['customercode'] = $customercode;
        //
        $invoiceArr = CollectionPaginateHelper::paginateSec($invoiceArr, PAGINATE_PERPAGE);
        $data['invoiceArr'] = $invoiceArr;
        $data['invoiceTotal'] = $invoiceTotal;
        //
        return view($data['view'] , compact('data'));
    }

    /**
     * @param $id
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $data['title'] = KIOTVIET_INVOICE_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.filter';

        $frmDate = (string) strip_tags(request()->post('frmDate', date('Y-m-01')));
        if(empty($frmDate))
        {
            $error   = 'Vui lòng chọn điều kiện lọc thời gian';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
        else
        {
            $frmDate = DateHelper::getDate('Y-m-d', $frmDate);
        }

        $toDate = (string) strip_tags(request()->post('toDate', date('Y-m-d')));
        if(empty($toDate))
        {
            $error   = 'Vui lòng chọn điều kiện lọc thời gian';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
        else
        {
            $toDate = DateHelper::getDate('Y-m-d', $toDate);
        }
        //
        $branch = (string) strip_tags(request()->post('branch', '%'));
        $status = (string) strip_tags(request()->post('status', '%'));
        $code = (string) strip_tags(request()->post('code', ''));
        $customercode = (string) strip_tags(request()->post('customercode', ''));
        //
        $client = $this->kiotvietAuth->doCreateClient();
        $incDelivery = 1;
        $incPayment = 1;
        $pageSize = 100;
        //
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
        if($status != '%')
        {
            $criteria->setStatus(Invoice::STATUSES_REVERT[$status]);
        }

        if($branch != '%')
        {
            $criteria->setBranchIds($branch);
        }

        if($customercode != '')
        {
            $criteria->setCustomerCode($customercode);
        }
        //
        $invoices = $invoiceResource->search($criteria);
        $total = $invoices->getTotal();
        //
        $invoiceArr = array();
        //
        for ($i = 0; $i < $total; $i = $i + $pageSize) 
        {
            $criteria->setCurrentItem($i);
            $invoices = $invoiceResource->search($criteria);
            //
            if($code != '')
            {
                $invoiceItems = $invoices->getItems();
                foreach ($invoiceItems as $key => $item) 
                {
                    if($item->getCode() == $code)
                    {
                        $invoiceItems[$item->getId()] = $invoiceItems[$key];
                        unset($invoiceItems[$key]);
                        $i = $total;
                    }
                    else
                    {
                        unset($invoiceItems[$key]);
                    }
                }
            }
            else
            {
                $invoiceItems = $invoices->getItems();
                foreach ($invoiceItems as $key => $item) 
                {
                    $invoiceItems[$item->getId()] = $invoiceItems[$key];
                    unset($invoiceItems[$key]);
                }
            }
            $invoiceArr += $invoiceItems;
        }

        // dd($total, count($invoiceArr));

        //
        $data['frmDate'] = $frmDate;
        $data['toDate'] = $toDate;
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['status'] = $status;
        $data['statuses'] = Invoice::STATUSES_LABEL;
        $data['code'] = $code;
        $data['customercode'] = $customercode;
        //
        $invoiceArr = CollectionPaginateHelper::paginateSec($invoiceArr, PAGINATE_PERPAGE);
        $data['invoiceArr'] = $invoiceArr;
        //
        return view($data['view'] , compact('data'));
    }

    /**
     * @param $id
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function edit()
    {
        $client = $this->kiotvietAuth->doCreateClient();
        $invoiceResource = new InvoiceResource($client);
        //
        $user = Auth::guard('admin')->user();
        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;
        //
        $id = (int) request()->get('id', 0);
        $code = (string) request()->get('code', '');
        if($id != 0)
        {
            $invoice = $invoiceResource->getById($id);
        }
        if($code != 'code')
        {
            $invoice = $invoiceResource->getByCode($code);
        }
        // dd($invoice);
        if($invoice){
            $data['title'] = KIOTVIET_INVOICE_TITLE.SHOW_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['id'] = $invoice->getId();
            $data['code'] = $invoice->getCode();
            $data['uuid'] = $invoice->getUUid();
            $data['purchaseDate'] = $invoice->getPurchaseDate();
            $data['branchId'] = $invoice->getBranchId();
            $data['branchName'] = $invoice->getBranchName();
            $data['soldById'] = $invoice->getSoldById();
            $data['soldByName'] = $invoice->getSoldByName();
            $data['customerId'] = $invoice->getCustomerId();
            $data['customerCode'] = $invoice->getCustomerCode();
            $data['customerName'] = $invoice->getCustomerName();
            $data['orderCode'] = $invoice->getOrderCode();
            $data['total'] = $invoice->getTotal();
            $data['totalPayment'] = $invoice->getTotalPayment();
            $data['discount'] = $invoice->getDiscount();
            $data['status'] = $invoice->getStatus();
            $data['statusValue'] = $invoice->getStatusValue();
            $data['description'] = $invoice->getDescription();
            $data['usingCod'] = $invoice->getUsingCod();
            $data['createdDate'] = $invoice->getCreatedDate();
            $data['invoiceDetails'] = $invoice->getInvoiceDetails();
            $data['invoiceDelivery'] = $invoice->getInvoiceDelivery();
            $data['payments'] = $invoice->getPayments();
            $data['invoiceOrderSurcharges'] = $invoice->getInvoiceOrderSurcharges();
            $data['saleChannel'] = $invoice->getSaleChannel();
            $data['invoice'] = $invoice;

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy khách hàng';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }
}