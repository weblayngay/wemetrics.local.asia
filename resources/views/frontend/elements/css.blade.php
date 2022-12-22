@php
  $cssArr = [
            'css/material-design-iconic-font.min.css',
            'css/font-awesome.min.css',
            'css/fontawesome-stars.css',
            'css/meanmenu.css',
            'css/nivo-slider.css',
            'css/owl.carousel.min.css',
            'css/slick.css',
            'css/animate.css',
            'css/jquery-ui.min.css',
            'css/venobox.css',
            'css/nice-select.css',
            'css/magnific-popup.css',
            'css/bootstrap.min.css',
            'css/jquery.toast.css',
            // 'css/custom.css',
            // 'style.css',
            // 'css/responsive.css',
            // 'my-style.css',
            'css/fontawesome.v5.15.3/all.css',
            'css/fontawesome.v5.15.3/v4-shims.css',
            'vendors/leeandtee/assets/css/theme.css',
            'vendors/leeandtee/assets/css/general.css',
        ];
@endphp

@section('css_tag')
    @foreach($cssArr as $css)
        <link href="{{@asset(FRONTEND_CSS_AND_JAVASCRIPT_PATH . $css. '?v=' . FRONTEND_CSS_AND_JAVASCRIPT_VERSION)}}" rel="stylesheet" type="text/css">
    @endforeach
@show
