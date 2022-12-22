@if ($paginator->hasPages())
    <div class="row">
        <div class="col-sm-12 col-md-5">
            <div class="dataTables_info" id="datable_1_info" role="status" aria-live="polite">{{__('Hiển thị')}} {{$paginator->firstItem()}} {{__('đến')}} {{$paginator->lastItem()}} {{__('của')}} {{$paginator->total()}} {{__('mã')}}</div>
        </div>
        <div class="col-sm-12 col-md-7">
            <div class="dataTables_paginate paging_simple_numbers" id="datable_1_paginate">
                <ul class="pagination">
                    @if ($paginator->onFirstPage())
                        <li class="paginate_button page-item previous disabled" id="datable_1_previous"><a href="#" aria-controls="datable_1" tabindex="0" class="page-link">{{__('Trước')}}</a></li>
                    @else
                        <li class="paginate_button page-item previous" id="datable_1_previous"><a href="{{ $paginator->previousPageUrl() }}" aria-controls="datable_1" tabindex="0" class="page-link">{{__('Trước')}}</a></li>
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
                                    <li class="paginate_button page-item"><a href="{{ $url }}" aria-controls="datable_1" tabindex="0" class="page-link">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach


                    @if ($paginator->hasMorePages())
                        <li class="paginate_button page-item next" id="datable_1_next"><a href="{{ $paginator->nextPageUrl() }}" aria-controls="datable_1" tabindex="0" class="page-link">{{__('Sau')}}</a></li>
                    @else
                        <li class="paginate_button page-item next disabled" id="datable_1_next"><a href="#" aria-controls="datable_1" tabindex="0" class="page-link">{{__('Sau')}}</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endif
