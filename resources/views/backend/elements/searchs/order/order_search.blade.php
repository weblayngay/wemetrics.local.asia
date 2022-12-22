@php
    // Begin Nested items
    $parents = isset($data['parents']) ? $data['parents'] : '';
    $parentId = isset($data['parentId']) ? $data['parentId'] : 0;
    $node = 1;
    // End Nested items
@endphp
<form id="search-form" method="POST" action="{{app('UrlHelper')::admin('order', 'search')}}" enctype="multipart/form-data" class="txt-al-l">
	@csrf
    <div class="row">
        <div class="col-md-2 pb-10">
            @include(ORDER_SEARCH.'.status')
        </div>
        <div class="col-md-2 pb-10">
            @include(ORDER_SEARCH.'.payment_method')
        </div>
        <div class="col-md-3 pb-10">
            @include(ORDER_SEARCH.'.input')
        </div>
        <div class="col-md-2 pb-10">
            @include(ORDER_SEARCH.'.frmDate')
        </div>
        <div class="col-md-2 pb-10">
            @include(ORDER_SEARCH.'.toDate')
        </div>
        <div class="col-md-1 pb-10 txt-al-r">
        	<a data-url='{{app('UrlHelper')::admin('order', 'search')}}' class='js-search button-search'>
        	    <button class='btn btn-outline-primary btn-search-80'><i class='glyphicon glyphicon-search'></i>{{__(FILTER_BUTTON_LABEL)}}</button>
        	</a>
        </div>
</form>