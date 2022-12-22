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
    $invoices = !empty($data['invoices']) ? $data['invoices'] : [];
    $invoiceLatest = !empty($data['invoiceLatest']) ? $data['invoiceLatest'] : [];
    //
    $totalInvoices = !empty($data['totalInvoices']) ? $data['totalInvoices'] : 0;
    $totalInvoicesCompleted = !empty($data['totalInvoicesCompleted']) ? $data['totalInvoicesCompleted'] : 0;
    $totalInvoicesCanceled = !empty($data['totalInvoicesCanceled']) ? $data['totalInvoicesCanceled'] : 0;
    $totalInvoicesProcess = !empty($data['totalInvoicesProcess']) ? $data['totalInvoicesProcess'] : 0;
    $totalInvoiceByDate = !empty($data['totalInvoiceByDate']) ? $data['totalInvoiceByDate'] : [];
    //
    $totalAmount = !empty($data['totalAmount']) ? $data['totalAmount'] : 0;
    $totalAmountCompleted = !empty($data['totalAmountCompleted']) ? $data['totalAmountCompleted'] : 0;
    $totalAmountProcess = !empty($data['totalAmountProcess']) ? $data['totalAmountProcess'] : 0;
    //
    $mLimit = !empty($data['mLimit']) ? $data['mLimit'] : '10';
    //
    $getTotalCustomerCtrl = new getTotalCustomerController();
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.kiotvietinvoicereportoverview.kiotvietinvoicereportoverview_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.kiotvietinvoicereportoverview.kiotvietinvoicereportoverview_search'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap" style="overflow-x:auto;">
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <div id="chartTotalInvoiceCompletedByDate" name="chartTotalInvoiceCompletedByDate">
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
                                                        <span class="initial-wrap"><span><i class="zmdi zmdi-shopping-cart"></i></span></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Tổng bill')}}</span>
                                                <span class="d-block  text-truncate ">{{ MoneyHelper::getQuantity('', $totalInvoices) }}</span>
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
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Tổng bill hoàn thành')}}</span>
                                                <span class="d-block  text-truncate ">{{ MoneyHelper::getQuantity('', $totalInvoicesCompleted) }}</span>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-md-3">
                                    <section class="hk-sec-wrapper" style="margin-top: 15px">
                                        <div class="media align-items-center">
                                            <div class="d-flex media-img-wrap mr-15">
                                                <div class="avatar avatar-sm">
                                                    <span class="avatar-text avatar-text-inv-warning">
                                                        <span class="initial-wrap"><span><i class="zmdi zmdi-shopping-cart"></i></span></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Tổng bill đang xử lý')}}</span>
                                                <span class="d-block  text-truncate ">{{ MoneyHelper::getQuantity('', $totalInvoicesProcess) }}</span>
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
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Tổng bill hủy')}}</span>
                                                <span class="d-block  text-truncate ">{{ MoneyHelper::getQuantity('', $totalInvoicesCanceled) }}</span>
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
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Tổng thành tiền')}}</span>
                                                <span class="d-block  text-truncate ">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $totalAmount) }}</span>
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
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Tổng thành tiền hoàn thành')}}</span>
                                                <span class="d-block  text-truncate ">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $totalAmountCompleted) }}</span>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-md-3">
                                    <section class="hk-sec-wrapper" style="margin-top: 15px">
                                        <div class="media align-items-center">
                                            <div class="d-flex media-img-wrap mr-15">
                                                <div class="avatar avatar-sm">
                                                    <span class="avatar-text avatar-text-inv-warning">
                                                        <span class="initial-wrap"><span><i class="zmdi zmdi-money"></i></span></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <span class="d-block text-dark text-cap[italize text-truncate ">{{__('Tổng thành tiền đang xử lý')}}</span>
                                                <span class="d-block  text-truncate ">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $totalAmountProcess) }}</span>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <div id="chartTotalInvoice" name="chartTotalInvoice">
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <div id="chartTotalAmount" name="chartTotalAmount">
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
    @include('backend.elements.ajax.kiotviet.kiotvietinvoicereportoverview_list')
    @include('backend.elements.ajax.kiotviet.items.chartTotalInvoiceCompletedByDate')
    @include('backend.elements.ajax.kiotviet.items.chartTotalInvoice')
    @include('backend.elements.ajax.kiotviet.items.chartTotalAmount')
@endsection