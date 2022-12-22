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
use VienThuong\KiotVietClient\Model\Product;
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
use App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\Children\getTotalProductController;

class KiotvietProductReportOverviewController extends BaseController
{
    private $view = '.kiotvietproductreportoverview';
    private $model = 'kiotvietproductreportoverview';
    private $adminUserModel;
    private $productModel;
    private $invoiceModel;
    private $kiotvietAuth;
    private $getBranchCtrl;
    private $getTotalProductCtrl;
    private $getTotalInvoiceCtrl;

    public function __construct()
    {
        $this->adminUserModel = new AdminUser();
        $this->productModel = new Product();
        $this->invoiceModel = new Invoice();
        $this->kiotvietAuth = new KiotvietAuthController();
        $this->getBranchCtrl = new getKiotvietBranchController();
        $this->getTotalProductCtrl = new getTotalProductController();
        $this->getTotalInvoiceCtrl = new getTotalInvoiceController();
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
        $code = (string) strip_tags(request()->post('code', '%'));
        $mLimit = (string) strip_tags(request()->post('mLimit', KIOTVIET_DEFAULT_LIMIT));
        //
        $data['action'] = 'index';
        $data['frmDate'] = $frmDate;
        $data['toDate'] = $toDate;
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['code'] = $code;
        $data['codes'] = $this->getTotalProductCtrl->getListProduct();
        $data['mLimit'] = $mLimit;
        //
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
        $code = (string) strip_tags(request()->post('code', '%'));
        $mLimit = (string) strip_tags(request()->post('mLimit', KIOTVIET_DEFAULT_LIMIT));
        $_token = (string) strip_tags(request()->post('_token', csrf_token()));
        //
        $data['action'] = 'stats';
        $data['frmDate'] = $frmDate;
        $data['toDate'] = $toDate;
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['code'] = $code;
        $data['codes'] = $this->getTotalProductCtrl->getListProduct();
        $data['mLimit'] = $mLimit;
        $data['_token'] = $_token;
        //
        return view($data['view'] , compact('data'));
    }      

    /**
     * @return Application|Factory|View
     */
    public function FnTotalProduct($frmDate = '', $toDate = '', $branch = '%', $code = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalProductCtrl->doGetProduct($frmDate, $toDate, $branch, $code);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FnTotalProductByDate($data)
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalProductCtrl->doGetTotalProductByDate($data);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    } 

    /**
     * @return Application|Factory|View
     */
    public function FnProductInventory($now = '', $code = '%', $branch = '%', $data)
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalProductCtrl->doGetProductInventory($now, $code, $branch, $data);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    } 

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $data['title'] = KIOTVIET_PRODUCT_REPORT_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';
        $data['action'] = 'index';

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
        $code = (string) strip_tags(request()->post('code', '%'));
        $mLimit = (string) strip_tags(request()->post('mLimit', KIOTVIET_DEFAULT_LIMIT));
        $now = (string) date('Y-m-d');
        //
        $user = Auth::guard('admin')->user();
        $adgroup = $user->adgroup_id;
        //
        $totalProduct = $this->FnTotalProduct($frmDate, $toDate, $branch, $code);
        $totalProductByDate = $this->FnTotalProductByDate($totalProduct);
        $totalProductInventory = $this->FnProductInventory($now, $code, $branch, $totalProduct);
        //
        $data['totalProduct'] = $totalProduct;
        $data['totalProductByDate'] = $totalProductByDate;
        $data['totalProductInventory'] = $totalProductInventory;
        //
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['code'] = $code;
        $data['codes'] = $this->getTotalProductCtrl->getListProduct();
        $data['mLimit'] = $mLimit;
        //
        $data['frmDate'] = $frmDate;
        $data['toDate'] = $toDate;
        $data['now'] = $now;
        //
        $data['adgroup'] = $adgroup;

        return view($data['view'] , compact('data'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stats()
    {
        $data['title'] = KIOTVIET_PRODUCT_REPORT_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.list';
        $data['action'] = 'stats';

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
        $code = (string) strip_tags(request()->post('code', '%'));
        $mLimit = (string) strip_tags(request()->post('mLimit', KIOTVIET_DEFAULT_LIMIT));
        $now = (string) date('Y-m-d');
        //
        $user = Auth::guard('admin')->user();
        $adgroup = $user->adgroup_id;
        //
        $totalProduct = $this->FnTotalProduct($frmDate, $toDate, $branch, $code);
        $totalProductByDate = $this->FnTotalProductByDate($totalProduct);
        $totalProductInventory = $this->FnProductInventory($now, $code, $branch, $totalProduct);
        //
        $data['totalProduct'] = $totalProduct;
        $data['totalProductByDate'] = $totalProductByDate;
        $data['totalProductInventory'] = $totalProductInventory;
        //
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['code'] = $code;
        $data['codes'] = $this->getTotalProductCtrl->getListProduct();
        $data['mLimit'] = $mLimit;
        //
        $data['frmDate'] = $frmDate;
        $data['toDate'] = $toDate;
        $data['now'] = $now;
        //
        $data['adgroup'] = $adgroup;

        return view($data['view'] , compact('data'));
    }
}
