@extends('backend.main')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <section class="hk-sec-wrapper hk-sec-content">
            <div class="row">
                @foreach($data['parentMenus'] as $menu)
                    <div class="col-md-3" style="text-align: center;padding: 20px;">
                        <div class="thumbnail">
                            <a href="{{app('UrlHelper')::admin($menu->controller, $menu->action)}}">
                                <img class="shake icon-size-64" src="{{ADMIN_DIST_ICON_URL . $menu->icon}}" alt="" >
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
