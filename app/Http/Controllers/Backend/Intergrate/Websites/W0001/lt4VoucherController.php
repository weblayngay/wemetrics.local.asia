<?php

namespace App\Http\Controllers\Backend\Intergrate\Websites\W0001;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\BaseController;
use App\Http\Requests\VoucherRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Helpers\ImageHelper;
use App\Helpers\UrlHelper;
use App\Helpers\DateHelper;
use App\Models\Websites\W0001\lt4Voucher;


class lt4VoucherController extends BaseController
{
    private $view = '.lt4Voucher';
    private $model = 'lt4Voucher';
    private $lt4VoucherModel;
    public function __construct()
    {
        $this->lt4VoucherModel = new lt4Voucher();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $lt4Vouchers = $this->lt4VoucherModel::query()->paginate(15);
        $data['lt4Vouchers'] = $lt4Vouchers;
        dd($data);
    }
}
