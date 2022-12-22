<?php
/**
 * @var \App\Models\AdminMenu $adminMenuModel
 */
$adminMenuModel = app('AdminMenu');
$parentMenus    = $adminMenuModel->getMenuByUser('parent');
if (count($parentMenus) < 1) {
    return false;
}

/**
 * Childrens menu
 */
$childrenMenus  = $adminMenuModel->getMenuByUser('children');
$childrenMenuArr = [];
if (count($parentMenus) > 0) {
    /**
     * @var \App\Helpers\ArrayHelper $arrayHelper
     */
    $arrayHelper = app('ArrayHelper');
    foreach ($childrenMenus as $childrenMenu) {
        $childrenMenuArr[$childrenMenu->parent][] = $childrenMenu->toArray();
    }
}
$urlHelper = app('UrlHelper');
/**
 * Logo
 */
$bannerId = app('Config')->getConfig('logo-cong-ty', '');
$logo = app('Banner')::query()->where('banner_id', $bannerId)->first();
?>
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="{{route(ADMIN_ROUTE . '.dashboard')}}">
                    <div class="brand-logo">
                        <img class="img-fluid" src="{{config('my.path.image_banner_of_module') . $logo->avatar->image_name}}" alt="brand" style="max-width: 500%!important;">
                    </div>
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="bx bx-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="bx-disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="">
            @foreach($parentMenus as $parentMenu)
                @php
                /**
                * @var \App\Models\AdminMenu $parentMenu
                * @var \App\Helpers\UrlHelper $urlHelper
                */
                    $menuUrl  = $urlHelper::admin($parentMenu->controller, $parentMenu->action);
                    $iconUrl  = $urlHelper::adminIcon($parentMenu->icon);
                    $menuName = $parentMenu->name;
                    $menuId = $parentMenu->admenu_id;
                    $newChildrenMenuArr = @$childrenMenuArr[$menuId];
                    $toggleValue = ($newChildrenMenuArr) ? 'collapse' : '';
                @endphp
                <li class=" nav-item">
                    <a href="@if ($newChildrenMenuArr) {{__('#')}} @else {{__($menuUrl)}} @endif" data-toggle="{{__($toggleValue)}}" data-target="#menu_{{__($menuId)}}">
                        <span class="menu-title text-truncate" data-i18n="banner"><i style="margin-top: 12px;"><img width="20px" src="{{$iconUrl}}"></i> {{__($menuName)}}</span>
                        <span class="badge badge-light-danger badge-pill badge-round float-right mr-50 ml-auto"></span>
                    </a>
                    @if ($newChildrenMenuArr)
                        <ul class="menu-content">
                            @foreach($newChildrenMenuArr as $value)
                                <li>
                                        <a class="d-flex align-items-center" href="{{$urlHelper::admin($value['controller'], $value['action'])}}">
                                        <i class="bx bx-right-arrow-alt" aria-hidden="true"></i>
                                        <span class="menu-item text-truncate" data-i18n="list-banner">{{$value['name']}}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>
