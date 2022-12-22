<?php
$title      = isset($data['title']) ? $data['title'] : '';
$adminUser  = $data['adminUser'] ?? (object)[];
$userName   = @$adminUser->username ?? '';
$adminGroups= $data['adminGroups'] ?? (object)[];
$icons      = $data['icons'] ?? [];
if (old()) {
    $adminUser = (object)old();
    if (!isset($adminUser->username))
        $adminUser->username = $userName;
}

?>
@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.adminuser.adminuser_detail'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <form action="#" method="post" id="admin-form">
                                <input type="hidden" name="id" value="{{$adminUser->aduser_id ?? (@$adminUser->id ?? 0)}}">
                                <input type="hidden" name="action_type" value="save">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Họ tên<span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input name="name" class="form-control" id="name" value="{{$adminUser->name ?? ''}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="username" class="col-sm-2 col-form-label">Tên đăng nhập<span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input @if(@$adminUser->aduser_id > 0 || @$adminUser->id > 0) disabled @endif name="username" class="form-control" id="username" value="{{$adminUser->username ?? ''}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" name="email" class="form-control" id="email" value="{{$adminUser->email ?? ''}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-sm-2 col-form-label">Mật khẩu</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="password" class="form-control" id="password" value="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password_confirmation" class="col-sm-2 col-form-label">Xác nhận Mật khẩu</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" value="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 pt-0">Trạng thái</label>
                                    <div class="col-sm-10">
                                        <select class="form-control custom-select d-block w-100" name="status" id="status">
                                            <option value="">Choose...</option>
                                            @foreach(['activated', 'inactive'] as $item)
                                                @if($item == @$adminUser->status)
                                                    <option value="{{$item}}" selected="selected">{{$item}}</option>
                                                @else
                                                    <option value="{{$item}}">{{$item}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 pt-0">Nhóm</label>
                                    <div class="col-sm-10">
                                        <select class="form-control custom-select d-block w-100" name="adgroup_id" id="adgroup_id">
                                            <option value="">Choose...</option>
                                            @foreach($adminGroups as $adminGroup)
                                                @if($adminGroup->adgroup_id == @$adminUser->adgroup_id)
                                                    <option value="{{$adminGroup->adgroup_id}}" selected="selected">{{$adminGroup->name}}</option>
                                                @else
                                                    <option value="{{$adminGroup->adgroup_id}}">{{$adminGroup->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('javascript_tag')
    @parent
    <script>
        /**
         * Khi Checked menu cha
         */
        $("input[data-menu-type='parent']").click(function (){
            var isCheck = $(this).is(':checked');
            var parentId = $(this).attr('id');

            /**
             * Bỏ checked menu con
             */
            if (isCheck == false) {
                $("input[data-parent='"+parentId+"']").prop( "checked", false );
            }
        });

        /**
         * Khi Checked menu con
         */
        $("input[data-menu-type='children']").click(function (){
            var isCheck = $(this).is(':checked');
            var parentId = $(this).data('parent');

            /**
             * Checked menu cha
             */
            if (isCheck == true) {
                $("input#" + parentId).prop( "checked", true );
            }
        });
    </script>
@endsection
