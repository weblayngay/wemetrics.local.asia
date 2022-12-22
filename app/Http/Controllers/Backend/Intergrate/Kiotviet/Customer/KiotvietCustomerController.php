<?php

namespace App\Http\Controllers\Backend\Intergrate\Kiotviet\Customer;

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
use App\Http\Controllers\Backend\Intergrate\Kiotviet\Invoice\KiotvietInvoiceController;
use App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\Children\getKiotvietBranchController;
use VienThuong\KiotVietClient;
use VienThuong\KiotVietClient\Model\Customer;
use VienThuong\KiotVietClient\Criteria\CustomerCriteria;
use VienThuong\KiotVietClient\Resource\CustomerResource;
use Vienthuong\KiotVietClient\Exception\KiotVietException;


class KiotvietCustomerController extends BaseController
{
    private $view = '.kiotvietcustomer';
    private $model = 'kiotvietcustomer';
    private $imageModel;
    private $adminUserModel;
    private $invoiceModel;
    private $adminMenu;
    private $kiotvietAuth;
    private $kiotvietInvoice;
    private $getBranchCtrl;

    public function __construct()
    {
        $this->imageModel = new Image();
        $this->adminUserModel = new AdminUser();
        $this->adminMenuModel = new AdminMenu();
        $this->customerModel = new Customer();
        $this->kiotvietAuth = new KiotvietAuthController();
        $this->kiotvietInvoice = new KiotvietInvoiceController();
        $this->getBranchCtrl = new getKiotvietBranchController();
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawCustomerById($id = '')
    {
        $client = $this->kiotvietAuth->doCreateClient();
        $customerResource = new CustomerResource($client);
        $customer = $customerResource->getById($id);

        dd($customer);
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawCustomerByCode($code = '')
    {
        $client = $this->kiotvietAuth->doCreateClient();
        $customerResource = new CustomerResource($client);
        $customer = $customerResource->getByCode($code);

        dd($customer);
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawCustomer($pageSize = 50)
    {
        $client = $this->kiotvietAuth->doCreateClient();
        $customerResource = new CustomerResource($client);
        $customer = new Customer();
        $criteria = new CustomerCriteria($customer);
        //
        $criteria->setPageSize($pageSize);
        $customer = $customerResource->search($criteria);

        dd($customer);
    }

    /**
     * @return Application|Factory|View
     */
    public function getRawInvoiceByCustomerCode($status = '1', $customerCode = '', $pageSize = 50, $incDelivery = 1, $incPayment = 1)
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function preloadindex()
    {
        $data['view']  = $this->viewPath . $this->view . '.preload';

        $branch = (string) strip_tags(request()->post('branch', '%'));
        $code = (string) strip_tags(request()->post('code', ''));
        $contactNumber = (string) strip_tags(request()->post('contactNumber', ''));
        $name = (string) strip_tags(request()->post('name', ''));
        $_token = (string) strip_tags(request()->post('_token', csrf_token()));
        //
        $data['action'] = 'index';
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['code'] = $code;
        $data['contactNumber'] = $contactNumber;
        $data['name'] = $name;
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

        $branch = (string) strip_tags(request()->post('branch', '%'));
        $code = (string) strip_tags(request()->post('code', ''));
        $contactNumber = (string) strip_tags(request()->post('contactNumber', ''));
        $name = (string) strip_tags(request()->post('name', ''));
        $_token = (string) strip_tags(request()->post('_token', csrf_token()));
        //
        $data['action'] = 'search';
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['code'] = $code;
        $data['contactNumber'] = $contactNumber;
        $data['name'] = $name;
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
        $data['title'] = KIOTVIET_CUSTOMER_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';

        //
        $branch = (string) strip_tags(request()->post('branch', '%'));
        $code = (string) strip_tags(request()->post('code', ''));
        $contactNumber = (string) strip_tags(request()->post('contactNumber', ''));
        $name = (string) strip_tags(request()->post('name', ''));
        //
        $client = $this->kiotvietAuth->doCreateClient();
        $pageSize = KIOTVIET_DEFAULT_PAGESIZE;
        //
        $customerResource = new CustomerResource($client);
        $customer = new Customer();
        $criteria = new CustomerCriteria($customer);
        //
        $criteria->setPageSize($pageSize);
        $criteria->setOrderBy('createdDate');
        $criteria->setOrderDirection(KIOTVIET_DEFAULT_ORD_DIRECTION);
        $criteria->setIncludeTotal(KIOTVIET_INC_CUST_TOTAL);
        //
        $total = KIOTVIET_CUSTOMER_PAGINATE;
        //
        $customerArr = array();
        $customerTotal = 0;
        //
        for ($i = 0; $i < $total; $i = $i + $pageSize) 
        {
            $criteria->setCurrentItem($i);
            $customers = $customerResource->search($criteria);
            $customerTotal = $customers->getTotal();
            //
            $customerItems = $customers->getItems();
            foreach ($customerItems as $key => $item) 
            {
                $customerItems[$item->getId()] = $customerItems[$key];
                unset($customerItems[$key]);
            }
            $customerArr += $customerItems;
        }

        // dd($total, count($customerArr));

        //
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['code'] = $code;
        $data['contactNumber'] = $contactNumber;
        $data['name'] = $name;
        //
        $customerArr = CollectionPaginateHelper::paginateSec($customerArr, PAGINATE_PERPAGE);
        // dd($customerArr);
        $data['customerArr'] = $customerArr;
        $data['customerTotal'] = $customerTotal;
        //
        return view($data['view'] , compact('data'));
    }

    /**
     * @param $id
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $data['title'] = KIOTVIET_CUSTOMER_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.filter';

        //
        $branch = (string) strip_tags(request()->post('branch', '%'));
        $code = (string) strip_tags(request()->post('code', ''));
        $contactNumber = (string) strip_tags(request()->post('contactNumber', ''));
        $name = (string) strip_tags(request()->post('name', ''));
        //
        $client = $this->kiotvietAuth->doCreateClient();
        $pageSize = KIOTVIET_DEFAULT_PAGESIZE;
        //
        $customerResource = new CustomerResource($client);
        $customer = new Customer();
        $criteria = new CustomerCriteria($customer);
        //
        $criteria->setPageSize($pageSize);
        $criteria->setOrderBy('createdDate');
        $criteria->setOrderDirection(KIOTVIET_DEFAULT_ORD_DIRECTION);
        $criteria->setIncludeTotal(KIOTVIET_INC_CUST_TOTAL);
        //
        if($code != '')
        {
            $criteria->setCode($code);
        }

        if($name != '')
        {
            $criteria->setName($name);
        }

        if($contactNumber != '')
        {
            $criteria->setContactNumber($contactNumber);
        }
        //
        $total = KIOTVIET_CUSTOMER_PAGINATE;
        //
        $customerArr = array();
        //
        for ($i = 0; $i < $total; $i = $i + $pageSize) 
        {
            $criteria->setCurrentItem($i);
            $customers = $customerResource->search($criteria);
            //
            $customerItems = $customers->getItems();
            foreach ($customerItems as $key => $item) 
            {
                $customerItems[$item->getId()] = $customerItems[$key];
                unset($customerItems[$key]);
            }
            $customerArr += $customerItems;
        }

        // dd($total, count($customerArr));

        //
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['code'] = $code;
        $data['contactNumber'] = $contactNumber;
        $data['name'] = $name;
        //
        $customerArr = CollectionPaginateHelper::paginateSec($customerArr, PAGINATE_PERPAGE);
        // dd($customerArr);
        $data['customerArr'] = $customerArr;
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
        $customerResource = new CustomerResource($client);
        //
        $user = Auth::guard('admin')->user();
        $data['adminName']  = $user->username;
        $data['adminId']  = $user->aduser_id;
        //
        $id = (int) request()->get('id', 0);
        $code = (string) request()->get('code', '');
        if($id != 0)
        {
            $customer = $customerResource->getById($id);
        }
        if($code != 'code')
        {
            $customer = $customerResource->getByCode($code);
        }

        if($customer){
            $data['title'] = KIOTVIET_CUSTOMER_TITLE.SHOW_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['customer'] = $customer;
            $data['name'] = $customer->getName();
            $data['contactNumber'] = $customer->getContactNumber();
            $data['gender'] = $customer->getGender();
            $data['birthDate'] = $customer->getBirthDate();
            $data['address'] = $customer->getLocationName();
            $data['locationName'] = $customer->getLocationName();
            $data['email'] = $customer->getEmail();
            $data['organization'] = $customer->getOrganization();
            $data['comment'] = $customer->getComment();
            $data['taxCode'] = $customer->getTaxCode();
            $data['debt'] = $customer->getDebt();
            $data['totalPoint'] = $customer->getTotalPoint();
            $data['totalRevenue'] = $customer->getTotalRevenue();
            $data['rewardPoint'] = $customer->getRewardPoint();
            $data['totalInvoiced'] = $customer->getTotalInvoiced();
            $data['groupId'] = $customer->getGroupId();
            $data['groups'] = $customer->getGroups();
            $data['groupIds'] = $customer->getGroupIds();
            $data['customerGroupDetails'] = $customer->getCustomerGroupDetails();
            $data['id'] = $customer->getId();
            $data['code'] = $customer->getCode();
            $data['createdDate'] = $customer->getCreatedDate();
            $data['modifiedDate'] = $customer->getModifiedDate();
            $data['retailerId'] = $customer->getRetailerId();
            $data['otherProperties'] = $customer->getOtherProperties();

            $customerCode = $data['code'];
            if(!empty($customerCode))
            {
                $invoices = $this->kiotvietInvoice->listInvoiceByCustomerCode($customerCode, 100, 1, 1);
                $data['invoices'] = $invoices->getItems();
            }

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy khách hàng';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }
}