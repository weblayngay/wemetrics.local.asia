<?php
$configs = $data['configs'];
$title = isset($data['title']) ? $data['title'] : '';
?>
@extends('backend.main')
@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.config.index'])
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
                                        <th>Key</th>
                                        <th>Giá trị</th>
                                        <th>Mô tả</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($configs) > 0)
                                        @foreach($configs as $key => $item)
                                            <tr>
                                                <th><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->conf_id }}"></th>
                                                <td>{{ $key + 1 }}</td>
                                                <td><a href="{{app('UrlHelper')::admin('config', 'detail', ['id' => $item->conf_id])}}">{{ $item->conf_name}}</a></td>
                                                <td>{{ $item->conf_key }}</td>
                                                <td>{{ $item->conf_value }}</td>
                                                <td>{{ $item->conf_description }}</td>
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
