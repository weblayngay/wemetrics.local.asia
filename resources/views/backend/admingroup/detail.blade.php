<?php
$title = isset($data['title']) ? $data['title'] : '';

$adminGroupId = 0;
$menusOfGroup = [];
if ($adminGroup = @$data['adminGroup']) {
    $adminGroupId = $adminGroup->adgroup_id;
    $menusOfGroup = explode(',', $adminGroup->admenu_ids);
}

$adminMenus = $data['adminMenus'];
if (count($adminMenus)) {
    $parentMenus = [];
    $childrenMenus = [];
    foreach ($adminMenus as $key => $adminMenu) {
        if ($adminMenu->parent == 0) {
            $parentMenus[$key] = $adminMenu;
        } else {
            $childrenMenus[$key] = $adminMenu;
        }
    }
}


?>
@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.admingroup.admingroup_detail'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <form action="#" method="post" id="admin-form">
                                <input type="hidden" name="id" value="{{$adminGroupId}}">
                                <input type="hidden" name="action_type" value="save">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Tên nhóm <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input name="name" class="form-control" id="name" value="{{$adminGroup->name ?? ''}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="description" class="col-sm-2 col-form-label">Mô tả</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="description" id="description">{{$adminGroup->description ?? ''}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 pt-0">Trạng thái</label>
                                    <div class="col-sm-10">
                                        <select class="form-control custom-select d-block w-100" name="status" id="status">
                                            <option value="">Choose...</option>
                                            @foreach(['activated', 'inactive'] as $item)
                                                @if($item == @$adminGroup->status)
                                                    <option value="{{$item}}" selected="selected">{{$item}}</option>
                                                @else
                                                    <option value="{{$item}}">{{$item}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 pt-0">Chi tiết quyền</label>
                                    <div class="col-sm-10">
                                        @if(count($parentMenus))
                                            @foreach($parentMenus as $parentMenu)
                                                <h6 style="font-weight: bold; border-bottom: 1px solid #D7D7D7; padding-bottom: 7px; padding-top: 10px">{{$parentMenu['name']}}</h6>
                                                <div class="custom-control custom-checkbox">
                                                    <input value="{{$parentMenu['admenu_id']}}" data-menu-type="parent" class="custom-control-input" name="menu[]" id="parent-{{$parentMenu['admenu_id']}}" type="checkbox" @if (in_array($parentMenu['admenu_id'], $menusOfGroup)) checked @endif>
                                                    <label class="custom-control-label" for="parent-{{$parentMenu['admenu_id']}}">{{$parentMenu['name']}}</label>
                                                </div>
                                                @foreach($childrenMenus as $childrenMenu)
                                                    @if($childrenMenu['parent'] == $parentMenu['admenu_id'])
                                                        <div class="custom-control custom-checkbox" style="padding-left: 55px">
                                                            <input value="{{$childrenMenu['admenu_id']}}" data-menu-type="children" data-parent="parent-{{$parentMenu['admenu_id']}}" class="custom-control-input" name="menu[]" id="children-{{$childrenMenu['admenu_id']}}" type="checkbox" @if (in_array($childrenMenu['admenu_id'], $menusOfGroup)) checked @endif>
                                                            <label class="custom-control-label" for="children-{{$childrenMenu['admenu_id']}}">{{$childrenMenu['name']}}</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
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
