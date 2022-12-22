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
    $payments = !empty($data['payments']) ? $data['payments'] : [];
    $paidPayments = !empty($data['paidPayments']) ? $data['paidPayments'] : [];
    $notPaidPayments = !empty($data['notPaidPayments']) ? $data['notPaidPayments'] : [];
    //
    $totalPayAmount = !empty($data['totalPayAmount']) ? $data['totalPayAmount'] : '0';
    $totalPaidAmount = !empty($data['totalPaidAmount']) ? $data['totalPaidAmount'] : '0';
    $totalNotPaidAmount = !empty($data['totalNotPaidAmount']) ? $data['totalNotPaidAmount'] : '0';
    //
    $totalSalesApprovedByDate = !empty($data['totalSalesApprovedByDate']) ? $data['totalSalesApprovedByDate'] : [];
    $totalCommByDate = !empty($data['totalCommByDate']) ? $data['totalCommByDate'] : [];
    $totalAffiliateByPayComm = !empty($data['totalAffiliateByPayComm']) ? $data['totalAffiliateByPayComm'] : [];
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.affiliatepaycommreportoverview.affiliatepaycommreportoverview_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.affiliatepaycommreportoverview.affiliatepaycommreportoverview_search'])
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
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Tổng thanh toán')}}</span>
                                                <span class="d-block  text-truncate ">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $totalPayAmount) }}</span>
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
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Đã chi')}}</span>
                                                <span class="d-block  text-truncate ">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $totalPaidAmount) }}</span>
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
                                                        <span class="initial-wrap"><span><i class="zmdi zmdi-money"></i></span></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Chưa chi')}}</span>
                                                <span class="d-block  text-truncate ">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $totalNotPaidAmount) }}</span>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <div id="chartTotalCommByDate" name="chartTotalCommByDate">
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
                                                    <h5><span class="text-primary font-weight-bolder">{{__('DANH SÁCH THANH TOÁN HOA HỒNGG 15 CỘNG TÁC VIÊN')}}</span></h5>
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
                                                                        {{__('Cộng tác viên')}}
                                                                    </span>
                                                                </th>
                                                                <th scope="col">
                                                                    <span class="text-center font-weight-bolder">
                                                                        {{__('Hoa hồng')}}
                                                                    </span>
                                                                </th>
                                                                <th scope="col">
                                                                    <span class="text-center font-weight-bolder">
                                                                        {{__('Đã chi')}}
                                                                    </span>
                                                                </th>
                                                                <th scope="col">
                                                                    <span class="text-center font-weight-bolder">
                                                                        {{__('Chưa chi')}}
                                                                    </span>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($totalAffiliateByPayComm as $key => $item)
                                                                <tr>
                                                                    <td data-label="ID">{{ $item->afid }}</td>
                                                                    <td data-label="Cộng tác viên">{{ $item->name }}</td>
                                                                    <td data-label="Hoa hồng">
                                                                        <span class="text-primary font-weight-bolder">
                                                                            {{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item->totalAmount) }}
                                                                        </span>
                                                                    </td>
                                                                    <td data-label="Đã chi">
                                                                        <span class="text-success font-weight-bolder">
                                                                            {{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item->totalPaidAmount) }}
                                                                        </span>
                                                                    </td>
                                                                    <td data-label="Chưa chi">
                                                                        <span class="text-danger font-weight-bolder">
                                                                            {{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item->totalNotPaidAmount) }}
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
    @include('backend.elements.ajax.affiliate.affiliatepaycommreportoverview_list')
    @include('backend.elements.ajax.affiliate.items.chartTotalSalesByDate')
    @include('backend.elements.ajax.affiliate.items.chartTotalCommByDate')
@endsection