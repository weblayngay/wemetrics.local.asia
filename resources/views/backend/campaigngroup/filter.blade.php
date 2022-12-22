<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\TranslateHelper;
    use App\Helpers\DateHelper;
    $urlHelper = app('UrlHelper');
    $groups = !empty($data['groups']) ? $data['groups'] : [];
    $title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.campaigngroup.campaigngroup_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.campaigngroup.campaigngroup_search'])
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
                                        <th scope="col">{{__('Nhóm Chiến dịch')}}</th>
                                        <th scope="col">{{__('Sử dụng')}}</th>
                                        <th scope="col">{{__('Ngày tạo')}}</th>
                                        <th scope="col">{{__('Bật')}}</th>
                                        <th scope="col">{{__('Id')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($groups) && count($groups) > 0)
                                        @foreach($groups as $key => $item)
                                            <tr>
                                                <td data-label="checkbox"><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->campaigngroup_id }}"></td>
                                                <td data-label="Nhóm chiến dịch"><a href="@php echo $urlHelper::admin('campaigngroup', 'edit')."?id=$item->campaigngroup_id" @endphp">{{ $item->campaigngroup_name }}</a></td>
                                                <td data-label="Sử dụng">
                                                    <span class="{{($item->campaigngroup_used == 'yes') ? 'badge badge-warning' : 'badge badge-success'}}">
                                                        {{ TranslateHelper::getTranslate('vi', 'isUsed', $item->campaigngroup_used) }}
                                                    </span>
                                                </td>
                                                <td data-label="Ngày tạo">{{ DateHelper::getDate('d/m/Y', $item->campaigngroup_created_at) }}</td>
                                                <td data-label="Bật">
                                                    <span class="{{($item->campaigngroup_status == 'inactive') ? 'badge badge-danger' : 'badge badge-success'}}">
                                                        {{ TranslateHelper::getTranslate('vi', 'status', $item->campaigngroup_status) }}
                                                    </span>
                                                </td>
                                                <td data-label="Id"><a href="@php echo $urlHelper::admin('campaigngroup', 'edit')."?id=$item->campaigngroup_id" @endphp">{{ $item->campaigngroup_id }}</a></td>
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
                                    {{ $groups->links(CAMPAIGN_GROUP_SEARCH.'.pagination') }}
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
