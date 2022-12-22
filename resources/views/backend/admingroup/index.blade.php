<?php
/**
 * @var \App\Helpers\UrlHelper $urlHelper
 */
$urlHelper = app('UrlHelper');

$adminGroups = !empty($data['adminGroups']) ? $data['adminGroups'] : [];
$title = isset($data['title']) ? $data['title'] : '';
?>
@extends('backend.main')
@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.admingroup.admingroup_index'])
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
                                        <th>Tên nhóm</th>
                                        <th>Mô tả</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($adminGroups) && count($adminGroups) > 0)
                                        @foreach($adminGroups as $key => $item)
                                            <tr>
                                                <th><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->adgroup_id }}"></th>
                                                <td>{{ $key + 1 }}</td>
                                                <td><a href="{{app('UrlHelper')::admin('admingroup', 'detail', ['id' => $item->adgroup_id])}}">{{ $item->name}}</a></td>
                                                <td>{{ $item->description }}</td>
                                                <td>{{ $item->status }}</td>
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
