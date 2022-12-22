<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\TranslateHelper;
    use App\Helpers\DateHelper;

    $urlHelper = app('UrlHelper');
    $clienttrackingexcludereqruis = !empty($data['clienttrackingexcludereqruis']) ? $data['clienttrackingexcludereqruis'] : [];
    $title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.clienttrackingexcludereqrui.clienttrackingexcludereqrui_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.clienttrackingexcludereqrui.clienttrackingexcludereqrui_search'])
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
                                        <th scope="col">{{__('Từ khóa')}}</th>
                                        <th scope="col">{{__('Ngày tạo')}}</th>
                                        <th scope="col">{{__('Bật')}}</th>
                                        <th scope="col">{{__('Id')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($clienttrackingexcludereqruis) && count($clienttrackingexcludereqruis) > 0)
                                        @foreach($clienttrackingexcludereqruis as $key => $item)
                                            <tr>
                                                <td data-label="checkbox"><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->id }}"></td>
                                                <td data-label="Từ khóa"><a href="@php echo $urlHelper::admin('clienttrackingexcludereqrui', 'edit')."?id=$item->id" @endphp">{{ $item->value }}</a></td>
                                                <td data-label="Ngày tạo">{{ DateHelper::getDate('d/m/Y', $item->created_at) }}</td>
                                                <td data-label="Bật">
                                                    <span class="{{($item->status == 'inactive') ? 'badge badge-danger' : 'badge badge-success'}}">
                                                        {{ TranslateHelper::getTranslate('vi', 'status', $item->status) }}
                                                    </span>
                                                </td>
                                                <td data-label="Id"><a href="@php echo $urlHelper::admin('clienttrackingexcludereqrui', 'edit')."?id=$item->id" @endphp">{{ $item->id }}</a></td>
                                            </tr>
                                        @endforeach
                                        @else
                                            <tr>
                                                <td colspan="9" class="not-found-records">{{__('Không tồn tại dữ liệu')}}</td>
                                            </tr>
                                    @endif
                                    </tbody>
                                </table>
                                @if(!empty($clienttrackingexcludereqruis))
                                    {{ $clienttrackingexcludereqruis->links('backend.elements.pagination') }}
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
