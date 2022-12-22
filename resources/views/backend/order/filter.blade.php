<?php
/**
 * @var \App\Helpers\UrlHelper $urlHelper
 */
use App\Helpers\TranslateHelper;
use App\Helpers\DateHelper;
use App\Helpers\MoneyHelper;
use App\Helpers\StringHelper;

$urlHelper = app('UrlHelper');
$orders = !empty($data['orders']) ? $data['orders'] : [];
$title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.order.order_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.order.order_search'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap" style="overflow-x:auto;">
                            <form action="#" method="post" id="admin-form">
                                @csrf
                                    <table class="table table-hover w-100 display pb-30 js-main-table">
                                    <thead>
                                    <tr>
                                        <th scope="col"><input type="checkbox" class="checkAll" name="checkAll" value=""></th>
                                        <th scope="col">{{__('Số đơn hàng')}}</th>
                                        <th scope="col">{{__('Tên khách hàng')}}</th>
                                        <th scope="col">{{__('Điện thoại')}}</th>
                                        <th scope="col">{{__('Thành tiền')}}</th>
                                        <th scope="col">{{__('Ngày tạo')}}</th>
                                        <th scope="col">{{__('Trạng thái')}}</th>
                                        <th scope="col">{{__('PT thanh toán')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($orders) && count($orders) > 0)
                                        @foreach($orders as $key => $item)
                                            <tr>
                                                <td data-label="checkbox"><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->OrderNum }}"></td>
                                                <td data-label="Số đơn hàng"><a href="@php echo $urlHelper::admin('order', 'edit')."?id=$item->OrderNum" @endphp">{{ $item->OrderNum }}</a></td>
                                                <td data-label="Tên khách hàng">{{ Str::title($item->customerName) }}</td>
                                                <td data-label="Điện thoại"><span class="text-info font-weight-bolder">{{ StringHelper::getPhoneNumber($item->customerPhone) }}</span></td>
                                                <td data-label="Thành tiền"><span class="text-danger font-weight-bolder">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item->amount) }}</span></td>
                                                <td data-label="Ngày tạo">{{ DateHelper::getDate('d/m/Y', $item->createdAt) }}</td>
                                                <td data-label="Trạng thái"><span class="text-{{ \App\Models\Websites\W0001\lt4ProductsOrders::STATUS_COLOR[$item->statusId] }}">{{ \App\Models\Websites\W0001\lt4ProductsOrders::STATUS[$item->statusId]  }}</span></td>
                                                <td data-label="PT thanh toán"><span class="text-{{ \App\Models\Websites\W0001\lt4ProductsOrders::PAYMENT_COLOR[$item->paymentMethod] }}">{{ \App\Models\Websites\W0001\lt4ProductsOrders::PAYMENT[$item->paymentMethod]  }}</span></td>
                                            </tr>
                                        @endforeach
                                        @else
                                            <tr>
                                                <td colspan="9" class="not-found-records">{{__('Không tồn tại dữ liệu')}}</td>
                                            </tr>
                                    @endif
                                    </tbody>
                                </table>
                                @if(!empty($orders))
                                    {{ $orders->links(ORDER_SEARCH.'.pagination') }}
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
