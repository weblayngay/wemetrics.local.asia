<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\TranslateHelper;
    use App\Helpers\DateHelper;
    $urlHelper = app('UrlHelper');
    $contactconfigs = !empty($data['contactconfigs']) ? $data['contactconfigs'] : [];
    $title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.contactconfig.contactconfig_list'])
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
                                        <th>{{__('Ngày tạo')}}</th>
                                        <th>{{__('Bật')}}</th>
                                        <th>{{__('Id')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($contactconfigs) && count($contactconfigs) > 0)
                                        @foreach($contactconfigs as $key => $item)
                                            <tr>
                                                <th><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->contactconfig_id }}"></th>
                                                <td>{{ $key + 1 }}</td>
                                                <td><a href="{{app('UrlHelper')::admin('contactconfig', 'edit', ['id' => $item->contactconfig_id])}}">{{ $item->contactconfig_name}}</a></td>
                                                <td>{{ DateHelper::getDate('d/m/Y', $item->contactconfig_created_at) }}</td>
                                                <td>{{ TranslateHelper::getTranslate('vi', 'status', $item->contactconfig_status) }}</td>
                                                <td><a href="@php echo $urlHelper::admin('contactconfig', 'edit')."?id=$item->contactconfig_id" @endphp">{{ $item->contactconfig_id }}</a></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                {{ $contactconfigs->links('backend.elements.pagination') }}
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
