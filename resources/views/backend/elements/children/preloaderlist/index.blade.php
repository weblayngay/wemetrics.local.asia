<?php
    $faviconId = app('Config')->getConfig('favicon-cong-ty', '');
    $favicon = app('Banner')::query()->where('banner_id', $faviconId)->first();
    $companyName = app('Config')->getConfig('ten-cong-ty', '');
?>
<!--Preloader start here-->
<div id="pre-load-report">
    <div id="loader-report" class="loader-report">
        <div class="loader-report-container-img">
        	<img src="{{ ADMIN_DIST_ICON_URL. DS. 'preload'. DS. 'loading_3.gif' }}" alt="{{__($companyName)}}">
        </div>
    </div>
</div>
<!--Preloader area end here-->
