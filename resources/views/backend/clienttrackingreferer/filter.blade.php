<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\TranslateHelper;
    use App\Helpers\DateHelper;

    $urlHelper = app('UrlHelper');
    $clienttrackingreferers = !empty($data['clienttrackingreferers']) ? $data['clienttrackingreferers'] : [];
    $title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.clienttrackingreferer.clienttrackingreferer_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.clienttrackingreferer.clienttrackingreferer_search'])
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
                                        <th scope="col">{{__('Nguồn truy cập')}}</th>
                                        <th scope="col">{{__('Icon')}}</th>
                                        <th scope="col">{{__('Loại')}}</th>
                                        <th scope="col">{{__('Nhóm')}}</th>
                                        <th scope="col">{{__('Nhà cung cấp')}}</th>
                                        <th scope="col">{{__('Ngày tạo')}}</th>
                                        <th scope="col">{{__('Bật')}}</th>
                                        <th scope="col">{{__('Id')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($clienttrackingreferers) && count($clienttrackingreferers) > 0)
                                        @foreach($clienttrackingreferers as $key => $item)
                                            <tr>
                                                <td data-label="checkbox"><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->id }}"></td>
                                                <td data-label="Nguồn truy cập"><a href="@php echo $urlHelper::admin('clienttrackingreferer', 'edit')."?id=$item->id" @endphp">{{ $item->referral }}</a></td>
                                                <td data-label="Icon"><a href="@php echo $urlHelper::admin('clienttrackingreferer', 'edit')."?id=$item->id" @endphp"><img class="shake icon-size-32" src="{{ADMIN_DIST_ICON_URL . '/tracking-referer/' . $item->icon}}" alt="{{ $item->name }}" ></img></a></td>
                                                <td data-label="Loại">{{ $item->type }}</td>
                                                <td data-label="Nhóm" class="text-info">{{ $item->category }}</td>
                                                <td data-label="Nhà cung cấp" class="text-primary">{{ $item->provider }}</td>
                                                <td data-label="Ngày tạo">{{ DateHelper::getDate('d/m/Y', $item->created_at) }}</td>
                                                <td data-label="Bật">
                                                    <span class="{{($item->status == 'inactive') ? 'badge badge-danger' : 'badge badge-success'}}">
                                                        {{ TranslateHelper::getTranslate('vi', 'status', $item->status) }}
                                                    </span>
                                                </td>
                                                <td data-label="Id"><a href="@php echo $urlHelper::admin('clienttrackingreferer', 'edit')."?id=$item->id" @endphp">{{ $item->id }}</a></td>
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
                                    {{ $campaigns->links(CLIENTTRACKING_TRACKINGREFERER_SEARCH.'.pagination') }}
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
