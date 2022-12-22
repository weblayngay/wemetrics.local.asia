<?php
/**
 * @var \App\Models\Menu $menuModel
 */
$menuModel = app('Menu');
$menus = $menuModel::parentQuery()->where(['menu_status' => 'activated', 'group_id' => 6, 'menu_is_delete' => 'no'])->orderBy('menu_number', 'asc')->get();
$parentMenus = $childrenMenus = [];

$cart = session()->get('cart') ? session()->get('cart') : [];
$totalPriceCart = session()->get('total_price') ? session()->get('total_price') : 0;
$totalCart = session()->get('total') ? session()->get('total') : 0;

foreach ($menus as $menu) {
    if ($menu->parent_id == 0) {
        $parentMenus[] = $menu->toArray();
    } else {
        $childrenMenus[$menu->parent_id][] = $menu->toArray();
    }
}
$logo = app('Banner')::query()->where('bangroup_id', 6)->orderBy('banner_id', 'desc')->first();

$phoneNumber = app('Config')->getConfig('phone');

$totalQuantityCart = 0;
?>

<header style="padding-bottom: 0.25rem">
    <div class="main-header stick" style="background-color: #f0f0f0;">
        <div class="container-fluid">
			<!-- Begin Top Header -->
			<div class="row">			
				<div class="col-lg-12 col-md-12 col-12">
                    <div class="header-right-2">
                        <!-- Begin Mini Cart Area -->
						<div class="main-menu primary-menu-left">
						<nav style="padding-top: 5px;">
							<ul>
								<li><i style="color: #099B05;"class="fas fa-phone"></i><a href="tel:{!! $phoneNumber !!}" class="top-header-content"> HOTLINE: {!! $phoneNumber !!}</a></li>
								<li>{{app('Config')->getConfig('mien-phi-van-chuyen', '')}}</li>
								<li>{{app('Config')->getConfig('san-pham-giay-doc-dao', '')}}</li>
								<li>{{app('Config')->getConfig('chinh-sach-1-doi-1', '')}}</li>							
							</ul>
						</nav>
						</div>
                        <div class="main-menu primary-menu-left">
                            <nav>
                                <ul>
									@if(Auth::guard('web')->check())
										<li><a href="{{route('logout')}}"><i class="fas fa-unlock"></i>Đăng xuất</a></li>
									@else
										<li><a href="{{route('login')}}"><i class="fas fa-lock"></i>Đăng Nhập</a></li>
										<li><a href="{{route('register')}}"><i class="fas fa-unlock"></i>Tạo tài khoản</a></li>
									@endif								
                                    <li><a href="{{ route('shopping-cart') }}"><i class="fas fa-shopping-cart"></i>Giỏ hàng <span id="countCart">({{ count($cart) }})</span></a>
                                        <ul class="dropdown cart-dropdown">
                                            <li>
                                                @if(count($cart) > 0 && !empty($cart))
                                                    <?php
                                                        $i = 0;
                                                    ?>
                                                    @foreach($cart as $key => $item)
                                                        <?php
                                                            $i++
                                                        ?>
                                                        <div class="cart-item">
                                                            <div class="cart-img">
                                                                <a href="{{ route('detailProduct', ['slug' => $item['slug'], 'type' => $item['type'], 'id' => $item['id']]) }}">
                                                                    <img style="width: 80px;" src="{{ $item['image'] }}" alt="Giày thể thao DaiKon, Mỹ phẩm Thái Lan DaiKon">
                                                                </a>
                                                            </div>
                                                            <div class="cart-info">
                                                                <div class="pro-item">
                                                                    <span class="quantity-formated">{{ $item['quantity'] }} x </span>
                                                                    <a class="pro-name" href="{{ route('detailProduct', ['slug' => $item['slug'], 'type' => $item['type'], 'id' => $item['id']]) }}" title="{{ $item['name'] }}">{{ $item['name'] }}</a>
                                                                </div>
                                                                <div class="pro-price">
                                                                    <span class="amount">{{ number_format($item['price'], 0, '.', ',') }}đ</span>
                                                                </div>
                                                                <div class="remove-link raavin-product-remove">
                                                                    <a data-id="{{ $item['id'] }}" href="#" title="Xóa sản phẩm khỏi giỏ hàng"></a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @if ($i == 3)
                                                            <div class="cart-btn">
                                                                <a class="links links-3" href="{{ route('shopping-cart') }}">Xem giỏ hàng</a>
                                                            </div>
                                                            @break
                                                        @endif

                                                    @endforeach
                                                @endif

                                                <div class="cart-inner-bottom">
                                                    <div class="cart-shipping cart-item">
                                                        <div class="total">
                                                            <span>Tạm tính</span>
                                                            <span class="amount">{{ number_format($totalPriceCart, 0, '.', ',')  }}đ</span>
                                                        </div>
                                                        <div class="total">
                                                            <span>Thành Tiền</span>
                                                            <span class="amount">{{ number_format($totalCart, 0, '.', ',')  }}đ</span>
                                                        </div>
                                                    </div>
                                                    <div class="cart-btn">
                                                        <a class="links links-3" href="{{ route('checkout') }}">Thanh Toán</a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <!-- Mini Cart Area End Here -->
                        <!-- Begin User Account Area -->
                        <div class="main-menu primary-menu-left">
                            <nav>
                                <ul>
									    <li><a href="#"><i class="fas fa-cog"></i>Cá nhân</a>
                                        <ul class="dropdown primary-dropdown">
                                            @if(Auth::guard('web')->check())
                                            <li><a href="{{route('detailUser')}}"><i class="fas fa-user"></i>Tài khoản</a></li>
                                            <li><a href="{{route('deliveryUser')}}"><i class="fas fa-truck"></i>Thông tin giao hàng</a></li>
                                            <li><a href="{{route('wish-list')}}"><i class="fas fa-heart"></i>Sản phẩm yêu thích</a></li>
                                            <li><a href="{{route('indexOrder')}}"><i class="fas fa-shopping-cart"></i>Đơn hàng của tôi</a></li>
                                            @endif
                                            <li><a href="{{route('shopping-cart')}}"><i class="fas fa-shopping-cart"></i>Giỏ hàng</a></li>
                                            @if(Auth::guard('web')->check())
                                                <li><a href="{{route('logout')}}"><i class="fas fa-unlock"></i>Đăng xuất</a></li>
                                            @else
                                                <li><a href="{{route('login')}}"><i class="fas fa-lock"></i>Đăng Nhập</a></li>
                                                <li><a href="{{route('register')}}"><i class="fas fa-unlock"></i>Tạo tài khoản</a></li>
                                            @endif
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <!-- User Account Area End Here -->
                        <!-- Begin Header Search Area -->
                        <div class="main-menu primary-menu-left">
                            <nav>
                                <ul>
                                    <li><a href="#"><i class="fas fa-search"></i>Tìm kiếm</a>
                                        <ul class="dropdown header-search">
                                            <li>
                                                <form action="#">
                                                    <input type="text" name="Enter key words" value="Enter key words..." onblur="if(this.value==''){this.value='Enter key words...'}" onfocus="if(this.value=='Enter key words...'){this.value=''}">
                                                </form>
                                                <button><i class="fas fa-search"></i></button>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <!-- Header Search Area End Here -->							
                    </div>
                </div> 				
			</div>
			<!-- End Top Header -->
		</div>
	</div>
    <div class="main-header stick" style="background-color: #fff;">
        <div class="container-fluid">	
			<!-- Begin Logo Top Header -->
			<div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="top-header-logo">
						<li><i style="color:#099B05;" class="fas fa-phone"></i><a href="tel:{!! $phoneNumber !!}" class="top-header-content"> HOTLINE: {!! $phoneNumber !!}</a></li><br>
                        <a href="/">
                            <img src="{{config('my.path.image_banner_of_module') . $logo->avatar->image_name}}" alt="Giày thể thao DaiKon, Mỹ phẩm Thái Lan DaiKon">
                        </a>
                    </div>
                </div>			
			</div>
			<!-- End Logo Top Header -->
		</div>
	</div>
    <div class="main-header stick header-sticky" style="background-color: #fff;">
        <div class="container-fluid">
			<div class="row">
                <div class="col-lg-1 col-md-2 col-1">
                    <div class="logo">
                        <a href="/">
                            <img src="{{config('my.path.image_banner_of_module') . $logo->avatar->image_name}}" alt="Giày thể thao DaiKon, Mỹ phẩm Thái Lan DaiKon">
                        </a>
                    </div>
                </div>
                <!--<div class="col-lg-8 d-none d-lg-block d-xl-block">-->
				<div class="col-lg-10 d-none d-lg-block d-xl-block">
                    <div class="main-menu">
                        <nav>
                            <ul>
                                @if(count($parentMenus) > 0)
                                    @foreach($parentMenus as $key => $parentMenu)
                                        @php
                                        $activeClass = ($key == 0) ? 'active' : '';
                                        @endphp
                                        <li class="{{$activeClass}}"><a href="{{$parentMenu['menu_url']}}">{{$parentMenu['menu_name']}}</a>
                                            @if(array_key_exists($parentMenu['menu_id'], $childrenMenus))
                                            <ul class="dropdown my-dropdown">
                                                @foreach($childrenMenus[$parentMenu['menu_id']] as $key => $childrenMenu)
                                                    <li><a href="{{$childrenMenu['menu_url']}}">{{$childrenMenu['menu_name']}}</a></li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
                <!--<div class="col-lg-3 col-md-10 col-11">-->
				<div class="col-lg-1 col-md-10 col-11">
                    <div class="header-right">
                        <!-- Begin Mini Cart Area -->
                        <div class="main-menu primary-menu">
                            <nav>
                                <ul>
                                    <li><a href="{{ route('shopping-cart') }}"><i class="fas fa-shopping-bag"></i>Giỏ hàng <span id="countCart">({{ count($cart) }})</span></a>
                                        <ul class="dropdown cart-dropdown">
                                            <li>

                                                @if(count($cart) > 0 && !empty($cart))
                                                    <?php
                                                        $i = 1;
                                                    ?>
                                                    @foreach($cart as $key => $item)
                                                        <?php
                                                            $i++
                                                        ?>
                                                        <div class="cart-item">
                                                            <div class="cart-img">
                                                                <a href="{{ route('detailProduct', ['slug' => $item['slug'], 'type' => $item['type'], 'id' => $item['id']]) }}">
                                                                    <img style="width: 80px;" src="{{ $item['image'] }}" alt="Giày thể thao DaiKon, Mỹ phẩm Thái Lan DaiKon">
                                                                </a>
                                                            </div>
                                                            <div class="cart-info">
                                                                <div class="pro-item">
                                                                    <span class="quantity-formated">{{ $item['quantity'] }} x </span>
                                                                    <a class="pro-name" href="{{ route('detailProduct', ['slug' => $item['slug'], 'type' => $item['type'], 'id' => $item['id']]) }}" title="">{{ $item['name'] }}</a>
                                                                </div>
                                                                <div class="pro-price">
                                                                    <span>{{ number_format($item['price'], 0, '.', ',') }}đ</span>
                                                                </div>
                                                                <div class="remove-link raavin-product-remove">
                                                                    <a data-id="{{ $item['id'] }}" href="#" title="Xóa sản phẩm khỏi giỏ hàng"></a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @if ($i == 3)
                                                            <div class="cart-btn">
                                                                <a class="links links-3" href="{{ route('shopping-cart') }}">Xem giỏ hàng</a>
                                                            </div>
                                                            @break
                                                        @endif

                                                    @endforeach
                                                @endif

                                                <div class="cart-inner-bottom">
                                                    <div class="cart-shipping cart-item">
                                                        <div class="total">
                                                            <span>Tạm tính</span>
                                                            <span class="amount">{{ number_format($totalPriceCart, 0, '.', ',')  }}đ</span>
                                                        </div>
                                                        <div class="total">
                                                            <span>Thành Tiền</span>
                                                            <span class="amount">{{ number_format($totalCart, 0, '.', ',')  }}đ</span>
                                                        </div>
                                                    </div>
                                                    <div class="cart-btn">
                                                        <a class="links links-3" href="{{ route('checkout') }}">Thanh Toán</a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <!-- Mini Cart Area End Here -->
                        <!-- Begin User Account Area -->
                        <div class="main-menu primary-menu">
                            <nav>
                                <ul>
                                    <li><a href="#"><i class="fas fa-cog"></i>Cá nhân</a>
                                        <ul class="dropdown primary-dropdown">
                                            @if(Auth::guard('web')->check())
                                            <li><a href="{{route('detailUser')}}"><i class="fas fa-user"></i>Tài khoản</a></li>
                                            <li><a href="{{route('deliveryUser')}}"><i class="fas fa-truck"></i>Thông tin giao hàng</a></li>
                                            <li><a href="{{route('wish-list')}}"><i class="fas fa-heart"></i>Sản phẩm yêu thích</a></li>
                                            <li><a href="{{route('indexOrder')}}"><i class="fas fa-shopping-cart"></i>Đơn hàng của tôi</a></li>
                                            @endif
                                            <li><a href="{{route('shopping-cart')}}"><i class="fas fa-check-square"></i>Giỏ hàng</a></li>
                                            @if(Auth::guard('web')->check())
                                                <li><a href="{{route('logout')}}"><i class="fas fa-unlock"></i>Đăng xuất</a></li>
                                            @else
                                                <li><a href="{{route('login')}}"><i class="fas fa-lock"></i>Đăng Nhập</a></li>
                                                <li><a href="{{route('register')}}"><i class="fas fa-unlock"></i>Tạo tài khoản</a></li>
                                            @endif
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <!-- User Account Area End Here -->
                        <!-- Begin Header Search Area -->
                        <div class="main-menu primary-menu">
                            <nav>
                                <ul>
                                    <li><a href="#"><i class="fas fa-search"></i>Tìm kiếm</a>
                                        <ul class="dropdown header-search">
                                            <li>
                                                <form action="#">
                                                    <input type="text" name="Enter key words" value="Enter key words..." onblur="if(this.value==''){this.value='Enter key words...'}" onfocus="if(this.value=='Enter key words...'){this.value=''}">
                                                </form>
                                                <button><i class="fas fa-search"></i></button>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <!-- Header Search Area End Here -->						
                    </div>
                </div>
                <div class="mobile-menu-area d-lg-none d-xl-none col-12">
                    <div class="mobile-menu m-mobile-menu">
                        <nav>
                            <ul>
                                @if(count($parentMenus) > 0)
                                    @foreach($parentMenus as $key => $parentMenu)
                                        @php
                                            $activeClass = ($key == 0) ? 'active' : '';
                                        @endphp
                                        <li class="{{$activeClass}}">
                                            <a href="{{$parentMenu['menu_url']}}">
                                                @if ($parentMenu['menu_name'] == 'Trang chủ') <i class="fas fa-home"></i> 
                                                    @elseif ($parentMenu['menu_name'] == 'Giới thiệu') <i class="fas fa-network-wired"></i>
                                                    @elseif ($parentMenu['menu_name'] == 'Tin tức') <i class="fas fa-rss-square"></i>
                                                    @elseif ($parentMenu['menu_name'] == 'Khuyến mãi') <i class="fas fa-tags"></i>
                                                    @elseif ($parentMenu['menu_name'] == 'Hướng dẫn') <i class="fas fa-book-reader"></i>
                                                    @elseif ($parentMenu['menu_name'] == 'Liên hệ') <i class="fas fa-id-card-alt"></i>
                                                    @elseif ($parentMenu['menu_name'] == 'Tra cứu') <i class="fas fa-folder-open"></i>
                                                    @elseif ($parentMenu['menu_name'] == 'Mỹ phẩm Thái Lan') <i class="fas fa-magic"></i>
                                                    @elseif ($parentMenu['menu_name'] == 'Giày thể thao') <i class="fas fa-shoe-prints"></i>
                                                @else <i class="fas fa-shoe-prints"></i> 
                                                @endif 
                                            {{$parentMenu['menu_name']}}</a>
                                            @if(array_key_exists($parentMenu['menu_id'], $childrenMenus))
                                                <ul class="dropdown">
                                                    @foreach($childrenMenus[$parentMenu['menu_id']] as $key => $childrenMenu)
                                                        <li><a href="{{$childrenMenu['menu_url']}}"><i class="fas fa-chevron-circle-down"></i>{{$childrenMenu['menu_name']}}</a></li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
