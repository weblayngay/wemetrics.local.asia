<?php
/**
 * @var \App\Helpers\UrlHelper $urlHelper
 */
use App\Helpers\TranslateHelper;
use App\Helpers\DateHelper;
use App\Helpers\MoneyHelper;
use App\Helpers\StringHelper;
use VienThuong\KiotVietClient\Model\Invoice;

$urlHelper = app('UrlHelper');
$invoiceArr = !empty($data['invoiceArr']) ? $data['invoiceArr'] : [];
$invoiceTotal = !empty($data['invoiceTotal']) ? $data['invoiceTotal'] : 0;
$title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.kiotvietinvoice.kiotvietinvoice_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.kiotvietinvoice.kiotvietinvoice_search'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap" style="overflow-x:auto;">
                            <form action="#" method="post" id="admin-form">
                                @csrf
                                    <table class="table table-striped table-hover w-100 display pb-30 js-main-table">
                                    <thead>
                                    <tr>
                                        <th scope="col"><input type="checkbox" class="checkAll" name="checkAll" value=""></th>
                                        <th scope="col">{{__('Số bill')}}</th>
                                        <th scope="col">{{__('Chi nhánh')}}</th>
                                        <th scope="col">{{__('Tên khách hàng')}}</th>
                                        <th scope="col">{{__('Thành tiền')}}</th>
                                        <th scope="col">{{__('Thanh toán')}}</th>
                                        <th scope="col">{{__('Ngày mua')}}</th>
                                        <th scope="col">{{__('Trạng thái')}}</th>
                                        <th scope="col">{{__('PT thanh toán')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($invoiceArr) && count($invoiceArr) > 0)
                                        @foreach($invoiceArr as $key => $item)
                                            <tr>
                                                <td data-label="checkbox"><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->getCode() }}"></td>
                                                <td data-label="Số bill"><a href="@php echo $urlHelper::admin('kiotvietInvoice', 'edit')."?code=".$item->getCode(); @endphp">{{ $item->getCode() }}</a></td>
                                                <td data-label="Chi nhánh">{{  Str::title($item->getBranchName()) }}</a></td>
                                                <td data-label="Tên khách hàng">{{ Str::title($item->getCustomerName()) }}</td>
                                                <td data-label="Thành tiền"><span class="text-danger font-weight-bolder">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item->getTotal()) }}</span></td>
                                                <td data-label="Thanh toán"><span class="text-danger font-weight-bolder">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item->getTotalPayment()) }}</span></td>

                                                <td data-label="Ngày mua">{{ DateHelper::getDate('d/m/Y', $item->getPurchaseDate()) }}</td>
                                                <td data-label="Trạng thái">
                                                    <span class="text-{{ Invoice::STATUSES_COLOR[$item->getStatus()] }}">
                                                        {{ Invoice::STATUSES_LABEL[$item->getStatus()] }}
                                                    </span>
                                                </td>
                                                <td data-label="PT thanh toán">
                                                    @php
                                                        $payments = $item->getPayments();
                                                        if(!empty($payments))
                                                        {
                                                            $paymentArr = $payments->getItems();
                                                            foreach($paymentArr as $key => $item)
                                                            {
                                                                $paymentMethod = $item->getMethod();
                                                            }
                                                        }
                                                    @endphp
                                                    @if(!empty($paymentMethod))
                                                        <span class="text-{{ Invoice::PAYMENTMETHODS_COLOR[$paymentMethod] }}">
                                                            {{ Invoice::PAYMENTMETHODS_LABEL[$paymentMethod] }}
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                            <tr>
                                                <td colspan="9" class="text-center text-success font-weight-bolder">{{__('Tổng bill: ').MoneyHelper::getQuantity('', $invoiceTotal) }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="9" class="not-found-records">{{__('Không tồn tại dữ liệu')}}</td>
                                            </tr>
                                    @endif
                                    </tbody>
                                </table>
                                @if(!empty($invoiceArr))
                                    {{ $invoiceArr->links('backend.elements.pagination') }}
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
