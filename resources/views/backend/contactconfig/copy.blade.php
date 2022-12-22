<?php
    $title = isset($data['title']) ? $data['title'] : '';
    $contactconfig = !empty($data['contactconfig']) ? $data['contactconfig'] : [];
    $adminName = $data['adminName'];
    $adminId = $data['adminId'];
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.contactconfig.contactconfig_copy'])
    <form method="POST" id="admin-form" action="{{app('UrlHelper')::admin('contactconfig', 'duplicate')}}" enctype="multipart/form-data">
        <input type="hidden" name="action_type">
        <input type="hidden" name="id" value="{{$contactconfig->contactconfig_id}}">
        @csrf
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row product-module">
                        <nav id="nav-tabs">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-vi-tab" data-toggle="tab" href="#nav-vi" role="tab" aria-controls="nav-vi" aria-selected="true">{{__('Thông tin (Tiếng Việt)')}}</a>
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
                                                            <label for="name">{{__('Tên')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="name" class="form-control" placeholder="Tên cấu hình" value="{{ $contactconfig->contactconfig_name }}" required="">
                                                        </fieldset>
                                                    </div>
                                                </div>                                                
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="phoneNumbers">{{__('Điện thoại')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="phoneNumbers" class="form-control" placeholder="Điện thoại" value="{{ $contactconfig->contactconfig_phone_numbers }}">
                                                            <span class="span-guide-text-green">{{__('Ngăn cách bởi dấu chấm phẩy [;]')}}</span>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="emails">{{__('Emails')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="emails" class="form-control" placeholder="Email" value="{{ $contactconfig->contactconfig_emails }}">
                                                            <span class="span-guide-text-green">{{__('Ngăn cách bởi dấu chấm phẩy [;]')}}</span>
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
                                                            <input type="text" name="zaloId" class="form-control" placeholder="Zalo Id" value="{{ $contactconfig->contactconfig_zalo_id }}">
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
                                                            <input type="text" name="facebookId" class="form-control" placeholder="Facebook Id" value="{{ $contactconfig->contactconfig_facebook_id }}">
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
                                                            <input type="text" name="address" class="form-control" placeholder="Địa chỉ liên hệ" value="{{ $contactconfig->contactconfig_address }}">
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
                                                            <textarea type="text" name="map" class="form-control" placeholder="Bản đồ">{{ $contactconfig->contactconfig_map }}</textarea>
                                                            <span class="span-guide-text-green">{{__('Sử dụng iframe từ Google map')}}</span>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="subject">{{__('Tiêu đề')}} </label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="subject" class="form-control" placeholder="Tiêu đề" value="{{ $contactconfig->contactconfig_subject }}" required="">
                                                        </fieldset>
                                                    </div>
                                                </div>                                                                                        
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="content">{{__('Nội dung')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <textarea id="editor_short" name="content" class="form-control" placeholder="Nhập nội dung">{!! $contactconfig->contactconfig_content !!}</textarea>
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
                                                                <input class="form-check-input" type="radio" name="status" value="activated" @if($contactconfig->contactconfig_status == 'activated') checked @endif>
                                                                <label class="form-check-label" >{{__('Có')}}</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="status" value="inactive" @if($contactconfig->contactconfig_status == 'inactive') checked @endif>
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
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </form>
@endsection
