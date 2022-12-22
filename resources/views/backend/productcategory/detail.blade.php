<?php
$title = isset($data['title']) ? $data['title'] : '';
$productCategory = isset($data['productCategory']) ? $data['productCategory'] : (object)[];
$productCategories = $data['productCategories'];
$type = $data['type'];
$parentValue = ($type == 'shoes') ? '-- Chọn nhóm Giày --' : '-- Chọn nhóm Mỹ phẩm --';
?>
@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.productcategory.productcategory_detail'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <form action="#" method="post" id="admin-form">
                                <input type="hidden" name="id" value="{{$productCategory->pcat_id ?? intval(old('id'))}}">
                                <input type="hidden" name="action_type" value="save">
                                <input type="hidden" name="type" value="{{$type}}">
                                @csrf
                                <div class="form-group row">
                                    <label for="pcat_name" class="col-sm-2 col-form-label">Tên<span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input name="pcat_name" class="form-control" id="pcat_name" value="{{$productCategory->pcat_name ?? ''}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 pt-0">Trạng thái</label>
                                    <div class="col-sm-10">
                                        <select class="form-control custom-select d-block w-100" name="pcat_status" id="pcat_status">
                                            <option value="">Choose...</option>
                                            @foreach(['activated', 'inactive'] as $item)
                                                @if($item == @$productCategory->pcat_status)
                                                    <option value="{{$item}}" selected="selected">{{$item}}</option>
                                                @else
                                                    <option value="{{$item}}">{{$item}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 pt-0">Thuộc nhóm</label>
                                    <div class="col-sm-10">
                                        <select class="form-control custom-select d-block w-100" name="parent" id="parent">
                                            <option value="{{app('ProductCategory')::TYPE[$type]}}">{{$parentValue}}</option>
                                            @foreach($productCategories as $item)
                                                @php
                                                $level = $item->level - 2;
                                                $disableNode = ($item->left > @$productCategory->left && $item->right < @$productCategory->right) ? 'disabled' : '';
                                                @endphp
                                                @if(@$productCategory->parent == $item->pcat_id)
                                                    <option value="{{$item->pcat_id}}" selected>{{app('NestedSetModelHelper')::notationByLevel($level) . $item->pcat_name}}</option>
                                                @else
                                                    <option value="{{$item->pcat_id}}" {{$disableNode}}>{{app('NestedSetModelHelper')::notationByLevel($level) . $item->pcat_name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <span style="color: darkred">Tính năng này được tạo theo cấu trúc cây 3 cấp, để tạo cây cấp 1 hãy chọn '{{$parentValue}}', tạo cây cấp 2 hoặc 3 hãy chọn vào những nhóm khác.</span>
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
