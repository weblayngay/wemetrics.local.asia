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
use App\Http\Controllers\Backend\Order\Report\Children\getTotalOrderController;

class OrderWebsiteReportOverviewController extends BaseController
{
    private $view = '.orderwebsitereportoverview';
    private $model = 'orderwebsitereportoverview';
    private $adminUserModel;

    private $orderModel;
    private $orderItemModel;
    private $orderUserInfoModel;
    private $orderProductModel;
    private $orderProductCatModel;
    private $getTotalOrderCtrl;

    public function __construct()
    {
        $this->adminUserModel = new AdminUser();
        $this->orderModel = new lt4ProductsOrders();
        $this->orderItemModel = new lt4ProductsOrdersDetail();
        $this->orderUserInfoModel = new lt4ProductsOrdersUserInfo();
        $this->orderProductModel = new lt4Products();
        $this->orderProductCatModel = new lt4ProductsCategories();
        $this->getTotalOrderCtrl = new getTotalOrderController();
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrder($frmDate = '', $toDate = '')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderCtrl->doGetTotalOrder($frmDate, $toDate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrderLatest($frmDate = '', $toDate = '', $mLimit = 10)
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderCtrl->doGetTotalOrderLatest($frmDate, $toDate, $mLimit);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrderProcessing($frmDate = '', $toDate = '')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderCtrl->doGetOrderProcessing($frmDate, $toDate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrderShipping($frmDate = '', $toDate = '')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderCtrl->doGetOrderShipping($frmDate, $toDate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrderCanceled($frmDate = '', $toDate = '')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderCtrl->doGetOrderCanceled($frmDate, $toDate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrderByDate($frmDate = '', $toDate = '')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderCtrl->doGetTotalOrderByDate($frmDate, $toDate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrderCompleted($frmDate = '', $toDate = '')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderCtrl->doGetOrderCompleted($frmDate, $toDate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrderPaid($frmDate = '', $toDate = '')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderCtrl->doGetOrderPaid($frmDate, $toDate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrderPayOnline($frmDate = '', $toDate = '')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderCtrl->doGetOrderPayOnline($frmDate, $toDate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrderItems($frmDate = '', $toDate = '', $mLimit = '10')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderCtrl->doGetTotalOrderItems($frmDate, $toDate, $mLimit);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }   

    /**
     * @return Application|Factory|View
     */
    public function FntotalOrderCatItems($frmDate = '', $toDate = '')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalOrderCtrl->doGetTotalOrderCatItems($frmDate, $toDate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }               

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $data['title'] = ORDER_WEBSITE_REPORT_OVERVIEW_TITLE;
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

        $mLimit = (string) strip_tags(request()->post('mLimit', '10'));

        /**
         * order
         */
        $orders = $this->FntotalOrder($frmDate, $toDate);
        $orderLatest = $this->FntotalOrderLatest($frmDate, $toDate);
        $orderProcessing = $this->FntotalOrderProcessing($frmDate, $toDate);
        $orderShipping = $this->FntotalOrderShipping($frmDate, $toDate);
        $orderCanceled = $this->FntotalOrderCanceled($frmDate, $toDate);
        $orderCompleted = $this->FntotalOrderCompleted($frmDate, $toDate);
        $orderPaid = $this->FntotalOrderPaid($frmDate, $toDate);
        $orderPayOnline = $this->FntotalOrderPayOnline($frmDate, $toDate);
        $orderItems = $this->FntotalOrderItems($frmDate, $toDate, $mLimit);
        $orderCatItems = $this->FntotalOrderCatItems($frmDate, $toDate);

        $orderSumTotal = (string) $orders->sum('order_total');
        $orderSumDiscount = (string) $orders->sum('vdiscount');
        $orderSumEngraveFee = (string) $orders->sum('engrave_fee');
        $orderSumAmount = (string) $orders->sum('amount');
        $orderPaidSumTotal = (string) $orderPaid->sum('order_total');
        $orderPaidSumDiscount = (string) $orderPaid->sum('vdiscount');
        $orderPaidSumEngraveFee = (string) $orderPaid->sum('engrave_fee');
        $orderPaidSumAmount = (string) $orderPaid->sum('amount');
        //
        $totalOrderByDate = $this->FntotalOrderByDate($frmDate, $toDate);
        //
        $data['orders'] = $orders;
        $data['orderProcessing'] = $orderProcessing;
        $data['orderShipping'] = $orderShipping;
        $data['orderCanceled'] = $orderCanceled;
        $data['orderCompleted'] = $orderCompleted;
        $data['orderPaid'] = $orderPaid;
        $data['orderPayOnline'] = $orderPayOnline;
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
        $data['orderCatItems'] = (object) $orderCatItems;
        //
        $data['totalOrderByDate'] = $totalOrderByDate;
        //
        $data['mLimit'] = $mLimit;

        return view($data['view'] , compact('data'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stats()
    {
        $data['title'] = ORDER_WEBSITE_REPORT_OVERVIEW_TITLE;
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

        $mLimit = (string) strip_tags(request()->post('mLimit', '10'));

        /**
         * order
         */
        $orders = $this->FntotalOrder($frmDate, $toDate);
        $orderLatest = $this->FntotalOrderLatest($frmDate, $toDate);
        $orderProcessing = $this->FntotalOrderProcessing($frmDate, $toDate);
        $orderShipping = $this->FntotalOrderShipping($frmDate, $toDate);
        $orderCanceled = $this->FntotalOrderCanceled($frmDate, $toDate);
        $orderCompleted = $this->FntotalOrderCompleted($frmDate, $toDate);
        $orderPaid = $this->FntotalOrderPaid($frmDate, $toDate);
        $orderPayOnline = $this->FntotalOrderPayOnline($frmDate, $toDate);
        $orderItems = $this->FntotalOrderItems($frmDate, $toDate, $mLimit);
        $orderCatItems = $this->FntotalOrderCatItems($frmDate, $toDate);

        $orderSumTotal = (string) $orders->sum('order_total');
        $orderSumDiscount = (string) $orders->sum('vdiscount');
        $orderSumEngraveFee = (string) $orders->sum('engrave_fee');
        $orderSumAmount = (string) $orders->sum('amount');
        $orderPaidSumTotal = (string) $orderPaid->sum('order_total');
        $orderPaidSumDiscount = (string) $orderPaid->sum('vdiscount');
        $orderPaidSumEngraveFee = (string) $orderPaid->sum('engrave_fee');
        $orderPaidSumAmount = (string) $orderPaid->sum('amount');
        //
        $totalOrderByDate = $this->FntotalOrderByDate($frmDate, $toDate);
        //
        $data['orders'] = $orders;
        $data['orderProcessing'] = $orderProcessing;
        $data['orderShipping'] = $orderShipping;
        $data['orderCanceled'] = $orderCanceled;
        $data['orderCompleted'] = $orderCompleted;
        $data['orderPaid'] = $orderPaid;
        $data['orderPayOnline'] = $orderPayOnline;
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
        $data['orderCatItems'] = (object) $orderCatItems;
        //
        $data['totalOrderByDate'] = $totalOrderByDate;
        //
        $data['mLimit'] = $mLimit;

        return view($data['view'] , compact('data'));
    }
}
