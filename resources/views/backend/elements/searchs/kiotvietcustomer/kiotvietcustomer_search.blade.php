<form id="search-form" method="POST" action="{{app('UrlHelper')::admin('kiotvietCustomer', 'preloadsearch')}}" enctype="multipart/form-data" class="txt-al-l">
	@csrf
    <div class="row">
        <div class="col-md-2 pb-10">
            @include(KIOTVIET_CUSTOMER_SEARCH.'.code')
        </div>
        <div class="col-md-2 pb-10">
            @include(KIOTVIET_CUSTOMER_SEARCH.'.name')
        </div>
        <div class="col-md-2 pb-10">
            @include(KIOTVIET_CUSTOMER_SEARCH.'.phone')
        </div>
        <div class="col-md-2 pb-10">
            @include(KIOTVIET_CUSTOMER_SEARCH.'.branch')
        </div>
        <div class="col-md-1 pb-10 txt-al-r">
        	<a data-url='{{app('UrlHelper')::admin('kiotvietCustomer', 'preloadsearch')}}' class='js-search button-search'>
        	    <button class='btn btn-outline-primary btn-search-80'><i class='glyphicon glyphicon-search'></i>{{__(FILTER_BUTTON_LABEL)}}</button>
        	</a>
        </div>
</form>