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
    $orderUnPaid = !empty($data['orderUnPaid']) ? $data['orderUnPaid'] : [];
    $orderByReseller = !empty($data['orderByReseller']) ? $data['orderByReseller'] : [];
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
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.orderwebsitereportpayonline.orderwebsitereportpayonline_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.orderwebsitereportpayonline.orderwebsitereportpayonline_search'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap" style="overflow-x:auto;">
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <div id="chartTotalOrderPayOnlineByDate" name="chartTotalOrderPayOnlineByDate">
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
                                                <span class="d-block text-dark text-capitalize text-truncate ">{{__('Chưa thanh toán')}}</span>
                                                <span class="d-block  text-truncate ">{{ $orderUnPaid->count() }}</span>
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
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <div id="chartTotalAmount" name="chartTotalAmount">
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <div id="chartTotalPaid" name="chartTotalPaid">
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <div id="chartTotalOrder" name="chartTotalOrder">
                                        </div>
                                    </fieldset>
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
                                                    <h5><span class="text-primary font-weight-bolder">{{__('TÌNH HÌNH ĐƠN HÀNG ONLINE TẠI CÁC CỬA HÀNG')}}</span></h5>
                                                    <table class="table table-bordered table-hover w-100 display pb-30 js-main-table">
                                                        <thead class="thead-info">
                                                            <tr>
                                                                <th scope="col">
                                                                    <span class="text-center font-weight-bolder">
                                                                        {{__('ID')}}
                                                                    </span>
                                                                </th>
                                                                <th scope="col">
                                                                    <span class="text-center font-weight-bolder">
                                                                        {{__('Cửa hàng')}}
                                                                    </span>
                                                                </th>
                                                                <th scope="col">
                                                                    <span class="text-center font-weight-bolder">
                                                                        {{__('Đã thanh toán')}}
                                                                    </span>
                                                                </th>
                                                                <th scope="col">
                                                                    <span class="text-center font-weight-bolder">
                                                                        {{__('Thành tiền')}}
                                                                    </span>
                                                                </th>
                                                                <th scope="col">
                                                                    <span class="text-center font-weight-bolder">
                                                                        {{__('Chưa thanh toán')}}
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
                                                            @foreach($orderByReseller as $key => $item)
                                                                <tr>
                                                                    <td data-label="ID">
                                                                        <span class="text-primary">
                                                                            {{ $item->id }}
                                                                        </span>
                                                                    </td>
                                                                    <td data-label="Cửa hàng">
                                                                        {{ $item->reseller }}
                                                                    </td>
                                                                    <td data-label="Đã thanh toán">
                                                                        {{ number_format($item->totalOrderPaid, 0, '.', ',') }}
                                                                    </td>
                                                                    <td data-label="Thành tiền">
                                                                        <span class="text-success font-weight-bolder">
                                                                            {{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item->totalPaidAmount) }}
                                                                        </span>
                                                                    </td>
                                                                    <td data-label="Chưa thanh toán">
                                                                        {{ number_format($item->totalOrderUnPaid, 0, '.', ',') }}
                                                                    </td>
                                                                    <td data-label="Thành tiền">
                                                                        <span class="text-danger font-weight-bolder">
                                                                            {{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item->totalUnPaidAmount) }}
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
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('javascript_tag')
@parent
    @include('backend.elements.ajax.orderwebsite.orderwebsitereportpayonline_list')
    @include('backend.elements.ajax.orderwebsite.items.chartTotalOrderPayOnlineByDate')
    @include('backend.elements.ajax.orderwebsite.items.chartTotalAmount')
    @include('backend.elements.ajax.orderwebsite.items.chartTotalPaid')
    @include('backend.elements.ajax.orderwebsite.items.chartTotalOrder')
    @include('backend.elements.ajax.orderwebsite.items.chartTotalOrderCatItems')
@endsection