<?php
    $vendor = !empty($data['vendor']) ? $data['vendor'] : null;
    $vendors = !empty($data['vendors']) ? $data['vendors'] : null;
    $title = !empty($data['title']) ? $data['title'] : '';
    $urlAvatar = !empty($data['urlAvatar']) ? $data['urlAvatar'] : '';
    $avatarId = !empty($data['avatarId']) ? $data['avatarId'] : null;
    $adminName = $data['adminName'];
    $adminId = $data['adminId'];
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.ctokenvendor.vendor_copy'])
    <form method="POST" id="admin-form" action="{{app('UrlHelper')::admin('post', 'duplicate')}}" enctype="multipart/form-data">
        <input type="hidden" name="action_type">
        <input type="hidden" name="avatarId" value="{{ $avatarId }}">
        <input type="hidden" name="id" value="{{$vendor->vendor_id}}">
        @csrf
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <nav id="nav-tabs">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-vi-tab" data-toggle="tab" href="#nav-vi" role="tab" aria-controls="nav-vi" aria-selected="true">{{__('Thông tin (Tiếng Việt)')}}</a>
                                <a class="nav-item nav-link" id="nav-upload-tab" data-toggle="tab" href="#nav-upload" role="tab" aria-controls="nav-upload" aria-selected="false">{{__('Upload ảnh')}}</a>
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
                                                            <label for="createdBy">{{__('Được sao chép bởi')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="createdName" class="form-control" value="{{ $adminName }}" readonly="">
                                                            <input type="hidden" name="createdBy" class="form-control" value="{{ $adminId }}" readonly="">
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="name">{{__('Tên nhà cung cấp kết nối')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="name" class="form-control" placeholder="Tên nhà cung cấp kết nối" value="{{ $vendor->vendor_name }}">
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
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="status" value="activated" @if($vendor->vendor_status == 'activated') checked @endif>
                                                                <label class="form-check-label" >{{__('Có')}}</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="status" value="inactive" @if($vendor->vendor_status == 'inactive') checked @endif>
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
                                                            <textarea id="editor_short" name="description" class="form-control" placeholder="Nhập mô tả">{!! $vendor->vendor_description !!}</textarea>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-upload" role="tabpanel" aria-labelledby="nav-upload-tab">
                                <div class="col-xl-12">
                                    <section class="hk-sec-wrapper">
                                        <h5 class="hk-sec-title">{{__('Ảnh đại diện')}}</h5>
                                        <input type="file" name="imageAvatar" class="dropify" data-max-file-size="5M" data-allowed-file-extensions="pdf png psd webp jpg jpeg" @if(!empty($urlAvatar)) data-default-file="{{ asset($urlAvatar) }}" @endif/>
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
