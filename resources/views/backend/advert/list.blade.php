<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\TranslateHelper;
    use App\Helpers\DateHelper;

    $urlHelper = app('UrlHelper');
    $adverts = !empty($data['adverts']) ? $data['adverts'] : [];
    $title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.advert.advert_list'])
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
                                        <th>{{__('Tên quảng cáo')}}</th>
                                        <th>{{__('Nhóm')}}</th>
                                        <th>{{__('Thứ tự')}}</th>
                                        <th>{{__('Lượt xem')}}</th>
                                        <th>{{__('Ngày tạo')}}</th>
                                        <th>{{__('Bật')}}</th>
                                        <th>{{__('Id')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($adverts) && count($adverts) > 0)
                                        @foreach($adverts as $key => $item)
                                            <tr>
                                                <th><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->advert_id }}"></th>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    @if(!empty($item->urlAvatar))
                                                        <img width="70px" class="js-lazy-loading" data-src="{{ asset($item->urlAvatar) }}">
                                                    @endif
                                                </td>
                                                <td><a href="@php echo $urlHelper::admin('advert', 'edit')."?id=$item->advert_id" @endphp">{{ $item->advert_name }}</a></td>
                                                <td>{{ $item->group->adgroup_name }}</td>
                                                <td><input style="width: 40px;" type="number" name="sort[]" value="{{ $item->advert_sorted }}"><span style="display: none">{{ $item->advert_sorted }}</span></td>
                                                <td>{{ $item->advert_view}}</td>
                                                <td>{{ DateHelper::getDate('d/m/Y', $item->advert_created_at) }}</td>
                                                <td>{{ TranslateHelper::getTranslate('vi', 'status', $item->advert_status) }}</td>
                                                <td><a href="@php echo $urlHelper::admin('advert', 'edit')."?id=$item->advert_id" @endphp">{{ $item->advert_id }}</a></td>
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
