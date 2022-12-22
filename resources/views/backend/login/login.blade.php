<?php
    $bannerId = app('Config')->getConfig('logo-cong-ty', '');
    $logo = app('Banner')::query()->where('banner_id', $bannerId)->first();
    $faviconId = app('Config')->getConfig('favicon-cong-ty', '');
    $favicon = app('Banner')::query()->where('banner_id', $faviconId)->first();
    $companyName = app('Config')->getConfig('ten-cong-ty', '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>@php echo strtoupper($_SERVER['HTTP_HOST']); @endphp - Login</title>

    <!-- Toggles CSS -->
    <link href="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . 'vendors/jquery-toggles/css/toggles.css')}}" rel="stylesheet" type="text/css">
    <link href="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . 'vendors/jquery-toggles/css/themes/toggles-light.css')}}" rel="stylesheet" type="text/css">

    <!-- Custom CSS -->
    <link href="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . 'dist/css/style.css')}}" rel="stylesheet" type="text/css">
    <link href="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . 'vendors/clickup/dist/css/clickup.css')}}" rel="stylesheet" type="text/css">
    <style type="text/css">
        .login-page-new__main-bg {
            background: url({{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . 'vendors/clickup/dist/img/login-page-new__main-bg.svg')}}) center 10px no-repeat;
            background-size: cover
        }

        .login-page-new__main-bg:before {
            background: url({{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . 'vendors/clickup/dist/img/login-page-new__main-bg-before.svg')}});
            transform: rotate(-28deg)
        }

        .login-page-new__main-bg:after {
            background: url({{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . 'vendors/clickup/dist/img/login-page-new__main-bg-after.svg')}}) center top no-repeat;
            background-size: 100%
        }
    </style>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{config('my.path.image_banner_of_module') . $favicon->avatar->image_name}}">
    <link rel="icon" href="{{config('my.path.image_banner_of_module') . $favicon->avatar->image_name}}" type="image/x-icon">
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

    @foreach($cssArrFontawesome as $css)
        <link href="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . $css. '?v=' . ADMIN_CSS_AND_JAVASCRIPT_VERSION)}}" rel="stylesheet" type="text/css">
    @endforeach
</head>
<body>
    <div class="login-page-new">
        <nav><a href="#" target="_blank" data-test="login__logo" class="login-page-new__logo"><img src="{{config('my.path.image_banner_of_module') . $logo->avatar->image_name}}" class="login-page-new__logo-img" alt="{{__($companyName)}}"></a>
        </nav>
        <div class="login-page-new__main">
            <div class="login-page-new__main-bg"></div>
            <div data-test="login__main-container" class="login-page-new__main-container">
                <div class="login-page-new__main-form">
                    <div class="login-page-new__main-form-title-brand"></div>
                    <router-outlet></router-outlet>
                    <div class="app-content content">
                        <div class="content-overlay"></div>
                        <div class="content-wrapper">
                            <div class="content-header row">
                                <div class="notification card-body">
                                    @if (session()->has(SESSION_SUCCESS_KEY))
                                        <div class="alert alert-success alert-wth-icon alert-dismissible fade show" role="alert">
                                            <span class="alert-icon-wrap"><i class="zmdi zmdi-check-circle"></i></span> {{ session()->get(SESSION_SUCCESS_KEY) }}
                                        </div>
                                        @php session()->remove(SESSION_SUCCESS_KEY);@endphp
                                    @endif
                                    @if (session('success'))
                                        <div class="alert alert-success alert-wth-icon alert-dismissible fade show" role="alert">
                                            <span class="alert-icon-wrap"><i class="zmdi zmdi-check-circle"></i></span> {{ session('success') }}
                                        </div>
                                    @endif

                                    @if (session('error'))
                                        <div class="alert alert-danger alert-wth-icon alert-dismissible fade show" role="alert">
                                            <span class="alert-icon-wrap"><i class="zmdi zmdi-bug"></i></span> {{ session('error') }}
                                        </div>
                                    @endif
                                    @if (session()->has(SESSION_ERROR_KEY))
                                        <div class="alert alert-danger alert-wth-icon alert-dismissible fade show" role="alert">
                                            <span class="alert-icon-wrap"><i class="zmdi zmdi-bug"></i></span> {{ session()->has(SESSION_ERROR_KEY) }}
                                        </div>
                                        @php session()->remove(SESSION_ERROR_KEY);@endphp
                                    @endif


                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-wth-icon alert-dismissible fade show" role="alert">
                                            @foreach ($errors->all() as $error)
                                                <span class="alert-icon-wrap"><i class="zmdi zmdi-bug"></i></span> {{ $error }}<br/>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <cu-login-form>
                            <h1 class="login-page-new__main-form-title"> {{__('Welcome back!')}}</h1>
                            <div class="login-page-new__main-form-router-outlet login-page-new__main-form-login">
                            @if(Route::has(ADMIN_ROUTE . '.login'))
                                <form method="POST" action="{{route(ADMIN_ROUTE . '.login', []) }}" class="ng-pristine ng-invalid ng-touched">
                                    @if ( session('errors'))
                                        <div class="alert alert-danger alert-block">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('errors')->first() }}</strong>
                                        </div>
                                    @endif
                                    <div class="login-page-new__main-form-row">
                                        <label for="login-email-input" class="login-page-new__main-form-row-label"> {{__('Email đăng nhập')}} </label>
                                        <input name="email" class="cu-form__input" placeholder="Email đăng nhập" type="text">
                                        <div aria-hidden="true" style="position: absolute; left: 10px; top: 36px; width: 20px; height: 20px; fill: #ff5608;">
                                            <i style="font-size:14px; color: #ff5608;" class="fa-solid fa-envelope" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="login-page-new__main-form-row">
                                        <label for="login-email-input" class="login-page-new__main-form-row-label"> {{__('Mật khẩu')}} </label>
                                        <input class="form-control" placeholder="Mật khẩu" type="password" name="password">
                                        <div aria-hidden="true" style="position: absolute; left: 10px; top: 36px; width: 20px; height: 20px; fill: #ff5608;">
                                            <i style="font-size:14px; color: #ff5608;" class="fa-solid fa-key" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <button class="login-page-new__main-form-button" type="submit">
                                        <span class="login-page-new__main-form-button-text">{{__('Đăng nhập')}}</span>
                                        <div class="cu-btn__spinner">
                                            <div class="cu-btn__bounce1"></div>
                                            <div class="cu-btn__bounce2"></div>
                                            <div class="cu-btn__bounce3"></div>
                                        </div>
                                    </button>
                                    @csrf
                                </form>
                            @else
                                <form method="POST" action="{{route(ADMIN_ROUTE . '.login', []) }}" class="ng-pristine ng-invalid ng-touched">
                                    <button href="javascript:window.location.reload(true)" class="login-page-new__main-form-button" type="button">
                                        <span class="login-page-new__main-form-button-text">{{__('Refresh Page')}}</span>
                                        <div class="cu-btn__spinner">
                                            <div class="cu-btn__bounce1"></div>
                                            <div class="cu-btn__bounce2"></div>
                                            <div class="cu-btn__bounce3"></div>
                                        </div>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </cu-login-form>
                </div>
            </div>
        </div>
    </div>

<!-- JavaScript -->

<!-- jQuery -->
<script src="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . 'vendors/jquery/dist/jquery.min.js')}}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . 'vendors/popper.js/dist/umd/popper.min.js')}}"></script>
<script src="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . 'vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<!-- Slimscroll JavaScript -->
<script src="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . 'dist/js/jquery.slimscroll.js')}}"></script>

<!-- Fancy Dropdown JS -->
<script src="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . 'dist/js/dropdown-bootstrap-extended.js')}}"></script>

<!-- FeatherIcons JavaScript -->
<script src="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . 'dist/js/feather.min.js')}}"></script>

<!-- Init JavaScript -->
<script src="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . 'dist/js/init.js')}}"></script>

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
@foreach($javascriptArrFontawesome as $javascript)
    <script src="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . $javascript. '?v=' . ADMIN_CSS_AND_JAVASCRIPT_VERSION)}}"></script>
@endforeach
</body>
</html>
