<?php
    use App\Helpers\DateHelper;
    $clienttrackingreferer = !empty($data['clienttrackingreferer']) ? $data['clienttrackingreferer'] : null;
    $title = !empty($data['title']) ? $data['title'] : '';
    $sources = isset($data['sources']) ? $data['sources'] : null;
    $mediums = isset($data['mediums']) ? $data['mediums'] : null;
    $urlAvatar = !empty($data['urlAvatar']) ? $data['urlAvatar'] : '';
    $adminName = $data['adminName'];
    $adminId = $data['adminId'];
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.clienttrackingreferer.clienttrackingreferer_edit'])
    <form method="POST" id="admin-form" action="{{app('UrlHelper')::admin('clienttrackingreferer', 'update')}}" enctype="multipart/form-data">
        <input type="hidden" name="action_type">
        <input type="hidden" name="id" value="{{$clienttrackingreferer->id}}">
        <input type="hidden" name="task" value="update">
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
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="referral">{{__('Tên nguồn truy cập')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="referral" class="form-control" placeholder="Tên nguồn truy cập" value="{{ $clienttrackingreferer->referral }}" required="">
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="type">{{__('Loại')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="type" value="external" @if($clienttrackingreferer->type == 'external') checked @endif>
                                                                <label class="form-check-label" >{{__('Bên ngoài')}}</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="type" value="internal" @if($clienttrackingreferer->type == 'internal') checked @endif>
                                                                <label class="form-check-label">{{__('Nội bộ')}}</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="category">{{__('Nhóm')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <select class="form-control select2" name="category" id="category">
                                                                <option value="">{{__('Nhóm')}}</option>
                                                                @foreach($mediums as $key => $item)
                                                                    <option value="{{($item->name)}}" {{ ($item->name == $clienttrackingreferer->category) ? 'selected' : '' }}>
                                                                        {{($item->name)}}
                                                                    </option>
                                                                @endforeach                                                                
                                                            </select>
                                                            <span class="small">Marketing medium (e.g. <span><strong>cpc</strong></span>, <span><strong>banner</strong></span>, <span><strong>email</strong></span>)</span>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="provider">{{__('Nhà cung cấp')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <select class="form-control select2" name="provider" id="provider">
                                                                <option value="">{{__('Nhà cung cấp')}}</option>
                                                                @foreach($sources as $key => $item)
                                                                    <option value="{{($item->name)}}" {{ ($item->name == $clienttrackingreferer->provider) ? 'selected' : '' }}>
                                                                        {{($item->name)}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <span class="small">The referrer (e.g. <span><strong>google</strong></span>, <span><strong>newsletter</strong></span>)</span>
                                                        </fieldset>
                                                    </div>
                                                </div>  
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="icon">{{__('Biểu tượng')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="icon" class="form-control" placeholder="Biểu tượng" value="{{ $clienttrackingreferer->icon }}" required="">
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
                                                                <input class="form-check-input" type="radio" name="status" value="activated" @if($clienttrackingreferer->status == 'activated') checked @endif>
                                                                <label class="form-check-label" >{{__('Có')}}</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="status" value="inactive" @if($clienttrackingreferer->status == 'inactive') checked @endif>
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