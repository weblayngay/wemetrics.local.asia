<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Ward;
use App\Models\District;
use App\Models\Province;
use App\Models\Contact;
use App\Helpers\UrlHelper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Exports\OrderExport;
use App\Exports\CustomerExport;
use Maatwebsite\Excel\Facades\Excel;


class OrderController extends BaseController
{
    private $view = '.order';
    private $model = 'order';
    private $orderModel;
    private $orderItemModel;
    private $userModel;
    private $wardModel;
    private $districtModel;
    private $provinceModel;
    private $contactModel;
    public function __construct()
    {
        $this->orderModel = new Order();
        $this->orderItemModel = new OrderItem();
        $this->userModel = new User();
        $this->wardModel = new Ward();
        $this->districtModel = new District();
        $this->provinceModel = new Province();
        $this->contactModel = new Contact();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data['title'] = 'Quản lý đơn hàng ';
        $data['view']  = $this->viewPath . $this->view . '.list';

        $orders = $this->orderModel::query()
            ->select([ORDER_TBL . '.*', WARD_TBL . '.name as ward_name', PROVINCE_TBL . '.name as province_name', DISTRICT_TBL . '.name as district_name'] )
            ->orderBy('ord_id', 'DESC')
            ->leftJoin(WARD_TBL, WARD_TBL.'.id', ORDER_TBL . '.ward_id')
            ->leftJoin(PROVINCE_TBL, PROVINCE_TBL.'.id', ORDER_TBL . '.province_id')
            ->leftJoin(DISTRICT_TBL, DISTRICT_TBL.'.id', ORDER_TBL . '.district_id')
            ->paginate(50);
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
        $order = $this->orderModel::query()->where('ord_id', $id)->first();
        if($order){
            $data['title'] = 'Quản lý đơn hàng: [Sửa]';
            $data['view']  = $this->viewPath . $this->view . '.edit';
            $data['order'] = $order;
            $data['user'] = $this->userModel::query()->where('id', $order->user_id)->first();
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
        $number = $this->orderModel->query()->whereIn('ord_id', $ids)->update(['ord_is_deleted' => 'yes']);
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

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function statistic(Request $request)
    {
        $data['title'] = 'Thống kê đơn hàng ';
        $data['view']  = $this->viewPath . $this->view . '.statistic';


        $fromTime = $request->fromTime;
        $toTime = $request->toTime;

        $from = date("Y-m-d", strtotime($fromTime) - 1);
        $to = date("Y-m-d", strtotime($toTime)) . ' 23:59:59';

        if(empty($fromTime) && empty($toTime)){
            $to = date('Y-m-d', time())  . ' 23:59:59';
            $from= date('Y-m-d', strtotime('-1 month') - 1);

            $fromTime = date("d-m-Y", strtotime($from));
            $toTime = date("d-m-Y", strtotime($to));
        }


        $orderLastest = $this->orderModel::query()->whereBetween('ord_created_at', [$from, $to])->orderBy('ord_id', 'DESC')->limit(10)->get();
        if($orderLastest->count() > 0){
            foreach ($orderLastest as $key => $item){
                $item->userName = !empty($item->user) ? $item->user->name : '';
            }
        }

        /**
         * order
         */
        $order = $this->orderModel::query()->select('ord_id')->whereBetween('ord_created_at', [$from, $to])->get();
        $orderNew = $this->orderModel::query()->select('ord_id')->where('ord_status', 'new')->whereBetween('ord_created_at', [$from, $to])->get();
        $orderPending = $this->orderModel::query()->select('ord_id')->where('ord_status', 'pending')->whereBetween('ord_created_at', [$from, $to])->get();
        $orderProcessing = $this->orderModel::query()->select('ord_id')->where('ord_status', 'processing')->whereBetween('ord_created_at', [$from, $to])->get();
        $orderPaid = $this->orderModel::query()->where('ord_status', 'paid')->whereBetween('ord_created_at', [$from, $to])->get();
        $orderCancelled = $this->orderModel::query()->select('ord_id')->where('ord_status', 'cancelled')->whereBetween('ord_created_at', [$from, $to])->get();
        $orderSumPaid = $orderPaid->sum('ord_total_cost');

        /**
         * order item
         */
        $arrayOrderId = array_column($orderPaid->toArray(), 'ord_id');
        $orderItems = $this->orderItemModel::query()
            ->whereIn('ord_id', $arrayOrderId)
            ->selectRaw('product_id, SUM(ordi_quantity) as quantity, SUM(ordi_historical_cost * ordi_quantity) as total')->orderBy('quantity', 'desc')
            ->groupBy('product_id')->limit(5)->get()->toArray();

        /**
         * user
         */
        $user= $this->userModel::parentQuery()->select('id')->whereBetween('created_at', [$from, $to])->get();
        $userFacebook = $this->userModel::parentQuery()->select('id')->where('type', 'facebook')->whereBetween('created_at', [$from, $to])->get();
        $userGoogle = $this->userModel::parentQuery()->select('id')->where('type', 'google')->whereBetween('created_at', [$from, $to])->get();
        $userEmail = $this->userModel::parentQuery()->select('id')->where('type', 'system')->whereBetween('created_at', [$from, $to])->get();


        /**
         * contact
         */
        $contacts = $this->contactModel->query()->whereBetween('contact_created_at', [$from, $to])->get();


        $data['contacts'] = $contacts;

        $data['user'] = $user;
        $data['userFacebook'] = $userFacebook;
        $data['userGoogle'] = $userGoogle;
        $data['userEmail'] = $userEmail;

        $data['order'] = $order;
        $data['orderNew'] = $orderNew;
        $data['orderPending'] = $orderPending;
        $data['orderProcessing'] = $orderProcessing;
        $data['orderPaid'] = $orderPaid;
        $data['orderCancelled'] = $orderCancelled;
        $data['orderSumPaid'] = $orderSumPaid;

        $data['orderLastest'] = $orderLastest;
        $data['orderItems'] = $orderItems;

        $data['fromTime'] = $fromTime;
        $data['toTime'] = $toTime;

        return view($data['view'] , compact('data'));
    }
}
