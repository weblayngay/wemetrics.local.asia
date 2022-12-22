<?php
use App\Helpers\TranslateHelper;
use App\Helpers\DateHelper;
/**
 * @var \App\Helpers\UrlHelper $urlHelper
 */
$urlHelper = app('UrlHelper');
$groups = !empty($data['groups']) ? $data['groups'] : [];
$title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.vouchergroup.vouchergroup_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.vouchergroup.vouchergroup_search'])
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
                                        <th scope="col">{{__('Nhóm mã giảm giá')}}</th>
                                        <th scope="col">{{__('Sử dụng')}}</th>
                                        <th scope="col">{{__('Parent')}}</th>
                                        <th scope="col">{{__('Child items')}}</th>
                                        <th scope="col">{{__('Ngày tạo')}}</th>
                                        <th scope="col">{{__('Bật')}}</th>
                                        <th scope="col">{{__('Id')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($groups) && count($groups) > 0)
                                        @foreach($groups as $key => $item)
                                            <tr>
                                                <td data-label="checkbox"><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->vouchergroup_id }}"></td>
                                                <td data-label="Nhóm mã giảm giá"><a href="@php echo $urlHelper::admin('vouchergroup', 'edit')."?id=$item->vouchergroup_id" @endphp">{{ $item->vouchergroup_name }}</a></td>
                                                <td data-label="Sử dụng">
                                                    @if(!empty($item->campaigns) && count($item->campaigns) > 0)
                                                        @php
                                                            $isUsed = 'yes';
                                                        @endphp
                                                    @else
                                                        @php
                                                            $isUsed = 'no';
                                                        @endphp
                                                    @endif
                                                    <span class="{{($isUsed == 'yes') ? 'badge badge-warning' : 'badge badge-success'}}">
                                                        {{ TranslateHelper::getTranslate('vi', 'isUsed', $isUsed) }}
                                                    </span>
                                                </td>
                                                <td data-label="Parent">{{ $item->parent}}</td>
                                                <td data-label="Child items">
                                                    <a href="{{app('UrlHelper')->admin('vouchergroup', 'drill?parentId='.$item->vouchergroup_id)}}">
                                                        <image src="{{ asset('public/admin/dist/icons/go_items.png') }}"></image> <strong>{{ '[' . $item->childItems->count() . ']' }}</strong>
                                                    </a>
                                                </td>
                                                <td data-label="Ngày tạo">{{ DateHelper::getDate('d/m/Y', $item->vouchergroup_created_at) }}</td>
                                                <td data-label="Bật">{{ TranslateHelper::getTranslate('vi', 'status', $item->vouchergroup_status) }}</td>
                                                <td data-label="Id"><a href="@php echo $urlHelper::admin('vouchergroup', 'edit')."?id=$item->vouchergroup_id" @endphp">{{ $item->vouchergroup_id }}</a></td>
                                            </tr>
                                        @endforeach
                                        @else
                                            <tr>
                                                <td colspan="9" class="not-found-records">{{__('Không tồn tại dữ liệu')}}</td>
                                            </tr>
                                    @endif
                                    </tbody>
                                </table>
                                @if(!empty($groups))
                                    {{ $groups->links(VOUCHER_GROUP_SEARCH.'.pagination') }}
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
