<?php
$title = !empty($data['title']) ? $data['title'] : '';
$nutritions = !empty($data['nutritions']) ? $data['nutritions'] : null;
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.productnutritions.productnutritions_edit'])
    <form method="POST" id="admin-form" action="{{app('UrlHelper')::admin('productnutritions', 'update')}}" enctype="multipart/form-data">
        <input type="hidden" name="action_type">
        <input type="hidden" name="id" value="{{$nutritions->pnutri_id}}">
        <input type="hidden" name="task" value="update">
        @csrf
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <nav id="nav-tabs">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-vi-tab" data-toggle="tab" href="#nav-vi" role="tab" aria-controls="nav-vi" aria-selected="true">Thông tin</a>
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
                                                                <th scope="row">Tên<span class="red">*</span></th>
                                                                <td><input type="text" name="name" class="form-control form-control-sm" value="{{ $nutritions->pnutri_name }}" placeholder="Tên"></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Bật</th>
                                                                <td>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="status" value="activated" @if($nutritions->pnutri_status == 'activated') checked @endif>
                                                                        <label class="form-check-label" >Có</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="status" value="inactive" @if($nutritions->pnutri_status == 'inactive') checked @endif>
                                                                        <label class="form-check-label">Không</label>
                                                                    </div>
                                                                </td>
                                                            </tr>
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
