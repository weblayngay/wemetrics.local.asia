<?php
/**
 * @var \Illuminate\Pagination\LengthAwarePaginator $paginator
 */
if ($paginator->count() < 1) {
    return false;
}
?>
@if ($paginator->hasPages())
<div class="pagination-area pagination-area-reverse">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 p-0">
                <div class="product-pagination">
                    <ul style="border-top: 0px">
                        <li data-page="1"><a href="#"><<</a></li>
                        @if ($paginator->onFirstPage())
                            <li data-page="1" class="disabled"><a href="#"><</a></li>
                        @else
                            <li data-page="1"><a href="{{ $paginator->previousPageUrl() }}"><</a></li>
                        @endif
                            {{-- Pagination Elements --}}
                            @foreach ($elements as $element)
                                {{-- Array Of Links --}}
                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $paginator->currentPage())
                                            <li data-page="{{$page}}" class="active"><a href="#">{{ $page }}</a></li>
                                        @elseif (($page == $paginator->currentPage() + 1 || $page == $paginator->currentPage() + 2) || $page == $paginator->lastPage())
                                            <li data-page="{{$page}}"><a href="{{ $url }}">{{ $page }}</a></li>
                                        @elseif ($page == $paginator->lastPage() - 1)
                                            <li class="disabled"><span><i class="fa fa-ellipsis-h"></i></span></li>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach

                        @if ($paginator->hasMorePages())
                            <li data-page="{{$paginator->lastPage()}}"><a href="{{ $paginator->nextPageUrl() }}">></a></li>
                        @else
                            <li data-page="{{$paginator->lastPage()}}" class="disabled"><a href="#">></a></li>
                        @endif

                        <li data-page="{{$paginator->lastPage()}}"><a href="#">>></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
