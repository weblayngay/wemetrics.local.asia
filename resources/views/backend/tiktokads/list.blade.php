<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\TranslateHelper;
    use App\Helpers\DateHelper;

    $urlHelper = app('UrlHelper');
    $reports = !empty($data['reports']) ? $data['reports'] : [];
    $title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.tiktokads.tiktokads_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.tiktokads.tiktokads_search'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap" style="overflow-x:auto;">
                            <form action="#" method="post" id="admin-form">
                                @csrf
                                    <table class="table table-hover w-100 display pb-30 js-main-table">
                                    <thead>
                                    <tr>
                                        <th scope="col"><input type="checkbox" class="checkAll" name="checkAll" value=""></th>
                                        <th scope="col">{{__('Tiêu đề báo cáo')}}</th>
                                        <th scope="col">{{__('Xem báo cáo')}}</th>
                                        <th scope="col">{{__('Ngày tạo')}}</th>
                                        <th scope="col">{{__('Bật')}}</th>
                                        <th scope="col">{{__('Id')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($reports) && count($reports) > 0)
                                        @foreach($reports as $key => $item)
                                            <tr>
                                                <td data-label="checkbox"><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->report_id }}"></td>
                                                <td data-label="Tiêu đề"><a href="@php echo $urlHelper::admin('tiktokads', 'edit')."?id=$item->report_id" @endphp">{{ $item->report_name }}</a></td>
                                                <td data-label="Xem báo cáo">
                                                    <a href="@php echo $urlHelper::admin('tiktokads', 'report')."?id=$item->report_id" @endphp">
                                                        <span class="{{empty($item->report_url) ? 'badge badge-danger' : 'badge badge-primary'}}">
                                                            {{__('Xem báo cáo')}}
                                                        </span>
                                                    </a>
                                                </td>
                                                <td data-label="Ngày tạo">{{ DateHelper::getDate('d/m/Y', $item->report_created_at) }}</td>
                                                <td data-label="Bật">
                                                    <span class="{{($item->report_status == 'inactive') ? 'badge badge-danger' : 'badge badge-success'}}">
                                                        {{ TranslateHelper::getTranslate('vi', 'status', $item->report_status) }}
                                                    </span>
                                                </td>
                                                <td data-label="Id"><a href="@php echo $urlHelper::admin('tiktokads', 'edit')."?id=$item->report_id" @endphp">{{ $item->report_id }}</a></td>
                                            </tr>
                                        @endforeach
                                        @else
                                            <tr>
                                                <td colspan="9" class="not-found-records">{{__('Không tồn tại dữ liệu')}}</td>
                                            </tr>
                                    @endif
                                    </tbody>
                                </table>
                                @if(!empty($reports))
                                    {{ $reports->links('backend.elements.pagination') }}
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
