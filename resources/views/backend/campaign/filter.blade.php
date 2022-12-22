<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\TranslateHelper;
    use App\Helpers\DateHelper;

    $urlHelper = app('UrlHelper');
    $campaigns = !empty($data['campaigns']) ? $data['campaigns'] : [];
    $title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.campaign.campaign_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.campaign.campaign_search'])
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
                                        <th scope="col">{{__('Nhóm')}}</th>
                                        <th scope="col">{{__('Loại')}}</th>
                                        <th scope="col">{{__('Sử dụng')}}</th>
                                        <th scope="col">{{__('Ngày hết hạn')}}</th>
                                        <th scope="col">{{__('Bật')}}</th>
                                        <th scope="col">{{__('Id')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($campaigns) && count($campaigns) > 0)
                                        @foreach($campaigns as $key => $item)
                                            <tr>
                                                <td data-label="checkbox"><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->campaign_id }}"></td>
                                                <td data-label="Chiến dịch"><a href="@php echo $urlHelper::admin('campaign', 'edit')."?id=$item->campaign_id" @endphp">{{ $item->campaign_name }}</a></td>
                                                <td data-label="Nhóm">{{ !empty($item->group) ? $item->group->campaigngroup_name : '' }}</td>
                                                <td data-label="Loại">{{ !empty($item->group) ? $item->type->campaigntype_name : '' }}</td>
                                                <td data-label="Sử dụng">
                                                    <span class="{{($item->campaign_is_used == 'no') ? 'badge badge-warning' : 'badge badge-success'}}">
                                                        {{ TranslateHelper::getTranslate('vi', 'isUsed', $item->campaign_is_used) }}
                                                    </span>
                                                </td>
                                                <td data-label="Ngày hết hạn">{{ DateHelper::getDate('d/m/Y', $item->campaign_expired_at) }}</td>
                                                <td data-label="Bật">
                                                    <span class="{{($item->campaign_status == 'inactive') ? 'badge badge-danger' : 'badge badge-success'}}">
                                                        {{ TranslateHelper::getTranslate('vi', 'status', $item->campaign_status) }}
                                                    </span>
                                                </td>
                                                <td data-label="Id"><a href="@php echo $urlHelper::admin('campaign', 'edit')."?id=$item->campaign_id" @endphp">{{ $item->campaign_id }}</a></td>
                                            </tr>
                                        @endforeach
                                        @else
                                            <tr>
                                                <td colspan="9" class="not-found-records">{{__('Không tồn tại dữ liệu')}}</td>
                                            </tr>
                                    @endif
                                    </tbody>
                                </table>
                                @if(!empty($campaigns))
                                    {{ $campaigns->links(CAMPAIGN_SEARCH.'.pagination') }}
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
