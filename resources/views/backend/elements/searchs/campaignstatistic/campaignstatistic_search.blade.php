@php
    // Begin Nested items
    $parents = isset($data['parents']) ? $data['parents'] : '';
    $parentId = isset($data['parentId']) ? $data['parentId'] : 0;
    $node = 1;
    // End Nested items
@endphp
<form id="report-form" method="POST" action="{{app('UrlHelper')::admin('campaignstatistic', 'stats')}}" enctype="multipart/form-data" class="txt-al-l">
	@csrf
    <div class="row">
        <div class="col-md-2 pb-10">
            @include(CAMPAIGN_STATISTIC_SEARCH.'.campaign')
        </div>
        <div class="col-md-2 pb-10">
            @include(CAMPAIGN_STATISTIC_SEARCH.'.frmDate')
        </div>
        <div class="col-md-2 pb-10">
            @include(CAMPAIGN_STATISTIC_SEARCH.'.toDate')
        </div>
        <div class="col-md-6 pb-10 txt-al-r">
            <a data-url='{{app('UrlHelper')::admin('campaignstatistic', 'stats')}}' class='js-report'>
                <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-stats'></i>{{__(STATISTIC_BUTTON_LABEL)}}</button>
            </a>
        </div>
    </div>
</form>