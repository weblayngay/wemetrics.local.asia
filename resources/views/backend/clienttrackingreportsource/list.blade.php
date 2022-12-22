<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\TranslateHelper;
    use App\Helpers\DateHelper;
    $urlHelper = app('UrlHelper');
    $title = isset($data['title']) ? $data['title'] : '';
    $totalTrafficSource = isset($data['totalTrafficSource']) ? $data['totalTrafficSource'] : null;
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.clienttrackingreportsource.clienttrackingreportsource_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.clienttrackingreportsource.clienttrackingreportsource_search'])
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
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <div id="chartTotalTrafficSourceByDate" name="chartTotalTrafficSourceByDate">
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
    @include('backend.elements.ajax.clienttracking.clienttrackingreportsource_list')
    @include('backend.elements.ajax.clienttracking.items.chartTotalTrafficByDate')
    @include('backend.elements.ajax.clienttracking.items.chartTotalTrafficSource')
    @include('backend.elements.ajax.clienttracking.items.chartTotalTrafficSourceByDate')
@endsection