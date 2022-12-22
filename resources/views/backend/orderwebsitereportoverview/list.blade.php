<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\MoneyHelper;
    use App\Helpers\DateHelper;
    use App\Helpers\StringHelper;

    $urlHelper = app('UrlHelper');
    $title = isset($data['title']) ? $data['title'] : '';
    //
    $orders = !empty($data['orders']) ? $data['orders'] : [];
    $orderProcessing = !empty($data['orderProcessing']) ? $data['orderProcessing'] : [];
    $orderShipping = !empty($data['orderShipping']) ? $data['orderShipping'] : [];
    $orderCanceled = !empty($data['orderCanceled']) ? $data['orderCanceled'] : [];
    $orderCompleted = !empty($data['orderCompleted']) ? $data['orderCompleted'] : [];
    $orderPaid = !empty($data['orderPaid']) ? $data['orderPaid'] : [];
    $orderPayOnline = !empty($data['orderPayOnline']) ? $data['orderPayOnline'] : [];
    //
    $orderSumTotal = !empty($data['orderSumTotal']) ? $data['orderSumTotal'] : '0';
    $orderSumDiscount = !empty($data['orderSumDiscount']) ? $data['orderSumDiscount'] : '0';
    $orderSumEngraveFee = !empty($data['orderSumEngraveFee']) ? $data['orderSumEngraveFee'] : '0';
    $orderSumAmount = !empty($data['orderSumAmount']) ? $data['orderSumAmount'] : '0';
    $orderPaidSumTotal = !empty($data['orderPaidSumTotal']) ? $data['orderPaidSumTotal'] : '0';
    $orderPaidSumDiscount = !empty($data['orderPaidSumDiscount']) ? $data['orderPaidSumDiscount'] : '0';
    $orderPaidSumEngraveFee = !empty($data['orderPaidSumEngraveFee']) ? $data['orderPaidSumEngraveFee'] : '0';
    $orderPaidSumAmount = !empty($data['orderPaidSumAmount']) ? $data['orderPaidSumAmount'] : '0';

    $orderLatest = !empty($data['orderLatest']) ? $data['orderLatest'] : [];
    $orderItems = !empty($data['orderItems']) ? $data['orderItems'] : []; 
    $orderCatItems = !empty($data['orderCatItems']) ? $data['orderCatItems'] : [];
    //
    $mLimit = !empty($data['mLimit']) ? $data['mLimit'] : '10';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.orderwebsitereportoverview.orderwebsitereportoverview_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.orderwebsitereportoverview.orderwebsitereportoverview_search'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap" style="overflow-x:auto;">
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <div id="chartTotalOrderByDate" name="chartTotalOrderByDate">
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <section class="hk-sec-wrapper" style="margin-top: 15px">
                                        <div class="media align-items-center">
                                            <div class="d-flex media-img-wrap mr-15">
                                                <div class="avatar avatar-sm">
                                                    <span class="avatar-text avatar-text-inv-primary">
                                                        <span class="initial-wrap"><span><i class="zmdi zmdi-money"></i></span></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Tiền hàng')}}</span>
                                                <span class="d-block  text-truncate ">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $orderSumTotal) }}</span>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-md-3">
                                    <section class="hk-sec-wrapper" style="margin-top: 15px">
                                        <div class="media align-items-center">
                                            <div class="d-flex media-img-wrap mr-15">
                                                <div class="avatar avatar-sm">
                                                    <span class="avatar-text avatar-text-inv-primary">
                                                        <span class="initial-wrap"><span><i class="zmdi zmdi-money"></i></span></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Chiết khấu')}}</span>
                                                <span class="d-block  text-truncate ">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $orderSumDiscount) }}</span>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-md-3">
                                    <section class="hk-sec-wrapper" style="margin-top: 15px">
                                        <div class="media align-items-center">
                                            <div class="d-flex media-img-wrap mr-15">
                                                <div class="avatar avatar-sm">
                                                    <span class="avatar-text avatar-text-inv-primary">
                                                        <span class="initial-wrap"><span><i class="zmdi zmdi-money"></i></span></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Phí khắc')}}</span>
                                                <span class="d-block  text-truncate ">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $orderSumEngraveFee) }}</span>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-md-3">
                                    <section class="hk-sec-wrapper" style="margin-top: 15px">
                                        <div class="media align-items-center">
                                            <div class="d-flex media-img-wrap mr-15">
                                                <div class="avatar avatar-sm">
                                                    <span class="avatar-text avatar-text-inv-primary">
                                                        <span class="initial-wrap"><span><i class="zmdi zmdi-money"></i></span></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Tổng tiền')}}</span>
                                                <span class="d-block  text-truncate ">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $orderSumAmount) }}</span>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <section class="hk-sec-wrapper" style="margin-top: 15px">
                                        <div class="media align-items-center">
                                            <div class="d-flex media-img-wrap mr-15">
                                                <div class="avatar avatar-sm">
                                                    <span class="avatar-text avatar-text-inv-success">
                                                        <span class="initial-wrap"><span><i class="zmdi zmdi-money"></i></span></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Tiền hàng (Đã thanh toán)')}}</span>
                                                <span class="d-block  text-truncate ">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $orderPaidSumTotal) }}</span>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-md-3">
                                    <section class="hk-sec-wrapper" style="margin-top: 15px">
                                        <div class="media align-items-center">
                                            <div class="d-flex media-img-wrap mr-15">
                                                <div class="avatar avatar-sm">
                                                    <span class="avatar-text avatar-text-inv-success">
                                                        <span class="initial-wrap"><span><i class="zmdi zmdi-money"></i></span></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Chiết khấu (Đã thanh toán)')}}</span>
                                                <span class="d-block  text-truncate ">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $orderPaidSumDiscount) }}</span>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-md-3">
                                    <section class="hk-sec-wrapper" style="margin-top: 15px">
                                        <div class="media align-items-center">
                                            <div class="d-flex media-img-wrap mr-15">
                                                <div class="avatar avatar-sm">
                                                    <span class="avatar-text avatar-text-inv-success">
                                                        <span class="initial-wrap"><span><i class="zmdi zmdi-money"></i></span></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Phí khắc (Đã thanh toán)')}}</span>
                                                <span class="d-block  text-truncate ">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $orderPaidSumEngraveFee) }}</span>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-md-3">
                                    <section class="hk-sec-wrapper" style="margin-top: 15px">
                                        <div class="media align-items-center">
                                            <div class="d-flex media-img-wrap mr-15">
                                                <div class="avatar avatar-sm">
                                                    <span class="avatar-text avatar-text-inv-success">
                                                        <span class="initial-wrap"><span><i class="zmdi zmdi-money"></i></span></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Tổng tiền (Đã thanh toán)')}}</span>
                                                <span class="d-block  text-truncate ">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $orderPaidSumAmount) }}</span>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <section class="hk-sec-wrapper" style="margin-top: 15px">
                                        <div class="media align-items-center">
                                            <div class="d-flex media-img-wrap mr-15">
                                                <div class="avatar avatar-sm">
                                                    <span class="avatar-text avatar-text-inv-info">
                                                        <span class="initial-wrap"><span><i class="zmdi zmdi-shopping-cart"></i></span></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <span class="d-block text-dark text-capitalize text-truncate ">{{__('Tổng số đơn hàng')}}</span>
                                                <span class="d-block  text-truncate ">{{ $orders->count() }}</span>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-md-3">
                                    <section class="hk-sec-wrapper" style="margin-top: 15px">
                                        <div class="media align-items-center">
                                            <div class="d-flex media-img-wrap mr-15">
                                                <div class="avatar avatar-sm">
                                                    <span class="avatar-text avatar-text-inv-danger">
                                                        <span class="initial-wrap"><span><i class="zmdi zmdi-shopping-cart"></i></span></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <span class="d-block text-dark text-capitalize text-truncate ">{{__('Đã thanh toán')}}</span>
                                                <span class="d-block  text-truncate ">{{ $orderPaid->count() }}</span>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-md-3">
                                    <section class="hk-sec-wrapper" style="margin-top: 15px">
                                        <div class="media align-items-center">
                                            <div class="d-flex media-img-wrap mr-15">
                                                <div class="avatar avatar-sm">
                                                    <span class="avatar-text avatar-text-inv-danger">
                                                        <span class="initial-wrap"><span><i class="zmdi zmdi-shopping-cart"></i></span></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <span class="d-block text-dark text-capitalize text-truncate ">{{__('Thanh toán Online')}}</span>
                                                <span class="d-block  text-truncate ">{{ $orderPayOnline->count() }}</span>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-md-3">
                                    <section class="hk-sec-wrapper" style="margin-top: 15px">
                                        <div class="media align-items-center">
                                            <div class="d-flex media-img-wrap mr-15">
                                                <div class="avatar avatar-sm">
                                                    <span class="avatar-text avatar-text-inv-info">
                                                        <span class="initial-wrap"><span><i class="zmdi zmdi-shopping-cart"></i></span></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <span class="d-block text-dark text-capitalize text-truncate ">{{__('Đơn hàng đang xử lý')}}</span>
                                                <span class="d-block  text-truncate ">{{ $orderProcessing->count() }}</span>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-md-3">
                                    <section class="hk-sec-wrapper" style="margin-top: 15px">
                                        <div class="media align-items-center">
                                            <div class="d-flex media-img-wrap mr-15">
                                                <div class="avatar avatar-sm">
                                                    <span class="avatar-text avatar-text-inv-info">
                                                        <span class="initial-wrap"><span><i class="zmdi zmdi-shopping-cart"></i></span></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <span class="d-block text-dark text-capitalize text-truncate ">{{__('Đơn hàng đang giao')}}</span>
                                                <span class="d-block  text-truncate ">{{ $orderShipping->count()  }}</span>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-md-3">
                                    <section class="hk-sec-wrapper" style="margin-top: 15px">
                                        <div class="media align-items-center">
                                            <div class="d-flex media-img-wrap mr-15">
                                                <div class="avatar avatar-sm">
                                                    <span class="avatar-text avatar-text-inv-success">
                                                        <span class="initial-wrap"><span><i class="zmdi zmdi-shopping-cart"></i></span></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <span class="d-block text-dark text-capitalize text-truncate ">{{__('Đơn hàng hoàn thành')}}</span>
                                                <span class="d-block  text-truncate ">{{ $orderCompleted->count() }}</span>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-md-3">
                                    <section class="hk-sec-wrapper" style="margin-top: 15px">
                                        <div class="media align-items-center">
                                            <div class="d-flex media-img-wrap mr-15">
                                                <div class="avatar avatar-sm">
                                                    <span class="avatar-text avatar-text-inv-warning">
                                                        <span class="initial-wrap"><span><i class="zmdi zmdi-shopping-cart"></i></span></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <span class="d-block text-dark text-capitalize text-truncate ">{{__('Đơn hàng hủy')}}</span>
                                                <span class="d-block  text-truncate ">{{ $orderCanceled->count() }}</span>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-7">
                                    <section class="hk-sec-wrapper">
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="table-wrap">
                                                    <h5><span class="text-primary font-weight-bolder">{{__('THỐNG KÊ THEO NHÓM SẢN PHẨM')}}</span></h5>
                                                    <table class="table table-bordered table-hover w-100 display pb-30 js-main-table">
                                                        <thead class="thead-primary">
                                                            <tr>
                                                                <th scope="col">
                                                                    <span class="text-center font-weight-bolder">
                                                                        {{__('ID')}}
                                                                    </span>
                                                                </th>
                                                                <th scope="col">
                                                                    <span class="text-center font-weight-bolder">
                                                                        {{__('Nhóm sản phẩm')}}
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
                                                            @foreach($orderCatItems as $key => $item)
                                                                <tr>
                                                                    <td data-label="ID">
                                                                        <span class="text-primary">
                                                                            {{ $item->catid }}
                                                                        </span>
                                                                    </td>
                                                                    <td data-label="Nhóm sản phẩm">{{ $item->catname }}</td>
                                                                    <td data-label="Số lượng">{{ number_format($item->quantity, 0, '.', ',') }}</td>
                                                                    <td data-label="Thành tiền">
                                                                        <span class="text-danger font-weight-bolder">
                                                                            {{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item->total_price) }}
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-xl-5">
                                    <fieldset class="form-group">
                                        <div id="chartTotalOrderCatItems" name="chartTotalOrderCatItems">
                                        </div>
                                    </fieldset>
                                </div>                                 
                            </div>

                            <div class="row">
                                <div class="col-xl-12">
                                    <section class="hk-sec-wrapper">
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="table-wrap">
                                                    <h5><span class="text-primary font-weight-bolder">{{__('TOP '.$mLimit.' MẶT SẢN PHẨM ĐANG BÁN CHẠY NHẤT')}}</span></h5>
                                                    <table class="table table-bordered table-hover w-100 display pb-30 js-main-table">
                                                        <thead class="thead-primary">
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
                                                                        {{__('Đơn giá')}}
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
                                                            @foreach($orderItems as $key => $item)
                                                                <tr>
                                                                    <td data-label="ID">
                                                                        <span class="text-primary">
                                                                            {{ $item->pid }}
                                                                        </span>
                                                                    </td>
                                                                    <td data-label="Tên sản phẩm">{{ $item->name }}</td>
                                                                    <td data-label="Đơn giá">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item->price) }}</td>
                                                                    <td data-label="Số lượng">{{ number_format($item->quantity, 0, '.', ',') }}</td>
                                                                    <td data-label="Thành tiền">
                                                                        <span class="text-danger font-weight-bolder">
                                                                            {{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item->total_price) }}
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-12">
                                    <section class="hk-sec-wrapper">
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="table-wrap">
                                                    <h5><span class="text-primary font-weight-bolder">{{__('TOP '.$mLimit.' ĐƠN HÀNG ĐÃ THANH TOÁN GẦN NHẤT')}}</span></h5>
                                                    <table class="table table-bordered table-hover w-100 display pb-30 js-main-table">
                                                        <thead class="thead-info">
                                                        <tr>
                                                            <th scope="col">
                                                                <span class="text-center font-weight-bolder">
                                                                    {{__('Đơn hàng')}}
                                                                </span>
                                                            </th>
                                                            <th scope="col">
                                                                <span class="text-center font-weight-bolder">
                                                                    {{__('Khách hàng')}}
                                                                </span>
                                                            </th>
                                                            <th scope="col">
                                                                <span class="text-center font-weight-bolder">
                                                                    {{__('Điện thoại')}}
                                                                </span>
                                                            </th>
                                                            <th scope="col">
                                                                <span class="text-center font-weight-bolder">
                                                                    {{__('Ngày đặt hàng')}}
                                                                </span>
                                                            </th>
                                                            <th scope="col">
                                                                <span class="text-center font-weight-bolder">
                                                                    {{__('Doanh thu')}}
                                                                </span>
                                                            </th>
                                                            <th scope="col">
                                                                <span class="text-center font-weight-bolder">
                                                                    {{__('Trạng thái')}}
                                                                </span>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(!empty($orderLatest) && count($orderLatest) > 0)
                                                            @foreach($orderLatest as $key => $item)
                                                                <tr>
                                                                    <td data-label="Đơn hàng">
                                                                        <span class="text-primary">
                                                                            {{ $item->id }}
                                                                        </span>
                                                                    </td>
                                                                    <td data-label="Khách hàng">{{ Str::title($item->name) }}</td>
                                                                    <td data-label="Điện thoại"><span class="text-info font-weight-bolder">{{ StringHelper::getPhoneNumber($item->phone) }}</span></td>
                                                                    <td data-label="Ngày đặt hàng">{{ DateHelper::getDate('d/m/Y', $item->created) }}</td>
                                                                    <td data-label="Doanh thu">
                                                                        <span class="text-danger font-weight-bolder">
                                                                            {{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item->amount) }}
                                                                        </span>
                                                                    </td>
                                                                    <td data-label="Trạng thái">
                                                                        <span class="text-{{ \App\Models\Websites\W0001\lt4ProductsOrders::STATUS_COLOR[$item->status_id] }}">
                                                                            {{ \App\Models\Websites\W0001\lt4ProductsOrders::STATUS[$item->status_id] }}
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('javascript_tag')
@parent
    @include('backend.elements.ajax.orderwebsite.orderwebsitereportoverview_list')
    @include('backend.elements.ajax.orderwebsite.items.chartTotalOrderByDate')
    @include('backend.elements.ajax.orderwebsite.items.chartTotalOrderCatItems')
@endsection