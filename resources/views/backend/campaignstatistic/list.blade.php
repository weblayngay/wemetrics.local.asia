<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\TranslateHelper;
    use App\Helpers\DateHelper;
    $urlHelper = app('UrlHelper');
    $totalAssignedVoucher = !empty($data['totalAssignedVoucher']) ? $data['totalAssignedVoucher'] : [];
    $totalUsedVoucher = !empty($data['totalUsedVoucher']) ? $data['totalUsedVoucher'] : [];
    $totalOrderAndVoucherByDate = !empty($data['totalOrderAndVoucherByDate']) ? $data['totalOrderAndVoucherByDate'] : [];
    $totalVoucher = !empty($data['totalVoucher']) ? $data['totalVoucher'] : [];
    $title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.campaignstatistic.campaignstatistic_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.campaignstatistic.campaignstatistic_search'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap" style="overflow-x:auto;">
                            <div class="row">
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <div id="charttotalAssignedVoucher" name="charttotalAssignedVoucher">
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <div id="charttotalUsedVoucher" name="charttotalUsedVoucher">
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    @if(!empty($totalVoucher) && count($totalVoucher) > 0)
                                        @foreach($totalVoucher as $key => $item)
                                            <div class="card border-left-primary shadow h-25">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col m-1">
                                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{__('Số lượng mã giảm giá')}}</div>
                                                        <div class="h5 mb-0 font-weight-bold text-primary-800">{{__($item->total)}}</div>
                                                    </div>
                                                    <div class="col-auto mr-2">
                                                        <i class="fa fa-gift fa-2x text-primary" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                    @if(!empty($totalAssignedVoucher) && count($totalAssignedVoucher) > 0)
                                        @foreach($totalAssignedVoucher as $key => $item)
                                            @if($item->isAssigned == 'Đã cấp phát')
                                                <div class="card border-left-warning shadow h-25">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col m-1">
                                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{__('Mã giảm giá đã cấp')}}</div>
                                                            <div class="h5 mb-0 font-weight-bold text-warning-800">{{__($item->total)}}</div>
                                                        </div>
                                                        <div class="col-auto mr-2">
                                                            <i class="fa fa-gift fa-2x text-warning" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif

                                    @if(!empty($totalUsedVoucher) && count($totalUsedVoucher) > 0)
                                        @foreach($totalUsedVoucher as $key => $item)
                                            @if($item->isUsed == 'Đã sử dụng')
                                                <div class="card border-left-success shadow h-25">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col m-1">
                                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{__('Mã giảm giá đã sử dụng')}}</div>
                                                            <div class="h5 mb-0 font-weight-bold text-success-800">{{__($item->total)}}</div>
                                                        </div>
                                                        <div class="col-auto mr-2">
                                                            <i class="fa fa-gift fa-2x text-success" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <div id="charttotalAssignedVoucherGroupByDevice" name="charttotalAssignedVoucherGroupByDevice">
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <div id="charttotalUsedVoucherGroupByDevice" name="charttotalUsedVoucherGroupByDevice">
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <div id="chartorderUsedVoucherByCity" name="chartorderUsedVoucherByCity">
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <div id="chartorderAndVoucherByDate" name="chartorderAndVoucherByDate">
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <div id="chartorderUsedVoucherByReseller" name="chartorderUsedVoucherByReseller">
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
    @include('backend.elements.ajax.campaignstatistic.campaignstatistic_list')
    @include('backend.elements.ajax.campaignstatistic.items.charttotalAssignedVoucher')
    @include('backend.elements.ajax.campaignstatistic.items.charttotalAssignedVoucherGroupByDevice')
    @include('backend.elements.ajax.campaignstatistic.items.charttotalUsedVoucher')
    @include('backend.elements.ajax.campaignstatistic.items.charttotalUsedVoucherGroupByDevice')
    @include('backend.elements.ajax.campaignstatistic.items.chartorderAndVoucherByDate')
    @include('backend.elements.ajax.campaignstatistic.items.chartorderUsedVoucherByReseller')
    @include('backend.elements.ajax.campaignstatistic.items.chartorderUsedVoucherByCity')
@endsection