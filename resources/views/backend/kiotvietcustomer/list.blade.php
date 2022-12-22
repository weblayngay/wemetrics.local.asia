<?php
/**
 * @var \App\Helpers\UrlHelper $urlHelper
 */
use App\Helpers\TranslateHelper;
use App\Helpers\DateHelper;
use App\Helpers\MoneyHelper;
use App\Helpers\StringHelper;
use App\Helpers\UrlHelper;

$urlHelper = app('UrlHelper');
$customerArr = !empty($data['customerArr']) ? $data['customerArr'] : [];
$customerTotal = !empty($data['customerTotal']) ? $data['customerTotal'] : 0;
$title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.kiotvietcustomer.kiotvietcustomer_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.kiotvietcustomer.kiotvietcustomer_search'])
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
                                        <th scope="col">{{__('Mã khách hàng')}}</th>
                                        <th scope="col">{{__('Tên khách hàng')}}</th>
                                        <th scope="col">{{__('Điện thoại')}}</th>
                                        <th scope="col">{{__('Thành tiền')}}</th>
                                        <th scope="col">{{__('Ngày tạo')}}</th>
                                        <th scope="col">{{__('Tổng điểm')}}</th>
                                        <th scope="col">{{__('Điểm còn lại')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($customerArr) && count($customerArr) > 0)
                                        @foreach($customerArr as $key => $item)
                                            <tr>
                                                <td data-label="checkbox"><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->getCode() }}"></td>
                                                <td data-label="Mã khách hàng">
                                                    <a href="@php echo $urlHelper::admin('kiotvietCustomer', 'edit')."?code=".$item->getCode() @endphp">{{ $item->getCode() }}</a>
                                                </td>
                                                <td data-label="Tên khách hàng">{{ Str::title($item->getName()) }}</td>
                                                <td data-label="Điện thoại"><span class="text-info font-weight-bolder">{{ StringHelper::getPhoneNumber($item->getContactNumber()) }}</span></td>
                                                <td data-label="Thành tiền"><span class="text-danger font-weight-bolder">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item->getTotalRevenue()) }}</span></td>
                                                <td data-label="Ngày tạo">{{ DateHelper::getDate('d/m/Y', $item->getCreatedDate()) }}</td>
                                                <td data-label="Tổng điểm"><span class="text-danger font-weight-bolder">{{ MoneyHelper::getQuantity('', $item->getTotalPoint()) }}</span></td>
                                                <td data-label="Điểm còn lại"><span class="text-danger font-weight-bolder">{{ MoneyHelper::getQuantity('', $item->getRewardPoint()) }}</span></td>
                                            </tr>
                                        @endforeach
                                            <tr>
                                                <td colspan="9" class="text-center text-success font-weight-bolder">{{__('Tổng khách hàng: ').MoneyHelper::getQuantity('', $customerTotal) }}</td>
                                            </tr>
                                    @else
                                            <tr>
                                                <td colspan="9" class="not-found-records">{{__('Không tồn tại dữ liệu')}}</td>
                                            </tr>
                                    @endif
                                    </tbody>
                                </table>
                                @if(!empty($customerArr))
                                    {{ $customerArr->links('backend.elements.pagination') }}
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
