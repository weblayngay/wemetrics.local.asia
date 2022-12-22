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
    $totalCateProduct = !empty($data['totalCateProduct']) ? $data['totalCateProduct'] : [];
    $totalTopProductByDate = !empty($data['totalTopProductByDate']) ? $data['totalTopProductByDate'] : [];
    //
    $mLimit = !empty($data['mLimit']) ? $data['mLimit'] : KIOTVIET_DEFAULT_LIMIT;
    $branch = !empty($data['branch']) ? $data['branch'] : '%';
    $cateProduct = !empty($data['cateProduct']) ? $data['cateProduct'] : '%';
    //
    $frmDate = !empty($data['frmDate']) ? $data['frmDate'] : date('Y-m-01');
    $toDate = !empty($data['toDate']) ? $data['toDate'] : date('Y-m-d');
    $beginYear = date('Y-01-01');
    $now = date('Y-m-d');
    //
    $frmDate = DateHelper::getDate('d-m-Y', $frmDate);
    $toDate = DateHelper::getDate('d-m-Y', $toDate);
    $beginYear = DateHelper::getDate('d-m-Y', $beginYear);
    $now = DateHelper::getDate('d-m-Y', $now);
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.kiotvietcateproductreportoverview.kiotvietcateproductreportoverview_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.kiotvietcateproductreportoverview.kiotvietcateproductreportoverview_search'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap" style="overflow-x:auto;">
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <div id="chartTotalCateProductByDate" name="chartTotalCateProductByDate">
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <div id="chartTotalQuantityCateProduct" name="chartTotalQuantityCateProduct">
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            {{-- Show with admin --}}
                            @if($adgroup == 1 || $adgroup == 2)
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset class="form-group">
                                            <div id="chartTotalAmountCateProduct" name="chartTotalAmountCateProduct">
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-xl-12">
                                    <section class="hk-sec-wrapper">
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="table-wrap">
                                                    <div class="row">
                                                        <div class="col-md-4 pt-1">
                                                            <h5><span class="text-primary font-weight-bolder">{{__('TOP '.$mLimit.' SẢN PHẨM BÁN CHẠY NHẤT')}}</span></h5>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div type="button" class="btn d-flex justify-content-center" data-toggle="modal" data-target="#biModal">
                                                              <span class="btn btn-info font-weight-bolder">{{__('Đọc phân tích')}}</span>
                                                            </div> 
                                                            <fieldset class="form-group">
                                                                @include('backend.kiotvietcateproductreportoverview.modals.modalbybi', 
                                                                [
                                                                    'modalId' => 'biModal',
                                                                    'action' => $action,
                                                                    'title' => $title, 
                                                                    'totalCateProduct' => $totalCateProduct,
                                                                    'totalTopProductByDate' => $totalTopProductByDate,
                                                                    'branch' => $branch,
                                                                    'cateProduct' => $cateProduct,
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
                                                    <table class="table table-striped table-bordered table-hover w-100 display pb-30 js-main-table">
                                                        <thead class="thead-primary">
                                                        <tr>
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
                                                                    {{__('Số lượng bán')}}
                                                                </span><br>
                                                                <span class="text-center font-weight-bolder">
                                                                    {{__('từ '.$frmDate.' đến '.$toDate)}}
                                                                </span>
                                                            </th>
                                                            {{-- Show with admin --}}
                                                            @if($adgroup == 1 || $adgroup == 2)
                                                                <th scope="col">
                                                                    <span class="text-center font-weight-bolder">
                                                                        {{__('Tiền hàng')}}
                                                                    </span><br>
                                                                    <span class="text-center font-weight-bolder">
                                                                        {{__('từ '.$frmDate.' đến '.$toDate)}}
                                                                    </span>
                                                                </th>
                                                            @endif
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(!empty($totalTopProductByDate))
                                                                @php
                                                                    $totalSubTotal = 0;
                                                                    $totalQuantity = 0;
                                                                @endphp
                                                                @foreach($totalTopProductByDate as $key => $item)
                                                                    @php
                                                                        $totalSubTotal += $item->subTotal;
                                                                        $totalQuantity += $item->quantity;
                                                                    @endphp
                                                                @endforeach
                                                                @foreach($totalTopProductByDate as $key => $item)
                                                                    @php
                                                                        // Quantity Percent
                                                                        $quantityPercent = Round($item->quantity / $totalQuantity * 100, 0);
                                                                        if($quantityPercent >= 15)
                                                                        {
                                                                            $quantityBgProcess = 'bg-primary';
                                                                        }
                                                                        if($quantityPercent >= 10 && $quantityPercent < 15)
                                                                        {
                                                                            $quantityBgProcess = 'bg-success';
                                                                        }
                                                                        if($quantityPercent >= 5 && $quantityPercent < 10)
                                                                        {
                                                                            $quantityBgProcess = 'bg-info';
                                                                        } 
                                                                        if($quantityPercent < 5)
                                                                        {
                                                                            $quantityBgProcess = 'bg-warning';
                                                                        }
                                                                        // Subtotal Percent                                      
                                                                        $subTotalPercent = Round($item->subTotal / $totalSubTotal * 100, 0);
                                                                        if($subTotalPercent >= 15)
                                                                        {
                                                                            $subTotalBgProcess = 'bg-primary';
                                                                        }
                                                                        if($subTotalPercent >= 10 && $subTotalPercent < 15)
                                                                        {
                                                                            $subTotalBgProcess = 'bg-success';
                                                                        }
                                                                        if($subTotalPercent >= 5 && $subTotalPercent < 10)
                                                                        {
                                                                            $subTotalBgProcess = 'bg-info';
                                                                        } 
                                                                        if($subTotalPercent < 5)
                                                                        {
                                                                            $subTotalBgProcess = 'bg-warning';
                                                                        }  
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
                                                                        <td data-label="Mã hàng">
                                                                            <a href="@php echo $urlHelper::admin('kiotvietproductreportoverview', 'preloadindex')."?branch=".$branch."&code=".$item->productCode."&frmDate=".$frmDate."&toDate=".$toDate; @endphp" target="_blank">
                                                                                <span class="text-primary">
                                                                                    {{ $item->productCode }}
                                                                                </span>
                                                                            </a>
                                                                        </td>
                                                                        <td data-label="Tên hàng">
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
                                                                                            <p class="mb-0"><strong>{{ Str::title($item->productName) }}</strong></p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td data-label="Số lượng">
                                                                            <span class="text-danger font-weight-bolder">
                                                                                {{ MoneyHelper::getQuantity('', $item->quantity) }}
                                                                            </span>
                                                                            <div class="progress">
                                                                                <div class="progress-bar {{__($quantityBgProcess)}} progress-bar-striped progress-bar-animated" style="width:{{ $quantityPercent.'%'}}"></div>
                                                                            </div>                                                                            
                                                                        </td>
                                                                        {{-- Show with admin --}}
                                                                        @if($adgroup == 1 || $adgroup == 2)
                                                                            <td data-label="Tiền hàng">
                                                                                <span class="text-danger font-weight-bolder">
                                                                                    {{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item->subTotal) }}
                                                                                </span>
                                                                                <div class="progress">
                                                                                    <div class="progress-bar {{__($subTotalBgProcess)}} progress-bar-striped progress-bar-animated" style="width:{{ $subTotalPercent.'%'}}"></div>
                                                                                </div>                                                                                   
                                                                            </td>
                                                                        @endif
                                                                    </tr>
                                                                @endforeach
                                                                {{-- Show with admin --}}
                                                                @if($adgroup == 1 || $adgroup == 2)
                                                                    <tr>
                                                                        <td></td>
                                                                        <td><strong>{{__('Số lượng: ')}}</strong></td>
                                                                        <td></td>
                                                                        <td><span style="color: crimson; font-weight: bold;">{{ MoneyHelper::getQuantity('', $totalQuantity) }}</span></td>
                                                                    </tr>
                                                                @else
                                                                    <tr>
                                                                        <td></td>
                                                                        <td><strong>{{__('Số lượng: ')}}</strong></td>
                                                                        <td><span style="color: crimson; font-weight: bold;">{{ MoneyHelper::getQuantity('', $totalQuantity) }}</span></td>
                                                                    </tr>
                                                                @endif
                                                                {{-- Show with admin --}}
                                                                @if($adgroup == 1 || $adgroup == 2)
                                                                    <tr>
                                                                        <td></td>
                                                                        <td><strong>{{__('Tiền hàng: ')}}</strong></td>                                                                    
                                                                        <td></td>
                                                                        <td><span style="color: crimson; font-weight: bold;">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $totalSubTotal) }}</span></td>
                                                                    </tr>
                                                                @endif
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
    @include('backend.elements.ajax.kiotviet.kiotvietcateproductreportoverview_list')
    @include('backend.elements.ajax.kiotviet.items.cateproducts.chartTotalCateProductByDate') 
    @include('backend.elements.ajax.kiotviet.items.cateproducts.chartTotalQuantityCateProduct')
    @include('backend.elements.ajax.kiotviet.items.cateproducts.chartTotalAmountCateProduct')
@endsection