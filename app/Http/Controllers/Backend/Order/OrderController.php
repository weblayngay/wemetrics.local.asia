<?php

namespace App\Http\Controllers\Backend\Order;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\BaseController;
use App\Models\Websites\W0001\lt4ProductsOrders;
use App\Models\Websites\W0001\lt4ProductsOrdersDetail;
use App\Models\Websites\W0001\lt4ProductsOrdersStatus;
use App\Models\Websites\W0001\lt4ProductsOrdersUserInfo;
use App\Models\Websites\W0001\lt4ProductsShippingCities;
use App\Models\Websites\W0001\lt4ProductsShippingDist;
use App\Models\User;
use App\Helpers\UrlHelper;
use App\Helpers\DateHelper;
use App\Helpers\ArrayHelper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Exports\OrderExport;
use App\Exports\CustomerExport;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use App\Helpers\CollectionPaginateHelper;


class OrderController extends BaseController
{
    private $view = '.order';
    private $model = 'order';

    private $orderModel;
    private $orderItemModel;
    private $orderUserInfoModel;
    private $orderStatus;
    private $districtModel;
    private $provinceModel;
    private $userModel;

    private $tblProductsOrders;
    private $tblProductsOrdersDetail;
    private $tblProductsOrdersStatus;
    private $tblProductsPaymentMethod;
    private $tblProductsOrdersUserInfo;
    private $tblProductsShippingCities;
    private $tblProductsShippingDist;

    public function __construct()
    {
        $this->orderModel = new lt4ProductsOrders();
        $this->orderItemModel = new lt4ProductsOrdersDetail();
        $this->orderUserInfoModel = new lt4ProductsOrdersUserInfo();
        $this->orderStatus = new lt4ProductsOrdersStatus();
        $this->districtModel = new lt4ProductsShippingDist();
        $this->provinceModel = new lt4ProductsShippingCities();
        $this->userModel = new User();

        $this->tblProductsOrders = 'lt4_products_orders';
        $this->tblProductsOrdersDetail = 'lt4_products_orders_detail';
        $this->tblProductsOrdersStatus = 'lt4_products_orders_status';
        $this->tblProductsPaymentMethod = 'lt4_products_payment_method';
        $this->tblProductsOrdersUserInfo = 'lt4_products_orders_user_info';
        $this->tblProductsShippingCities = 'lt4_products_shipping_cities';
        $this->tblProductsShippingDist = 'lt4_products_shipping_dist';
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = ORDER_TITLE;
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

        $orders = DB::table(LT4_PRODUCTS_ORDERS. " AS t1")
            ->selectRaw("t1.id AS OrderNum, t1.user_info_id AS customerId, t1.amount AS amount, '' AS customerName, '' AS customerAddress, '' AS customerCity, '' AS CustomerDist, '' AS customerEmail, '' AS customerPhone, t1.created AS createdAt, t1.status_id AS statusId, t1.payment_id AS paymentMethod")
            ->orderBy('t1.id', 'DESC')
            ->whereRaw("DATE_FORMAT(DATE(t1.created), '%Y-%m-%d') BETWEEN '".$frmDate."' AND '".$toDate."'")->get();

        $customerIds = [];
        if($orders->count() > 0){
            $customerIds = array_column($orders->toArray(), 'customerId');
        }

        $customerIds = ArrayHelper::convertToString($customerIds);

        $customers = DB::table(LT4_PRODUCTS_ORDERS_USER_INFO. " AS t1")
            ->selectRaw("t1.id AS customerId, t1.name AS customerName, t1.address AS customerAddress, t1.city_name AS customerCity, t1.dist_name AS CustomerDist, t1.email AS customerEmail, t1.phone AS customerPhone")
            ->orderBy('t1.id', 'DESC')
            ->whereRaw('t1.id IN ('.$customerIds.')')
            ->get();

        foreach ($orders as $k1 => $i1) {
            foreach ($customers as $k2 => $i2) {
                if($i1->customerId == $i2->customerId)
                {
                    $i1->customerName = $i2->customerName;
                    $i1->customerAddress = $i2->customerAddress;
                    $i1->customerCity = $i2->customerCity;
                    $i1->CustomerDist = $i2->CustomerDist;
                    $i1->customerEmail = $i2->customerEmail;
                    $i1->customerPhone = $i2->customerPhone;
                    break;
                }
            }
        }

        $orders = CollectionPaginateHelper::paginate($orders, PAGINATE_PERPAGE);

        $data['orders'] = $orders;

        return view($data['view'] , compact('data'));
    }

    /**
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function searchQuery(string $searchStr, string $paymentMethod, string $statusId, int $paginateNum, string $frmDate, string $toDate)
    {
        $orders = $this->orderModel::search($searchStr, $paymentMethod, $statusId, $paginateNum, $frmDate, $toDate);
        if(!empty($orders) && $orders->total() > 0)
        {
            return $orders;
        }
        return null; //If can not find any records follow the column;
    }

    /**
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $searchStr = (string) strip_tags(request()->post('searchStr', ''));
        $statusId = (string) strip_tags(request()->post('statusId', ''));
        $paymentMethod = (string) strip_tags(request()->post('paymentMethod', ''));

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

        $data['title'] = ORDER_TITLE;
        $data['view']  = $this->viewPath . $this->view . '.filter';

        // \DB::enableQueryLog(); // Enable query log
        // Your Eloquent query executed by using get()
        $orders = $this->searchQuery($searchStr, $paymentMethod, $statusId, PAGINATE_PERPAGE, $frmDate, $toDate);
        // dd(\DB::getQueryLog()); // Show results of log
        $data['orders'] = $orders;
        return view($data['view'] , compact('data'));
    }

    /**
     * @param $id
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function edit()
    {
        $id = (int) request()->get('id', 0);
        $order = $this->orderModel::query()->where('id', $id)->first();
        if($order){
            $data['title'] = ORDER_TITLE.EDIT_LABEL;
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['order'] = $order;
            $data['user'] = $this->orderUserInfoModel::query()->where('id', $order->user_info_id)->first();
            $data['status'] = $this->orderModel::STATUS;
            $data['items'] = $order->items;

            return view($data['view'] , compact('data'));
        }else{
            $error   = 'Không tìm thấy đơn hàng';
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $actionType = request()->post('action_type', 'save');
        $id = request()->post('id', 0);

        if($actionType == 'save'){
            $redirect = UrlHelper::admin($this->model);
        }else{
            $redirect = UrlHelper::admin($this->model,'edit', ['id' => $id]);
        }

        $success = 'Cập nhật đơn hàng thành công.';
        $error   = 'Cập nhật đơn hàng thất bại.';
        $params = $this->orderModel->revertAlias(request()->post());

        try {
            $this->orderModel::query()->where('ord_id', $id)->update($params);
            return redirect()->to($redirect)->with('success', $success);
        } catch ( \Exception $e ) {
            $redirect = UrlHelper::admin($this->model);
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $ids = request()->post('cid', []);
        $success = 'Xóa đơn hàng thành công.';
        $error   = 'Xóa đơn hàng thất bại.';

        $redirect = UrlHelper::admin($this->model);
        $number = $this->orderModel->query()->whereIn('id', $ids)->update(['status_id' => '3']);
        if($number > 0) {
            return redirect()->to($redirect)->with('success', $success);
        }else{
            return redirect()->to($redirect)->with('error', $error);
        }
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportOrder(Request $request)
    {
        return Excel::download(new OrderExport(), 'orders.xlsx');
    }

    /**
     * @param Request $request
     */
    public function exportCustomer(Request $request)
    {
        return Excel::download(new CustomerExport(), 'customers.xlsx');
    }
}
