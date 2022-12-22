<?php
    $post = !empty($data['post']) ? $data['post'] : null;
    $posts = !empty($data['posts']) ? $data['posts'] : null;
    $groups = !empty($data['groups']) ? $data['groups'] : null;
    $arrayRelated = !empty($data['arrayRelated']) ? $data['arrayRelated'] : [];
    $title = !empty($data['title']) ? $data['title'] : '';
    $urlAvatar = !empty($data['urlAvatar']) ? $data['urlAvatar'] : '';
    $avatarId = !empty($data['avatarId']) ? $data['avatarId'] : null;
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
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.post.post_copy'])
    <form method="POST" id="admin-form" action="{{app('UrlHelper')::admin('post', 'duplicate')}}" enctype="multipart/form-data">
        <input type="hidden" name="action_type">
        <input type="hidden" name="avatarId" value="{{ $avatarId }}">
        <input type="hidden" name="id" value="{{$post->post_id}}">
        @csrf
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <nav id="nav-tabs">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-vi-tab" data-toggle="tab" href="#nav-vi" role="tab" aria-controls="nav-vi" aria-selected="true">{{__('Thông tin (Tiếng Việt)')}}</a>
{{--                                <a class="nav-item nav-link" id="nav-en-tab" data-toggle="tab" href="#nav-en" role="tab" aria-controls="nav-en" aria-selected="false">Thông tin (Tiếng Anh)</a>--}}
                                <a class="nav-item nav-link" id="nav-upload-tab" data-toggle="tab" href="#nav-upload" role="tab" aria-controls="nav-upload" aria-selected="false">{{__('Upload ảnh')}}</a>
                                <a class="nav-item nav-link" id="nav-related-tab" data-toggle="tab" href="#nav-related" role="tab" aria-controls="nav-related" aria-selected="false">{{__('Bài viết liên quan')}}</a>
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
                                                            <label for="name">{{__('Tên Bài viết')}} <span class="red">*</span></label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="name" class="form-control" placeholder="Tên bài viết" value="{{ $post->post_name }}">
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="group">{{__('group')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <select class="form-control select2" name="group">
                                                                <option value="">{{__('Chọn nhóm bài viết')}}</option>
                                                                @include(POST_PARENT, ['parents' => $parents, 'parentId' => $parentId, 'sub' => POST_SUB, 'node' => $node, 'separate' => SEPARATE, 'verticalBar' => VERTICAL_BAR])
                                                            </select>
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
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="status" value="activated" @if($post->post_status == 'activated') checked @endif>
                                                                <label class="form-check-label" >{{__('Có')}}</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="status" value="inactive" @if($post->post_status == 'inactive') checked @endif>
                                                                <label class="form-check-label">{{__('Không')}}</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="isHot">{{__('Bài viết nổi bật')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="isHot" value="yes" @if($post->post_is_hot == 'yes') checked @endif>
                                                                <label class="form-check-label">{{__('Có')}}</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="isHot" value="no" @if($post->post_is_hot == 'no') checked @endif>
                                                                <label class="form-check-label">{{__('Không')}}</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="isNew">{{__('Bài viết mới')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="isNew" value="yes" @if($post->post_is_new == 'yes') checked @endif>
                                                                <label class="form-check-label">{{__('Có')}}</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="isNew" value="no" @if($post->post_is_new == 'no') checked @endif>
                                                                <label class="form-check-label">{{__('Không')}}</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="isView">{{__('Bài viết xem nhiều')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="isView" value="yes" @if($post->post_is_view == 'yes') checked @endif>
                                                                <label class="form-check-label">{{__('Có')}}</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="isView" value="no" @if($post->post_is_view == 'no') checked @endif>
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
                                                            <textarea id="editor_short" name="description" class="form-control" placeholder="Nhập mô tả">{!! $post->post_description !!}</textarea>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="editor">{{__('Nội dung')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <textarea id="editor" name="content" class="form-control" placeholder="Nhập nội dung">{!! $post->post_content !!}</textarea>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="metaTitle">{{__('Meta Title')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="metaTitle" class="form-control form-control-sm" placeholder="" value="{{ $post->post_meta_title }}">
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="metaKeywords">{{__('Meta Kewords')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="metaKeywords" class="form-control form-control-sm" placeholder="" value="{{ $post->post_meta_keywords }}">
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <fieldset class="form-group">
                                                            <label for="metaDescription">{{__('Meta Description')}}</label>
                                                        </fieldset>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <input type="text" name="metaDescription" class="form-control form-control-sm" placeholder="" value="{{ $post->post_meta_description }}">
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
{{--                            <div class="tab-pane fade" id="nav-en" role="tabpanel" aria-labelledby="nav-en-tab">--}}
{{--                                <div class="col-xl-12">--}}
{{--                                    <section class="hk-sec-wrapper">--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col-sm">--}}
{{--                                                <div class="table-wrap">--}}
{{--                                                    <div class="table-responsive">--}}
{{--                                                        <table class="table mb-0">--}}
{{--                                                            <tbody>--}}
{{--                                                            <tr>--}}
{{--                                                                <th scope="row">Tên Bài viết</th>--}}
{{--                                                                <td><input type="text" name="nameEn" class="form-control form-control-sm" placeholder="Tên Bài viết" value="{{ $post->post_name_en }}"></td>--}}
{{--                                                            </tr>--}}
{{--                                                            <tr>--}}
{{--                                                                <th scope="row">Mô tả</th>--}}
{{--                                                                <td><textarea id="editor_short_en" name="descriptionEn" class="form-control" placeholder="Nhập mô tả">{!! $post->post_description_en !!}</textarea></td>--}}
{{--                                                            </tr>--}}
{{--                                                            <tr>--}}
{{--                                                                <th scope="row">Nội dung</th>--}}
{{--                                                                <td><textarea id="editor_en" name="contentEn" class="form-control" placeholder="Nhập nội dung">{!! $post->post_content_en !!}</textarea></td>--}}
{{--                                                            </tr>--}}
{{--                                                            <tr>--}}
{{--                                                                <th scope="row">Meta Title</th>--}}
{{--                                                                <td><input type="text" name="metaTitleEn" class="form-control form-control-sm" placeholder="" value="{{ $post->post_meta_title_en }}"></td>--}}
{{--                                                            </tr>--}}
{{--                                                            <tr>--}}
{{--                                                                <th scope="row">Meta Keywords</th>--}}
{{--                                                                <td><input type="text" name="metaKeywordsEn" class="form-control form-control-sm" placeholder="" value="{{ $post->post_meta_keywords_en }}"></td>--}}
{{--                                                            </tr>--}}
{{--                                                            <tr>--}}
{{--                                                                <th scope="row">Meta Description</th>--}}
{{--                                                                <td><input type="text" name="metaDescriptionEn" class="form-control form-control-sm" placeholder="" value="{{ $post->post_meta_description_en }}"></td>--}}
{{--                                                            </tr>--}}
{{--                                                            </tbody>--}}
{{--                                                        </table>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </section>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="tab-pane fade" id="nav-upload" role="tabpanel" aria-labelledby="nav-upload-tab">
                                <div class="col-xl-12">
                                    <section class="hk-sec-wrapper">
                                        <h5 class="hk-sec-title">{{__('Ảnh đại diện')}}</h5>
                                        <input type="file" name="imageAvatar" class="dropify" @if(!empty($urlAvatar)) data-default-file="{{ asset($urlAvatar) }}" @endif/>
                                    </section>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-related" role="tabpanel" aria-labelledby="nav-related-tab">
                                <div class="col-xl-12">
                                    <select class="select2 select2-multiple" name="related[]" multiple="multiple" data-placeholder="Choose">
                                        @if($posts->count() > 0)
                                            @foreach($posts as $key => $itemPost)
                                                @php
                                                    $itemId = $itemPost->post_id;
                                                @endphp
                                                <option value="{{ $itemId }}" @if(in_array($itemId,$arrayRelated )) selected @endif>{{ $itemPost->post_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </form>
@endsection
