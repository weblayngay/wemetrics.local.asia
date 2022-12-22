<?php
$title      = isset($data['title']) ? $data['title'] : '';
$adminMenu  = $data['adminMenu'] ?? (object)[];
$icons      = $data['icons'] ?? [];
$parentMenus= $data['parentMenus'] ?? (object)[];
?>
@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.adminmenu.adminmenu_detail'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <form action="#" method="post" id="admin-form">
                                <input type="hidden" name="id" value="{{$adminMenu->admenu_id ?? 0}}">
                                <input type="hidden" name="action_type" value="save">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Tên <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input name="name" class="form-control" id="name" value="{{$adminMenu->name ?? ''}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="description" class="col-sm-2 col-form-label">Controller</label>
                                    <div class="col-sm-10">
                                        <input name="controller" class="form-control" id="name" value="{{$adminMenu->controller ?? ''}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="description" class="col-sm-2 col-form-label">Action</label>
                                    <div class="col-sm-10">
                                        <input name="action" class="form-control" id="name" value="{{$adminMenu->action ?? ''}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 pt-0">Trạng thái</label>
                                    <div class="col-sm-10">
                                        <select class="form-control custom-select d-block w-100" name="status" id="status">
                                            <option value="">Choose...</option>
                                            @foreach(['activated', 'inactive'] as $item)
                                                @if($item == @$adminMenu->status)
                                                    <option value="{{$item}}" selected="selected">{{$item}}</option>
                                                @else
                                                    <option value="{{$item}}">{{$item}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 pt-0">Icon</label>
                                    <div class="col-sm-10">
                                        <select class="form-control custom-select d-block w-100" name="icon" id="icon">
                                            <option value="">Choose...</option>
                                            @foreach($icons as $icon)
                                                @if($icon == @$adminMenu->icon)
                                                    <option value="{{$icon}}" selected="selected">{{$icon}}</option>
                                                @else
                                                    <option value="{{$icon}}">{{$icon}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 pt-0">Menu cha</label>
                                    <div class="col-sm-10">
                                        <select class="form-control custom-select d-block w-100" name="parent" id="parent">
                                            <option value="0">Choose...</option>
                                            @foreach($parentMenus as $menu)
                                                @if($menu->admenu_id == @$adminMenu->parent)
                                                    <option value="{{$menu->admenu_id}}" selected="selected">{{$menu->name}}</option>
                                                @else
                                                    <option value="{{$menu->admenu_id}}">{{$menu->name}}</option>
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
