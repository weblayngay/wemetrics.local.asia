<form id="search-form" method="POST" action="{{app('UrlHelper')::admin('campaigntype', 'search')}}" enctype="multipart/form-data" class="txt-al-l">
	@csrf
	<div class="row">
		<div class="col-md-2 pb-10">
	    	@include(CAMPAIGN_TYPE_SEARCH.'.status')
		</div>
        <div class="col-md-2 pb-10">
            @include(CAMPAIGN_TYPE_SEARCH.'.isUsed')
        </div>
		<div class="col-md-3 pb-10">
	    	@include(CAMPAIGN_TYPE_SEARCH.'.input')
		</div>
		<div class="col-md-5 pb-10 txt-al-r">
			<a data-url='{{app('UrlHelper')::admin('campaigntype', 'search')}}' class='js-search button-search'>
			    <button class='btn btn-outline-primary btn-search-80'><i class='glyphicon glyphicon-search'></i>{{__(FILTER_BUTTON_LABEL)}}</button>
			</a>
		</div>
	</div>
</form>