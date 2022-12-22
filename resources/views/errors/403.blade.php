@php
    $faviconId = app('Config')->getConfig('favicon-cong-ty', '');
    $favicon = app('Banner')::query()->where('banner_id', $faviconId)->first();
    $companyName = app('Config')->getConfig('ten-cong-ty', '');
@endphp

@php
  $cssArrFrest = [
            // BEGIN: Vendor CSS
            'vendors/frest/dist/vendors/css/vendors.min.css',
            'vendors/frest/dist/vendors/css/charts/apexcharts.css',
            'vendors/frest/dist/vendors/css/charts/chartist.min.css',
            'vendors/frest/dist/vendors/css/extensions/dragula.min.css',
            // END: Vendor CSS

            // BEGIN: Theme CSS
            'vendors/frest/dist/css/bootstrap.css',
            'vendors/frest/dist/css/bootstrap-extended.css',
            'vendors/frest/dist/css/colors.css',
            'vendors/frest/dist/css/components.css',
            // END: Theme CSS

            // BEGIN: Page CSS
            'vendors/frest/dist/css/core/menu/menu-types/vertical-menu.css',
            'vendors/frest/dist/css/pages/widgets.css',
            'vendors/frest/dist/css/pages/dashboard-analytics.css',
            // END: Page CSS

            // BEGIN: Custom CSS
            'vendors/frest/dist/css/custom-style.css',
            // END: Custom CSS
        ];
@endphp

@php
  $cssArrFontawesome = [
            // BEGIN: fontawesome v6
            'vendors/fontawesome/v6/dist/css/fontawesome.css',
            // 'vendors/fontawesome/v6/dist/css/all.css',
            'vendors/fontawesome/v6/dist/css/brands.css',
            'vendors/fontawesome/v6/dist/css/solid.css',
            'vendors/fontawesome/v6/dist/css/duotone.css',
            'vendors/fontawesome/v6/dist/css/light.css',
            'vendors/fontawesome/v6/dist/css/regular.css',
            'vendors/fontawesome/v6/dist/css/svg-with-js.css',
            'vendors/fontawesome/v6/dist/css/thin.css',
            'vendors/fontawesome/v6/dist/css/v4-shims.css',
            // END: fontawesome v6
        ];
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>{{__('403 Forbidden')}}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{config('my.path.image_banner_of_module') . $favicon->avatar->image_name}}">
    <link rel="icon" href="{{config('my.path.image_banner_of_module') . $favicon->avatar->image_name}}" type="image/x-icon">

    @foreach($cssArrFrest as $css)
        <link href="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . $css. '?v=' . ADMIN_CSS_AND_JAVASCRIPT_VERSION)}}" rel="stylesheet" type="text/css">
    @endforeach

    @foreach($cssArrFontawesome as $css)
        <link href="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . $css. '?v=' . ADMIN_CSS_AND_JAVASCRIPT_VERSION)}}" rel="stylesheet" type="text/css">
    @endforeach
</head>

<body style="background: transparent;">

<div class="row" style="position: absolute; top: 5%; left: 30%">
    <div class="col-md-12">
        <img src="{{ ADMIN_DIST_ICON_URL. DS. 'errors'. DS. '403.gif' }}" alt="{{__($companyName)}}">
    </div>
</div>
<div class="row" style="margin: 30% 20% 0% 25%;">
    <div class="col-md-12">
        <h2 class="font-weight-bolder danger"><i class="fa-duotone fa-face-holding-back-tears"></i> 403 Forbidden</h2>
        <p><span><strong>The HTTP 403 Forbidden response status code indicates that the server understands the request but refuses to authorize it.</strong></span></p>
    </div>
</div>
<div class="row" style="margin: 0% 20% 0% 25%;">
    <div class="col-md-2">
        <a class="btn btn-primary hover" type="button" href="{{url()->previous()}}">Go back</a>
    </div>
    <div class="col-md-2">
        <a class="btn btn-primary hover" type="button" href="{{URL::to('/')}}">Go home</a>
    </div>            
</div>

@php
    $javascriptArrFrest = [
              'vendors/frest/dist/vendors/js/charts/apexcharts.min.js',
              
              // BEGIN: Vendor JS
              'vendors/frest/dist/vendors/js/vendors.min.js',
              // END: Vendor JS

              // BEGIN: Theme JS
              'vendors/frest/dist/js/core/app-menu.js',
              'vendors/frest/dist/js/core/app.js',
              'vendors/frest/dist/js/scripts/components.js',
              'vendors/frest/dist/js/scripts/footer.js',
              // END: Theme JS
          ];
@endphp

@php
    $javascriptArrFontawesome = [
            // BEGIN: fontawesome v6
            'vendors/fontawesome/v6/dist/js/fontawesome.js',
            // 'vendors/fontawesome/v6/dist/js/all.js',
            'vendors/fontawesome/v6/dist/js/brands.js',
            'vendors/fontawesome/v6/dist/js/solid.js',
            'vendors/fontawesome/v6/dist/js/duotone.js',
            'vendors/fontawesome/v6/dist/js/light.js',
            'vendors/fontawesome/v6/dist/js/regular.js',
            'vendors/fontawesome/v6/dist/js/sharp-solid.js',
            'vendors/fontawesome/v6/dist/js/thin.js',
            'vendors/fontawesome/v6/dist/js/v4-shims.js',
            // 'vendors/fontawesome/v6/dist/js/conflict-detection.js',
            // END: fontawesome v6
          ];
@endphp

@foreach($javascriptArrFrest as $javascript)
    <script src="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . $javascript. '?v=' . ADMIN_CSS_AND_JAVASCRIPT_VERSION)}}"></script>
@endforeach

@foreach($javascriptArrFontawesome as $javascript)
    <script src="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . $javascript. '?v=' . ADMIN_CSS_AND_JAVASCRIPT_VERSION)}}"></script>
@endforeach

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
