<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\TranslateHelper;
    use App\Helpers\DateHelper;
    $urlHelper = app('UrlHelper');
    $users = !empty($data['users']) ? $data['users'] : [];
    $title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.user.user_list'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <form action="#" method="post" id="admin-form">
                                @csrf
                                <div class="table-responsive">
                                    <table class="table table-hover w-100 display pb-30 js-main-table">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" class="checkAll" name="checkAll" value=""></th>
                                        <th>{{__('#')}}</th>
                                        <th>{{__('Tên')}}</th>
                                        <th>{{__('Email')}}</th>
                                        <th>{{__('Điện thoại')}}</th>
                                        <th>{{__('Giới tính')}}</th>
                                        <th>{{__('Loại')}}</th>
                                        <th>{{__('Trạng thái')}}</th>
                                        <th>{{__('Ngày tạo')}}</th>
                                        <th>{{__('ID')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($users) && count($users) > 0)
                                        @foreach($users as $key => $item)
                                            <tr>
                                                <th><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->id }}"></th>
                                                <td>{{ $key + 1 }}</td>
                                                <td><a href="@php echo $urlHelper::admin('user', 'edit')."?id=$item->id" @endphp">{{ $item->name }}</a></td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->phone }}</td>
                                                <td>{{ TranslateHelper::getTranslate('vi', 'gender', $item->gender) }}</td>
                                                <td>{{ $item->type }}</td>
                                                <td>{{ TranslateHelper::getTranslate('vi', 'status', $item->status) }}</td>
                                                <td>{{ DateHelper::getDate('d/m/Y', $item->created_at) }}</td>
                                                <td><a href="@php echo $urlHelper::admin('user', 'edit')."?id=$item->id" @endphp">{{ $item->id }}</a></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                </div>
                                {{ $users->links('backend.elements.pagination') }}
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
