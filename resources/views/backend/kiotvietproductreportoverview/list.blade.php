<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\MoneyHelper;
    use App\Helpers\DateHelper;
    use App\Helpers\StringHelper;
    $urlHelper = app('UrlHelper');
    //
    $adgroup = isset($data['adgroup']) ? $data['adgroup'] : '';
    $action = isset($data['action']) ? $data['action'] : 'index';
    $title = isset($data['title']) ? $data['title'] : '';
    //
    $totalProductInventory = !empty($data['totalProductInventory']) ? $data['totalProductInventory'] : [];
    $mLimit = !empty($data['mLimit']) ? $data['mLimit'] : KIOTVIET_DEFAULT_LIMIT;
    $code = !empty($data['code']) ? $data['code'] : '%';
    $branch = !empty($data['branch']) ? $data['branch'] : '%';
    //
    $frmDate = !empty($data['frmDate']) ? $data['frmDate'] : date('Y-m-01');
    $toDate = !empty($data['toDate']) ? $data['toDate'] : date('Y-m-d');
    $beginYear = date('Y-01-01');
    $now = !empty($data['now']) ? $data['now'] : date('Y-m-d');
    //
    $frmDate = DateHelper::getDate('d-m-Y', $frmDate);
    $toDate = DateHelper::getDate('d-m-Y', $toDate);
    $beginYear = DateHelper::getDate('d-m-Y', $beginYear);
    $now = DateHelper::getDate('d-m-Y', $now);
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.kiotvietproductreportoverview.kiotvietproductreportoverview_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.kiotvietproductreportoverview.kiotvietproductreportoverview_search'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap" style="overflow-x:auto;">

                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <div id="chartTotalProductByDate" name="chartTotalProductByDate">
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
                                                    <div class="row">
                                                        <div class="col-md-5 pt-1">
                                                            <h5><span class="text-primary font-weight-bolder">{{__('TÌNH HÌNH NHẬP - XUẤT - TỒN TẠI CỬA HÀNG')}}</span></h5>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div type="button" class="btn d-flex justify-content-center" data-toggle="modal" data-target="#biModal">
                                                              <span class="btn btn-info font-weight-bolder">{{__('Đọc phân tích')}}</span>
                                                            </div> 
                                                            <fieldset class="form-group">
                                                                @include('backend.kiotvietproductreportoverview.modals.modalbybi', 
                                                                [
                                                                    'modalId' => 'biModal',
                                                                    'action' => $action,
                                                                    'title' => $title, 
                                                                    'totalProductInventory' => $totalProductInventory,
                                                                    'branch' => $branch,
                                                                    'code' => $code,
                                                                    'frmDate' => $frmDate,
                                                                    'toDate' => $toDate,
                                                                    'beginYear' => $beginYear,
                                                                    'now' => $now,
                                                                    'adgroup' => $adgroup,
                                                                    'mLimit' => $mLimit
                                                                ])
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <table class="table table-bordered table-hover w-100 display pb-30 js-main-table">
                                                        <thead class="thead-info">
                                                        <tr>
                                                            <th scope="col">
                                                                <span class="text-center font-weight-bolder">
                                                                    {{__('Cửa hàng')}}
                                                                </span>
                                                            </th>
                                                            <th scope="col">
                                                                <span class="text-center font-weight-bolder">
                                                                    {{__('Tên cửa hàng')}}
                                                                </span>
                                                            </th>
                                                            <th scope="col">
                                                                <span class="text-center font-weight-bolder">
                                                                    {{__('Mã hàng')}}
                                                                </span>
                                                            </th>
                                                            <th scope="col">
                                                                <span class="text-center font-weight-bolder">
                                                                    {{__('Tên hàng')}}
                                                                </span>
                                                            </th>
                                                            <th scope="col">
                                                                <span class="text-center font-weight-bolder">
                                                                    {{__('Nhập hàng')}}
                                                                </span><br>
                                                                <span class="text-center font-weight-bolder">
                                                                    {{__('đến '.$now)}}
                                                                </span>
                                                            </th>
                                                            <th scope="col">
                                                                <span class="text-center font-weight-bolder">
                                                                    {{__('Bán hàng ')}}
                                                                </span><br>
                                                                <span class="text-center font-weight-bolder">
                                                                    {{__('từ '.$frmDate.' đến '.$toDate)}}
                                                                </span>
                                                            </th>
                                                            <th scope="col">
                                                                <span class="text-center font-weight-bolder">
                                                                    {{__('Tồn kho')}}
                                                                </span><br>
                                                                <span class="text-center font-weight-bolder">
                                                                    {{__('đến '.$now)}}
                                                                </span>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(!empty($totalProductInventory))
                                                            @foreach($totalProductInventory as $key => $item)
                                                                @php
                                                                    // Top
                                                                    if($loop->index + 1 == 1)
                                                                    {
                                                                        $badgebg = 'primary';
                                                                    }
                                                                    if($loop->index + 1 == 2)
                                                                    {
                                                                        $badgebg = 'success';
                                                                    }
                                                                    if($loop->index + 1 == 3)
                                                                    {
                                                                        $badgebg = 'info';
                                                                    }
                                                                    if($loop->index + 1 == 4)
                                                                    {
                                                                        $badgebg = 'warning';
                                                                    }
                                                                    if($loop->index + 1 == 5)
                                                                    {
                                                                        $badgebg = 'danger';
                                                                    }
                                                                    if($loop->index + 1 > 5)
                                                                    {
                                                                        $badgebg = 'secondary';
                                                                    } 
                                                                @endphp
                                                                <tr>
                                                                    <td data-label="Mã cửa hàng">
                                                                        <span class="text-primary">
                                                                            {{ $item->getBranchId() }}
                                                                        </span>
                                                                    </td>
                                                                    <td data-label="Tên cửa hàng">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="card">
                                                                                    @if($loop->index <= 4)
                                                                                        <div class="ribbon-wrapper">
                                                                                            <div class="ribbon ribbon-{{__($badgebg)}}">{{__('Top ').($loop->index + 1)}}</div>
                                                                                        </div>
                                                                                    @else
                                                                                        <div class="ribbon-wrapper">
                                                                                            <div class="ribbon ribbon-{{__($badgebg)}}">{{__('Regular')}}</div>
                                                                                        </div>
                                                                                    @endif
                                                                                    <div class="card-body">
                                                                                        <p class="mb-0"><strong>{{ Str::title($item->getBranchName()) }}</strong></p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>                                                                                
                                                                        </div>
                                                                    </td>
                                                                    <td data-label="Mã hàng">
                                                                        <span class="text-primary">
                                                                            {{ $item->productCode }}
                                                                        </span>
                                                                    </td>
                                                                    <td data-label="Tên hàng">
                                                                        {{ Str::title($item->productName) }}
                                                                    </td>
                                                                    <td data-label="Nhập hàng">
                                                                        <span class="text-danger font-weight-bolder">
                                                                            {{ MoneyHelper::getQuantity('', $item->purchaseQuantity) }}
                                                                        </span>
                                                                    </td>
                                                                    <td data-label="Bán hàng">
                                                                        <span class="text-danger font-weight-bolder">
                                                                            {{ MoneyHelper::getQuantity('', $item->getQuantity()) }}
                                                                        </span>
                                                                    </td>
                                                                    <td data-label="tồn kho">
                                                                        <span class="text-danger font-weight-bolder">
                                                                            {{ MoneyHelper::getQuantity('', $item->getOnHand()) }}
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
    @include('backend.elements.ajax.kiotviet.kiotvietproductreportoverview_list') 
    @include('backend.elements.ajax.kiotviet.items.chartTotalProductByDate')
@endsection