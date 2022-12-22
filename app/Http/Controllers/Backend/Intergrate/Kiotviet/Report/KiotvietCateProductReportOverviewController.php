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
use App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\Children\getTotalCateProductController;

class KiotvietCateProductReportOverviewController extends BaseController
{
    private $view = '.kiotvietcateproductreportoverview';
    private $model = 'kiotvietcateproductreportoverview';
    private $adminUserModel;
    private $productModel;
    private $invoiceModel;
    private $kiotvietAuth;
    private $getBranchCtrl;
    private $getTotalCateProductCtrl;
    private $getTotalProductCtrl;
    private $getTotalInvoiceCtrl;

    public function __construct()
    {
        $this->adminUserModel = new AdminUser();
        $this->productModel = new Product();
        $this->invoiceModel = new Invoice();
        $this->kiotvietAuth = new KiotvietAuthController();
        $this->getBranchCtrl = new getKiotvietBranchController();
        $this->getTotalCateProductCtrl = new getTotalCateProductController();
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
        $cateProduct = (string) strip_tags(request()->post('cateProduct', '%'));
        $mLimit = (string) strip_tags(request()->post('mLimit', KIOTVIET_DEFAULT_LIMIT));
        $_token = (string) strip_tags(request()->post('_token', csrf_token()));
        //
        $data['action'] = 'index';
        $data['frmDate'] = $frmDate;
        $data['toDate'] = $toDate;
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['cateProduct'] = $cateProduct;
        $data['cateProducts'] = $this->productModel::CATEGORIES;
        $data['mLimit'] = $mLimit;
        $data['mLimits'] = KIOTVIET_DEFAULT_LIMIT_ARR;
        $data['_token'] = $_token;
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
        $cateProduct = (string) strip_tags(request()->post('cateProduct', '%'));
        $mLimit = (string) strip_tags(request()->post('mLimit', KIOTVIET_DEFAULT_LIMIT));
        $_token = (string) strip_tags(request()->post('_token', csrf_token()));
        //
        $data['action'] = 'stats';
        $data['frmDate'] = $frmDate;
        $data['toDate'] = $toDate;
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['cateProduct'] = $cateProduct;
        $data['cateProducts'] = $this->productModel::CATEGORIES;
        $data['mLimit'] = $mLimit;
        $data['mLimits'] = KIOTVIET_DEFAULT_LIMIT_ARR;
        $data['_token'] = $_token;
        //
        return view($data['view'] , compact('data'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function preloaddrilldownbranchandcateproduct()
    {
        $data['view']  = $this->viewPath . $this->view . '.preload';

        $frmDate = (string) strip_tags(request()->post('frmDate', date('Y-m-01')));
        $toDate = (string) strip_tags(request()->post('toDate', date('Y-m-d')));
        $branch = (string) strip_tags(request()->post('branch', '%'));
        $cateProduct = (string) strip_tags(request()->post('cateProduct', '%'));
        $mLimit = (string) strip_tags(request()->post('mLimit', KIOTVIET_DEFAULT_LIMIT));
        $_token = (string) strip_tags(request()->post('_token', csrf_token()));
        //
        $data['action'] = 'drilldownbranchandcateproduct';
        $data['frmDate'] = $frmDate;
        $data['toDate'] = $toDate;
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['cateProduct'] = $cateProduct;
        $data['cateProducts'] = $this->productModel::CATEGORIES;
        $data['mLimit'] = $mLimit;
        $data['mLimits'] = KIOTVIET_DEFAULT_LIMIT_ARR;
        $data['_token'] = $_token;
        //
        return view($data['view'] , compact('data'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function preloaddrilldownbranchesandcateproduct()
    {
        $data['view']  = $this->viewPath . $this->view . '.preload';

        $frmDate = (string) strip_tags(request()->post('frmDate', date('Y-m-01')));
        $toDate = (string) strip_tags(request()->post('toDate', date('Y-m-d')));
        $branch = (string) strip_tags(request()->post('branch', '%'));
        $cateProduct = (string) strip_tags(request()->post('cateProduct', '%'));
        $mLimit = (string) strip_tags(request()->post('mLimit', KIOTVIET_DEFAULT_LIMIT));
        $_token = (string) strip_tags(request()->post('_token', csrf_token()));
        //
        $data['action'] = 'drilldownbranchesandcateproduct';
        $data['frmDate'] = $frmDate;
        $data['toDate'] = $toDate;
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['cateProduct'] = $cateProduct;
        $data['cateProducts'] = $this->productModel::CATEGORIES;
        $data['mLimit'] = $mLimit;
        $data['mLimits'] = KIOTVIET_DEFAULT_LIMIT_ARR;
        $data['_token'] = $_token;
        //
        return view($data['view'] , compact('data'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function preloaddrilldownbrachesandproducts()
    {
        $data['view']  = $this->viewPath . $this->view . '.preload';

        $frmDate = (string) strip_tags(request()->post('frmDate', date('Y-m-01')));
        $toDate = (string) strip_tags(request()->post('toDate', date('Y-m-d')));
        $branch = (string) strip_tags(request()->post('branch', '%'));
        $cateProduct = (string) strip_tags(request()->post('cateProduct', '%'));
        $mLimit = (string) strip_tags(request()->post('mLimit', KIOTVIET_DEFAULT_LIMIT));
        $_token = (string) strip_tags(request()->post('_token', csrf_token()));
        //
        $data['action'] = 'drilldownbrachesandproducts';
        $data['frmDate'] = $frmDate;
        $data['toDate'] = $toDate;
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['cateProduct'] = $cateProduct;
        $data['cateProducts'] = $this->productModel::CATEGORIES;
        $data['mLimit'] = $mLimit;
        $data['mLimits'] = KIOTVIET_DEFAULT_LIMIT_ARR;
        $data['_token'] = $_token;
        //
        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function FnTotalProduct($frmDate = '', $toDate = '', $branch = '%', $cateProduct = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalCateProductCtrl->doGetProduct($frmDate, $toDate, $branch, $cateProduct);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }       

    /**
     * @return Application|Factory|View
     */
    public function FnTotalCateProductByDate($data, $frmDate = '', $toDate = '')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalCateProductCtrl->doGetTotalCateProductByDate($data, $frmDate, $toDate);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }

    /**
     * @return Application|Factory|View
     */
    public function FnTotalCateProductByBranch($data, $frmDate = '', $toDate = '', $branch = '%', $cateProduct = '%')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalCateProductCtrl->doGetTotalCateProductByBranch($data, $frmDate, $toDate, $branch, $cateProduct);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }    

    /**
     * @return Application|Factory|View
     */
    public function FnTotalCateProduct($data)
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalCateProductCtrl->doGetTotalCateProduct($data);
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
        $result = $this->getTotalCateProductCtrl->doGetTotalProductByDate($data);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }  

    /**
     * @return Application|Factory|View
     */
    public function FnTotalTopProductByDate($data, $mLimit = '10')
    {
        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using post()
        $result = $this->getTotalCateProductCtrl->doGetTotalTopProductByDate($data, $mLimit);
        // dd(\DB::getQueryLog()); // Show results of log
        return $result;
    }    

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $data['title'] = KIOTVIET_CATEPRODUCT_REPORT_TITLE;
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
        $cateProduct = (string) strip_tags(request()->post('cateProduct', '%'));
        $mLimit = (string) strip_tags(request()->post('mLimit', KIOTVIET_DEFAULT_LIMIT));
        $now = (string) date('Y-m-d');
        //
        $user = Auth::guard('admin')->user();
        $adgroup = $user->adgroup_id;
        //
        $totalProduct = $this->FnTotalProduct($frmDate, $toDate, $branch, $cateProduct);
        $totalCateProductByDate = $this->FnTotalCateProductByDate($totalProduct, $frmDate, $toDate);
        $totalCateProduct = $this->FnTotalCateProduct($totalCateProductByDate);
        $totalProductByDate = $this->FnTotalProductByDate($totalProduct);
        $totalTopProductByDate = $this->FnTotalTopProductByDate($totalProductByDate, $mLimit);
        //
        $totalCateProductByBranch = $this->FnTotalCateProductByBranch($totalProduct, $frmDate, $toDate, $branch, $cateProduct);
        $tuideoByBranch = (array_key_exists('tuideoByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['tuideoByBranch'] : [];
        $phukienByBranch = (array_key_exists('phukienByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['phukienByBranch'] : [];
        $quatangByBranch = (array_key_exists('quatangByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['quatangByBranch'] : [];
        $bopviByBranch = (array_key_exists('bopviByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['bopviByBranch'] : [];
        $baloByBranch = (array_key_exists('baloByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['baloByBranch'] : [];
        $capxachByBranch = (array_key_exists('capxachByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['capxachByBranch'] : [];
        $daynitByBranch = (array_key_exists('daynitByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['daynitByBranch'] : [];
        $tuidulichByBranch = (array_key_exists('tuidulichByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['tuidulichByBranch'] : [];
        $khacByBranch = (array_key_exists('khacByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['khacByBranch'] : [];
        $tuixachByBranch = (array_key_exists('tuixachByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['tuixachByBranch'] : [];
        $tuiquangByBranch = (array_key_exists('tuiquangByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['tuiquangByBranch'] : [];
        //
        $data['totalCateProductByDate'] = $totalCateProductByDate;
        $data['totalCateProduct'] = $totalCateProduct;
        $data['totalProductByDate'] = $totalProductByDate;
        $data['totalTopProductByDate'] = $totalTopProductByDate;
        //
        $data['totalCateProductByBranch'] = $totalCateProductByBranch;
        $data['tuideoByBranch'] = $tuideoByBranch;
        $data['phukienByBranch'] = $phukienByBranch;
        $data['quatangByBranch'] = $quatangByBranch;
        $data['bopviByBranch'] = $bopviByBranch;
        $data['baloByBranch'] = $baloByBranch;
        $data['capxachByBranch'] = $capxachByBranch;
        $data['daynitByBranch'] = $daynitByBranch;
        $data['tuidulichByBranch'] = $tuidulichByBranch;
        $data['khacByBranch'] = $khacByBranch;
        $data['tuixachByBranch'] = $tuixachByBranch;
        $data['tuiquangByBranch'] = $tuiquangByBranch;
        //
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['cateProduct'] = $cateProduct;
        $data['cateProducts'] = $this->productModel::CATEGORIES;
        $data['mLimits'] = KIOTVIET_DEFAULT_LIMIT_ARR;
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
        $data['title'] = KIOTVIET_CATEPRODUCT_REPORT_TITLE;
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
        $cateProduct = (string) strip_tags(request()->post('cateProduct', '%'));
        $mLimit = (string) strip_tags(request()->post('mLimit', KIOTVIET_DEFAULT_LIMIT));
        $now = (string) date('Y-m-d');
        //
        $user = Auth::guard('admin')->user();
        $adgroup = $user->adgroup_id;
        //
        $totalProduct = $this->FnTotalProduct($frmDate, $toDate, $branch, $cateProduct);
        $totalCateProductByDate = $this->FnTotalCateProductByDate($totalProduct, $frmDate, $toDate);
        $totalCateProduct = $this->FnTotalCateProduct($totalCateProductByDate);
        $totalProductByDate = $this->FnTotalProductByDate($totalProduct);
        $totalTopProductByDate = $this->FnTotalTopProductByDate($totalProductByDate, $mLimit);
        //
        $totalCateProductByBranch = $this->FnTotalCateProductByBranch($totalProduct, $frmDate, $toDate, $branch, $cateProduct);
        $tuideoByBranch = (array_key_exists('tuideoByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['tuideoByBranch'] : [];
        $phukienByBranch = (array_key_exists('phukienByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['phukienByBranch'] : [];
        $quatangByBranch = (array_key_exists('quatangByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['quatangByBranch'] : [];
        $bopviByBranch = (array_key_exists('bopviByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['bopviByBranch'] : [];
        $baloByBranch = (array_key_exists('baloByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['baloByBranch'] : [];
        $capxachByBranch = (array_key_exists('capxachByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['capxachByBranch'] : [];
        $daynitByBranch = (array_key_exists('daynitByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['daynitByBranch'] : [];
        $tuidulichByBranch = (array_key_exists('tuidulichByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['tuidulichByBranch'] : [];
        $khacByBranch = (array_key_exists('khacByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['khacByBranch'] : [];
        $tuixachByBranch = (array_key_exists('tuixachByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['tuixachByBranch'] : [];
        $tuiquangByBranch = (array_key_exists('tuiquangByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['tuiquangByBranch'] : [];
        //
        $data['totalCateProductByDate'] = $totalCateProductByDate;
        $data['totalCateProduct'] = $totalCateProduct;
        $data['totalProductByDate'] = $totalProductByDate;
        $data['totalTopProductByDate'] = $totalTopProductByDate;
        //
        $data['totalCateProductByBranch'] = $totalCateProductByBranch;
        $data['tuideoByBranch'] = $tuideoByBranch;
        $data['phukienByBranch'] = $phukienByBranch;
        $data['quatangByBranch'] = $quatangByBranch;
        $data['bopviByBranch'] = $bopviByBranch;
        $data['baloByBranch'] = $baloByBranch;
        $data['capxachByBranch'] = $capxachByBranch;
        $data['daynitByBranch'] = $daynitByBranch;
        $data['tuidulichByBranch'] = $tuidulichByBranch;
        $data['khacByBranch'] = $khacByBranch;
        $data['tuixachByBranch'] = $tuixachByBranch;
        $data['tuiquangByBranch'] = $tuiquangByBranch;
        //
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['cateProduct'] = $cateProduct;
        $data['cateProducts'] = $this->productModel::CATEGORIES;
        $data['mLimits'] = KIOTVIET_DEFAULT_LIMIT_ARR;
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
    public function drilldownbranchandcateproduct()
    {
        $data['title'] = 'Phân tích bán hàng 1 cửa hàng 1 nhóm hàng';
        $data['view']  = $this->viewPath . $this->view . '.drilldowns.listbranchandcateproduct';
        $data['action'] = 'drilldownbranchandcateproduct';

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
        $cateProduct = (string) strip_tags(request()->post('cateProduct', '%'));
        $mLimit = (string) strip_tags(request()->post('mLimit', KIOTVIET_DEFAULT_LIMIT));
        $now = (string) date('Y-m-d');
        //
        $user = Auth::guard('admin')->user();
        $adgroup = $user->adgroup_id;
        //
        $totalProduct = $this->FnTotalProduct($frmDate, $toDate, $branch, $cateProduct);
        $totalCateProductByDate = $this->FnTotalCateProductByDate($totalProduct, $frmDate, $toDate);
        $totalCateProduct = $this->FnTotalCateProduct($totalCateProductByDate);
        $totalProductByDate = $this->FnTotalProductByDate($totalProduct);
        $totalTopProductByDate = $this->FnTotalTopProductByDate($totalProductByDate, $mLimit);
        //
        $data['totalCateProductByDate'] = $totalCateProductByDate;
        $data['totalCateProduct'] = $totalCateProduct;
        $data['totalProductByDate'] = $totalProductByDate;
        $data['totalTopProductByDate'] = $totalTopProductByDate;
        //
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['cateProduct'] = $cateProduct;
        $data['cateProducts'] = $this->productModel::CATEGORIES;
        $data['mLimits'] = KIOTVIET_DEFAULT_LIMIT_ARR;
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
    public function drilldownbranchesandcateproduct()
    {
        $data['title'] = 'Phân tích bán hàng nhiều cửa hàng 1 nhóm hàng';
        $data['view']  = $this->viewPath . $this->view . '.drilldowns.listbranchesandcateproduct';
        $data['action'] = 'drilldownbranchesandcateproduct';

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
        $cateProduct = (string) strip_tags(request()->post('cateProduct', '%'));
        $mLimit = (string) strip_tags(request()->post('mLimit', KIOTVIET_DEFAULT_LIMIT));
        $now = (string) date('Y-m-d');
        //
        $user = Auth::guard('admin')->user();
        $adgroup = $user->adgroup_id;
        //
        $totalProduct = $this->FnTotalProduct($frmDate, $toDate, $branch, $cateProduct);
        $totalCateProductByDate = $this->FnTotalCateProductByDate($totalProduct, $frmDate, $toDate);
        $totalCateProduct = $this->FnTotalCateProduct($totalCateProductByDate);
        $totalProductByDate = $this->FnTotalProductByDate($totalProduct);
        $totalTopProductByDate = $this->FnTotalTopProductByDate($totalProductByDate, $mLimit);
        //
        $totalCateProductByBranch = $this->FnTotalCateProductByBranch($totalProduct, $frmDate, $toDate, $branch, $cateProduct);
        $tuideoByBranch = (array_key_exists('tuideoByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['tuideoByBranch'] : [];
        $phukienByBranch = (array_key_exists('phukienByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['phukienByBranch'] : [];
        $quatangByBranch = (array_key_exists('quatangByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['quatangByBranch'] : [];
        $bopviByBranch = (array_key_exists('bopviByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['bopviByBranch'] : [];
        $baloByBranch = (array_key_exists('baloByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['baloByBranch'] : [];
        $capxachByBranch = (array_key_exists('capxachByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['capxachByBranch'] : [];
        $daynitByBranch = (array_key_exists('daynitByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['daynitByBranch'] : [];
        $tuidulichByBranch = (array_key_exists('tuidulichByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['tuidulichByBranch'] : [];
        $khacByBranch = (array_key_exists('khacByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['khacByBranch'] : [];
        $tuixachByBranch = (array_key_exists('tuixachByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['tuixachByBranch'] : [];
        $tuiquangByBranch = (array_key_exists('tuiquangByBranch', $totalCateProductByBranch)) ? $totalCateProductByBranch['tuiquangByBranch'] : [];
        //
        $data['totalCateProductByDate'] = $totalCateProductByDate;
        $data['totalCateProduct'] = $totalCateProduct;
        $data['totalProductByDate'] = $totalProductByDate;
        $data['totalTopProductByDate'] = $totalTopProductByDate;
        //
        $data['totalCateProductByBranch'] = $totalCateProductByBranch;
        $data['tuideoByBranch'] = $tuideoByBranch;
        $data['phukienByBranch'] = $phukienByBranch;
        $data['quatangByBranch'] = $quatangByBranch;
        $data['bopviByBranch'] = $bopviByBranch;
        $data['baloByBranch'] = $baloByBranch;
        $data['capxachByBranch'] = $capxachByBranch;
        $data['daynitByBranch'] = $daynitByBranch;
        $data['tuidulichByBranch'] = $tuidulichByBranch;
        $data['khacByBranch'] = $khacByBranch;
        $data['tuixachByBranch'] = $tuixachByBranch;
        $data['tuiquangByBranch'] = $tuiquangByBranch;
        //
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['cateProduct'] = $cateProduct;
        $data['cateProducts'] = $this->productModel::CATEGORIES;
        $data['mLimits'] = KIOTVIET_DEFAULT_LIMIT_ARR;
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
    public function drilldownbrachesandproducts()
    {
        $data['title'] = 'Phân tích sản phẩm nhiều cửa hàng 1 nhóm hàng';
        $data['view']  = $this->viewPath . $this->view . '.drilldowns.listbrachesandproducts';
        $data['action'] = 'drilldownbrachesandproducts';

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
        $cateProduct = (string) strip_tags(request()->post('cateProduct', '%'));
        $mLimit = (string) strip_tags(request()->post('mLimit', KIOTVIET_DEFAULT_LIMIT));
        $now = (string) date('Y-m-d');
        //
        $user = Auth::guard('admin')->user();
        $adgroup = $user->adgroup_id;
        //
        $totalProduct = $this->FnTotalProduct($frmDate, $toDate, $branch, $cateProduct);
        $totalCateProductByDate = $this->FnTotalCateProductByDate($totalProduct, $frmDate, $toDate);
        $totalCateProduct = $this->FnTotalCateProduct($totalCateProductByDate);
        $totalProductByDate = $this->FnTotalProductByDate($totalProduct);
        $totalTopProductByDate = $this->FnTotalTopProductByDate($totalProductByDate, $mLimit);
        //
        $data['totalCateProductByDate'] = $totalCateProductByDate;
        $data['totalCateProduct'] = $totalCateProduct;
        $data['totalProductByDate'] = $totalProductByDate;
        $data['totalTopProductByDate'] = $totalTopProductByDate;
        //
        $data['branch'] = $branch;
        $data['branches'] = $this->getBranchCtrl->doQuery('%');
        $data['cateProduct'] = $cateProduct;
        $data['cateProducts'] = $this->productModel::CATEGORIES;
        $data['mLimits'] = KIOTVIET_DEFAULT_LIMIT_ARR;
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
