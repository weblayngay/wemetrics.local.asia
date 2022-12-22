<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\TranslateHelper;
    use App\Helpers\DateHelper;

    $urlHelper = app('UrlHelper');
    $vouchers = !empty($data['vouchers']) ? $data['vouchers'] : [];
    $title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.voucher.voucher_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.voucher.voucher_search'])
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
                                        <th scope="col">{{__('Mã giảm giá')}}</th>
                                        <th scope="col">{{__('Nhóm')}}</th>
                                        <th scope="col">{{__('Loại')}}</th>
                                        <th scope="col">{{__('Sử dụng')}}</th>
                                        <th scope="col">{{__('Được cấp')}}</th>
                                        <th scope="col">{{__('Ngày hết hạn')}}</th>
                                        <th scope="col">{{__('Bật')}}</th>
                                        <th scope="col">{{__('Id')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($vouchers) && count($vouchers) > 0)
                                        @foreach($vouchers as $key => $item)
                                            <tr>
                                                <td data-label="checkbox"><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->voucher_id }}"></td>
                                                <td data-label="Mã giảm giá"><a href="@php echo $urlHelper::admin('voucher', 'edit')."?id=$item->voucher_id" @endphp">{{ $item->voucher_code }}</a></td>
                                                <td data-label="Nhóm">{{ !empty($item->group) ? $item->group->vouchergroup_name : '' }}</td>
                                                <td data-label="Loại">{{ TranslateHelper::getTranslate('vi', 'type', $item->voucher_type) }}</td>
                                                <td data-label="Sử dụng">
                                                    <span class="{{($item->voucher_is_used == 'no') ? 'badge badge-warning' : 'badge badge-success'}}">
                                                        {{ TranslateHelper::getTranslate('vi', 'isUsed', $item->voucher_is_used) }}
                                                    </span>
                                                </td>
                                                <td data-label="Được cấp">
                                                    <span class="{{($item->voucher_is_assigned == 'no') ? 'badge badge-warning' : 'badge badge-success'}}">
                                                        {{ TranslateHelper::getTranslate('vi', 'isAssigned', $item->voucher_is_assigned) }}
                                                    </span>
                                                </td>
                                                <td data-label="Ngày hết hạn">{{ DateHelper::getDate('d/m/Y', $item->voucher_expired_at) }}</td>
                                                <td data-label="Bật">
                                                    <span class="{{($item->voucher_status == 'inactive') ? 'badge badge-danger' : 'badge badge-success'}}">
                                                        {{ TranslateHelper::getTranslate('vi', 'status', $item->voucher_status) }}
                                                    </span>
                                                </td>
                                                <td data-label="Id"><a href="@php echo $urlHelper::admin('voucher', 'edit')."?id=$item->voucher_id" @endphp">{{ $item->voucher_id }}</a></td>
                                            </tr>
                                        @endforeach
                                        @else
                                            <tr>
                                                <td colspan="9" class="not-found-records">{{__('Không tồn tại dữ liệu')}}</td>
                                            </tr>
                                    @endif
                                    </tbody>
                                </table>
                                @if(!empty($vouchers))
                                    {{ $vouchers->links(VOUCHER_SEARCH.'.pagination') }}
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
