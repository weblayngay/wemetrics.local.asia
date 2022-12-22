<?php
    $adgroup = !empty($data['adgroup']) ? $data['adgroup'] : null;
    $title = !empty($data['title']) ? $data['title'] : '';
    $adminName = $data['adminName'];
    $adminId = $data['adminId'];
    // Begin Nested items
    $parents = isset($data['parents']) ? $data['parents'] : '';
    $parentId = isset($data['parentId']) ? $data['parentId'] : 0;
    $node = 1;
    // End Nested items
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.advertgroup.advertgroup_edit'])
    <form method="POST" id="admin-form" action="{{app('UrlHelper')::admin('advertgroup', 'update')}}" enctype="multipart/form-data">
        <input type="hidden" name="action_type">
        <input type="hidden" name="id" value="{{$adgroup->adgroup_id}}">
        @csrf
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <nav id="nav-tabs">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-vi-tab" data-toggle="tab" href="#nav-vi" role="tab" aria-controls="nav-vi" aria-selected="true">Thông tin (Tiếng Việt)</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-vi" role="tabpanel" aria-labelledby="nav-vi-tab">
                                <div class="col-xl-12">
                                    <section class="hk-sec-wrapper">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="updatedBy">{{__('Được sửa bởi')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="updatedName" class="form-control" value="{{ $adminName }}" readonly="">
                                                            <input type="hidden" name="updatedBy" class="form-control" value="{{ $adminId }}" readonly="">
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="name">{{__('Tên nhóm quảng cáo')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="name" class="form-control" placeholder="Tên nhóm quảng cáo" value="{{ $adgroup->adgroup_name }}">
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="slug">{{__('Slug')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="slug" class="form-control" placeholder="slug" value="{{ $adgroup->adgroup_slug }}">
                                                        </fieldset>
                                                    </div>
                                                </div>                                                 
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="url">{{__('Url (hiện tại)')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <a href="javascript:copyUrl();"><i class="glyphicon glyphicon-duplicate"></i></a>
                                                            <a href="{{ config('app.url').'/'.ADVERTGROUP_TAXONOMY.'/'.$adgroup->adgroup_url }}" target="_blank" id="url" name="url">{{ $adgroup->adgroup_url }}</a>
                                                        </fieldset>
                                                    </div>
                                                </div>                                                                            
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="parent">{{__('Parent')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <select class="form-control select2" name="parent">
                                                                <option value="">{{__('Parent')}}</option>
                                                                @include(ADVERT_GROUP_PARENT, ['parents' => $parents, 'parentId' => $parentId, 'sub' => ADVERT_GROUP_SUB, 'node' => $node, 'separate' => SEPARATE, 'verticalBar' => VERTICAL_BAR])
                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="status">{{__('Bật')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="status" value="activated" @if($adgroup->adgroup_status == 'activated') checked @endif>
                                                                <label class="form-check-label" >{{__('Có')}}</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="status" value="inactive" @if($adgroup->adgroup_status == 'inactive') checked @endif>
                                                                <label class="form-check-label">{{__('Không')}}</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="editor_short">{{__('Mô tả')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <textarea id="editor_short" name="description" class="form-control" placeholder="Nhập mô tả">{!! $adgroup->adgroup_description !!}</textarea>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </form>
@endsection
