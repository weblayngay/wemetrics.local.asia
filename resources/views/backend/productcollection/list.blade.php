<?php
/**
 * @var \App\Helpers\UrlHelper $urlHelper
 */
$urlHelper = app('UrlHelper');
$collections = !empty($data['collections']) ? $data['collections'] : [];
$title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.productcollection.productcollection_list'])
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
                                        <th>Tên</th>
                                        <th>Ngày tạo</th>
                                        <th>Bật</th>
                                        <th>Id</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($collections) && count($collections) > 0)
                                        @foreach($collections as $key => $item)
                                            <tr>
                                                <th><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->pcollection_id }}"></th>
                                                <td>{{ $key + 1 }}</td>
                                                <td><a href="@php echo $urlHelper::admin('productcollection', 'edit')."?id=$item->pcollection_id" @endphp">{{ $item->pcollection_name }}</a></td>
                                                <td>{{ $item->pcollection_created_at}}</td>
                                                <td>{{ $item->pcollection_status}}</td>
                                                <td>{{ $item->pcollection_id }}</td>
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
