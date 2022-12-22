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
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.bannergroup.bannergroup_list'])
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
                                        <th>{{__('Tên nhóm banner')}}</th>
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
                                                <th><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->bannergroup_id }}"></th>
                                                <td>{{ $key + 1 }}</td>
                                                <td><a href="@php echo $urlHelper::admin('bannergroup', 'edit')."?id=$item->bannergroup_id" @endphp">{{ $item->bannergroup_name }}</a></td>
                                                <td>{{ $item->parent}}</td>
                                                <td>
                                                    <a href="{{app('UrlHelper')->admin('bannergroup', 'drill?parentId='.$item->bannergroup_id)}}">
                                                        <image src="{{ asset('public/admin/dist/icons/go_items.png') }}"></image> <strong>{{ '[' . $item->childItems->count() . ']' }}</strong>
                                                    </a>
                                                </td>
                                                <td>{{ DateHelper::getDate('d/m/Y', $item->bannergroup_created_at) }}</td>
                                                <td>{{ TranslateHelper::getTranslate('vi', 'status', $item->bannergroup_status) }}</td>
                                                <td><a href="@php echo $urlHelper::admin('bannergroup', 'edit')."?id=$item->bannergroup_id" @endphp">{{ $item->bannergroup_id }}</a></td>
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
