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
use App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\Children\getTotalInvoiceController;

class KiotvietInvoiceReportOverviewController extends BaseController
{
    private $view = '.kiotvietinvoicereportoverview';
    private $model = 'kiotvietinvoicereportoverview';
    private $adminUserModel;
    private $kiotvietAuth;
    private $getBranchCtrl;
    private $getTotalInvoiceCtrl;

    public function __construct()
    {
        $this->adminUserModel = new AdminUser();
        $this->invoiceModel = new Invoice();
        $this->kiotvietAuth = new KiotvietAuthController();
        $this->getBranchCtrl = new getKiotvietBranchController();
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
    public function FnInvoices($frmDate = '', $toDate = '', $branch = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalInvoiceCtrl->doGetInvoices($frmDate, $toDate, $branch);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FnTotalInvoiceCompletedByDate($data, $branch = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalInvoiceCtrl->doGetTotalInvoiceCompletedByDate($data, $branch);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FnTotalInvoices($data, $branch = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalInvoiceCtrl->doGetTotalInvoices($data, $branch);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FnTotalAmount($data, $branch = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalInvoiceCtrl->doGetTotalAmount($data, $branch);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FnTotalInvoiceCompleted($data, $branch = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalInvoiceCtrl->doGetTotalInvoiceCompleted($data, $branch);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FnTotalAmountCompleted($data, $branch = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalInvoiceCtrl->doGetTotalAmountCompleted($data, $branch);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FnTotalInvoiceProcess($data, $branch = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalInvoiceCtrl->doGetTotalInvoiceProcess($data, $branch);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FnTotalAmountProcess($data, $branch = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalInvoiceCtrl->doGetTotalAmountProcess($data, $branch);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FnTotalInvoiceCanceled($data, $branch = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalInvoiceCtrl->doGetTotalInvoiceCanceled($data, $branch);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FnTotalAmountCanceled($data, $branch = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalInvoiceCtrl->doGetTotalAmountCanceled($data, $branch);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FnTotalInvoiceLatest($data, $branch = '%', $mLimit = 10)
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalInvoiceCtrl->doGetInvoiceLatest($data, $branch, $mLimit);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }              

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $data['title'] = KIOTVIET_INVOICE_REPORT_TITLE;
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
        $invoices = $this->FnInvoices($frmDate, $toDate, $branch);
        //
        $totalInvoiceCompletedByDate = $this->FnTotalInvoiceCompletedByDate($invoices, $branch);
        //
        $totalInvoices = $this->FnTotalInvoices($invoices, $branch);
        $totalInvoicesCompleted = $this->FnTotalInvoiceCompleted($invoices, $branch);
        $totalInvoicesProcess = $this->FnTotalInvoiceProcess($invoices, $branch);
        $totalInvoicesCanceled = $this->FnTotalInvoiceCanceled($invoices, $branch);
        //
        $totalAmount = $this->FnTotalAmount($invoices, $branch);
        $totalAmountCompleted = $this->FnTotalAmountCompleted($invoices, $branch);
        $totalAmountProcess = $this->FnTotalAmountProcess($invoices, $branch);
        $totalAmountCanceled = $this->FnTotalAmountCanceled($invoices, $branch);
        //
        $invoiceLatest = $this->FnTotalInvoiceLatest($invoices, $branch, $mLimit);
        //
        $data['invoices'] = $invoices;
        $data['totalInvoiceCompletedByDate'] = $totalInvoiceCompletedByDate;
        $data['invoiceLatest'] = $invoiceLatest;
        //
        $data['totalInvoices'] = $totalInvoices;
        $data['totalInvoicesCompleted'] = $totalInvoicesCompleted;
        $data['totalInvoicesProcess'] = $totalInvoicesProcess;
        $data['totalInvoicesCanceled'] = $totalInvoicesCanceled;
        //
        $data['totalAmount'] = $totalAmount;
        $data['totalAmountCompleted'] = $totalAmountCompleted;
        $data['totalAmountProcess'] = $totalAmountProcess;
        $data['totalAmountCanceled'] = $totalAmountCanceled;
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
        $data['title'] = KIOTVIET_INVOICE_REPORT_TITLE;
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
        $invoices = $this->FnInvoices($frmDate, $toDate, $branch);
        //
        $totalInvoiceCompletedByDate = $this->FnTotalInvoiceCompletedByDate($invoices, $branch);
        //
        $totalInvoices = $this->FnTotalInvoices($invoices, $branch);
        $totalInvoicesCompleted = $this->FnTotalInvoiceCompleted($invoices, $branch);
        $totalInvoicesProcess = $this->FnTotalInvoiceProcess($invoices, $branch);
        $totalInvoicesCanceled = $this->FnTotalInvoiceCanceled($invoices, $branch);
        //
        $totalAmount = $this->FnTotalAmount($invoices, $branch);
        $totalAmountCompleted = $this->FnTotalAmountCompleted($invoices, $branch);
        $totalAmountProcess = $this->FnTotalAmountProcess($invoices, $branch);
        $totalAmountCanceled = $this->FnTotalAmountCanceled($invoices, $branch);
        //
        $invoiceLatest = $this->FnTotalInvoiceLatest($invoices, $branch, $mLimit);
        //
        $data['invoices'] = $invoices;
        $data['totalInvoiceCompletedByDate'] = $totalInvoiceCompletedByDate;
        $data['invoiceLatest'] = $invoiceLatest;
        //
        $data['totalInvoices'] = $totalInvoices;
        $data['totalInvoicesCompleted'] = $totalInvoicesCompleted;
        $data['totalInvoicesProcess'] = $totalInvoicesProcess;
        $data['totalInvoicesCanceled'] = $totalInvoicesCanceled;
        //
        $data['totalAmount'] = $totalAmount;
        $data['totalAmountCompleted'] = $totalAmountCompleted;
        $data['totalAmountProcess'] = $totalAmountProcess;
        $data['totalAmountCanceled'] = $totalAmountCanceled;
        //
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['mLimit'] = $mLimit;

        return view($data['view'] , compact('data'));
    }
}
