<?php
$title = isset($data['title']) ? $data['title'] : '';
$config = @$data['config'];
?>
@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.config.detail'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <form action="#" method="post" id="admin-form">
                                <input type="hidden" name="id" value="{{$config->conf_id ?? intval(old('id'))}}">
                                <input type="hidden" name="action_type" value="save">
                                @csrf
                                <div class="form-group row">
                                    <label for="conf_name" class="col-sm-2 col-form-label">Tên<span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input name="conf_name" class="form-control" id="conf_name" value="{{$config->conf_name ?? old('conf_name')}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="conf_key" class="col-sm-2 col-form-label">Key<span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input @if(@$config->conf_id > 0) disabled @endif name="conf_key" class="form-control" id="conf_key" value="{{$config->conf_key ?? old('conf_key')}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="conf_value" class="col-sm-2 col-form-label">Giá trị<span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="conf_value" id="conf_value">{{$config->conf_value ?? old('conf_value')}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="conf_description" class="col-sm-2 col-form-label">Mô tả</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="conf_description" id="conf_description">{{$config->conf_description ?? old('conf_description')}}</textarea>
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
