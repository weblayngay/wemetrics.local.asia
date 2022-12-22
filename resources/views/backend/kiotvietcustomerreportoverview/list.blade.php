<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\MoneyHelper;
    use App\Helpers\DateHelper;
    use App\Helpers\StringHelper;
    use VienThuong\KiotVietClient\Model\Invoice;
    use App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\Children\getTotalCustomerController;

    $urlHelper = app('UrlHelper');
    $title = isset($data['title']) ? $data['title'] : '';
    //
    $invoiceLatest = !empty($data['invoiceLatest']) ? $data['invoiceLatest'] : [];
    //
    $totalCustomerByDate = !empty($data['totalInvoiceByDate']) ? $data['totalInvoiceByDate'] : [];
    //
    $mLimit = !empty($data['mLimit']) ? $data['mLimit'] : '10';
    //
    $getTotalCustomerCtrl = new getTotalCustomerController();
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.kiotvietcustomerreportoverview.kiotvietcustomerreportoverview_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.kiotvietcustomerreportoverview.kiotvietcustomerreportoverview_search'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap" style="overflow-x:auto;">
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <div id="chartTotalCustomerByDate" name="chartTotalCustomerByDate">
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <div id="chartTotalCustomer" name="chartTotalCustomer">
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <div id="chartTotalAmountCustomer" name="chartTotalAmountCustomer">
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
                                                    <h5><span class="text-primary font-weight-bolder">{{__('TOP '.$mLimit.' BILL THÀNH CÔNG GẦN NHẤT')}}</span></h5>
                                                    <table class="table table-bordered table-hover w-100 display pb-30 js-main-table">
                                                        <thead class="thead-info">
                                                        <tr>
                                                            <th scope="col">
                                                                <span class="text-center font-weight-bolder">
                                                                    {{__('Bill')}}
                                                                </span>
                                                            </th>
                                                            <th scope="col">
                                                                <span class="text-center font-weight-bolder">
                                                                    {{__('Khách hàng')}}
                                                                </span>
                                                            </th>
                                                            <th scope="col">
                                                                <span class="text-center font-weight-bolder">
                                                                    {{__('Điện thoại')}}
                                                                </span>
                                                            </th>
                                                            <th scope="col">
                                                                <span class="text-center font-weight-bolder">
                                                                    {{__('Ngày đặt hàng')}}
                                                                </span>
                                                            </th>
                                                            <th scope="col">
                                                                <span class="text-center font-weight-bolder">
                                                                    {{__('Doanh thu')}}
                                                                </span>
                                                            </th>
                                                            <th scope="col">
                                                                <span class="text-center font-weight-bolder">
                                                                    {{__('Trạng thái')}}
                                                                </span>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(!empty($invoiceLatest) && count($invoiceLatest) > 0)
                                                            @foreach($invoiceLatest as $key => $item)
                                                                <tr>
                                                                    <td data-label="Đơn hàng">
                                                                        <a href="@php echo $urlHelper::admin('kiotvietInvoice', 'edit')."?code=".$item->getCode(); @endphp" target="blank">
                                                                            <span class="text-primary">
                                                                                {{ $item->getCode() }}
                                                                            </span>
                                                                        </a>
                                                                    </td>
                                                                    <td data-label="Khách hàng">{{ Str::title($item->getCustomerName()) }}</td>
                                                                    <td data-label="Điện thoại">
                                                                        @php
                                                                            $customerCode = $item->getCustomerCode();
                                                                            if(!empty($customerCode))
                                                                            {
                                                                                $customer = $getTotalCustomerCtrl->doGetCustomerByCode($customerCode);
                                                                            }
                                                                        @endphp
                                                                        <a href="@php echo $urlHelper::admin('kiotvietCustomer', 'edit')."?code=".$customerCode; @endphp" target="blank">
                                                                            <span class="text-info font-weight-bolder">
                                                                                @if(!empty($customerCode))
                                                                                    {{ 
                                                                                        StringHelper::getPhoneNumber($customer->getContactNumber()) 
                                                                                    }}
                                                                                @endif
                                                                            </span>
                                                                        </a>
                                                                    </td>
                                                                    <td data-label="Ngày đặt hàng">{{ DateHelper::getDate('d/m/Y', $item->getPurchaseDate()) }}</td>
                                                                    <td data-label="Doanh thu">
                                                                        <span class="text-danger font-weight-bolder">
                                                                            {{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item->getTotalPayment()) }}
                                                                        </span>
                                                                    </td>
                                                                    <td data-label="Trạng thái">
                                                                        <span class="text-{{ Invoice::STATUSES_COLOR[$item->getStatus()] }}">
                                                                            {{ Invoice::STATUSES_LABEL[$item->getStatus()] }}
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
    @include('backend.elements.ajax.kiotviet.kiotvietcustomerreportoverview_list')
    @include('backend.elements.ajax.kiotviet.items.chartTotalCustomerByDate')
    @include('backend.elements.ajax.kiotviet.items.chartTotalCustomer')
    @include('backend.elements.ajax.kiotviet.items.chartTotalAmountCustomer')
@endsection