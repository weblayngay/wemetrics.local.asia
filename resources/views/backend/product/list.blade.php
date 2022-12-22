<?php
/**
 * @var \App\Helpers\UrlHelper $urlHelper
 */
$urlHelper = app('UrlHelper');
$products = !empty($data['products']) ? $data['products'] : [];
$title = isset($data['title']) ? $data['title'] : '';
$producers = !empty($data['producers']) ? $data['producers'] : [];
$type = $data['type'];
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.product.product_list'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <form action="#" method="post" id="admin-form">
                                <input type="hidden" name="type" value="{{$type}}">
                                @csrf
                                <table id="datable_1" class="table table-hover w-100 display pb-30 js-main-table">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" class="checkAll" name="checkAll" value=""></th>
                                        <th>#</th>
                                        <th>Ảnh</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Nhà sản xuất</th>
                                        <th>Nhóm sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày tạo</th>
                                        <th>Bật</th>
                                        <th>Id</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($products) && count($products) > 0)
                                        @foreach($products as $key => $item)
                                            <tr>
                                                <th><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->product_id }}"></th>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    @if(!empty($item->urlAvatar))
                                                        <img width="70px" class="js-lazy-loading" data-src="{{ asset($item->urlAvatar) }}">
                                                    @endif
                                                </td>
                                                <td><a href="@php echo $urlHelper::admin('product', 'edit', ['type' => $type, 'id' => $item->product_id]) @endphp">{{ $item->product_name }}</a></td>
                                                <td>{{ $item->producerName }} </td>
                                                <td>{{ \App\Models\Product::GROUP_NAME[$item->product_group] }}</td>
                                                <td>{{ $item->product_price }}</td>
                                                <td>{{ $item->product_status }}</td>
                                                <td>{{ $item->product_created_at}}</td>
                                                <td>{{ $item->product_status_show }}</td>
                                                <td>{{ $item->product_id }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
