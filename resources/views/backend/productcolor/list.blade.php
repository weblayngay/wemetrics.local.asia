<?php
/**
 * @var \App\Helpers\UrlHelper $urlHelper
 */
$urlHelper = app('UrlHelper');
$colors = !empty($data['colors']) ? $data['colors'] : [];
$title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.productcolor.productcolor_list'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <form action="#" method="post" id="admin-form">
                                @csrf
                                <table id="datable_1" class="table table-hover w-100 display pb-30 js-main-table">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" class="checkAll" name="checkAll" value=""></th>
                                        <th>#</th>
                                        <th>Mô tả ngắn</th>
                                        <th>HEX</th>
                                        <th>Ngày tạo</th>
                                        <th>Bật</th>
                                        <th>Id</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($colors) && count($colors) > 0)
                                        @foreach($colors as $key => $item)
                                            <tr>
                                                <th><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->pcolor_id }}"></th>
                                                <td>{{ $key + 1 }}</td>
                                                <td><a href="@php echo $urlHelper::admin('productcolor', 'edit', ['id' => $item->pcolor_id]) @endphp">{{ $item->pcolor_code }}</a></td>
                                                <td><input type="color" disabled width="15px" value="{{$item->pcolor_hex}}"> {{ $item->pcolor_hex}}</td>
                                                <td>{{ $item->pcolor_created_at}}</td>
                                                <td>{{ $item->pcolor_status}}</td>
                                                <td>{{ $item->pcolor_id }}</td>
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
