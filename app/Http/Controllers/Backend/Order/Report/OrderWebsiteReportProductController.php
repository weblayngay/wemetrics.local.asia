<?php

namespace App\Http\Controllers\Backend\Order\Report;

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
use App\Helpers\CollectionPaginateHelper;
use App\Models\AdminUser;
use App\Models\Websites\W0001\lt4ProductsOrders;
use App\Models\Websites\W0001\lt4ProductsOrdersDetail;
use App\Models\Websites\W0001\lt4ProductsOrdersUserInfo;
use App\Models\Websites\W0001\lt4Products;
use App\Models\Websites\W0001\lt4ProductsCategories;
use DB;
use App\Http\Controllers\Backend\Order\Report\Children\getTotalOrderByProductController;
use App\Http\Controllers\Backend\Order\Report\Children\getResellerController;

class OrderWebsiteReportProductController extends BaseController
{
    private $view = '.orderwebsitereportproduct';
    private $model = 'orderwebsitereportproduct';
    private $adminUserModel;

    private $orderModel;
    private $orderItemModel;
    private $orderUserInfoModel;
    private $orderProductModel;
    private $orderProductCatModel;
    private $getTotalOrderProductCtrl;
    private $getResellerCtrl;

    public function __construct()
    {
        $this->adminUserModel = new AdminUser();
        $this->orderModel = new lt4ProductsOrders();
        $this->orderItemModel = new lt4ProductsOrdersDetail();
        $this->orderUserInfoModel = new lt4ProductsOrdersUserInfo();
        $this->orderProductModel = new lt4Products();
        $this->orderProductCatModel = new lt4ProductsCategories();
        $this->getTotalOrderProductCtrl = new getTotalOrderByProductController();
        $this->getResellerCtrl = new getResellerController();
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrder($frmDate = '', $toDate = '', $reseller = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderProductCtrl->doGetTotalOrder($frmDate, $toDate, $reseller);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrderLatest($frmDate = '', $toDate = '', $mLimit = 10, $reseller = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderProductCtrl->doGetTotalOrderLatest($frmDate, $toDate, $mLimit, $reseller);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrderProcessing($frmDate = '', $toDate = '', $reseller = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderProductCtrl->doGetOrderProcessing($frmDate, $toDate, $reseller);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrderShipping($frmDate = '', $toDate = '', $reseller = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderProductCtrl->doGetOrderShipping($frmDate, $toDate, $reseller);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrderCanceled($frmDate = '', $toDate = '', $reseller = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderProductCtrl->doGetOrderCanceled($frmDate, $toDate, $reseller);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrderByDate($frmDate = '', $toDate = '', $reseller = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderProductCtrl->doGetTotalOrderByDate($frmDate, $toDate, $reseller);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrderCompleted($frmDate = '', $toDate = '', $reseller = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderProductCtrl->doGetOrderCompleted($frmDate, $toDate, $reseller);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrderPaid($frmDate = '', $toDate = '', $reseller = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderProductCtrl->doGetOrderPaid($frmDate, $toDate, $reseller);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrderPayOnline($frmDate = '', $toDate = '', $reseller = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderProductCtrl->doGetOrderPayOnline($frmDate, $toDate, $reseller);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrderByReseller($frmDate = '', $toDate = '', $reseller = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderProductCtrl->doGetTotalOrderByReseller($frmDate, $toDate, $reseller);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrderItems($frmDate = '', $toDate = '', $reseller = '%', $mLimit = '10')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderProductCtrl->doGetTotalOrderItems($frmDate, $toDate, $reseller, $mLimit);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }   

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrderCatItems($frmDate = '', $toDate = '', $reseller = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderProductCtrl->doGetTotalOrderCatItems($frmDate, $toDate, $reseller);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }     

    /**
     * @return Application|Factory|View
     */
    public function FntotalCatProductByDate($frmDate = '', $toDate = '', $reseller = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderProductCtrl->doGetCatProductByDate($frmDate, $toDate, $reseller);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }         

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $data['title'] = ORDER_WEBSITE_REPORT_PRODUCT_TITLE;
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

        $reseller = (string) strip_tags(request()->post('reseller', '%'));
        $mLimit = (string) strip_tags(request()->post('mLimit', '10'));

        /**
         * order
         */
        $orders = $this->FntotalOrder($frmDate, $toDate, $reseller);
        $orderLatest = $this->FntotalOrderLatest($frmDate, $toDate, $mLimit, $reseller);
        $orderProcessing = $this->FntotalOrderProcessing($frmDate, $toDate, $reseller);
        $orderShipping = $this->FntotalOrderShipping($frmDate, $toDate, $reseller);
        $orderCanceled = $this->FntotalOrderCanceled($frmDate, $toDate, $reseller);
        $orderCompleted = $this->FntotalOrderCompleted($frmDate, $toDate, $reseller);
        $orderPaid = $this->FntotalOrderPaid($frmDate, $toDate, $reseller);
        $orderPayOnline = $this->FntotalOrderPayOnline($frmDate, $toDate, $reseller);
        $orderByReseller = $this->FntotalOrderByReseller($frmDate, $toDate, $reseller);
        $orderItems = $this->FntotalOrderItems($frmDate, $toDate, $reseller, $mLimit);
        $orderCatItems = $this->FntotalOrderCatItems($frmDate, $toDate, $reseller);
        $orderCatItemsByDate = $this->FntotalCatProductByDate($frmDate, $toDate, $reseller);

        $orderSumTotal = (string) $orders->sum('order_total');
        $orderSumDiscount = (string) $orders->sum('vdiscount');
        $orderSumEngraveFee = (string) $orders->sum('engrave_fee');
        $orderSumAmount = (string) $orders->sum('amount');
        $orderPaidSumTotal = (string) $orderPaid->sum('order_total');
        $orderPaidSumDiscount = (string) $orderPaid->sum('vdiscount');
        $orderPaidSumEngraveFee = (string) $orderPaid->sum('engrave_fee');
        $orderPaidSumAmount = (string) $orderPaid->sum('amount');

        $totalAmount = array();
        $totalAmount['0']['label'] = 'Thành tiền';
        $totalAmount['0']['total'] = $orderSumTotal;
        $totalAmount['1']['label'] = 'Chiết khấu';
        $totalAmount['1']['total'] = $orderSumDiscount;
        $totalAmount['2']['label'] = 'Phí khắc';
        $totalAmount['2']['total'] = $orderSumEngraveFee;

        $totalPaid = array();
        $totalPaid['0']['label'] = 'Thành tiền';
        $totalPaid['0']['total'] = $orderPaidSumTotal;
        $totalPaid['1']['label'] = 'Chiết khấu';
        $totalPaid['1']['total'] = $orderPaidSumDiscount;
        $totalPaid['2']['label'] = 'Phí khắc';
        $totalPaid['2']['total'] = $orderPaidSumEngraveFee;

        $totalOrder = array();
        $totalOrder['0']['label'] = 'Đang xử lý';
        $totalOrder['0']['total'] = $orderProcessing->count();
        $totalOrder['1']['label'] = 'Online';
        $totalOrder['1']['total'] = $orderPayOnline->count();
        $totalOrder['2']['label'] = 'Hủy';
        $totalOrder['2']['total'] = $orderCanceled->count();
        //
        $totalOrderByDate = $this->FntotalOrderByDate($frmDate, $toDate, $reseller);
        //
        $data['orders'] = $orders;
        $data['orderProcessing'] = $orderProcessing;
        $data['orderShipping'] = $orderShipping;
        $data['orderCanceled'] = $orderCanceled;
        $data['orderCompleted'] = $orderCompleted;
        $data['orderPaid'] = $orderPaid;
        $data['orderPayOnline'] = $orderPayOnline;
        $data['orderByReseller'] = $orderByReseller;
        //
        $data['orderSumTotal'] = $orderSumTotal;
        $data['orderSumDiscount'] = $orderSumDiscount;
        $data['orderSumEngraveFee'] = $orderSumEngraveFee;
        $data['orderSumAmount'] = $orderSumAmount;
        $data['orderPaidSumTotal'] = $orderPaidSumTotal;
        $data['orderPaidSumDiscount'] = $orderPaidSumDiscount;
        $data['orderPaidSumEngraveFee'] = $orderPaidSumEngraveFee;
        $data['orderPaidSumAmount'] = $orderPaidSumAmount;
        //
        $data['orderLatest'] = $orderLatest;
        $data['orderItems'] = $orderItems;
        $data['orderCatItems'] = $orderCatItems;
        $data['orderCatItemsByDate'] = $orderCatItemsByDate;
        //
        $data['totalOrderByDate'] = $totalOrderByDate;
        $data['totalAmount'] = $totalAmount;
        $data['totalPaid'] = $totalPaid;
        $data['totalOrder'] = $totalOrder;
        //
        $data['reseller'] = $reseller;
        $data['mLimit'] = $mLimit;
        $data['resellers'] = $this->getResellerCtrl->doQuery('%');

        return view($data['view'] , compact('data'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stats()
    {
        $data['title'] = ORDER_WEBSITE_REPORT_PRODUCT_TITLE;
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

        $reseller = (string) strip_tags(request()->post('reseller', '%'));
        $mLimit = (string) strip_tags(request()->post('mLimit', '10'));

        /**
         * order
         */
        $orders = $this->FntotalOrder($frmDate, $toDate, $reseller);
        $orderLatest = $this->FntotalOrderLatest($frmDate, $toDate, $mLimit, $reseller);
        $orderProcessing = $this->FntotalOrderProcessing($frmDate, $toDate, $reseller);
        $orderShipping = $this->FntotalOrderShipping($frmDate, $toDate, $reseller);
        $orderCanceled = $this->FntotalOrderCanceled($frmDate, $toDate, $reseller);
        $orderCompleted = $this->FntotalOrderCompleted($frmDate, $toDate, $reseller);
        $orderPaid = $this->FntotalOrderPaid($frmDate, $toDate, $reseller);
        $orderPayOnline = $this->FntotalOrderPayOnline($frmDate, $toDate, $reseller);
        $orderByReseller = $this->FntotalOrderByReseller($frmDate, $toDate, $reseller);
        $orderItems = $this->FntotalOrderItems($frmDate, $toDate, $reseller, $mLimit);
        $orderCatItems = $this->FntotalOrderCatItems($frmDate, $toDate, $reseller);
        $orderCatItemsByDate = $this->FntotalCatProductByDate($frmDate, $toDate, $reseller);

        $orderSumTotal = (string) $orders->sum('order_total');
        $orderSumDiscount = (string) $orders->sum('vdiscount');
        $orderSumEngraveFee = (string) $orders->sum('engrave_fee');
        $orderSumAmount = (string) $orders->sum('amount');
        $orderPaidSumTotal = (string) $orderPaid->sum('order_total');
        $orderPaidSumDiscount = (string) $orderPaid->sum('vdiscount');
        $orderPaidSumEngraveFee = (string) $orderPaid->sum('engrave_fee');
        $orderPaidSumAmount = (string) $orderPaid->sum('amount');

        $totalAmount = array();
        $totalAmount['0']['label'] = 'Thành tiền';
        $totalAmount['0']['total'] = $orderSumTotal;
        $totalAmount['1']['label'] = 'Chiết khấu';
        $totalAmount['1']['total'] = $orderSumDiscount;
        $totalAmount['2']['label'] = 'Phí khắc';
        $totalAmount['2']['total'] = $orderSumEngraveFee;

        $totalPaid = array();
        $totalPaid['0']['label'] = 'Thành tiền';
        $totalPaid['0']['total'] = $orderPaidSumTotal;
        $totalPaid['1']['label'] = 'Chiết khấu';
        $totalPaid['1']['total'] = $orderPaidSumDiscount;
        $totalPaid['2']['label'] = 'Phí khắc';
        $totalPaid['2']['total'] = $orderPaidSumEngraveFee;

        $totalOrder = array();
        $totalOrder['0']['label'] = 'Đang xử lý';
        $totalOrder['0']['total'] = $orderProcessing->count();
        $totalOrder['1']['label'] = 'Online';
        $totalOrder['1']['total'] = $orderPayOnline->count();
        $totalOrder['2']['label'] = 'Hủy';
        $totalOrder['2']['total'] = $orderCanceled->count();
        //
        $totalOrderByDate = $this->FntotalOrderByDate($frmDate, $toDate, $reseller);
        //
        $data['orders'] = $orders;
        $data['orderProcessing'] = $orderProcessing;
        $data['orderShipping'] = $orderShipping;
        $data['orderCanceled'] = $orderCanceled;
        $data['orderCompleted'] = $orderCompleted;
        $data['orderPaid'] = $orderPaid;
        $data['orderPayOnline'] = $orderPayOnline;
        $data['orderByReseller'] = $orderByReseller;
        //
        $data['orderSumTotal'] = $orderSumTotal;
        $data['orderSumDiscount'] = $orderSumDiscount;
        $data['orderSumEngraveFee'] = $orderSumEngraveFee;
        $data['orderSumAmount'] = $orderSumAmount;
        $data['orderPaidSumTotal'] = $orderPaidSumTotal;
        $data['orderPaidSumDiscount'] = $orderPaidSumDiscount;
        $data['orderPaidSumEngraveFee'] = $orderPaidSumEngraveFee;
        $data['orderPaidSumAmount'] = $orderPaidSumAmount;
        //
        $data['orderLatest'] = $orderLatest;
        $data['orderItems'] = $orderItems;
        $data['orderCatItems'] = $orderCatItems;
        $data['orderCatItemsByDate'] = $orderCatItemsByDate;
        //
        $data['totalOrderByDate'] = $totalOrderByDate;
        $data['totalAmount'] = $totalAmount;
        $data['totalPaid'] = $totalPaid;
        $data['totalOrder'] = $totalOrder;
        //
        $data['reseller'] = $reseller;
        $data['mLimit'] = $mLimit;
        $data['resellers'] = $this->getResellerCtrl->doQuery('%');

        return view($data['view'] , compact('data'));
    }
}
