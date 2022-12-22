<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\TranslateHelper;
    use App\Helpers\DateHelper;
    $menus = !empty($data['items']) ? $data['items'] : [];
    $title = isset($data['title']) ? $data['title'] : '';
    $group = $data['group'];
    $parentMenuArr = [];
    $childrenMenuArr = [];
    if (count($menus)) {
        foreach ($menus as $menu) {
            if ($menu->parent_id == 0 || $menu->parent_id == null) {
                $parentMenuArr[] = $menu;
            } else {
                $childrenMenuArr[] = $menu;
            }
        }
    }
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.menu.menu_list'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <form action="#" method="post" id="admin-form">
                                <input type="hidden" name="group" value="{{$group}}">
                                @csrf
                                <table id="datable_1" class="table table-hover w-100 display pb-30 js-main-table">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" class="checkAll" name="checkAll" value=""></th>
                                        <th>{{__('#')}}</th>
                                        <th>{{__('Tên menu')}}</th>
                                        <th>{{__('Tên group')}}</th>
                                        <th>{{__('Url')}}</th>
                                        <th>{{__('Thứ tự')}}</th>
                                        <th>{{__('Ngày tạo')}}</th>
                                        <th>{{__('Bật')}}</th>
                                        <th>{{__('Id')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($parentMenuArr) > 0)
                                        @foreach($parentMenuArr as $key => $parentMenu)
                                            <tr>
                                                <th><input type="checkbox" class="checkItem" name="cid[]" value="{{ $parentMenu['menu_id'] }}"></th>
                                                <td>{{ $key + 1 }}</td>
                                                <td><a href="{{app('UrlHelper')::admin('menu', 'edit', ['group' => $group, 'id' => $parentMenu['menu_id']])}}">{{ $parentMenu['menu_name'] }}</a></td>
                                                <td>{{ $parentMenu['group'] }}</td>
                                                <td>{{ $parentMenu['menu_url'] }}</td>
                                                <td>{{ $parentMenu['menu_sorted'] }}</td>
                                                <td>{{ DateHelper::getDate('d/m/Y', $parentMenu['menu_created_at']) }}</td>
                                                <td>{{ TranslateHelper::getTranslate('vi', 'status', $parentMenu['menu_status']) }}</td>
                                                <td>{{ $parentMenu['menu_id'] }}</td>
                                            </tr>
                                            @foreach($childrenMenuArr as $childrenMenu)
                                                @if($childrenMenu['parent_id'] == $parentMenu['menu_id'])
                                                    <tr>
                                                        <th><input type="checkbox" class="checkItem" name="cid[]" value="{{ $childrenMenu['menu_id'] }}"></th>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td><a href="{{app('UrlHelper')::admin('menu', 'edit', ['group' => $group, 'id' => $childrenMenu['menu_id']])}}">|--->{{ $childrenMenu['menu_name'] }}</a></td>
                                                        <td>{{ $childrenMenu['group'] }}</td>
                                                        <td>{{ $childrenMenu['menu_url'] }}</td>
                                                        <td>{{ $childrenMenu['menu_sorted'] }}</td>
                                                        <td>{{ DateHelper::getDate('d/m/Y', $childrenMenu['menu_created_at']) }}</td>
                                                        <td>{{ TranslateHelper::getTranslate('vi', 'status', $childrenMenu['menu_status']) }}</td>                                                        
                                                        <td>{{ $childrenMenu['menu_id'] }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
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
