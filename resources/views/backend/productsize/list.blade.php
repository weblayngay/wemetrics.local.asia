<?php
/**
 * @var \App\Helpers\UrlHelper $urlHelper
 */
$urlHelper = app('UrlHelper');
$sizes = !empty($data['sizes']) ? $data['sizes'] : [];
$title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.productsize.productsize_list'])
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
                                        <th>Code</th>
                                        <th>Ngày tạo</th>
                                        <th>Bật</th>
                                        <th>Id</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($sizes) && count($sizes) > 0)
                                        @foreach($sizes as $key => $item)
                                            <tr>
                                                <th><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->psize_id }}"></th>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->psize_value}}</td>
                                                <td><a href="@php echo $urlHelper::admin('productsize', 'edit')."?id=$item->psize_id" @endphp">{{ $item->psize_code }}</a></td>
                                                <td>{{ $item->psize_created_at}}</td>
                                                <td>{{ $item->psize_status}}</td>
                                                <td>{{ $item->psize_id }}</td>
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
