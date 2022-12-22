<?php
$adminUsers = count(@$data['adminUsers']) > 0 ? $data['adminUsers'] : (object)[];
$title      = isset($data['title']) ? $data['title'] : '';
//dd($adminUsers);
?>
@extends('backend.main')
@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.adminuser.adminuser_index'])
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
                                        <th>Họ Tên</th>
                                        <th>Tên đăng nhập</th>
                                        <th>Email</th>
                                        <th>Trạng thái</th>
                                        <th>Nhóm</th>
                                        <th>ID</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($adminUsers) > 0)
                                        @foreach($adminUsers as $key => $item)
                                            <tr>
                                                <th><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->aduser_id }}"></th>
                                                <td>{{ $key + 1 }}</td>
                                                <td><a href="{{app('UrlHelper')::admin('adminuser', 'detail', ['id' => $item->aduser_id])}}">{{ $item->name}}</a></td>
                                                <td>{{ $item->username }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->status }}</td>
                                                <td>{{ $item->group_name }}</td>
                                                <td>{{ $item->aduser_id }}</td>
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
