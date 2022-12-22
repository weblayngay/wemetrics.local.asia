<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\TranslateHelper;
    use App\Helpers\DateHelper;
    $urlHelper = app('UrlHelper');
    $contacts = !empty($data['contacts']) ? $data['contacts'] : [];
    $title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.contact.contact_list'])
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
                                        <th>{{__('Tiêu đề')}}</th>
                                        <th>{{__('Người liên hệ')}}</th>
                                        <th>{{__('Số điện thoại')}}</th>
                                        <th>{{__('Email')}}</th>
                                        <th>{{__('Ngày tạo')}}</th>
                                        <th>{{__('Bật')}}</th>
                                        <th>{{__('Id')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($contacts) && count($contacts) > 0)
                                        @foreach($contacts as $key => $item)
                                            <tr>
                                                <th><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->contact_id }}"></th>
                                                <td>{{ $key + 1 }}</td>
                                                <td><a href="{{app('UrlHelper')::admin('contact', 'edit', ['id' => $item->contact_id])}}">{{ $item->contact_subject}}</a></td>
                                                <td>{{ $item->contact_name }}</td>
                                                <td>{{ $item->contact_phone_number}}</td>
                                                <td>{{ $item->contact_email}}</td>
                                                <td>{{ DateHelper::getDate('d/m/Y', $item->contact_created_at) }}</td>
                                                <td>{{ TranslateHelper::getTranslate('vi', 'status', $item->contact_status) }}</td>
                                                <td><a href="@php echo $urlHelper::admin('contact', 'edit')."?id=$item->contact_id" @endphp">{{ $item->contact_id }}</a></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                {{ $contacts->links('backend.elements.pagination') }}
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
