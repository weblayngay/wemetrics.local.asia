<form id="search-form" method="POST" action="{{app('UrlHelper')::admin('kiotvietInvoice', 'preloadsearch')}}" enctype="multipart/form-data" class="txt-al-l">
	@csrf
    <div class="row">
        <div class="col-md-2 pb-10">
            @include(KIOTVIET_INVOICE_SEARCH.'.frmDate')
        </div>
        <div class="col-md-2 pb-10">
            @include(KIOTVIET_INVOICE_SEARCH.'.toDate')
        </div>
        {{-- <div class="col-md-2 pb-10">
            @include(KIOTVIET_INVOICE_SEARCH.'.code')
        </div> --}}
        <div class="col-md-2 pb-10">
            @include(KIOTVIET_INVOICE_SEARCH.'.customercode')
        </div>
        <div class="col-md-2 pb-10">
            @include(KIOTVIET_INVOICE_SEARCH.'.branch')
        </div>
        <div class="col-md-2 pb-10">
            @include(KIOTVIET_INVOICE_SEARCH.'.status')
        </div>
        <div class="col-md-1 pb-10 txt-al-r">
            <a data-url='{{app('UrlHelper')::admin('kiotvietInvoice', 'preloadsearch')}}' class='js-search button-search'>
                <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-search'></i>{{__(STATISTIC_BUTTON_LABEL)}}</button>
            </a>
        </div>
    </div>
</form>