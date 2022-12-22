<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\TranslateHelper;
    use App\Helpers\DateHelper;

    $urlHelper = app('UrlHelper');
    $perceivedValues = !empty($data['perceivedValues']) ? $data['perceivedValues'] : [];
    $title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.perceivedvalue.perceivedvalue_list'])
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
                                        <th>{{__('Tên khách hàng')}}</th>
                                        <th>{{__('Ngày tạo')}}</th>
                                        <th>{{__('Bật')}}</th>
                                        <th>{{__('Id')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($perceivedValues) && count($perceivedValues) > 0)
                                        @foreach($perceivedValues as $key => $item)
                                            <tr>
                                                <th><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->pervalue_id }}"></th>
                                                <td>{{ $key + 1 }}</td>
                                                <td><a href="@php echo $urlHelper::admin('perceivedvalue', 'edit')."?id=$item->pervalue_id" @endphp">{{ $item->pervalue_fullname }}</a></td>
                                                <td>{{ DateHelper::getDate('d/m/Y', $item->pervalue_created_at) }}</td>
                                                <td>{{ TranslateHelper::getTranslate('vi', 'status', $item->pervalue_status) }}</td>
                                                <td><a href="@php echo $urlHelper::admin('perceivedvalue', 'edit')."?id=$item->pervalue_id" @endphp">{{ $item->pervalue_id }}</a></td>
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
