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
    $totalCateProductByBranch = !empty($data['totalCateProductByBranch']) ? $data['totalCateProductByBranch'] : [];
    $tuideoByBranch = !empty($data['tuideoByBranch']) ? $data['tuideoByBranch'] : [];
    $phukienByBranch = !empty($data['phukienByBranch']) ? $data['phukienByBranch'] : [];
    $quatangByBranch = !empty($data['quatangByBranch']) ? $data['quatangByBranch'] : [];
    $bopviByBranch = !empty($data['bopviByBranch']) ? $data['bopviByBranch'] : [];
    $baloByBranch = !empty($data['baloByBranch']) ? $data['baloByBranch'] : [];
    $capxachByBranch = !empty($data['capxachByBranch']) ? $data['capxachByBranch'] : [];
    $daynitByBranch = !empty($data['daynitByBranch']) ? $data['daynitByBranch'] : [];
    $tuidulichByBranch = !empty($data['tuidulichByBranch']) ? $data['tuidulichByBranch'] : [];
    $khacByBranch = !empty($data['khacByBranch']) ? $data['khacByBranch'] : [];
    $tuixachByBranch = !empty($data['tuixachByBranch']) ? $data['tuixachByBranch'] : [];
    $tuiquangByBranch = !empty($data['tuiquangByBranch']) ? $data['tuiquangByBranch'] : [];
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

                            @if(!empty($totalCateProductByBranch))
                                <div class="row">
                                    @if(!empty($tuideoByBranch) && count($tuideoByBranch) > 0)
                                        <div class="col-md-4">
                                            <div type="button" class="btn d-flex justify-content-center" data-toggle="modal" data-target="#tuideoModal">
                                              <span class="btn btn-primary font-weight-bolder">{{__('Xem tất cả cửa hàng')}}</span>
                                            </div>                                            
                                            <fieldset class="form-group">
                                                @include('backend.kiotvietcateproductreportoverview.modals.modalbybranch', 
                                                [
                                                    'modalId' => 'tuideoModal',
                                                    'title' => 'Thống kê túi đeo theo cửa hàng', 
                                                    'tuideoByBranch' => $tuideoByBranch,
                                                    'frmDate' => $frmDate,
                                                    'toDate' => $toDate,
                                                    'beginYear' => $beginYear,
                                                    'adgroup' => $adgroup
                                                ])
                                                <div id="chartTuiDeoByBranch" name="chartTuiDeoByBranch">
                                                </div>
                                            </fieldset>
                                        </div>
                                    @endif
                                    @if(!empty($capxachByBranch) && count($capxachByBranch) > 0)
                                        <div class="col-md-4">
                                            <div type="button" class="btn d-flex justify-content-center" data-toggle="modal" data-target="#capxachModal">
                                              <span class="btn btn-primary font-weight-bolder">{{__('Xem tất cả cửa hàng')}}</span>
                                            </div> 
                                            <fieldset class="form-group">
                                                @include('backend.kiotvietcateproductreportoverview.modals.modalbybranch', 
                                                [
                                                    'modalId' => 'capxachModal',
                                                    'title' => 'Thống kê cặp xách theo cửa hàng', 
                                                    'tuideoByBranch' => $capxachByBranch,
                                                    'frmDate' => $frmDate,
                                                    'toDate' => $toDate,
                                                    'beginYear' => $beginYear,
                                                    'adgroup' => $adgroup
                                                ])
                                                <div id="chartCapXachByBranch" name="chartCapXachByBranch">
                                                </div>
                                            </fieldset>
                                        </div>
                                    @endif
                                    @if(!empty($tuiquangByBranch) && count($tuiquangByBranch) > 0)
                                        <div class="col-md-4">
                                            <div type="button" class="btn d-flex justify-content-center" data-toggle="modal" data-target="#tuiquangModal">
                                              <span class="btn btn-primary font-weight-bolder">{{__('Xem tất cả cửa hàng')}}</span>
                                            </div>                                             
                                            <fieldset class="form-group">
                                                @include('backend.kiotvietcateproductreportoverview.modals.modalbybranch', 
                                                [
                                                    'modalId' => 'tuiquangModal',
                                                    'title' => 'Thống kê túi quàng theo cửa hàng', 
                                                    'tuideoByBranch' => $tuiquangByBranch,
                                                    'frmDate' => $frmDate,
                                                    'toDate' => $toDate,
                                                    'beginYear' => $beginYear,
                                                    'adgroup' => $adgroup
                                                ])                                    
                                                <div id="chartTuiQuangByBranch" name="chartTuiQuangByBranch">
                                                </div>
                                            </fieldset>
                                        </div>
                                    @endif
                                </div>

                                <div class="row">
                                    @if(!empty($tuixachByBranch) && count($tuixachByBranch) > 0)
                                        <div class="col-md-4">
                                            <div type="button" class="btn d-flex justify-content-center" data-toggle="modal" data-target="#tuixachModal">
                                              <span class="btn btn-primary font-weight-bolder">{{__('Xem tất cả cửa hàng')}}</span>
                                            </div>                                            
                                            <fieldset class="form-group">
                                                @include('backend.kiotvietcateproductreportoverview.modals.modalbybranch', 
                                                [
                                                    'modalId' => 'tuixachModal',
                                                    'title' => 'Thống kê túi xách theo cửa hàng', 
                                                    'tuideoByBranch' => $tuixachByBranch,
                                                    'frmDate' => $frmDate,
                                                    'toDate' => $toDate,
                                                    'beginYear' => $beginYear,
                                                    'adgroup' => $adgroup
                                                ])                                                  
                                                <div id="chartTuiXachByBranch" name="chartTuiXachByBranch">
                                                </div>
                                            </fieldset>
                                        </div>
                                    @endif
                                    @if(!empty($bopviByBranch) && count($bopviByBranch) > 0)
                                        <div class="col-md-4">
                                            <div type="button" class="btn d-flex justify-content-center" data-toggle="modal" data-target="#bopviModal">
                                              <span class="btn btn-primary font-weight-bolder">{{__('Xem tất cả cửa hàng')}}</span>
                                            </div>                                            
                                            <fieldset class="form-group">
                                                @include('backend.kiotvietcateproductreportoverview.modals.modalbybranch', 
                                                [
                                                    'modalId' => 'bopviModal',
                                                    'title' => 'Thống kê bóp ví theo cửa hàng', 
                                                    'tuideoByBranch' => $bopviByBranch,
                                                    'frmDate' => $frmDate,
                                                    'toDate' => $toDate,
                                                    'beginYear' => $beginYear,
                                                    'adgroup' => $adgroup
                                                ])                                                  
                                                <div id="chartBopViByBranch" name="chartBopViByBranch">
                                                </div>
                                            </fieldset>
                                        </div>
                                    @endif
                                    @if(!empty($baloByBranch) && count($baloByBranch) > 0)
                                        <div class="col-md-4">
                                            <div type="button" class="btn d-flex justify-content-center" data-toggle="modal" data-target="#baloModal">
                                              <span class="btn btn-primary font-weight-bolder">{{__('Xem tất cả cửa hàng')}}</span>
                                            </div>                                               
                                            <fieldset class="form-group">
                                                @include('backend.kiotvietcateproductreportoverview.modals.modalbybranch', 
                                                [
                                                    'modalId' => 'baloModal',
                                                    'title' => 'Thống kê balo theo cửa hàng', 
                                                    'tuideoByBranch' => $baloByBranch,
                                                    'frmDate' => $frmDate,
                                                    'toDate' => $toDate,
                                                    'beginYear' => $beginYear,
                                                    'adgroup' => $adgroup
                                                ])                                                 
                                                <div id="chartBaloByBranch" name="chartBaloByBranch">
                                                </div>
                                            </fieldset>
                                        </div>
                                    @endif
                                </div>

                                <div class="row">
                                    @if(!empty($tuidulichByBranch) && count($tuidulichByBranch) > 0)
                                        <div class="col-md-4">
                                            <div type="button" class="btn d-flex justify-content-center" data-toggle="modal" data-target="#tuidulichModal">
                                              <span class="btn btn-primary font-weight-bolder">{{__('Xem tất cả cửa hàng')}}</span>
                                            </div>                                              
                                            <fieldset class="form-group">
                                                @include('backend.kiotvietcateproductreportoverview.modals.modalbybranch', 
                                                [
                                                    'modalId' => 'tuidulichModal',
                                                    'title' => 'Thống kê túi du lịch theo cửa hàng', 
                                                    'tuideoByBranch' => $tuidulichByBranch,
                                                    'frmDate' => $frmDate,
                                                    'toDate' => $toDate,
                                                    'beginYear' => $beginYear,
                                                    'adgroup' => $adgroup
                                                ])                                                 
                                                <div id="chartTuiDuLichByBranch" name="chartTuiDuLichByBranch">
                                                </div>
                                            </fieldset>
                                        </div>
                                    @endif
                                    @if(!empty($daynitByBranch) && count($daynitByBranch) > 0)
                                        <div class="col-md-4">
                                            <div type="button" class="btn d-flex justify-content-center" data-toggle="modal" data-target="#daynitModal">
                                              <span class="btn btn-primary font-weight-bolder">{{__('Xem tất cả cửa hàng')}}</span>
                                            </div>                                             
                                            <fieldset class="form-group">
                                                @include('backend.kiotvietcateproductreportoverview.modals.modalbybranch', 
                                                [
                                                    'modalId' => 'daynitModal',
                                                    'title' => 'Thống kê dây nịt theo cửa hàng', 
                                                    'tuideoByBranch' => $daynitByBranch,
                                                    'frmDate' => $frmDate,
                                                    'toDate' => $toDate,
                                                    'beginYear' => $beginYear,
                                                    'adgroup' => $adgroup
                                                ])                                                 
                                                <div id="chartDayNitByBranch" name="chartDayNitByBranch">
                                                </div>
                                            </fieldset>
                                        </div>
                                    @endif
                                    @if(!empty($phukienByBranch) && count($phukienByBranch) > 0)
                                        <div class="col-md-4">
                                            <div type="button" class="btn d-flex justify-content-center" data-toggle="modal" data-target="#phukienModal">
                                              <span class="btn btn-primary font-weight-bolder">{{__('Xem tất cả cửa hàng')}}</span>
                                            </div>                                             
                                            <fieldset class="form-group">
                                                @include('backend.kiotvietcateproductreportoverview.modals.modalbybranch', 
                                                [
                                                    'modalId' => 'phukienModal',
                                                    'title' => 'Thống kê phụ kiện theo cửa hàng', 
                                                    'tuideoByBranch' => $phukienByBranch,
                                                    'frmDate' => $frmDate,
                                                    'toDate' => $toDate,
                                                    'beginYear' => $beginYear,
                                                    'adgroup' => $adgroup
                                                ])                                                   
                                                <div id="chartPhuKienByBranch" name="chartPhuKienByBranch">
                                                </div>
                                            </fieldset>
                                        </div>
                                    @endif
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
                                                            <h5><span class="text-primary font-weight-bolder">{{__('THỐNG KÊ THEO NHÓM SẢN PHẨM')}}</span></h5>
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
                                                                    'tuideoByBranch' => $tuideoByBranch,
                                                                    'capxachByBranch' => $capxachByBranch,
                                                                    'tuiquangByBranch' => $tuiquangByBranch,
                                                                    'tuixachByBranch' => $tuixachByBranch,
                                                                    'bopviByBranch' => $bopviByBranch,
                                                                    'baloByBranch' => $baloByBranch,
                                                                    'tuidulichByBranch' => $tuidulichByBranch,
                                                                    'daynitByBranch' => $daynitByBranch,
                                                                    'phukienByBranch' => $phukienByBranch,
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
                                                        <thead class="thead-info">
                                                        <tr>
                                                            <th scope="col">
                                                                <span class="text-center font-weight-bolder">
                                                                    {{__('Tên nhóm hàng')}}
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
                                                            @if(!empty($totalCateProduct))
                                                                @php
                                                                    $totalSubTotal = 0;
                                                                    $totalQuantity = 0;
                                                                @endphp
                                                                {{-- Get Total --}}
                                                                @foreach($totalCateProduct as $key => $item)
                                                                    @if($item->quantity > 0)
                                                                        @php
                                                                            $totalSubTotal += $item->subTotal;
                                                                            $totalQuantity += $item->quantity;
                                                                        @endphp
                                                                    @endif
                                                                @endforeach
                                                                @foreach($totalCateProduct as $key => $item)
                                                                    @if($item->quantity > 0)
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
                                                                                $badgebg = 'warning';
                                                                            } 
                                                                            if($loop->index + 1 > 3)
                                                                            {
                                                                                $badgebg = 'info';
                                                                            }                                                                                                                                        
                                                                        @endphp
                                                                        <tr>
                                                                            <td data-label="Tên nhóm hàng">
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="card">
                                                                                            @if($loop->index <= 2)
                                                                                                <div class="ribbon-wrapper">
                                                                                                    <div class="ribbon ribbon-{{__($badgebg)}}">{{__('Top ').($loop->index + 1)}}</div>
                                                                                                </div>
                                                                                            @else
                                                                                                <div class="ribbon-wrapper">
                                                                                                    <div class="ribbon ribbon-{{__($badgebg)}}">{{__('Regular')}}</div>
                                                                                                </div>
                                                                                            @endif
                                                                                            <div class="card-body">
                                                                                                <p class="mb-0"><strong>{{ Str::title($item->name) }}</strong></p>
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
                                                                    @endif
                                                                @endforeach
                                                                {{-- Show with admin --}}
                                                                @if($adgroup == 1 || $adgroup == 2)
                                                                    <tr>
                                                                        <td></td>
                                                                        <td><strong>{{__('Số lượng bán: ')}}</strong></td>
                                                                        <td><span style="color: crimson; font-weight: bold;">{{ MoneyHelper::getQuantity('', $totalQuantity) }}</span></td>
                                                                    </tr>
                                                                @else
                                                                    <tr>
                                                                        <td><strong>{{__('Số lượng bán: ')}}</strong></td>                                                                        
                                                                        <td><span style="color: crimson; font-weight: bold;">{{ MoneyHelper::getQuantity('', $totalQuantity) }}</span></td>
                                                                    </tr>
                                                                @endif
                                                                {{-- Show with admin --}}
                                                                @if($adgroup == 1 || $adgroup == 2)
                                                                    <tr>
                                                                        <td></td>
                                                                        <td><strong>{{__('Tiền hàng: ')}}</strong></td>
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

                            <div class="row">
                                <div class="col-xl-12">
                                    <section class="hk-sec-wrapper">
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="table-wrap">
                                                    <h5><span class="text-primary font-weight-bolder">{{__('TOP '.$mLimit.' SẢN PHẨM BÁN CHẠY NHẤT')}}</span></h5>
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
    @include('backend.elements.ajax.kiotviet.items.cateproducts.chartTotalQuantityCateProduct')
    @include('backend.elements.ajax.kiotviet.items.cateproducts.chartTotalAmountCateProduct')
    @if(!empty($totalCateProductByBranch))
        @if(!empty($tuixachByBranch) && count($tuixachByBranch) > 0)
            @include('backend.elements.ajax.kiotviet.items.cateproducts.chartTuiXachByBranch')
        @endif

        @if(!empty($tuideoByBranch) && count($tuideoByBranch) > 0)
            @include('backend.elements.ajax.kiotviet.items.cateproducts.chartTuiDeoByBranch')
        @endif

        @if(!empty($tuiquangByBranch) && count($tuiquangByBranch) > 0)
            @include('backend.elements.ajax.kiotviet.items.cateproducts.chartTuiQuangByBranch')
        @endif

        @if(!empty($capxachByBranch) && count($capxachByBranch) > 0)
            @include('backend.elements.ajax.kiotviet.items.cateproducts.chartCapXachByBranch')
        @endif

        @if(!empty($bopviByBranch) && count($bopviByBranch) > 0)
            @include('backend.elements.ajax.kiotviet.items.cateproducts.chartBopViByBranch')
        @endif

        @if(!empty($baloByBranch) && count($baloByBranch) > 0)
            @include('backend.elements.ajax.kiotviet.items.cateproducts.chartBaloByBranch')
        @endif

        @if(!empty($tuidulichByBranch) && count($tuidulichByBranch) > 0)
            @include('backend.elements.ajax.kiotviet.items.cateproducts.chartTuiDuLichByBranch')
        @endif

        @if(!empty($daynitByBranch) && count($daynitByBranch) > 0)
            @include('backend.elements.ajax.kiotviet.items.cateproducts.chartDayNitByBranch')
        @endif

        @if(!empty($phukienByBranch) && count($phukienByBranch) > 0)
            @include('backend.elements.ajax.kiotviet.items.cateproducts.chartPhuKienByBranch')
        @endif
    @endif
@endsection