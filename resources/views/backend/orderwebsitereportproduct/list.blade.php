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
    //
    $mLimit = !empty($data['mLimit']) ? $data['mLimit'] : '10';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.orderwebsitereportproduct.orderwebsitereportproduct_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.orderwebsitereportproduct.orderwebsitereportproduct_search'])
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
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <div id="chartTotalOrderCatItemsByDate" name="chartTotalOrderCatItemsByDate">
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
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('javascript_tag')
@parent
    @include('backend.elements.ajax.orderwebsite.orderwebsitereportproduct_list')
    @include('backend.elements.ajax.orderwebsite.items.chartTotalOrderByDate')
    @include('backend.elements.ajax.orderwebsite.items.chartTotalAmount')
    @include('backend.elements.ajax.orderwebsite.items.chartTotalPaid')
    @include('backend.elements.ajax.orderwebsite.items.chartTotalOrder')
    @include('backend.elements.ajax.orderwebsite.items.chartTotalOrderCatItems')
    @include('backend.elements.ajax.orderwebsite.items.chartTotalOrderCatItemsByDate')
@endsection