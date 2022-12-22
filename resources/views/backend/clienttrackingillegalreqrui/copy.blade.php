<?php
    use App\Helpers\DateHelper;
    $clienttrackingillegalreqrui = !empty($data['clienttrackingillegalreqrui']) ? $data['clienttrackingillegalreqrui'] : null;
    $title = !empty($data['title']) ? $data['title'] : '';
    $urlAvatar = !empty($data['urlAvatar']) ? $data['urlAvatar'] : '';
    $avatarId = !empty($data['avatarId']) ? $data['avatarId'] : null;
    $adminName = $data['adminName'];
    $adminId = $data['adminId'];
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.clienttrackingillegalreqrui.clienttrackingillegalreqrui_copy'])
    <form method="POST" id="admin-form" action="{{app('UrlHelper')::admin('clienttrackingillegalreqrui', 'duplicate')}}" enctype="multipart/form-data">
        <input type="hidden" name="action_type">
        <input type="hidden" name="avatarId" value="{{ $avatarId }}">
        <input type="hidden" name="id" value="{{$clienttrackingillegalreqrui->id}}">
        @csrf
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
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
                                                            <label for="value">{{__('Từ khóa')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="value" class="form-control" placeholder="Từ khóa" value="{{ $clienttrackingillegalreqrui->value }}" required="">
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
                                                                <input class="form-check-input" type="radio" name="status" value="activated" @if($clienttrackingillegalreqrui->status == 'activated') checked @endif>
                                                                <label class="form-check-label" >{{__('Có')}}</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="status" value="inactive" @if($clienttrackingillegalreqrui->status == 'inactive') checked @endif>
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