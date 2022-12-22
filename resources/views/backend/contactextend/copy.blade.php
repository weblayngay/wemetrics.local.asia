<?php
    $title = isset($data['title']) ? $data['title'] : '';
    $contactextend = !empty($data['contactextend']) ? $data['contactextend'] : [];
    $avatarId = !empty($data['avatarId']) ? $data['avatarId'] : null;
    $urlAvatar = !empty($data['urlAvatar']) ? $data['urlAvatar'] : '';
    $adminName = $data['adminName'];
    $adminId = $data['adminId'];
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.contactextend.contactextend_copy'])
    <form method="POST" id="admin-form" action="{{app('UrlHelper')::admin('contactextend', 'duplicate')}}" enctype="multipart/form-data">
        <input type="hidden" name="action_type">
        <input type="hidden" name="id" value="{{$contactextend->contactextend_id}}">
        <input type="hidden" name="avatarId" value="{{ $avatarId }}">
        @csrf
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row product-module">
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
                                                            <label for="name">{{__('Tên liên hệ')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="name" class="form-control" placeholder="Tên liên hệ" value="{{ $contactextend->contactextend_name }}" required="">
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="gender">{{__('Giới tính')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="gender" value="activated" @if($contactextend->contactextend_gender == 'male') checked @endif>
                                                                <label class="form-check-label" >{{__('Nam')}}</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="gender" value="inactive" @if($contactextend->contactextend_gender == 'female') checked @endif>
                                                                <label class="form-check-label">{{__('Nữ')}}</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>                                                                                                
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="phoneNumber">{{__('Điện thoại')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="phoneNumber" class="form-control" placeholder="Điện thoại" value="{{ $contactextend->contactextend_phone_number }}">
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="email">{{__('Email')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="email" class="form-control" placeholder="Email" value="{{ $contactextend->contactextend_email }}">
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="zaloId">{{__('Zalo Id')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="zaloId" class="form-control" placeholder="Zalo Id" value="{{ $contactextend->contactextend_zalo_id }}">
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="facebookId">{{__('Facebook Id')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="facebookId" class="form-control" placeholder="Facebook Id" value="{{ $contactextend->contactextend_facebook_id }}">
                                                        </fieldset>
                                                    </div>
                                                </div>                                                 
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="address">{{__('Địa chỉ')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="address" class="form-control" placeholder="Địa chỉ liên hệ" value="{{ $contactextend->contactextend_address }}">
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="map">{{__('Bản đồ')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <textarea type="text" name="map" class="form-control" placeholder="Bản đồ">{{ $contactextend->contactextend_map }}</textarea>
                                                            <span class="span-guide-text-green">{{__('Sử dụng iframe từ Google map')}}</span>
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
                                                                <input class="form-check-input" type="radio" name="status" value="activated" @if($contactextend->contactextend_status == 'activated') checked @endif>
                                                                <label class="form-check-label" >{{__('Có')}}</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="status" value="inactive" @if($contactextend->contactextend_status == 'inactive') checked @endif>
                                                                <label class="form-check-label">{{__('Không')}}</label>
                                                            </div>
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
                                        <input type="file" name="imageAvatar" class="dropify" @if(!empty($urlAvatar)) data-default-file="{{ asset($urlAvatar) }}" @endif/>
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
