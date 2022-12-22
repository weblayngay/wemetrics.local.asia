<?php
$adminMenuArr    = count(@$data['adminMenus']) > 0 ? $data['adminMenus']->toArray() : [];
$parentMenuArr   = [];
$childrenMenuArr = [];
if (is_array($adminMenuArr) && count($adminMenuArr)) {
    foreach ($adminMenuArr as $menu) {
        if ($menu['parent'] == 0) {
            $parentMenuArr[$menu['admenu_id']] = $menu;
        } else {
            $childrenMenuArr[$menu['admenu_id']] = $menu;
        }
    }
}

$title = isset($data['title']) ? $data['title'] : '';
?>
@extends('backend.main')
@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.adminmenu.adminmenu_index'])
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
                                        <th>Controller</th>
                                        <th>Action</th>
                                        <th>Trạng thái</th>
                                        <th>Icon</th>
                                        <th>Id</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(is_array($parentMenuArr) && count($parentMenuArr) > 0)
                                        @foreach($parentMenuArr as $key => $parentMenu)
                                            <tr>
                                                <th><input type="checkbox" class="checkItem" name="cid[]" value="{{ $parentMenu['admenu_id'] }}"></th>
                                                <td>{{ $key + 1 }}</td>
                                                <td><a href="{{app('UrlHelper')::admin('adminmenu', 'detail', ['id' => $parentMenu['admenu_id']])}}">{{ $parentMenu['name']}}</a></td>
                                                <td>{{ $parentMenu['controller'] }}</td>
                                                <td>{{ $parentMenu['action'] }}</td>
                                                <td>{{ $parentMenu['status'] }}</td>
                                                <td><img src="{{ ADMIN_DIST_ICON_URL . $parentMenu['icon'] }}" alt="not found"></td>
                                                <td>{{$parentMenu['admenu_id']}}</td>
                                            </tr>
                                            @foreach($childrenMenuArr as $childrenMenu)
                                                @if($childrenMenu['parent'] == $parentMenu['admenu_id'])
                                                    <tr>
                                                        <th><input type="checkbox" class="checkItem" name="cid[]" value="{{ $childrenMenu['admenu_id'] }}"></th>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td><a href="{{app('UrlHelper')::admin('adminmenu', 'detail', ['id' => $childrenMenu['admenu_id']])}}">|----> {{ $childrenMenu['name']}}</a></td>
                                                        <td>{{ $childrenMenu['controller'] }}</td>
                                                        <td>{{ $childrenMenu['action'] }}</td>
                                                        <td>{{ $childrenMenu['status'] }}</td>
                                                        <td><img src="{{ ADMIN_DIST_ICON_URL . $childrenMenu['icon'] }}" alt=""></td>
                                                        <td>{{$childrenMenu['admenu_id']}}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
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
