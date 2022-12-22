<?php
use App\Helpers\TranslateHelper;
use App\Helpers\DateHelper;
/**
 * @var \App\Helpers\UrlHelper $urlHelper
 */
$urlHelper = app('UrlHelper');
$groups = !empty($data['groups']) ? $data['groups'] : [];
$title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.postgroup.postgroup_list'])
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
                                        <th>{{__('Tên nhóm bài viết')}}</th>
                                        <th>{{__('Parent')}}</th>
                                        <th>{{__('Child items')}}</th>
                                        <th>{{__('Ngày tạo')}}</th>
                                        <th>{{__('Bật')}}</th>
                                        <th>{{__('Id')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($groups) && count($groups) > 0)
                                        @foreach($groups as $key => $item)
                                            <tr>
                                                <th><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->postgroup_id }}"></th>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    @if(!empty($item->urlAvatar))
                                                        <img class="lazy" data-src="{{ asset($item->urlAvatar) }}">
                                                    @endif
                                                </td>
                                                <td><a href="@php echo $urlHelper::admin('postgroup', 'edit')."?id=$item->postgroup_id" @endphp">{{ $item->postgroup_name }}</a></td>
                                                <td>{{ $item->parent}}</td>
                                                <td>
                                                    <a href="{{app('UrlHelper')->admin('postgroup', 'drill?parentId='.$item->postgroup_id)}}">
                                                        <image src="{{ asset('public/admin/dist/icons/go_items.png') }}"></image> <strong>{{ '[' . $item->childItems->count() . ']' }}</strong>
                                                    </a>
                                                </td>
                                                <td>{{ DateHelper::getDate('d/m/Y', $item->postgroup_created_at) }}</td>
                                                <td>{{ TranslateHelper::getTranslate('vi', 'status', $item->postgroup_status) }}</td>
                                                <td><a href="@php echo $urlHelper::admin('postgroup', 'edit')."?id=$item->postgroup_id" @endphp">{{ $item->postgroup_id }}</a></td>
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
