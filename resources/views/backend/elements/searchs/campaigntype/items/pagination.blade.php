<?php
    /**
     * @var \Illuminate\Pagination\LengthAwarePaginator $paginator
     */
    if ($paginator->count() < 1) {
        return false;
    }
    $request = Request::all();
    $token = $request['_token'];
    $searchStr = $request['searchStr'];
    $isUsed = $request['isUsed'];
    $status = $request['status'];
    $currentURL = url()->current();
    $currentURL = str_replace('/search', '/paginate', $currentURL);
    $currentURL = $currentURL.'?_token='.$token.'&searchStr='.$searchStr.'&status='.$status.'&isUsed='.$isUsed;
    $currentRoute = Route::current()->getName();
?>
@if ($paginator->hasPages())
    <div class="row">
        <div class="col-sm-12 col-md-5">
            <div class="dataTables_info" id="datable_1_info" role="status" aria-live="polite">{{__('Hiển thị')}} {{$paginator->firstItem()}} {{__('đến')}} {{$paginator->lastItem()}} {{__('của')}} {{$paginator->total()}} {{__('mã')}}</div>
        </div>
        <div class="col-sm-12 col-md-7">
            <div class="dataTables_paginate paging_simple_numbers" id="datable_1_paginate">
                <ul class="pagination">
                    <li class="paginate_button page-item first" id="datable_1_first">
                        <a href="{{$currentURL.'&page=1'}}" data-page="1" aria-controls="tblbody" class="page-link">{{__('Đầu')}}</a>
                    </li>
                    @if ($paginator->onFirstPage())
                        <li class="paginate_button page-item previous disabled" id="datable_1_previous"><a href="#" aria-controls="datable_1" tabindex="0" class="page-link">{{__('Trước')}}</a></li>
                    @else
                        <li class="paginate_button page-item previous" id="datable_1_previous"><a href="{{ $currentURL.'&page='.$paginator->currentPage() - 1 }}" aria-controls="datable_1" tabindex="0" class="page-link">{{__('Trước')}}</a></li>
                    @endif


                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <li class="paginate_button page-item "><a href="" aria-controls="datable_1" data-dt-idx="2" tabindex="0" class="page-link">{{ $element }}</a></li>
                        @endif
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="paginate_button page-item active"><a href="" aria-controls="datable_1" tabindex="0" class="page-link">{{ $page }}</a></li>
                                @else
                                    <li class="paginate_button page-item"><a href="{{ $currentURL.'&page='.$page }}" aria-controls="datable_1" tabindex="0" class="page-link">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach


                    @if ($paginator->hasMorePages())
                        <li class="paginate_button page-item next" id="datable_1_next"><a href="{{ $currentURL.'&page='.$paginator->currentPage() + 1 }}" aria-controls="datable_1" tabindex="0" class="page-link">{{__('Sau')}}</a></li>
                    @else
                        <li class="paginate_button page-item next disabled" id="datable_1_next"><a href="#" aria-controls="datable_1" tabindex="0" class="page-link">{{__('Sau')}}</a></li>
                    @endif
                    <li class="paginate_button page-item last" id="datable_1_last">
                        <a aria-controls="tblbody" class="page-link" data-page="{{$paginator->lastPage()}}" href="{{$currentURL.'&page='.$paginator->lastPage()}}">{{__('Cuối')}}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endif
