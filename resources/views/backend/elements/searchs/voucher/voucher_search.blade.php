@php
    // Begin Nested items
    $parents = isset($data['parents']) ? $data['parents'] : '';
    $parentId = isset($data['parentId']) ? $data['parentId'] : 0;
    $node = 1;
    // End Nested items
@endphp
<form id="search-form" method="POST" action="{{app('UrlHelper')::admin('voucher', 'search')}}" enctype="multipart/form-data" class="txt-al-l">
	@csrf
    <div class="row">
        <div class="col-md-2 pb-10">
            @include(VOUCHER_SEARCH.'.group')
        </div>
        <div class="col-md-2 pb-10">
            @include(VOUCHER_SEARCH.'.status')
        </div>
        <div class="col-md-2 pb-10">
            @include(VOUCHER_SEARCH.'.isAssigned')
        </div>
        <div class="col-md-2 pb-10">
            @include(VOUCHER_SEARCH.'.isUsed')
        </div>
        <div class="col-md-3 pb-10">
            @include(VOUCHER_SEARCH.'.input')
        </div>
        <div class="col-md-1 pb-10 txt-al-r">
        	<a data-url='{{app('UrlHelper')::admin('voucher', 'search')}}' class='js-search button-search'>
        	    <button class='btn btn-outline-primary btn-search-80'><i class='glyphicon glyphicon-search'></i>{{__(FILTER_BUTTON_LABEL)}}</button>
        	</a>
        </div>
</form>