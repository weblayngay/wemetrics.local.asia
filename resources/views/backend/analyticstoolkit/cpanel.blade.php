<?php
    /**
     * @var \App\Helpers\UrlHelper $urlHelper
     */
    use App\Helpers\TranslateHelper;
    use App\Helpers\DateHelper;

    $urlHelper = app('UrlHelper');
    $title = isset($data['title']) ? $data['title'] : '';
?>

@extends('backend.main')

@section('content')
<div class="hk-pg-header js-admin-action">
    <div class="row">
        <div class="col-md-3">
            <h4 class="hk-pg-title btn btn-success content-action">
                {{ Str::of($title)->title()->replace('-', ' ') }}
            </h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <section class="hk-sec-wrapper hk-sec-content">
            <div class="row">
                @foreach($data['parentMenus'] as $menu)
                    <div class="col-md-3" style="text-align: center;padding: 20px;">
                        <div class="thumbnail">
                            <a href="{{app('UrlHelper')::admin($menu->controller, $menu->action)}}">
                                <img class="shake icon-size-64" src="{{ADMIN_DIST_ICON_URL . $menu->icon}}" alt="{{ $menu->name }}" >
                                <div class="mt-1 text-primary font-weight-bolder">
                                    <p>{{Str::of($menu->name)->title()}}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</div>
@endsection
