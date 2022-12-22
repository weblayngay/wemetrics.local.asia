<?php
    $faviconId = app('Config')->getConfig('favicon-cong-ty', '');
    $favicon = app('Banner')::query()->where('banner_id', $faviconId)->first();
    $companyName = app('Config')->getConfig('ten-cong-ty', '');
    $action = !empty($data['action']) ? $data['action'] : 'index';
?>
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

        <!--Preloader start here-->
        @include('backend.elements.children.preloaderreport.index')
        <!--Preloader area end here-->

        @if($action == 'stats')
            <!-- BEGIN: Content-->
            <div class="app-content content">
                <div class="content-overlay"></div>
                <div class="content-wrapper">
                    <div class="content-header row">
                        @include('backend.elements.children.notification.index')
                    </div>
                    <div class="content-body">
                        @include('backend.elements.content_search', ['search' => 'backend.elements.searchs.kiotvietcateproductreportoverview.kiotvietcateproductreportoverview_preload_search'])
                    </div>
                </div>
            </div>
            <!-- END: Content-->
        @endif

        @include('backend.elements.javascript')
        @include('backend.elements.ajax.kiotviet.preload.kiotvietcateproductreportoverview_preload') 
    </body>
</html>