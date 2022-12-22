<?php
$bannerId = app('Config')->getConfig('logo-cong-ty', '');
$logo = app('Banner')::query()->where('banner_id', $bannerId)->first();
?>
<!-- NAVBAR -->
<nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top bg-danger">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto">
                            <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="javascript:void(0);"><i class="ficon bx bx-menu"></i>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav bookmark-icons">
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link" href="app-email.html" data-toggle="tooltip" data-placement="top" title="Email"><i class="ficon bx bx-envelope"></i>
                            </a>
                        </li>
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link" href="app-chat.html" data-toggle="tooltip" data-placement="top" title="Chat"><i class="ficon bx bx-chat"></i>
                            </a>
                        </li>
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link" href="app-todo.html" data-toggle="tooltip" data-placement="top" title="Todo"><i class="ficon bx bx-check-circle"></i>
                            </a>
                        </li>
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link" href="app-calendar.html" data-toggle="tooltip" data-placement="top" title="Calendar"><i class="ficon bx bx-calendar-alt"></i>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav">
                        <li class="nav-item d-none d-lg-block"><a class="nav-link bookmark-star"><i class="ficon bx bx-star warning"></i></a>
                            <div class="bookmark-input search-input">
                                <div class="bookmark-input-icon"><i class="bx bx-search primary"></i></div>
                                <input class="form-control input" type="text" placeholder="Explore Frest..." tabindex="0" data-search="template-search">
                                <ul class="search-list"></ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-language nav-item">
                        <a class="dropdown-toggle nav-link" id="dropdown-flag" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="flag-icon flag-icon-vn"></i>
                            <span class="selected-language">{{__('Việt Nam')}}</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdown-flag">
                            <a class="dropdown-item" href="javascript:void(0);" data-language="en">
                                <i class="flag-icon flag-icon-vn mr-50"></i> {{__('Việt Nam')}}
                            </a>
                        </div>
                    </li>
                    <li class="nav-item d-none d-lg-block">
                        <a class="nav-link nav-link-expand"><i class="ficon bx bx-fullscreen"></i>
                        </a>
                    </li>
                    <li class="nav-item nav-search">
                        <a class="nav-link nav-link-search"><i class="ficon bx bx-search"></i>
                        </a>
                        <div class="search-input">
                            <div class="search-input-icon"><i class="bx bx-search primary"></i></div>
                            <input class="input" type="text" placeholder="{{__('Tìm kiếm...')}}" tabindex="-1" data-search="template-search">
                            <div class="search-input-close"><i class="bx bx-x"></i></div>
                            <ul class="search-list"></ul>
                        </div>
                    </li>
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="javascript:void(0);" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none">
                                <span class="user-name">
                                    @auth('admin')
                                        {{\Illuminate\Support\Facades\Auth::guard('admin')->user()->name}}
                                    @endauth
                                    @php
                                        $userId = \Illuminate\Support\Facades\Auth::guard('admin')->user()->aduser_id;
                                    @endphp
                                </span>
                                <span class="user-status text-muted">
                                    {{__('Hoạt động')}}
                                </span>
                            </div>
                            <span>
                                <img class="round" src="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . 'dist/icons/avatar-default.png')}}" alt="avatar" height="30" width="30">
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right pb-0">
                            <a class="dropdown-item" href="{{app('UrlHelper')::admin('adminuser', 'detail', ['id' => $userId])}}"><i class="bx bx-user mr-50"></i> {{__('Edit Profile')}}</a>
                            <a class="dropdown-item" href="{{app('UrlHelper')::admin('adminuser', 'detail', ['id' => $userId])}}"><i class="bx bx-envelope mr-50"></i> {{__('My Inbox')}}</a>
                            <a class="dropdown-item" href="{{app('UrlHelper')::admin('adminuser', 'detail', ['id' => $userId])}}"><i class="bx bx-check-square mr-50"></i> {{__('Task')}}</a>
                            <a class="dropdown-item" href="{{app('UrlHelper')::admin('adminuser', 'detail', ['id' => $userId])}}"><i class="bx bx-message mr-50"></i> {{__('Chats')}}</a>
                            <div class="dropdown-divider mb-0"></div>
                            <a class="dropdown-item" href="{{@route(ADMIN_ROUTE . '.logout')}}"><i class="bx bx-power-off mr-50"></i> {{__('Đăng xuất')}}</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!--/ NAVBAR -->