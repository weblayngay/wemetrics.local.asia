<?php

namespace App\Http\Controllers\Backend\Intergrate\Kiotviet\Report;

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
use App\Http\Controllers\Backend\Intergrate\Kiotviet\Auth\KiotvietAuthController;
use VienThuong\KiotVietClient;
use VienThuong\KiotVietClient\Model\Invoice;
use VienThuong\KiotVietClient\Model\InvoiceDetail;
use VienThuong\KiotVietClient\Criteria\InvoiceCriteria;
use VienThuong\KiotVietClient\Criteria\InvoiceDetailCriteria;
use VienThuong\KiotVietClient\Resource\InvoiceResource;
use VienThuong\KiotVietClient\Resource\InvoiceDetailResource;
use Vienthuong\KiotVietClient\Exception\KiotVietException;
use DB;
use App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\Children\getKiotvietBranchController;
use App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\Children\getTotalCustomerController;
use App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\Children\getTotalInvoiceController;

class KiotvietCustomerReportOverviewController extends BaseController
{
    private $view = '.kiotvietcustomerreportoverview';
    private $model = 'kiotvietcustomerreportoverview';
    private $adminUserModel;
    private $kiotvietAuth;
    private $getBranchCtrl;
    private $getTotalCustomerCtrl;

    public function __construct()
    {
        $this->adminUserModel = new AdminUser();
        $this->invoiceModel = new Invoice();
        $this->kiotvietAuth = new KiotvietAuthController();
        $this->getBranchCtrl = new getKiotvietBranchController();
        $this->getTotalCustomerCtrl = new getTotalCustomerController();
        $this->getTotalInvoiceCtrl = new getTotalInvoiceController();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function preloadindex()
    {
        $data['view']  = $this->viewPath . $this->view . '.preload';
        $data['action'] = 'index';
        return view($data['view'] , compact('data'));
    } 

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function preloadstats()
    {
        $data['view']  = $this->viewPath . $this->view . '.preload';

        $frmDate = (string) strip_tags(request()->post('frmDate', date('Y-m-01')));
        $toDate = (string) strip_tags(request()->post('toDate', date('Y-m-d')));
        $branch = (string) strip_tags(request()->post('branch', '%'));
        $mLimit = (string) strip_tags(request()->post('mLimit', KIOTVIET_DEFAULT_LIMIT));
        $_token = (string) strip_tags(request()->post('_token', csrf_token()));
        //
        $data['action'] = 'stats';
        $data['frmDate'] = $frmDate;
        $data['toDate'] = $toDate;
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['mLimit'] = $mLimit;
        $data['_token'] = $_token;
        //
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function FnTotalInvoices($frmDate = '', $toDate = '', $branch = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalCustomerCtrl->doGetInvoices($frmDate, $toDate, $branch);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }      

    /**
     * @return Application|Factory|View
     */
    public function FnTotalCustomerByDate($data, $branch = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalCustomerCtrl->doGetTotalCustomerByDate($data, $branch);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }  

    /**
     * @return Application|Factory|View
     */
    public function FntotalInvoiceLatest($data, $branch = '%', $mLimit = 10)
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalCustomerCtrl->doGetInvoiceLatest($data, $branch, $mLimit);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }         

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $data['title'] = KIOTVIET_CUSTOMER_REPORT_TITLE;
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

        $branch = (string) strip_tags(request()->post('branch', '%'));
        $mLimit = (string) strip_tags(request()->post('mLimit', KIOTVIET_DEFAULT_LIMIT));
        //
        $invoices = $this->FnTotalInvoices($frmDate, $toDate, $branch, $mLimit);
        $invoiceLatest = $this->FntotalInvoiceLatest($invoices, $branch, $mLimit);
        //
        $totalCustomerByDate = $this->FnTotalCustomerByDate($invoices, $branch);
        //
        $data['invoiceLatest'] = $invoiceLatest;
        //
        $data['totalCustomerByDate'] = $totalCustomerByDate;
        //
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['mLimit'] = $mLimit;

        return view($data['view'] , compact('data'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stats()
    {
        $data['title'] = KIOTVIET_CUSTOMER_REPORT_TITLE;
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

        $branch = (string) strip_tags(request()->post('branch', '%'));
        $mLimit = (string) strip_tags(request()->post('mLimit', KIOTVIET_DEFAULT_LIMIT));
        //
        $invoices = $this->FnTotalInvoices($frmDate, $toDate, $branch, $mLimit);
        $invoiceLatest = $this->FntotalInvoiceLatest($invoices, $branch, $mLimit);
        //
        $totalCustomerByDate = $this->FnTotalCustomerByDate($invoices, $branch);
        //
        $data['invoiceLatest'] = $invoiceLatest;
        //
        $data['totalCustomerByDate'] = $totalCustomerByDate;
        //
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['mLimit'] = $mLimit;

        return view($data['view'] , compact('data'));
    }
}
