<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\TranslateHelper;
    use App\Helpers\DateHelper;
    $urlHelper = app('UrlHelper');
    $title = isset($data['title']) ? $data['title'] : '';
    $totalTrafficSource = isset($data['totalTrafficSource']) ? $data['totalTrafficSource'] : null;
    $totalTrafficBrowser = isset($data['totalTrafficBrowser']) ? $data['totalTrafficBrowser'] : null;
    $totalTrafficDevice = isset($data['totalTrafficDevice']) ? $data['totalTrafficDevice'] : null;
    $totalTrafficPlatform = isset($data['totalTrafficPlatform']) ? $data['totalTrafficPlatform'] : null;
    $totalTrafficAds = isset($data['totalTrafficAds']) ? $data['totalTrafficAds'] : null;
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.clienttrackingreportoverview.clienttrackingreportoverview_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.clienttrackingreportoverview.clienttrackingreportoverview_search'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap" style="overflow-x:auto;">
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <div id="chartTotalTrafficByDate" name="chartTotalTrafficByDate">
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <div id="chartTotalTrafficSource" name="chartTotalTrafficSource"></div>
                                    </fieldset>
                                </div>
                                <div class="col-md-4">
                                    <table class="table table-hover w-100 display pb-30 js-main-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">{{__('Nguồn truy cập')}}</th>
                                                <th scope="col">{{__('Biểu tượng')}}</th>
                                                <th scope="col">{{__('Thống kê')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($totalTrafficSource) && count($totalTrafficSource) > 0)
                                                @foreach($totalTrafficSource as $key => $item)
                                                    <tr>
                                                        <td data-label="Nguồn truy cập">{{ $item->label }}</td>
                                                        <td data-label="Biểu tượng"><img class="shake icon-size-32" src="{{ADMIN_DIST_ICON_URL . '/tracking-referer/' . $item->icon}}" alt="{{ $item->label }}" ></img></td>
                                                        <td data-label="Thống kê" class="text-danger">{{ $item->total }}</td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td data-label="Xem báo cáo" colspan="1">
                                                        <div class="btn btn-primary">
                                                            <a href="@php echo $urlHelper::admin('clienttrackingreportsource', 'index') @endphp" style="color: #fff;">{{__('Xem báo cáo')}}</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @else
                                                    <tr>
                                                        <td colspan="9" class="not-found-records">{{__('Không tồn tại dữ liệu')}}</td>
                                                    </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <div id="chartTotalTrafficBrowser" name="chartTotalTrafficBrowser"></div>
                                    </fieldset>
                                </div>
                                <div class="col-md-4">
                                    <table class="table table-hover w-100 display pb-30 js-main-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">{{__('Trình duyệt')}}</th>
                                                <th scope="col">{{__('Biểu tượng')}}</th>
                                                <th scope="col">{{__('Thống kê')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($totalTrafficBrowser) && count($totalTrafficBrowser) > 0)
                                                @foreach($totalTrafficBrowser as $key => $item)
                                                    <tr>
                                                        <td data-label="Trình duyệt">{{ $item->label }}</td>
                                                        <td data-label="Biểu tượng"><img class="shake icon-size-32" src="{{ADMIN_DIST_ICON_URL . '/tracking-browser/' . $item->icon}}" alt="{{ $item->label }}" ></img></td>
                                                        <td data-label="Thống kê" class="text-danger">{{ $item->total }}</td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td data-label="Xem báo cáo" colspan="1">
                                                        <div class="btn btn-primary">
                                                            <a href="@php echo $urlHelper::admin('clienttrackingreportbrowser', 'index') @endphp" style="color: #fff;">{{__('Xem báo cáo')}}</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @else
                                                    <tr>
                                                        <td colspan="9" class="not-found-records">{{__('Không tồn tại dữ liệu')}}</td>
                                                    </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <div id="chartTotalTrafficDevice" name="chartTotalTrafficDevice"></div>
                                    </fieldset>
                                </div>
                                <div class="col-md-4">
                                    <table class="table table-hover w-100 display pb-30 js-main-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">{{__('Thiết bị')}}</th>
                                                <th scope="col">{{__('Biểu tượng')}}</th>
                                                <th scope="col">{{__('Thống kê')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($totalTrafficDevice) && count($totalTrafficDevice) > 0)
                                                @foreach($totalTrafficDevice as $key => $item)
                                                    <tr>
                                                        <td data-label="Thiết bị">{{ $item->label }}</td>
                                                        <td data-label="Biểu tượng"><img class="shake icon-size-32" src="{{ADMIN_DIST_ICON_URL . '/tracking-device/' . $item->icon}}" alt="{{ $item->label }}" ></img></td>
                                                        <td data-label="Thống kê" class="text-danger">{{ $item->total }}</td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td data-label="Xem báo cáo" colspan="1">
                                                        <div class="btn btn-primary">
                                                            <a href="@php echo $urlHelper::admin('clienttrackingreportdevice', 'index') @endphp" style="color: #fff;">{{__('Xem báo cáo')}}</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @else
                                                    <tr>
                                                        <td colspan="9" class="not-found-records">{{__('Không tồn tại dữ liệu')}}</td>
                                                    </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <div id="chartTotalTrafficPlatform" name="chartTotalTrafficPlatform"></div>
                                    </fieldset>
                                </div>
                                <div class="col-md-4">
                                    <table class="table table-hover w-100 display pb-30 js-main-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">{{__('Nền tảng')}}</th>
                                                <th scope="col">{{__('Biểu tượng')}}</th>
                                                <th scope="col">{{__('Thống kê')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($totalTrafficPlatform) && count($totalTrafficPlatform) > 0)
                                                @foreach($totalTrafficPlatform as $key => $item)
                                                    <tr>
                                                        <td data-label="Nền tảng">{{ $item->label }}</td>
                                                        <td data-label="Biểu tượng"><img class="shake icon-size-32" src="{{ADMIN_DIST_ICON_URL . '/tracking-platform/' . $item->icon}}" alt="{{ $item->label }}" ></img></td>
                                                        <td data-label="Thống kê" class="text-danger">{{ $item->total }}</td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td data-label="Xem báo cáo" colspan="1">
                                                        <div class="btn btn-primary">
                                                            <a href="@php echo $urlHelper::admin('clienttrackingreportplatform', 'index') @endphp" style="color: #fff;">{{__('Xem báo cáo')}}</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @else
                                                    <tr>
                                                        <td colspan="9" class="not-found-records">{{__('Không tồn tại dữ liệu')}}</td>
                                                    </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <div id="chartTotalTrafficAds" name="chartTotalTrafficAds"></div>
                                    </fieldset>
                                </div>
                                <div class="col-md-4">
                                    <table class="table table-hover w-100 display pb-30 js-main-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">{{__('Nguồn quảng cáo')}}</th>
                                                <th scope="col">{{__('Biểu tượng')}}</th>
                                                <th scope="col">{{__('Thống kê')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($totalTrafficAds) && count($totalTrafficAds) > 0)
                                                @foreach($totalTrafficAds as $key => $item)
                                                    <tr>
                                                        <td data-label="Nguồn quảng cáo">{{ $item->label }}</td>
                                                        <td data-label="Biểu tượng"><img class="shake icon-size-32" src="{{ADMIN_DIST_ICON_URL . '/tracking-ads/' . $item->icon}}" alt="{{ $item->label }}" ></img></td>
                                                        <td data-label="Thống kê" class="text-danger">{{ $item->total }}</td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td data-label="Xem báo cáo" colspan="1">
                                                        <div class="btn btn-primary">
                                                            <a href="@php echo $urlHelper::admin('clienttrackingreportads', 'index') @endphp" style="color: #fff;">{{__('Xem báo cáo')}}</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @else
                                                    <tr>
                                                        <td colspan="9" class="not-found-records">{{__('Không tồn tại dữ liệu')}}</td>
                                                    </tr>
                                            @endif
                                        </tbody>
                                    </table>
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
    @include('backend.elements.ajax.clienttracking.clienttrackingreportoverview_list')
    @include('backend.elements.ajax.clienttracking.items.chartTotalTrafficByDate')
    @include('backend.elements.ajax.clienttracking.items.chartTotalTrafficSource')
    @include('backend.elements.ajax.clienttracking.items.chartTotalTrafficBrowser')
    @include('backend.elements.ajax.clienttracking.items.chartTotalTrafficDevice')
    @include('backend.elements.ajax.clienttracking.items.chartTotalTrafficPlatform')
    @include('backend.elements.ajax.clienttracking.items.chartTotalTrafficAds')
@endsection