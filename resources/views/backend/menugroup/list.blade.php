<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\TranslateHelper;
    use App\Helpers\DateHelper;
    $menus = !empty($data['menus']) ? $data['menus'] : [];
    $urlHelper = app('UrlHelper');
    $title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.menugroup.menugroup_list'])
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
                                        <th>{{__('Tên nhóm menu')}}</th>
                                        <th>{{__('Mã')}}</th>
                                        <th>{{__('Menu Items')}}</th>
                                        <th>{{__('Ngày tạo')}}</th>
                                        <th>{{__('Bật')}}</th>
                                        <th>{{__('Id')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($menus) && count($menus) > 0)
                                        @foreach($menus as $key => $item)
                                            <tr>
                                                <th><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->menugroup_id }}"></th>
                                                <td>{{ $key + 1 }}</td>
                                                <td><a href="@php echo $urlHelper::admin('menugroup', 'edit')."?id=$item->menugroup_id" @endphp">{{ $item->menugroup_name }}</a></td>
                                                <td>{{ $item->menugroup_code}}</td>
                                                <td>
                                                    <a href="{{app('UrlHelper')->admin('menu', 'index?group='.$item->menugroup_id)}}">
                                                        <image src="{{ asset('public/admin/dist/icons/go_items.png') }}"></image>
                                                    </a>
                                                </td>
                                                <td>{{ DateHelper::getDate('d/m/Y', $item->menugroup_created_at) }}</td>
                                                <td>{{ TranslateHelper::getTranslate('vi', 'status', $item->menugroup_status) }}</td>
                                                <td><a href="@php echo $urlHelper::admin('menugroup', 'edit')."?id=$item->menugroup_id" @endphp">{{ $item->menugroup_id }}</a></td>
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
