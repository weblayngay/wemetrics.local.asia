<form id="search-form" method="POST" action="{{app('UrlHelper')::admin('clienttrackingwhitelistip', 'search')}}" enctype="multipart/form-data" class="txt-al-l">
	@csrf
    <div class="row">
        <div class="col-md-2 pb-10">
            @include(CLIENTTRACKING_WHITELISTIP_SEARCH.'.status')
        </div>
        <div class="col-md-3 pb-10">
            @include(CLIENTTRACKING_WHITELISTIP_SEARCH.'.input')
        </div>
        <div class="col-md-1 pb-10 txt-al-r">
        	<a data-url='{{app('UrlHelper')::admin('clienttrackingwhitelistip', 'search')}}' class='js-search button-search'>
        	    <button class='btn btn-outline-primary btn-search-80'><i class='glyphicon glyphicon-search'></i>{{__(FILTER_BUTTON_LABEL)}}</button>
        	</a>
        </div>
    </div>
</form>