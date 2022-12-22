<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loaded">
    <head>
        <?php
            $faviconId = app('Config')->getConfig('favicon-cong-ty', '');
            $favicon = app('Banner')::query()->where('banner_id', $faviconId)->first();
        ?>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>@php echo strtoupper($_SERVER['HTTP_HOST']); @endphp - Administrator</title>
        <!-- Favicon -->
        <link rel="shortcut icon" href="{{config('my.path.image_banner_of_module') . $favicon->avatar->image_name}}">
        <link rel="icon" href="{{config('my.path.image_banner_of_module') . $favicon->avatar->image_name}}" type="image/x-icon">

        @include('backend.elements.css')
    </head>

    <body class="vertical-layout vertical-menu-modern 2-columns navbar-sticky footer-static menu-expanded" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
        <!-- PRELOADER -->
        @include('backend.elements.children.preloader.index')
        <!--/ PRELOADER -->

        <!-- NAVBAR -->
        @include('backend.elements.children.navbartop.index')
        <!--/ NAVBAR -->

        <!-- NAVIGATION - MENU -->
        @include('backend.elements.children.menuleft.index')  
        <!--/ NAVIGATION - MENU -->

        <!-- BEGIN: Content-->
        <div class="app-content content">
            <div class="content-overlay"></div>
            <div class="content-wrapper">
                <div class="content-header row">
                    @include('backend.elements.children.notification.index')
                </div>
                <div class="content-body">
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- END: Content-->

        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>

        <!-- BEGIN: Footer-->
        @include('backend.elements.children.footer.index')
        <!-- END: Footer-->

        <input type="hidden" class="js-admin-route" value="{{ADMIN_ROUTE}}">
        @include('backend.elements.javascript')
    </body>
</html>
