<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\TranslateHelper;
    use App\Helpers\DateHelper;
    $urlHelper = app('UrlHelper');
    $contactextends = !empty($data['contactextends']) ? $data['contactextends'] : [];
    $title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.contactextend.contactextend_list'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <form action="#" method="post" id="admin-form">
                                @csrf
                                <table class="table table-hover w-100 display pb-30 js-main-table">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" class="checkAll" name="checkAll" value=""></th>
                                        <th>{{__('#')}}</th>
                                        <th>{{__('Ảnh')}}</th>
                                        <th>{{__('Tên')}}</th>
                                        <th>{{__('Điện thoại')}}</th>
                                        <th>{{__('Email')}}</th>
                                        <th>{{__('Vị trí')}}</th>
                                        <th>{{__('Ngày tạo')}}</th>
                                        <th>{{__('Bật')}}</th>
                                        <th>{{__('Id')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($contactextends) && count($contactextends) > 0)
                                        @foreach($contactextends as $key => $item)
                                            <tr>
                                                <th><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->contactextend_id }}"></th>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    @if(!empty($item->urlAvatar))
                                                        <img width="70px" class="js-lazy-loading" data-src="{{asset($item->urlAvatar)}}">
                                                    @endif
                                                </td>                                                
                                                <td><a href="{{app('UrlHelper')::admin('contactextend', 'edit', ['id' => $item->contactextend_id])}}">{{ $item->contactextend_name}}</a></td>
                                                <td>{{ $item->contactextend_phone_number}}</td>
                                                <td>{{ $item->contactextend_email}}</td>
                                                <td><input style="width: 40px;" type="number" name="sort[]" value="{{ $item->contactextend_sorted }}"><span style="display: none">{{ $item->contactextend_sorted }}</span></td>
                                                <td>{{ DateHelper::getDate('d/m/Y', $item->contactextend_created_at) }}</td>
                                                <td>{{ TranslateHelper::getTranslate('vi', 'status', $item->contactextend_status) }}</td>
                                                <td><a href="@php echo $urlHelper::admin('contactextend', 'edit')."?id=$item->contactextend_id" @endphp">{{ $item->contactextend_id }}</a></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                {{ $contactextends->links('backend.elements.pagination') }}
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
