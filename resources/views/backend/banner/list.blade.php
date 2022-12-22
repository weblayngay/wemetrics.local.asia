<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\TranslateHelper;
    use App\Helpers\DateHelper;

    $urlHelper = app('UrlHelper');
    $banners = !empty($data['banners']) ? $data['banners'] : [];
    $title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.banner.banner_list'])
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
                                        <th>{{__('Tên banner')}}</th>
                                        <th>{{__('Nhóm')}}</th>
                                        <th>{{__('Vị trí')}}</th>
                                        <th>{{__('Ngày tạo')}}</th>
                                        <th>{{__('Bật')}}</th>
                                        <th>{{__('Id')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($banners) && count($banners) > 0)
                                        @foreach($banners as $key => $item)
                                            <tr>
                                                <th><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->banner_id }}"></th>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    @if(!empty($item->urlAvatar))
                                                        <img width="70px" class="js-lazy-loading" data-src="{{asset($item->urlAvatar)}}">
                                                    @endif
                                                </td>
                                                <td><a href="@php echo $urlHelper::admin('banner', 'edit')."?id=$item->banner_id" @endphp">{{ $item->banner_name }}</a></td>
                                                @if(!empty($item->group))
                                                    <td>{{ $item->group->bannergroup_name }}</td>
                                                @else
                                                    <td></td>
                                                @endif
                                                <td><input style="width: 40px;" type="number" name="sort[]" value="{{ $item->banner_sorted }}"><span style="display: none">{{ $item->banner_sorted }}</span></td>
                                                <td>{{ DateHelper::getDate('d/m/Y', $item->banner_created_at) }}</td>
                                                <td>{{ TranslateHelper::getTranslate('vi', 'status', $item->banner_status) }}</td>
                                                <td>{{ $item->banner_id }}</td>
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
