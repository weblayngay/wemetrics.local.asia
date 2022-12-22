<?php
use App\Helpers\TranslateHelper;
use App\Helpers\DateHelper;
/**
 * @var \App\Helpers\UrlHelper $urlHelper
 */
$urlHelper = app('UrlHelper');
$posts = !empty($data['posts']) ? $data['posts'] : [];
$title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.post.post_list'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <form action="#" method="post" id="admin-form">
                                @csrf
                                <table id="datable_1" class="table table-hover w-100 display pb-30 js-main-table">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" class="checkAll" name="checkAll" value=""></th>
                                        <th>{{__('#')}}</th>
                                        <th>{{__('Ảnh')}}</th>
                                        <th>{{__('Tên bài viết')}}</th>
                                        <th>{{__('Nhóm')}}</th>
                                        <th>{{__('Ngày tạo')}}</th>
                                        <th>{{__('Bật')}}</th>
                                        <th>{{__('Id')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($posts) && count($posts) > 0)
                                        @foreach($posts as $key => $item)
                                            <tr>
                                                <th><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->post_id }}"></th>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    @if(!empty($item->urlAvatar))
                                                        <img class="lazy" src="{{ asset($item->urlAvatar) }}">
                                                    @endif
                                                </td>
                                                <td><a href="@php echo $urlHelper::admin('post', 'edit')."?id=$item->post_id" @endphp">{{ $item->post_name }}</a></td>
                                                <td>{{ $item->groupName }}</td>
                                                <td>{{ DateHelper::getDate('d/m/Y', $item->post_created_at) }}</td>
                                                <td>{{ TranslateHelper::getTranslate('vi', 'status', $item->post_status) }}</td>
                                                <td><a href="@php echo $urlHelper::admin('post', 'edit')."?id=$item->post_id" @endphp">{{ $item->post_id }}</a></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
