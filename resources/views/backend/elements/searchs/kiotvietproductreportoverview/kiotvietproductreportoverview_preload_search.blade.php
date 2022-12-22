<form id="report-form" method="POST" action="{{app('UrlHelper')::admin('kiotvietproductreportoverview', 'stats')}}" enctype="multipart/form-data" class="txt-al-l">
	@csrf
    <div class="row">
        <div class="col-md-2 pb-10">
            @include(KIOTVIET_PRODUCTREPORTOVERVIEW_SEARCH.'.frmDate')
        </div>
        <div class="col-md-2 pb-10">
            @include(KIOTVIET_PRODUCTREPORTOVERVIEW_SEARCH.'.toDate')
        </div>
        <div class="col-md-3 pb-10">
            @include(KIOTVIET_PRODUCTREPORTOVERVIEW_SEARCH.'.branch')
        </div>
        <div class="col-md-3 pb-10">
            @include(KIOTVIET_PRODUCTREPORTOVERVIEW_SEARCH.'.code')
        </div>
        <div class="col-md-1 pb-10 txt-al-r">
            <a data-url='{{app('UrlHelper')::admin('kiotvietproductreportoverview', 'stats')}}' class='js-report'>
                <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-stats'></i>{{__(STATISTIC_BUTTON_LABEL)}}</button>
            </a>
        </div>
    </div>
</form>