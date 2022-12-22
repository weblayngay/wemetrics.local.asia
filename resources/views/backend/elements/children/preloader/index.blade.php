<?php
    $faviconId = app('Config')->getConfig('favicon-cong-ty', '');
    $favicon = app('Banner')::query()->where('banner_id', $faviconId)->first();
    $companyName = app('Config')->getConfig('ten-cong-ty', '');
?>
<!--Preloader start here-->
{{-- <div id="pre-load">
   <div id="loader" class="loader">
       <div class="loader-container">
           <div class='loader-icon'>
           		<img src="{{config('my.path.image_banner_of_module') . $favicon->avatar->image_name}}" alt="{{__($companyName)}}">
           </div>
       </div>
   </div>              
</div> --}}

<div id="pre-load">
   <div id="loader" class="loader">
       <div id="loader-report" class="loader-report">
	        <div class="loader-report-container-img">
	        	<img src="{{ ADMIN_DIST_ICON_URL. DS. 'preload'. DS. 'loading_2.gif' }}" alt="{{__($companyName)}}">
	        </div>
       </div>
   </div>              
</div>
<!--Preloader area end here-->