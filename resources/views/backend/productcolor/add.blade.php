<?php
$title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.productcolor.productcolor_add'])
    <form method="POST" id="admin-form" action="{{app('UrlHelper')::admin('productcolor', 'store')}}" enctype="multipart/form-data">
        <input type="hidden" name="action_type">
        @csrf
        <input type="hidden" name="typeSubmit" value="0">
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
                                            <div class="col-sm">
                                                <div class="table-wrap">
                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">Mô tả ngắn<span class="red">*</span></th>
                                                                    <td><input type="text" name="code" class="form-control form-control-sm" placeholder="Mô tả"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Code<span class="red">*</span></th>
                                                                    <td><input type="color" name="hex" class="form-control form-control-sm" placeholder=""></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Bật</th>
                                                                    <td>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio" name="status" value="activated" checked="">
                                                                            <label class="form-check-label" >Có</label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio" name="status" value="inactive">
                                                                            <label class="form-check-label">Không</label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            <tr>
                                                            </tbody>
                                                        </table>
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
