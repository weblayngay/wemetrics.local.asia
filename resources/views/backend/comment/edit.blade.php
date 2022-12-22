<?php
    $comment = !empty($data['comment']) ? $data['comment'] : null;
    $title = !empty($data['title']) ? $data['title'] : '';
    $adminName = $data['adminName'];
    $adminId = $data['adminId'];
    
    if($comment->comment_type == 'product')
    {
        $commentType = 'Sản phẩm';
    }
    else
    {
        $commentType = 'Bài viết';
    }
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.comment.comment_edit'])
    <form method="POST" id="admin-form" action="{{app('UrlHelper')::admin('comment', 'update')}}" enctype="multipart/form-data">
        <input type="hidden" name="action_type">
        <input type="hidden" name="id" value="{{$comment->comment_id}}">
        @csrf
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
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
                                                    <label for="level">{{__('Cấp bình luận')}} <span class="red">*</span></label>
                                                </fieldset>
                                                <hr>
                                            </div>
                                            <div class="col-md-3">
                                                <fieldset class="form-group">
                                                    <input type="text" name="level" class="form-control" value="{{ $comment->comment_level }}" readonly="">
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <fieldset class="form-group">
                                                    <label for="commentType">{{__('Loại bình luận')}} <span class="red">*</span></label>
                                                </fieldset>
                                                <hr>
                                            </div>
                                            <div class="col-md-3">
                                                <fieldset class="form-group">
                                                    <input type="text" name="commentType" class="form-control" value="{{ $commentType }}" readonly="">
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <fieldset class="form-group">
                                                    <label for="status">{{__('Cho phép')}}</label>
                                                </fieldset>
                                                <hr>
                                            </div>
                                            <div class="col-md-6">
                                                <fieldset class="form-group">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="status" value="approved" @if($comment->comment_status == 'approved') checked @endif>
                                                        <label class="form-check-label" >{{__('Có')}}</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="status" value="unapproved" @if($comment->comment_status == 'unapproved') checked @endif>
                                                        <label class="form-check-label">{{__('Không')}}</label>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <fieldset class="form-group">
                                                    <label for="rating">{{__('Đánh giá')}}</label>
                                                </fieldset>
                                                <hr>
                                            </div>
                                            <div class="col-md-6">
                                                <fieldset class="form-group">
                                                    <select class="form-control select2" name="rating">
                                                        <option value="">{{__('Đánh giá')}}</option>
                                                        <option value="1" @if($comment->comment_rating == 1) selected @endif>{{__('1 sao')}}</option>
                                                        <option value="2" @if($comment->comment_rating == 2) selected @endif>{{__('2 sao')}}</option>
                                                        <option value="3" @if($comment->comment_rating == 3) selected @endif>{{__('3 sao')}}</option>
                                                        <option value="4" @if($comment->comment_rating == 4) selected @endif>{{__('4 sao')}}</option>
                                                        <option value="5" @if($comment->comment_rating == 5) selected @endif>{{__('5 sao')}}</option>
                                                    </select>
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
                                                    <textarea name="content" class="form-control" placeholder="">{!! $comment->comment_content !!}</textarea>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </form>
@endsection
