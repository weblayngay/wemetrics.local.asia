@php
  $cssArr = [
            'vendors/jquery-toggles/css/toggles.css',
            'vendors/daterangepicker/daterangepicker.css',
            'vendors/jquery-toggles/css/themes/toggles-light.css',
            'vendors/dropify/dist/css/dropify.min.css',
            'vendors/dropzone/dist/dropzone.css',
            'vendors/jquery-image-upload/src/image-uploader.css',
            'vendors/datatables.net-dt/css/jquery.dataTables.min.css',
            'vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css',
            'vendors/select2/dist/css/select2.min.css',
            'vendors/bootstrap-confirm/bootstrap-confirm-delete.css',
            'dist/css/style.css',
            'dist/css/custom-admin.css',
            'dist/css/responsive.css',
            'vendors/preloader/dist/css/preloader.css',
            'vendors/preloader/dist/css/animate.css',
            'vendors/shake-image/dist/css/shake.css',
        ];
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
  $cssArrBBBootstrap = [
            // BEGIN: toruskit
            'vendors/bbbootstrap/dist/css/ribbon.css',
            // END: toruskit
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

@section('css_tag')
    @foreach($cssArr as $css)
        <link href="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . $css. '?v=' . ADMIN_CSS_AND_JAVASCRIPT_VERSION)}}" rel="stylesheet" type="text/css">
    @endforeach

    @foreach($cssArrFrest as $css)
        <link href="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . $css. '?v=' . ADMIN_CSS_AND_JAVASCRIPT_VERSION)}}" rel="stylesheet" type="text/css">
    @endforeach

    @foreach($cssArrBBBootstrap as $css)
        <link href="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . $css. '?v=' . ADMIN_CSS_AND_JAVASCRIPT_VERSION)}}" rel="stylesheet" type="text/css">
    @endforeach

    @foreach($cssArrFontawesome as $css)
        <link href="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . $css. '?v=' . ADMIN_CSS_AND_JAVASCRIPT_VERSION)}}" rel="stylesheet" type="text/css">
    @endforeach
@show
