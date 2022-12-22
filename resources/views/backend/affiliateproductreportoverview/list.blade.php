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
    $sales = !empty($data['sales']) ? $data['sales'] : [];
    $salesApproved = !empty($data['salesApproved']) ? $data['salesApproved'] : [];
    $salesNotApproved = !empty($data['salesNotApproved']) ? $data['salesNotApproved'] : [];
    $salesApprovedPaid = !empty($data['salesApprovedPaid']) ? $data['salesApprovedPaid'] : [];
    $salesApprovedNotPaid = !empty($data['salesApprovedNotPaid']) ? $data['salesApprovedNotPaid'] : [];
    //
    $totalComm = !empty($data['totalComm']) ? $data['totalComm'] : '0';
    $totalCommApproved = !empty($data['totalCommApproved']) ? $data['totalCommApproved'] : '0';
    $totalCommNotApproved = !empty($data['totalCommNotApproved']) ? $data['totalCommNotApproved'] : '0';
    $totalCommApprovedPaid = !empty($data['totalCommApprovedPaid']) ? $data['totalCommApprovedPaid'] : '0';
    $totalCommApprovedNotPaid = !empty($data['totalCommApprovedNotPaid']) ? $data['totalCommApprovedNotPaid'] : '0';
    //
    $salesItems = !empty($data['salesItems']) ? $data['salesItems'] : [];
    $salesCatItems = !empty($data['salesCatItems']) ? $data['salesCatItems'] : [];
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.affiliateproductreportoverview.affiliateproductreportoverview_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.affiliateproductreportoverview.affiliateproductreportoverview_search'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap" style="overflow-x:auto;">
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <div id="chartTotalSalesByDate" name="chartTotalSalesByDate">
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <div id="chartTotalSalesCatItemsByDate" name="chartTotalSalesCatItemsByDate">
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
                                                            @foreach($salesCatItems as $key => $item)
                                                                <tr>
                                                                    <td data-label="ID">{{ $item->catid }}</td>
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
                                        <div id="chartTotalSalesCatItems" name="chartTotalSalesCatItems">
                                        </div>
                                    </fieldset>
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
    @include('backend.elements.ajax.affiliate.affiliateproductreportoverview_list')
    @include('backend.elements.ajax.affiliate.items.chartTotalSalesByDate') 
    @include('backend.elements.ajax.affiliate.items.chartTotalSalesCatItemsByDate')
    @include('backend.elements.ajax.affiliate.items.chartTotalSalesCatItems')
@endsection