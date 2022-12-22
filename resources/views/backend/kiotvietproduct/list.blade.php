<?php
/**
 * @var \App\Helpers\UrlHelper $urlHelper
 */
use App\Helpers\TranslateHelper;
use App\Helpers\DateHelper;
use App\Helpers\MoneyHelper;
use App\Helpers\StringHelper;
use App\Helpers\UrlHelper;
use VienThuong\KiotVietClient\Model\Product;

$urlHelper = app('UrlHelper');
$productArr = !empty($data['productArr']) ? $data['productArr'] : [];
$productTotal = !empty($data['productTotal']) ? $data['productTotal'] : 0;
$title = isset($data['title']) ? $data['title'] : '';
//
$productModel = new Product();
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.kiotvietproduct.kiotvietproduct_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.kiotvietproduct.kiotvietproduct_search'])
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
                                        <th scope="col">{{__('Mã sản phẩm')}}</th>
                                        <th scope="col">{{__('Tên sản phẩm')}}</th>
                                        <th scope="col">{{__('Nhóm sản phẩm')}}</th>
                                        <th scope="col">{{__('Đơn giá')}}</th>
                                        <th scope="col">{{__('Trạng thái')}}</th>
                                        <th scope="col">{{__('Ngày tạo')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($productArr) && count($productArr) > 0)
                                        @foreach($productArr as $key => $item)
                                            <tr>
                                                <td data-label="checkbox"><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->getCode() }}"></td>
                                                <td data-label="Mã sản phẩm">
                                                    <a href="@php echo $urlHelper::admin('kiotvietProduct', 'edit')."?code=".$item->getCode() @endphp">{{ $item->getCode() }}</a>
                                                </td>
                                                <td data-label="Tên sản phẩm">{{ Str::title($item->getFullName()) }}</td>
                                                <td data-label="Nhóm sản phẩm">{{ Str::title($item->getCategoryName()) }}</td>
                                                <td data-label="Đơn giá">
                                                    <span class="text-danger font-weight-bolder">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item->getBasePrice()) }}</span>
                                                </td>
                                                <td data-label="Trạng thái">
                                                    <span class="{{$productModel::ALLOWS_SALE_CLASS[$item->getIsAllowsSale()]}}">{{ $productModel::ALLOWS_SALE[$item->getIsAllowsSale()] }}</span>
                                                </td>
                                                <td data-label="Ngày tạo">{{ DateHelper::getDate('d/m/Y', $item->getCreatedDate()) }}</td>
                                            </tr>
                                        @endforeach
                                            <tr>
                                                <td colspan="9" class="text-center text-success font-weight-bolder">{{__('Tổng sản phẩm: ').MoneyHelper::getQuantity('', $productTotal) }}</td>
                                            </tr>
                                    @else
                                            <tr>
                                                <td colspan="9" class="not-found-records">{{__('Không tồn tại dữ liệu')}}</td>
                                            </tr>
                                    @endif
                                    </tbody>
                                </table>
                                @if(!empty($productArr))
                                    {{ $productArr->links('backend.elements.pagination') }}
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection