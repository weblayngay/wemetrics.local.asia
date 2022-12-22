<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\TranslateHelper;
    use App\Helpers\DateHelper;

    $urlHelper = app('UrlHelper');
    $comments = !empty($data['comments']) ? $data['comments'] : [];
    $title = isset($data['title']) ? $data['title'] : '';

?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.comment.comment_list'])
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
                                        <th>{{__('Nội Dung')}}</th>
                                        <th>{{__('Cấp')}}</th>
                                        <th>{{__('Đánh giá')}}</th>
                                        <th>{{__('Loại')}}</th>
                                        <th>{{__('Duyệt')}}</th>
                                        <th>{{__('Ngày tạo')}}</th>
                                        <th>{{__('parentId')}}</th>
                                        <th>{{__('ID')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($comments) && count($comments) > 0)
                                        @foreach($comments as $key => $item)
                                            <tr>
                                                <th><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->comment_id }}"></th>
                                                <td>{{ $key + 1 }}</td>
                                                <td><a href="@php echo $urlHelper::admin('comment', 'edit')."?id=$item->comment_id" @endphp">{!! substr($item->comment_content, 0, 100) !!}</a></td>
                                                <td>{{ $item->comment_level }}</td>
                                                <td>@if($item->comment_rating > 0) {{$item->comment_rating}} <i class="icon-star"></i> @endif</td>
                                                <td>{{ TranslateHelper::getTranslate('vi', 'type', $item->comment_type) }}</td>
                                                <td>{{ TranslateHelper::getTranslate('vi', 'status', $item->comment_status) }}</td>
                                                <td>{{ DateHelper::getDate('d/m/Y', $item->comment_created_at) }}</td>
                                                <td>{{ $item->comment_parent_id }}</td>
                                                <td>{{ $item->comment_id }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                {{ $comments->links('backend.elements.pagination') }}
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
