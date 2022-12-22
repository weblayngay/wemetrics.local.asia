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
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.affiliatesalesreportoverview.affiliatesalesreportoverview_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.affiliatesalesreportoverview.affiliatesalesreportoverview_search'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap" style="overflow-x:auto;">
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <div id="" name="">
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
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Tổng hoa hồng')}}</span>
                                                <span class="d-block  text-truncate ">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $totalComm) }}</span>
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
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Hoa hồng đã duyệt')}}</span>
                                                <span class="d-block  text-truncate ">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $totalCommApproved) }}</span>
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
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Hoa hồng đã duyệt và thanh toán')}}</span>
                                                <span class="d-block  text-truncate ">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $totalCommApprovedPaid) }}</span>
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
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Hoa hồng đã duyệt chưa thanh toán')}}</span>
                                                <span class="d-block  text-truncate ">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $totalCommApprovedNotPaid) }}</span>
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
                                                    <span class="avatar-text avatar-text-inv-primary">
                                                        <span class="initial-wrap"><span><i class="zmdi zmdi-money"></i></span></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Hoa hồng chưa duyệt')}}</span>
                                                <span class="d-block  text-truncate ">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $totalCommNotApproved) }}</span>
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
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Đơn hàng đã duyệt')}}</span>
                                                <span class="d-block  text-truncate ">{{ number_format($salesApproved->count(), 0, '.', ',') }}</span>
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
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Đơn hàng chưa duyệt')}}</span>
                                                <span class="d-block  text-truncate ">{{ number_format($salesNotApproved->count(), 0, '.', ',') }}</span>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <div id="chartTotalSalesByDate" name="chartTotalSalesByDate">
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
                                                    <h5><span class="text-primary font-weight-bolder">{{__('THỐNG KÊ THEO NHÓM HÀNG')}}</span></h5>
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
                                                                        {{__('Nhóm hàng')}}
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
                                                                    <td data-label="Nhóm hàng">{{ $item->catname }}</td>
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
    @include('backend.elements.ajax.affiliate.affiliatesalesreportoverview_list')
    @include('backend.elements.ajax.affiliate.items.chartTotalSalesByDate')
@endsection