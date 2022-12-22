<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\TranslateHelper;
    use App\Helpers\DateHelper;

    $urlHelper = app('UrlHelper');
    $tokens = !empty($data['tokens']) ? $data['tokens'] : [];
    $title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.ctokenin.ctokenin_list'])
    @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.ctokenin.ctokenin_search'])
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
                                        <th scope="col">{{__('Domain')}}</th>
                                        <th scope="col">{{__('Client Id')}}</th>
                                        <th scope="col">{{__('Ngày tạo')}}</th>
                                        <th scope="col">{{__('Bật')}}</th>
                                        <th scope="col">{{__('Id')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($tokens) && count($tokens) > 0)
                                        @foreach($tokens as $key => $item)
                                            <tr>
                                                <td data-label="checkbox"><input type="checkbox" class="checkItem" name="cid[]" value="{{ $item->ctokenin_id }}"></td>
                                                <td data-label="Domain"><a href="@php echo $urlHelper::admin('ctokenin', 'edit')."?id=$item->ctokenin_id" @endphp">{{ $item->ctokenin_name }}</a></td>
                                                <td data-label="Client Id">{{ $item->client_id }}</td>
                                                <td data-label="Ngày tạo">{{ DateHelper::getDate('d/m/Y', $item->ctokenin_created_at) }}</td>
                                                <td data-label="Bật">
                                                    <span class="{{($item->ctokenin_status == 'inactive') ? 'badge badge-danger' : 'badge badge-success'}}">
                                                        {{ TranslateHelper::getTranslate('vi', 'status', $item->ctokenin_status) }}
                                                    </span>
                                                </td>
                                                <td data-label="Id"><a href="@php echo $urlHelper::admin('ctokenin', 'edit')."?id=$item->ctokenin_id" @endphp">{{ $item->ctokenin_id }}</a></td>
                                            </tr>
                                        @endforeach
                                        @else
                                            <tr>
                                                <td colspan="9" class="not-found-records">{{__('Không tồn tại dữ liệu')}}</td>
                                            </tr>
                                    @endif
                                    </tbody>
                                </table>
                                @if(!empty($tokens))
                                    {{ $tokens->links('backend.elements.pagination') }}
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
