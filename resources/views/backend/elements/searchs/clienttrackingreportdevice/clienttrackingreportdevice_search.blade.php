<form id="report-form" method="POST" action="{{app('UrlHelper')::admin('clienttrackingreportdevice', 'stats')}}" enctype="multipart/form-data" class="txt-al-l">
	@csrf
    <div class="row">
        <div class="col-md-2 pb-10">
            @include(CLIENTTRACKING_REPORTDEVICE_SEARCH.'.frmDate')
        </div>
        <div class="col-md-2 pb-10">
            @include(CLIENTTRACKING_REPORTDEVICE_SEARCH.'.toDate')
        </div>
        <div class="col-md-2 pb-10">
            @include(CLIENTTRACKING_REPORTDEVICE_SEARCH.'.device')
        </div>
        <div class="col-md-1 pb-10 txt-al-r">
            <a data-url='{{app('UrlHelper')::admin('clienttrackingreportdevice', 'stats')}}' class='js-report'>
                <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-stats'></i>{{__(STATISTIC_BUTTON_LABEL)}}</button>
            </a>
        </div>
    </div>
</form>