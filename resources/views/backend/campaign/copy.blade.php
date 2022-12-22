<?php
    use App\Helpers\DateHelper;
    $campaign = !empty($data['campaign']) ? $data['campaign'] : null;
    $title = !empty($data['title']) ? $data['title'] : '';
    $urlAvatar = !empty($data['urlAvatar']) ? $data['urlAvatar'] : '';
    $groups = !empty($data['groups']) ? $data['groups'] : null;
    $types = !empty($data['types']) ? $data['types'] : null;
    $avatarId = !empty($data['avatarId']) ? $data['avatarId'] : null;
    $beganAt = DateHelper::getDate('d/m/Y', $campaign->campaign_began_at);
    $expiredAt = DateHelper::getDate('d/m/Y', $campaign->campaign_expired_at);
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
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.campaign.campaign_copy'])
    <form method="POST" id="admin-form" action="{{app('UrlHelper')::admin('campaign', 'duplicate')}}" enctype="multipart/form-data">
        <input type="hidden" name="action_type">
        <input type="hidden" name="avatarId" value="{{ $avatarId }}">
        <input type="hidden" name="id" value="{{$campaign->campaign_id}}">
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
                                                            <label for="name">{{__('Tên chiến dịch')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="name" class="form-control" placeholder="Tên chiến dịch" value="{{ $campaign->campaign_name }}" required="">
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
                                                                <input class="form-check-input" type="radio" name="status" value="activated" @if($campaign->campaign_status == 'activated') checked @endif>
                                                                <label class="form-check-label" >{{__('Có')}}</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="status" value="inactive" @if($campaign->campaign_status == 'inactive') checked @endif>
                                                                <label class="form-check-label">{{__('Không')}}</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="isUsed">{{__('Đã sử dụng')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="isUsed" value="yes" @if($campaign->campaign_is_used == 'yes') checked @endif>
                                                                <label class="form-check-label" >{{__('Đã sử dụng')}}</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="isUsed" value="no" @if($campaign->campaign_is_used == 'no') checked @endif>
                                                                <label class="form-check-label">{{__('Chưa sử dụng')}}</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="type">{{__('Loại chiến dịch')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <select class="form-control select2" name="type">
                                                                <option value="">{{__('Chọn loại chiến dịch')}}</option>
                                                                @foreach($types as $key => $item)
                                                                    <option value="{{($item->campaigntype_id)}}" {{ ($item->campaigntype_id == $campaign->campaign_type) ? 'selected' : '' }}>
                                                                        {{($item->campaigntype_name)}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                </div>                                                
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="group">{{__('Nhóm chiến dịch')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <select class="form-control select2" name="group">
                                                                <option value="">{{__('Chọn nhóm chiến dịch')}}</option>
                                                                @include(CAMPAIGN_PARENT, ['parents' => $parents, 'parentId' => $parentId, 'sub' => CAMPAIGN_SUB, 'node' => $node, 'separate' => SEPARATE, 'verticalBar' => VERTICAL_BAR])
                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="beganAt">{{__('Ngày bắt đầu')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <fieldset class="form-group">
                                                            <input class="form-control time-statistic" type="text" name="beganAt" value="{{ $beganAt }}" />
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="expiredAt">{{__('Ngày hết hạn')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <fieldset class="form-group">
                                                            <input class="form-control time-statistic" type="text" name="expiredAt" value="{{ $expiredAt }}" />
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
                                                            <textarea id="editor_short" name="description" class="form-control" placeholder="Nhập mô tả">{!! $campaign->campaign_description !!}</textarea>
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