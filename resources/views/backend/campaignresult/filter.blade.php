<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\TranslateHelper;
    use App\Helpers\DateHelper;
    $urlHelper = app('UrlHelper');
    $campaignresults = !empty($data['campaignresults']) ? $data['campaignresults'] : [];
    $title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.campaignresult.campaignresult_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.campaignresult.campaignresult_search'])
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
                                        <th scope="col">{{__('Chiến dịch')}}</th>
                                        <th scope="col">{{__('Mã giảm giá')}}</th>
                                        <th scope="col">{{__('Điện thoại')}}</th>
                                        <th scope="col">{{__('Email')}}</th>
                                        <th scope="col">{{__('Thiết bị')}}</th>
                                        <th scope="col">{{__('Sử dụng')}}</th>
                                        <th scope="col">{{__('Id')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($campaignresults) && count($campaignresults) > 0)
                                        @foreach($campaignresults as $key => $item)
                                            <tr>
                                                <td data-label="checkbox"><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->campaign_id }}"></td>
                                                <td data-label="Chiến dịch">{{ $item->campaign_name }}</td>
                                                <td data-label="Mã giảm giá">{{ $item->voucher_code }}</td>
                                                <td data-label="Điện thoại"><a href="@php echo $urlHelper::admin('campaignresult', 'show')."?id=$item->campaignresult_id" @endphp">{{ $item->object_phone }}</a></td>
                                                <td data-label="Email">{{ $item->object_email }}</td>
                                                <td data-label="deviceType">{{ $item->deviceType }}</td>
                                                <td data-label="Đã sử dụng">
                                                    <span class="{{($item->voucher_is_used == 'no') ? 'badge badge-warning' : 'badge badge-success'}}">
                                                        {{ TranslateHelper::getTranslate('vi', 'isUsed', $item->voucher_is_used) }}
                                                    </span>
                                                </td>                                                
                                                <td data-label="Id"><a href="@php echo $urlHelper::admin('campaignresult', 'show')."?id=$item->campaignresult_id" @endphp">{{ $item->campaignresult_id }}</a></td>
                                            </tr>
                                        @endforeach
                                        @else
                                            <tr>
                                                <td colspan="9" class="not-found-records">{{__('Không tồn tại dữ liệu')}}</td>
                                            </tr>
                                    @endif
                                    </tbody>
                                </table>
                                @if(!empty($campaignresults))
                                    {{ $campaignresults->links(CAMPAIGN_RESULT_SEARCH.'.pagination') }}
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection