<?php
use App\Helpers\MoneyHelper;
$order = !empty($data['order']) ? $data['order'] : null;
$user = !empty($data['user']) ? $data['user'] : null;
/**
 * order
 */
$orderFullName = !empty($user->name) ? $user->name : '';
$orderAddressDetail = !empty($user->address) ? $user->address : '';
$orderEmail = !empty($user->email) ? $user->email : '';
$orderPhone = !empty($user->phone) ? $user->phone : '';

$orderWardName = '';
$orderDistrictName = !empty($user->dist_name) ? $user->dist_name : '';
$orderProvinceName = !empty($user->city_name) ? $user->city_name : '';

$orderGfFullName = !empty($user->gf_name) ? $user->gf_name : '';
$orderGfAddressDetail = !empty($user->gf_address) ? $user->gf_address : '';
$orderGfEmail = !empty($user->gf_email) ? $user->gf_email : '';
$orderGfPhone = !empty($user->gf_phone) ? $user->gf_phone : '';
$orderGfWardName = '';
$orderGfDistrictName = !empty($user->dist_name) ? $user->gf_dist_name : '';
$orderGfProvinceName = !empty($user->city_name) ? $user->gf_city_name : '';

$arrayStatus = !empty($data['status']) ? $data['status'] : null;
$statusTitle = \App\Models\Websites\W0001\lt4ProductsOrders::STATUS[$order->status_id];
$title = !empty($data['title']) ? $data['title'] : '';
$paymentTitle = \App\Models\Websites\W0001\lt4ProductsOrders::PAYMENT[$order->payment_id];
$shippingTitle = \App\Models\Websites\W0001\lt4ProductsOrders::SHIPPING[$order->shipping_id];
$items = !empty($data['items']) ? $data['items'] : null;
$discount = !empty($order->vdiscount) ? $order->vdiscount : 0;
$voucherCode = !empty($order->vcode) ? $order->vcode : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.order.order_edit'])
    <form method="POST" id="admin-form" action="{{app('UrlHelper')::admin('order', 'update')}}" enctype="multipart/form-data">
        <input type="hidden" name="action_type">
        <input type="hidden" name="id" value="{{ $order->id }}">
        @csrf
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-xl-12">
                            <h5><strong>{{('Mã đơn hàng: ')}} {{ $order->id }}</strong></h5><br>
                            <h5><strong>{{('THÔNG TIN ĐƠN HÀNG')}}</strong></h5>
                            <hr>

                            <div class="form-group row">
                                <label class="col-md-1 col-form-label"><strong>{{ 'Trạng Thái' }}</strong></label>
                                <label class="col-md-2 col-form-label text-primary">
                                    <span class="text-{{ \App\Models\Websites\W0001\lt4ProductsOrders::STATUS_COLOR[$order->status_id] }}">
                                        {{ $statusTitle }}
                                    </span>
                                </label>

                                <label class="col-md-1 col-form-label"><strong>{{ 'Thanh toán' }}</strong></label>
                                <label class="col-md-2 col-form-label text-primary">
                                    <span class="text-{{ \App\Models\Websites\W0001\lt4ProductsOrders::PAYMENT_COLOR[$order->payment_id] }}">
                                        {{ $paymentTitle }}
                                    </span>
                                </label>

                                <label class="col-md-1 col-form-label"><strong>{{ 'Vận chuyển' }}</strong></label>
                                <label class="col-md-4 col-form-label text-primary">
                                    <span class="text-{{ \App\Models\Websites\W0001\lt4ProductsOrders::SHIPPING_COLOR[$order->shipping_id] }}">
                                        {{ $shippingTitle }}
                                    </span>
                                </label>
                            </div>

                            <table class="table table-bordered table-hover w-100 display pb-30 js-main-table">
                                <thead class="thead-primary">
                                    <tr>
                                        <th scope="col" class="col-md-6" colspan="2">
                                            <span class="text-center font-weight-bolder">{{'THÔNG TIN KHÁCH HÀNG'}}</span>
                                        </th>
                                        <th scope="col" class="col-md-6" colspan="2">
                                            <span class="text-center font-weight-bolder">{{('THÔNG TIN GIAO HÀNG')}}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="col-md-3">
                                            <strong>{{ 'Tên khách hàng' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            {{ $orderFullName }}
                                        </td>
                                        <td class="col-md-3">
                                            <strong>{{ 'Tên khách hàng' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            {{ $orderGfFullName }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="col-md-3">
                                            <strong>{{ 'Địa chỉ' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            {{ $orderAddressDetail }}
                                        </td>
                                        <td class="col-md-3">
                                            <strong>{{ 'Địa chỉ' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            {{ $orderGfAddressDetail }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="col-md-3">
                                            <strong>{{ 'Tỉnh thành' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            {{ $orderProvinceName }}
                                        </td>
                                        <td class="col-md-3">
                                            <strong>{{ 'Tỉnh thành' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            {{ $orderGfProvinceName }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="col-md-3">
                                            <strong>{{ 'Quận' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            {{ $orderDistrictName }}
                                        </td>
                                        <td class="col-md-3">
                                            <strong>{{ 'Quận' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            {{ $orderGfDistrictName }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="col-md-3">
                                            <strong>{{ 'Email' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            <span class="text-center text-primary font-weight-bolder">{{ $orderEmail }}</span>
                                        </td>
                                        <td class="col-md-3">
                                            <strong>{{ 'Email' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            <span class="text-center text-primary font-weight-bolder">{{ $orderGfEmail }}</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="col-md-3">
                                            <strong>{{ 'Điện thoại' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            <span class="text-center text-info font-weight-bolder">{{ $orderPhone }}</span>
                                        </td>
                                        <td class="col-md-3">
                                            <strong>{{ 'Điện thoại' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            <span class="text-center text-info font-weight-bolder">{{ $orderGfPhone }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <h5><strong>{{('CHI TIẾT ĐƠN HÀNG')}}</strong></h5>
                            @if($items->count() > 0)
                                <table class="table table-bordered">
                                    <thead class="thead-info">
                                    <tr>
                                        <th scope="col">
                                            <span class="text-center font-weight-bolder">
                                                {{__('ID')}}
                                            </span>
                                        </th>
                                        <th scope="col">
                                            <span class="text-center font-weight-bolder">
                                                {{__('Tên sản phẩm')}}
                                            </span>
                                        </th>
                                        <th scope="col">
                                            <span class="text-center font-weight-bolder">
                                                {{__('Giá sản phẩm')}}
                                            </span>
                                        </th>
                                        <th scope="col">
                                            <span class="text-center font-weight-bolder">
                                                {{__('Số lượng')}}
                                            </span>
                                        </th>
                                        <th scope="col">
                                            <span class="text-center font-weight-bolder">
                                                {{__('Thành tiền')}}
                                            </span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($items as $key => $item)
                                            @php
                                            $product = \App\Models\Websites\W0001\lt4Products::query()->where('id', $item->pid)->first();
                                            @endphp
                                            <tr>
                                                <td>{{ $item->pid }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item->price) }}</td>
                                                <td>{{ number_format($item->quantity, 0, '.', ',') }}</td>
                                                <td>{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item->total_price) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Tổng giá: {{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $order->order_total) }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Mã giảm giá: {{ $voucherCode }}</td>
                                            <td></td>
                                            <td></td>
                                            <td>Giảm giá: {{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $discount) }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Thành tiền: <span style="color: crimson; font-weight: bold;">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $order->amount) }}</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </form>
@endsection
